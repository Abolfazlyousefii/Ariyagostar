<?php

namespace App\Http\Controllers\Back;

use App\Models\Page;
use App\Models\Widget;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WidgetController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Widget::class, 'widget');

        if (!config('front.home-widgets')) {
            abort(404);
        }
    }

    public function index()
    {
        $theme = get_current_theme();
        $widgets = Widget::detectLang()->where('theme', $theme['name'] ?? '')
            ->orderBy('ordering')
            ->get();

        return view('back.widgets.index', compact('widgets'));
    }

    public function create()
    {
        return view('back.widgets.create');
    }

    public function store(Request $request)
    {
        $keys = implode(',', array_keys(config('front.home-widgets')));

        $request->validate([
            'key' => "required|in:$keys",
            'options' => 'required|array',
            'is_active' => 'boolean'
        ]);

        $key = config('front.home-widgets.' . $request->key);

        Validator::make($request->options, $key['rules'])->validate();

        $widget = Widget::create([
            'title' => $request->title,
            'key' => $request->key,
            'is_active' => $request->is_active,
            'theme' => current_theme_name(),
            'lang' => app()->getLocale(),
        ]);

        $options = $this->getRequestOptions($key, $request, $widget);

        $this->saveWidgetOptions($widget, $options);

        toastr()->success('ابزارک با موفقیت ایجاد شد');

        return response('success');
    }

    public function edit(Widget $widget)
    {
        $template = $this->template($widget->key, $widget);

        return view('back.widgets.edit', compact('widget', 'template'));
    }

    public function update(Widget $widget, Request $request)
    {
        $keys = implode(',', array_keys(config('front.home-widgets')));

        $request->validate([
            'key' => "required|in:$keys",
            'options' => 'required|array',
            'is_active' => 'boolean'
        ]);

        $key = config('front.home-widgets.' . $request->key);

        Validator::make($request->options, $key['rules'])->validate();

        $widget->update([
            'title' => $request->title,
            'key' => $request->key,
            'is_active' => $request->is_active,
        ]);

        $options = $this->getRequestOptions($key, $request, $widget);

        $widget->options()->delete();

        $this->saveWidgetOptions($widget, $options);

        toastr()->success('ابزارک با موفقیت ویرایش شد');

        return response('success');
    }

    public function destroy(Widget $widget)
    {
        $widget->delete();

        return response('success');
    }

    public function sort(Request $request)
    {
        $this->authorize('themes.widgets');

        $this->validate($request, [
            'widgets' => 'required|array'
        ]);

        $i = 1;

        foreach ($request->widgets as $widget) {
            Widget::findOrFail($widget)->update([
                'ordering' => $i++,
            ]);
        }
        ;

        return response('success');
    }

    public function template($key, $widget = null)
    {
        $this->authorize('themes.widgets');

        $options = config('front.home-widgets.' . $key . '.options');

        $product_categories = Category::detectLang()->where('type', 'productcat')->orderBy('ordering')->get();
        $post_categories = Category::detectLang()->where('type', 'postcat')->orderBy('ordering')->get();
        $pages = Page::detectLang()->where("published", 1)->get();
        $discount_products = Discount::where("method", "direct")->get();

        if (!$options) {
            return '';
        }

        return view('back.widgets.template', compact(
            'options',
            'widget',
            'product_categories',
            'post_categories',
            'discount_products',
            'pages'
        ));
    }

    private function getRequestOptions($key, $request, Widget $widget)
    {
        $options = [];

        foreach ($key['options'] as $key => $option) {
            switch ($option['input-type']) {
                case 'input': {
                    $options[$key]['input-type'] = $option['input-type'];
                    $options[$key]['key'] = $option['key'];
                    $options[$key]['value'] = $request->input('options.' . $option['key']);
                    break;
                }

                case 'file': {
                    $file = $request->file('options.' . $option['key']);

                    if ($file) {
                        $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('widgets', $name);
                        $options[$key]['value'] = '/uploads/' . $path;
                    } else {
                        $options[$key]['value'] = $widget->option($option['key']);
                    }

                    $options[$key]['input-type'] = $option['input-type'];
                    $options[$key]['key'] = $option['key'];

                    break;
                }

                case 'select': {
                    $options[$key]['input-type'] = $option['input-type'];
                    $options[$key]['key'] = $option['key'];
                    $options[$key]['value'] = $request->input('options.' . $option['key']);
                    break;
                }

                case 'post_categories':
                case 'custom-page':
                case 'product_categories': {
                    $options[$key]['input-type'] = $option['input-type'];
                    $options[$key]['key'] = $option['key'];
                    $options[$key]['value'] = $request->input('options.' . $option['key']);
                    break;
                }

                case 'discount_products': {
                    $options[$key]['input-type'] = $option['input-type'];
                    $options[$key]['key'] = $option['key'];
                    $options[$key]['value'] = $request->input('options.' . $option['key']);
                    break;
                }
            }
        }

        return $options;
    }

    private function saveWidgetOptions(Widget $widget, $options)
    {
        foreach ($options as $option) {
            switch ($option['input-type']) {
                case 'post_categories':
                case 'product_categories': {
                    $value = is_array($option['value']) && !empty($option['value']) ? 'on' : 'off';

                    $inserted_option = $widget->options()->create([
                        'key' => $option['key'],
                        'value' => $value
                    ]);

                    $inserted_option->categories()->sync($option['value']);

                    break;
                }

                default: {
                    $widget->options()->create([
                        'key' => $option['key'],
                        'value' => $option['value']
                    ]);
                }
            }
        }
    }
}
