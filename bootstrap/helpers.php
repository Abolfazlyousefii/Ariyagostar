<?php

// helper functions

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Gateway;
use App\Models\Option;
use App\Models\Order;
use App\Models\Product;
use App\Models\Specification;
use App\Models\SpecificationGroup;
use App\Models\SpecType;
use App\Models\Statistics;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserOption;
use App\Models\Viewer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Milon\Barcode\DNS1D;

/* add active class to li */

function active_class($route_name, $class = 'active')
{
    return Route::is($route_name) || Route::is(app()->getLocale() . '.' . $route_name) ? $class : '';
}

function open_class($route_list, $class = 'open')
{
    $text = '';

    foreach ($route_list as $route) {
        if (Route::is($route) || Route::is(app()->getLocale() . '.' . $route)) {
            $text = $class;
            break;
        }
    }

    return $text;
}

function option_update($option_name, $option_value)
{
    $option = Option::firstOrNew([
        'option_name' => $option_name,
        'lang'        => app()->getLocale(),
    ]);

    $option->option_value = $option_value;
    $option->save();

    Cache::forever('options.' . app()->getLocale() . '.' . $option_name, $option_value);
}

function option($option_name, $default_value = '')
{
    $non_language_options = config('general.non_language_options');

    if ($non_language_options && in_array($option_name, $non_language_options)) {
        $language = 'fa';
    } else {
        $language = app()->getLocale();
    }

    $value = Cache::rememberForever('options.' . $language . '.' . $option_name, function () use ($option_name, $default_value, $language) {
        $option = Option::where('option_name', $option_name)
            ->where('lang', $language)
            ->first();

        if ($option) {
            return is_null($option->option_value) ? false : $option->option_value;
        }

        return $default_value;
    });

    if (is_null($value) || $value === false) {
        return $default_value;
    }

    return  $value;
}

function user_option_update($option_name, $option_value, $user_id = null)
{
    if (!$user_id) {
        $user_id = auth()->user()->id;
    }

    $option = UserOption::firstOrNew([
        'option_name' => $option_name,
        'user_id'     => $user_id
    ]);

    $option->option_value = $option_value;
    $option->save();
}

function user_option($option_name, $default_value = '', $user_id = null)
{
    if (!$user_id) {
        if (!auth()->check()) {
            return $default_value;
        }

        $user_id = auth()->user()->id;
    }

    $option = UserOption::where('option_name', $option_name)->where('user_id', $user_id)->first();

    return $option ? $option->option_value : $default_value;
}

// add new tags and return tags id
function addTags($tags, $separator = ',')
{
    $tags    = explode($separator, $tags);
    $tags_id = [];

    foreach ($tags as $item) {

        if (!$item) {
            continue;
        }

        try {
            $tag = Tag::firstOrCreate([
                'name' => $item,
                'lang' => app()->getLocale()
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        if (isset($tag) && $tag) {
            $tags_id[] = $tag->id;
        }
    }

    return $tags_id;
}

function get_cart()
{
    $cart = null;

    if (auth()->check()) {
        $cart = auth()->user()->cart;
    } else {
        $cart_id = Cookie::get('cart_id');

        if ($cart_id) {
            $cart = Cart::whereNull('user_id')->find($cart_id);
        }
    }

    return $cart;
}

/* return true if cart products quantity is ok
 * and return false if cart products quantity is more than product stock
 */
function check_cart_quantity()
{
    $cart = get_cart();

    if (!$cart || !$cart->products()->count()) {
        return true;
    }

    foreach ($cart->products as $product) {
        $price     = $product->prices()->find($product->pivot->price_id);
        $has_stock = $price->hasStock($product->pivot->quantity);

        if (!$has_stock['status']) {
            return false;
        }
    }

    return true;
}

function check_cart_discount()
{
    $cart = get_cart();

    if (!$cart || !$cart->products()->count()) {
        return ['status' => true];
    }

    if ($cart->discount) {
        $status = $cart->canUseDiscount();
        return $status;
    }

    return ['status' => true];
}

function check_cart()
{
    return check_cart_quantity() && check_cart_discount()['status'];
}

//get user address
function user_address($key)
{
    if (old($key)) {
        return old($key);
    }

    return auth()->user()->address ? auth()->user()->address->$key : '';
}

function short_content($str, $words = 20, $strip_tags = true)
{
    if ($strip_tags) {
        $str = strip_tags($str);
    }

    return Str::words($str, $words);
}


function spec_type($request)
{
    if (!$request->spec_type || !$request->specification_group) {
        return null;
    }

    $spec_type = SpecType::firstOrCreate([
        'name' => $request->spec_type,
        'lang' => app()->getLocale()
    ]);

    $group_ordering = 0;

    foreach ($request->specification_group as $group) {

        if (!isset($group['specifications'])) {
            continue;
        }

        $spec_group = SpecificationGroup::firstOrCreate([
            'name' => $group['name'],
            'lang' => app()->getLocale()
        ]);

        $specification_ordering = 0;

        foreach ($group['specifications'] as $specification) {
            $spec = Specification::firstOrCreate([
                'name' => $specification['name']
            ]);

            if (!$spec_type->specifications()->where('specification_id', $spec->id)->where('specification_group_id', $spec_group->id)->first()) {
                $spec_type->specifications()->attach([
                    $spec->id => [
                        'specification_group_id' => $spec_group->id,
                        'group_ordering'         => $group_ordering,
                        'specification_ordering' => $specification_ordering++,
                    ]
                ]);
            }
        }

        $group_ordering++;
    }

    return $spec_type->id;
}

function viewers_data($number = 7)
{
    $data = [];

    for ($i = 0; $i < $number; $i++) {
        $date = Carbon::now()->subDays($i);

        if ($date->isToday() && Cache::get('admin.views-count-' . $date->format('Y-m-d')) <= 1) {
            Cache::forget('admin.views-count-' . $date->format('Y-m-d'));
        }

        $views = Cache::rememberForever('admin.views-count-' . $date->format('Y-m-d'), function () use ($date) {
            return Viewer::whereDate('created_at', $date)->count() + Statistics::whereDate('date', $date)->sum('view_count');
        });

        $data[jdate($date)->format('l')] = $views;
    }

    return $data;
}

function ip_data($number = 7)
{
    $data = [];

    for ($i = 0; $i < $number; $i++) {
        $date = Carbon::now()->subDays($i);

        $views = Cache::remember('admin.views-ip-' . $date->format('Y-m-d'), now()->addMinutes(10), function () use ($date) {
            return Viewer::whereDate('created_at', $date)->distinct('ip')->count() + Statistics::whereDate('date', $date)->sum('viewer_count');
        });

        $data[jdate($date)->format('l')] = $views;
    }

    return $data;
}

function array_to_string($array)
{
    $comma_separated = implode("','", $array);
    $comma_separated = "'" . $comma_separated . "'";
    return $comma_separated;
}

function get_discount_price($price, $discount, $product = null)
{
    $price = $price - ($price * ($discount / 100));

    return to_round_price($price, $product);
}

function to_round_price($price, $product)
{
    if ($product && $product->currency) {
        $price = $price * $product->currency->amount;
    }

    if ($product) {
        $rounding_amount = $product->rounding_amount;

        if ($rounding_amount == 'default') {
            $rounding_amount = option('default_rounding_amount', 'no');
        }

        $rounding_type = $product->rounding_type;

        if ($rounding_type == 'default') {
            $rounding_type = option('default_rounding_type', 'close');
        }

        switch ($rounding_amount) {
            case "100":
            case "1000":
            case "10000":
            case "100000": {
                    if ($rounding_type == 'up') {
                        $price = ceil($price / $rounding_amount) * $rounding_amount;
                    } else if ($rounding_type == 'down') {
                        $price = floor($price / $rounding_amount) * $rounding_amount;
                    } else {
                        $price = round($price / $rounding_amount) * $rounding_amount;
                    }
                    break;
                }
        }
    }

    return (float) $price;
}

function category_group($key)
{
    switch ($key) {
        case 'postcat': {
                return 'دسته بندی وبلاگ';
            }
        case 'productcat': {
                return 'دسته بندی محصول';
            }
    }
}

function convert2english($string)
{
    $newNumbers = range(0, 9);
    // 1. Persian HTML decimal
    $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
    // 2. Arabic HTML decimal
    $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
    // 3. Arabic Numeric
    $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    // 4. Persian Numeric
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

    $string =  str_replace($persianDecimal, $newNumbers, $string);
    $string =  str_replace($arabicDecimal, $newNumbers, $string);
    $string =  str_replace($arabic, $newNumbers, $string);
    return str_replace($persian, $newNumbers, $string);
}

function carbon($string)
{
    return Carbon::createFromFormat('Y-m-d H:i:s', $string, 'Asia/Tehran')->timestamp;
}

function datatable($request, $query)
{
    $page = 1;

    if ($request->pagination && isset($request->pagination['page'])) {
        $page = $request->pagination['page'];
    }

    $columns = ['*'];
    $pageName = 'page';
    $perPage = 10;

    if ($request->pagination && isset($request->pagination['perpage']) && $request->pagination['perpage'] > 0) {
        $perPage = $request->pagination['perpage'];
    }

    if ($query->paginate($perPage, $columns, $pageName, $page)->lastPage() >= $page) {
        return $query->paginate($perPage, $columns, $pageName, $page);
    } else {
        return $query->paginate($perPage, $columns, $pageName, 1);
    }
}

function cart_min($selected_price)
{
    if ($selected_price->product->isDownload()) return 1;

    if ($selected_price->cart_min !== null) {
        return min($selected_price->cart_min, $selected_price->stock);
    }

    return min($selected_price->stock, 1);
}

function cart_max($selected_price)
{
    if ($selected_price->product->isDownload()) return 1;

    if ($selected_price->cart_max !== null) {
        return min($selected_price->cart_max, $selected_price->stock);
    }

    return $selected_price->stock;
}

function remove_id_from_url($id)
{
    $segments = request()->segments();

    if (($key = array_search($id, $segments)) !== false) {
        unset($segments[$key]);
    }

    return url(implode('/', $segments));
}

function get_separated_values($array, $separator)
{
    if (!$separator) {
        return $array;
    }

    $result = [];

    foreach ($array as $item) {
        foreach (explode($separator, $item) as $val) {
            $result[] = trim($val);
        }
    }

    return array_unique($result);
}

function get_option_property($obj, $property)
{
    $obj = json_decode($obj);

    if (!is_object($obj)) {
        return null;
    }

    if (property_exists($obj, $property)) {
        return $obj->$property;
    }

    return null;
}

function application_installed()
{
    return file_exists(storage_path('installed'));
}

function change_env($key, $value)
{
    // Read .env-file
    $env = file_get_contents(base_path() . '/.env');

    // Split string on every " " and write into array
    $env = preg_split('/\s+/', $env);

    $key_exists = false;

    // Loop through .env-data
    foreach ($env as $env_key => $env_value) {

        // Turn the value into an array and stop after the first split
        // So it's not possible to split e.g. the App-Key by accident
        $entry = explode("=", $env_value, 2);

        // Check, if new key fits the actual .env-key
        if ($entry[0] == $key) {
            // If yes, overwrite it with the new one
            $env[$env_key] = $key . "=" . $value;
            $key_exists = true;
        } else {
            // If not, keep the old one
            $env[$env_key] = $env_value;
        }
    }

    if (!$key_exists) {
        $env[] = $key . "=" . $value;
    }

    // Turn the array back to an String
    $env = implode("\n", $env);

    // And overwrite the .env with the new data
    file_put_contents(base_path() . '/.env', $env);

    Artisan::call('config:cache');
}

function get_current_theme()
{
    $current_theme = config('general.current_theme');

    if (file_exists(base_path() . '/themes/' . $current_theme)) {
        $theme = [];
        $theme['name'] = $current_theme;
        $theme['service_provider'] = "Themes\\$current_theme\src\ThemeServiceProvider";
        return $theme;
    }

    return null;
}

function current_theme_name()
{
    return config('front.theme_name');
}

function customConfig($path)
{
    if (file_exists($path)) {
        $config = include $path;
        return $config;
    }
}

function str_random($length)
{
    return Str::random($length);
}

function get_svg_contents($path, $default = '')
{
    if (file_exists(public_path($path))) {

        $file_parts = pathinfo($path);

        if ($file_parts['extension'] == 'svg') {
            return file_get_contents(public_path($path));
        }
    }

    return $default;
}

function to_sql($query)
{
    return vsprintf(str_replace(['?'], ['\'%s\''], $query->toSql()), $query->getBindings());
}

function store_user_cart(User $user)
{
    $cart_id = Cookie::get('cart_id');

    if ($cart_id) {
        $cart = Cart::find($cart_id);

        if ($cart && $cart->user_id == null) {

            $user_cart = Cart::where('user_id', $user->id)->first();

            if (!$user_cart) {
                $cart->update([
                    'user_id' => $user->id,
                ]);
            } else {
                foreach ($cart->products as $product) {
                    $query = DB::table('cart_product')->where('cart_id', $user_cart->id)->where('product_id', $product->id)->where('price_id', $product->pivot->price_id);
                    $user_cart_product = $query->first();

                    if (!$user_cart_product) {

                        DB::table('cart_product')->insert([
                            'cart_id'    => $user_cart->id,
                            'product_id' => $product->id,
                            'quantity'   => $product->pivot->quantity,
                            'price_id'   => $product->pivot->price_id,
                        ]);
                    } else {

                        $query->update([
                            'quantity' => $product->pivot->quantity,
                        ]);
                    }
                }

                $cart->delete();
            }

            Cookie::queue(Cookie::forget('cart_id'));
        }
    }
}

function ellips_text($str, $char)
{
    $out = mb_strlen($str, 'utf-8') > $char ? mb_substr($str, 0, $char, 'utf-8') . "..." : $str;

    return $out;
}

function gateway_key($driver_name)
{
    if ($driver_name == 'behpardakht') {
        return 'mellat';
    }

    return $driver_name;
}

function get_gateway_configs($gateway)
{
    $gateway = Gateway::where('key', $gateway)->first();
    $configs = [];

    switch ($gateway->key) {
        case "zarinpal": {
                $configs['merchantId'] = $gateway->config('merchantId');
                break;
            }
        case "toman": {
                $user = auth()->user();
                $order =  $user->orders->last();
                $items = [];
                foreach ($order->items as $product) {

                    $data = [
                        'name' => $product->title,
                        'price' => $product->price . 0,
                        'quantity' => $product->quantity
                    ];
                    array_push($items, $data);
                    $data = null;
                }

                if ($order->shipping_cost > 0) {
                    $shipping = [
                        'name' => $order->carrier->title,
                        'price' => $order->shipping_cost . 0,
                        'quantity' => 1
                    ];
                    array_push($items, $shipping);
                }

                $data = [
                    'res_number' => $order->id,
                    'return_to' => route('front.orders.verify', ['gateway' => 'toman']),
                    'items' => $items
                ];

                $configs['shop_slug'] = $gateway->config('shop_slug');
                $configs['auth_code'] = $gateway->config('auth_code');
                $configs['data'] = $data;
                break;
            }
        case "payping": {
                $configs['merchantId'] = $gateway->config('merchantId');
                break;
            }
        case "irankish": {
                $configs['terminalId'] = $gateway->config('terminalId');
                $configs['password']   = $gateway->config('password');
                $configs['acceptorId'] = $gateway->config('acceptorId');
                $configs['pubKey']     = $gateway->config('pubKey');
                break;
            }
        case "pasargad": {
                $configs['merchantId']      = $gateway->config('merchantId');
                $configs['terminalCode']    = $gateway->config('terminalCode');
                $configs['certificate']     = $gateway->config('certificate');
                $configs['certificateType'] = 'xml_string';
                break;
            }
        case "idpay": {
                $configs['merchantId'] = $gateway->config('merchantId');
                break;
            }
        case "saman": {
                $configs['merchantId'] = $gateway->config('merchantId');
                break;
            }
        case "behpardakht": {
                $configs['terminalId'] = $gateway->config('terminalId');
                $configs['username']   = $gateway->config('username');
                $configs['password']   = $gateway->config('password');
                break;
            }
        case "payir": {
                $configs['merchantId'] = $gateway->config('merchantId');
                break;
            }
        case "sepehr": {
                $configs['terminalId'] = $gateway->config('terminalId');
                break;
            }
        case "sadad": {
                $configs['key']        = $gateway->config('key');
                $configs['merchantId'] = $gateway->config('merchantId');
                $configs['terminalId'] = $gateway->config('terminalId');
                break;
            }
        case "zibal": {
                $configs['merchantId'] = $gateway->config('merchantId');
                break;
            }
    }

    return $configs;
}

function sluggable_helper_function($string, $separator = '-')
{
    $_transliteration = [
        "/ö|œ/" => "e",
        "/ü/" => "e",
        "/Ä/" => "e",
        "/Ü/" => "e",
        "/Ö/" => "e",
        "/À|Á|Â|Ã|Å|Ǻ|Ā|Ă|Ą|Ǎ/" => "",
        "/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/" => "",
        "/Ç|Ć|Ĉ|Ċ|Č/" => "",
        "/ç|ć|ĉ|ċ|č/" => "",
        "/Ð|Ď|Đ/" => "",
        "/ð|ď|đ/" => "",
        "/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/" => "",
        "/è|é|ê|ë|ē|ĕ|ė|ę|ě/" => "",
        "/Ĝ|Ğ|Ġ|Ģ/" => "",
        "/ĝ|ğ|ġ|ģ/" => "",
        "/Ĥ|Ħ/" => "",
        "/ĥ|ħ/" => "",
        "/Ì|Í|Î|Ï|Ĩ|Ī| Ĭ|Ǐ|Į|İ/" => "",
        "/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/" => "",
        "/Ĵ/" => "",
        "/ĵ/" => "",
        "/Ķ/" => "",
        "/ķ/" => "",
        "/Ĺ|Ļ|Ľ|Ŀ|Ł/" => "",
        "/ĺ|ļ|ľ|ŀ|ł/" => "",
        "/Ñ|Ń|Ņ|Ň/" => "",
        "/ñ|ń|ņ|ň|ŉ/" => "",
        "/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/" => "",
        "/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/" => "",
        "/Ŕ|Ŗ|Ř/" => "",
        "/ŕ|ŗ|ř/" => "",
        "/Ś|Ŝ|Ş|Ș|Š/" => "",
        "/ś|ŝ|ş|ș|š|ſ/" => "",
        "/Ţ|Ț|Ť|Ŧ/" => "",
        "/ţ|ț|ť|ŧ/" => "",
        "/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/" => "",
        "/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/" => "",
        "/Ý|Ÿ|Ŷ/" => "",
        "/ý|ÿ|ŷ/" => "",
        "/Ŵ/" => "",
        "/ŵ/" => "",
        "/Ź|Ż|Ž/" => "",
        "/ź|ż|ž/" => "",
        "/Æ|Ǽ/" => "E",
        "/ß/" => "s",
        "/Ĳ/" => "J",
        "/ĳ/" => "j",
        "/Œ/" => "E",
        "/ƒ/" => "",
    ];
    $quotedReplacement = preg_quote($separator, '/');
    $merge = [
        '/[^\s\p{Zs}\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
        '/[\s\p{Zs}]+/mu' => $separator,
        sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
    ];
    $map = $_transliteration + $merge;
    unset($_transliteration);
    return preg_replace(array_keys($map), array_values($map), $string);
}

function admin_route_prefix()
{
    return config('general.admin_route_prefix');
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function formatPriceUnits($price)
{
    if ($price >= 1000000000) {
        $price = number_format($price / 1000000000, 2) . ' میلیارد';
    } elseif ($price >= 1000000) {
        $price = number_format($price / 1000000, 2) . ' میلیون';
    } elseif ($price >= 1000) {
        $price = number_format($price / 1000, 2) . ' هزار';
    } else {
        $price = round($price, 2);
    }

    return $price;
}

function convertPersianToEnglish($string)
{
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    $output = str_replace($persian, $english, $string);
    return $output;
}

function get_langs()
{
    return config('app.locales');
}

function get_current_url($lang)
{
    $locale = request()->segment(1);
    $current_url = request()->url();

    if (!$locale || !array_key_exists($locale, get_langs())) {
        $index = url('/');

        $url = str_replace_first($index, $index . '/' . $lang, $current_url);
    } else {
        $url = str_replace_first($locale, $lang, $current_url);
    }

    return $url;
}

function local_info()
{
    $local = app()->getLocale();

    $locals = get_langs();

    return $locals[$local];
}

function locale_date($date)
{
    if (app()->getLocale() == 'fa') {
        return jdate($date);
    }

    return carbon($date);
}

function str_replace_first($from, $to, $content)
{
    $from = '/' . preg_quote($from, '/') . '/';

    return preg_replace($from, $to, $content, 1);
}

function aparat_iframe($string)
{
    $p = '/^(?:https?:\/\/)?(?:www\.)?(?:aparat\.com\/v\/)(\w*)(?:\S+)?$/';
    preg_match($p, $string, $matches);

    if (empty($matches)) {
        return '';
    }

    return '<div class="h_iframe-aparat_embed_frame"><span style="display: block;padding-top: 57%">.</span><iframe data-src="https://www.aparat.com/video/video/embed/videohash/' . $matches[1] . '/vt/frame" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></div>';
}

function theme_asset($path)
{
    return asset(config('front.asset_path') . $path);
}

function theme_path($path)
{
    return base_path(config('front.theme_path') . $path);
}

function prepareNumber($num)
{
    if (gettype($num) == "integer" || gettype($num) == "double") {
        $num = (string) $num;
    }
    $length = strlen($num) % 3;
    if ($length == 1) {
        $num = "00" . $num;
    } else if ($length == 2) {
        $num = "0" . $num;
    }
    return str_split($num, 3);
}
function threeNumbersToLetter($num, $words, $splitter)
{
    if ((int) preg_replace('/\D/', '', $num) == 0) {
        return "";
    }
    $parsedInt = (int) preg_replace('/\D/', '', $num);
    if ($parsedInt < 10) {
        return $words[0][$parsedInt];
    }
    if ($parsedInt <= 20) {
        return $words[1][$parsedInt - 10];
    }
    if ($parsedInt < 100) {
        $one = $parsedInt % 10;
        $ten = ($parsedInt - $one) / 10;
        if ($one > 0) {
            return $words[2][$ten] . $splitter . $words[0][$one];
        }
        return $words[2][$ten];
    }
    $one        = $parsedInt % 10;
    $hundreds   = ($parsedInt - $parsedInt % 100) / 100;
    $ten        = ($parsedInt - (($hundreds * 100) + $one)) / 10;
    $out        = [$words[3][$hundreds]];
    $secondPart = (($ten * 10) + $one);
    if ($secondPart > 0) {
        if ($secondPart < 10) {
            array_push($out, $words[0][$secondPart]);
        } else if ($secondPart <= 20) {
            array_push($out, $words[1][$secondPart - 10]);
        } else {
            array_push($out, $words[2][$ten]);
            if ($one > 0) {
                array_push($out, $words[0][$one]);
            }
        }
    }
    return join($splitter, $out);
}

function convert_number($number)
{
    $words = [
        [
            "",
            "یک",
            "دو",
            "سه",
            "چهار",
            "پنج",
            "شش",
            "هفت",
            "هشت",
            "نه"
        ],
        [
            "ده",
            "یازده",
            "دوازده",
            "سیزده",
            "چهارده",
            "پانزده",
            "شانزده",
            "هفده",
            "هجده",
            "نوزده",
            "بیست"
        ],
        [
            "",
            "",
            "بیست",
            "سی",
            "چهل",
            "پنجاه",
            "شصت",
            "هفتاد",
            "هشتاد",
            "نود"
        ],
        [
            "",
            "یکصد",
            "دویست",
            "سیصد",
            "چهارصد",
            "پانصد",
            "ششصد",
            "هفتصد",
            "هشتصد",
            "نهصد"
        ],
        [
            '',
            " هزار ",
            " میلیون ",
            " میلیارد ",
            " بیلیون ",
            " بیلیارد ",
            " تریلیون ",
            " تریلیارد ",
            " کوآدریلیون ",
            " کادریلیارد ",
            " کوینتیلیون ",
            " کوانتینیارد ",
            " سکستیلیون ",
            " سکستیلیارد ",
            " سپتیلیون ",
            " سپتیلیارد ",
            " اکتیلیون ",
            " اکتیلیارد ",
            " نانیلیون ",
            " نانیلیارد ",
            " دسیلیون "
        ]
    ];
    $splitter = " و ";


    $zero = "صفر";
    if ($number == 0) {
        return $zero;
    }
    if (strlen($number) > 66) {
        return "خارج از محدوده";
    }
    //Split to sections
    $splittedNumber = prepareNumber($number);
    $result = [];
    $splitLength = count($splittedNumber);
    for ($i = 0; $i < $splitLength; $i++) {
        $sectionTitle = $words[4][$splitLength - ($i + 1)];
        $converted    = threeNumbersToLetter($splittedNumber[$i], $words, $splitter);
        if ($converted !== "") {
            array_push($result, $converted . $sectionTitle);
        }
    }
    return join($splitter, $result);
}

function run_theme_config()
{
    if (function_exists('theme_first_config')) {
        theme_first_config();
    }
}

function barcode($str)
{
    $barcode = new DNS1D();

    if (!is_dir(public_path() . '/uploads/barcodes')) {
        File::makeDirectory(public_path() . '/uploads/barcodes/');
    }

    return asset($barcode->getBarcodePNGPath($str, "C39E", 3, 33, array(0, 0, 0)));
}

function notification_link($notification)
{
    if ($notification->type == 'OrderPaid') {
        if (isset($notification->data['order_id']) && Order::find($notification->data['order_id'])) {
            return route('admin.orders.show', ['order' => $notification->data['order_id']]);
        }
    }

    if ($notification->type == 'UserRegistered') {
        if (isset($notification->data['user_id']) && User::find($notification->data['user_id'])) {
            return route('admin.users.show', ['user' => $notification->data['user_id']]);
        }
    }

    return null;
}

function random_code($letter_count = 2, $number_count = 3)
{
    $numbers = '0123456789';
    $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $letter_count; $i++) {
        $index = rand(0, strlen($numbers) - 1);
        $randomString .= $letters[$index];
    }

    for ($i = 0; $i < $number_count; $i++) {
        $index = rand(0, strlen($numbers) - 1);
        $randomString .= $numbers[$index];
    }

    return str_shuffle($randomString);
}

function getNewPrice($request, $price)
{
    $old_price          = $price->price;
    $old_discount_price = $price->discount_price;
    $new_discount       = $price->discount ?? 0;

    switch ($request->type) {
        case 'increase': {
                if ($request->amount_type == 'percentage') {
                    $new_price          = $old_price + $old_price * ($request->amount / 100);
                    $new_discount_price = $old_discount_price + $old_discount_price * ($request->amount / 100);
                } else {
                    $new_price          = $old_price + $request->amount;
                    $new_discount_price = $old_discount_price + $request->amount;
                }

                break;
            }

        case 'decrease': {
                if ($request->amount_type == 'percentage') {
                    $new_price          = $old_price - $old_price * ($request->amount / 100);
                    $new_discount_price = $old_discount_price - $old_discount_price * ($request->amount / 100);
                } else {
                    $new_price          = $old_price - $request->amount;
                    $new_discount_price = $old_discount_price - $request->amount;
                }

                break;
            }

        case 'discount': {
                $new_price          = $old_price;
                $new_discount_price = $old_price - ($old_price * ($request->discount / 100));
                $new_discount       = $request->discount;

                break;
            }

        case 'fake_discount': {
                $new_price          = ($old_price * 100) / (100 - intval($request->discount));
                $new_discount_price = $old_price;
                $new_discount       = $request->discount;

                break;
            }

        case 'remove_fake_discount': {
                $new_price          = $old_discount_price;
                $new_discount_price = $old_discount_price;
                $new_discount       = 0;

                break;
            }
    }

    $new_price          = ceil($new_price / 100) * 100;
    // $new_discount_price = $new_price - ($new_discount * ($new_price / 100));
    $new_discount_price = ceil($new_discount_price / 100) * 100;

    return [
        'discount_price' => $new_discount_price,
        'regular_price'  => $new_price,
        'price'          => $new_price,
        'discount'       => $new_discount,
    ];
}

function percentageDifference($num1, $num2)
{
    $average              = ($num1 + $num2) / 2;
    $absoluteDifference   = abs($num1 - $num2);
    $percentageDifference = ($absoluteDifference / $average) * 100;

    return $percentageDifference;
}

function row_number($collection, $loop)
{
    return ($collection->currentpage() - 1) * $collection->perpage() + $loop->index + 1;
}

function truncateText($text, $maxLength = 40) {
    return mb_strlen($text) > $maxLength ? mb_substr($text, 0, $maxLength - 3) . '...' : $text;
}
