<?php

use App\Models\Page;
use App\Models\Post;
use App\Models\Banner;
use App\Models\Slider;
use App\Models\Widget;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;

function get_widget($widget)
{
    $variables = [];

    switch ($widget->key) {
        case 'main-slider': {
            $variables['main_sliders'] = Slider::detectLang()->where('group', 'main_sliders')
                ->where('published', true)
                ->orderBy('ordering', $widget->option('ordering', 'asc'))
                ->take($widget->option('number', 5))
                ->get();

            $variables['mobile_sliders'] = Slider::detectLang()->where('group', 'mobile_sliders')
                ->where('published', true)
                ->orderBy('ordering', $widget->option('ordering', 'asc'))
                ->take($widget->option('number', 5))
                ->get();

            $variables['index_slider_banners'] = Banner::detectLang()->where('group', 'index_slider_banners')
                ->where('published', true)
                ->orderBy('ordering', $widget->option('ordering', 'asc'))
                ->take(2)
                ->get();

            break;
        }

        case 'fullscreen-slider': {
            $variables['fullscreen_slider'] = Slider::detectLang()->where('group', 'fullscreen_slider')
                ->where('published', true)
                ->orderBy('ordering', $widget->option('ordering', 'asc'))
                ->take($widget->option('number', 5))
                ->get();

            $variables['mobile_sliders'] = Slider::detectLang()->where('group', 'mobile_sliders')
                ->where('published', true)
                ->orderBy('ordering', $widget->option('ordering', 'asc'))
                ->take($widget->option('number', 5))
                ->get();

            break;
        }

        case 'middle-banners': {
            $variables['index_middle_banners'] = Banner::detectLang()->where('group', 'index_middle_banners')
                ->where('published', true)
                ->orderBy('ordering', $widget->option('ordering', 'asc'))
                ->take($widget->option('number', 2))
                ->get();

            break;
        }

        case 'sevices-sliders': {
            $variables['sevices_sliders'] = Slider::detectLang()->where('group', 'sevices_sliders')
                ->where('published', true)
                ->orderBy('ordering')
                ->take($widget->option('number', 2))
                ->get();

            break;
        }

        case 'categories': {

            $ids = [];
            $category_filter = $widget->options->where('key', 'categories')->first();

            if ($category_filter && $category_filter->hasCategory()) {
                $ids = $category_filter->categories()->pluck('categories.id');
            }

            $variables['categories'] = Category::detectLang()->published()->where('type', 'productcat')
                ->orderBy('ordering')
                ->whereIn('id', $ids)
                ->get();

            break;
        }
        case 'posts': {
            $posts = Post::detectLang();

            $category_filter = $widget->options->where('key', 'categories')->first();

            if ($category_filter && $category_filter->hasCategory()) {

                $ids = $category_filter->categories()->pluck('categories.id');
                $categories = [];

                foreach ($ids as $id) {
                    $category = Category::find($id);

                    if ($category) {
                        $categories = array_merge($categories, $category->allChildCategories());
                    }
                }

                $posts->whereIn('category_id', $categories);
            }

            switch ($widget->option('sort_type', 'latest')) {
                case 'latest': {
                    $posts->latest();
                    break;
                }
                case 'view': {
                    $posts->orderBy('view', 'desc');
                    break;
                }
            }

            $posts->published()->latest()->take($widget->option('number', 10));

            $variables['posts'] = $posts->get();

            break;
        }

        case 'products-default-block':
        case 'products-colorful-block': {
            $products = Product::detectLang()
                ->with('lowestPrice', 'category:id,title,slug,type')
                ->select(
                    'id',
                    'title',
                    'type',
                    'category_id',
                    'slug',
                    'image',
                    'special',
                    'image_alt'
                );

            $category_filter = $widget->options->where('key', 'categories')->first();

            if ($category_filter && $category_filter->hasCategory()) {

                $ids = $category_filter->categories()->pluck('categories.id');
                $categories = [];

                foreach ($ids as $id) {
                    $category = Category::find($id);

                    if ($category && $widget->option('sub_category_products', 'yes') == 'yes') {
                        $categories = array_merge($categories, $category->allChildCategories());
                    } else if ($category) {
                        $categories = array_merge($categories, [$category->id]);
                    }
                }

                $products->whereIn('category_id', $categories);
            }


            switch ($widget->option('order_by_stock', 'yes')) {
                case 'yes': {
                    $products->orderByStock();
                    break;
                }
            }

            switch ($widget->option('products_type', 'all')) {
                case 'discount': {
                    $products->discount();
                    break;
                }
                case 'special': {
                    $products->special();
                    break;
                }
            }

            switch ($widget->option('inventory_status', 'all')) {
                case 'available': {
                    $products->available();
                    break;
                }
                case 'unavailable': {
                    $products->unavailable();
                    break;
                }
            }

            switch ($widget->option('sort_type', 'latest')) {
                case 'latest': {
                    $products->latest();
                    break;
                }
                case 'sell': {
                    $products->orderBy('sell', 'desc');
                    break;
                }
                case 'view': {
                    $products->orderBy('view', 'desc');
                    break;
                }
                case 'cheapest': {
                    $products->orderByPrice('asc');
                    break;
                }
                case 'expensivest': {
                    $products->orderByPrice('desc');
                    break;
                }
            }

            $products->published()->latest()->take($widget->option('number', 10));

            $variables['products'] = $products->get();

            break;
        }

        case 'products-discount-block': {
            $discount = Discount::find($widget->option("discount_id"));

            $discount_products = $discount->allProducts()->pluck("id");
            $products = Product::detectLang()->whereIn("id", $discount_products)
                ->with('lowestPrice', 'category:id,title,slug,type')
                ->select(
                    'id',
                    'title',
                    'type',
                    'category_id',
                    'slug',
                    'image',
                    'special',
                    'image_alt'
                );

            switch ($widget->option('order_by_stock', 'yes')) {
                case 'yes': {
                    $products->orderByStock();
                    break;
                }
            }

            switch ($widget->option('inventory_status', 'all')) {
                case 'available': {
                    $products->available();
                    break;
                }
                case 'unavailable': {
                    $products->unavailable();
                    break;
                }
            }

            switch ($widget->option('sort_type', 'latest')) {
                case 'latest': {
                    $products->latest();
                    break;
                }
                case 'sell': {
                    $products->orderBy('sell', 'desc');
                    break;
                }
                case 'view': {
                    $products->orderBy('view', 'desc');
                    break;
                }
                case 'cheapest': {
                    $products->orderByPrice('asc');
                    break;
                }
                case 'expensivest': {
                    $products->orderByPrice('desc');
                    break;
                }
            }

            $products->published()->latest()->take($widget->option('number', 10));


            $variables['products'] = $products->get();
            $variables['timer']   = jdate($discount->end_date)->getTimestamp() * 1000;

            break;
        }
        case 'custom-page': {
            $variables['page'] = Page::find($widget->option("page_id"));
            $variables['block_color'] = $widget->option("block_color");

            break;
        }
    }

    return $variables;
}

function widget_seeder()
{
    $theme = current_theme_name();

    $widget_exists = Widget::where('theme', $theme)->first();

    if (!$widget_exists) {
        $widgets = [
            [
                'widget' => [
                    'title' => 'اسلایدر اصلی و بنر کناری',
                    'key' => 'main-slider',
                    'theme' => $theme,
                    'ordering' => 1
                ],
                'options' => [
                    [
                        'key' => 'number',
                        'value' => '10',
                    ],
                    [
                        'key' => 'banner_position',
                        'value' => 'left',
                    ]
                ]
            ],
            [
                'widget' => [
                    'title' => 'محصولات تخفیف دار',
                    'key' => 'products-default-block',
                    'theme' => $theme,
                    'ordering' => 2
                ],
                'options' => [
                    [
                        'key' => 'title',
                        'value' => 'محصولات تخفیف دار',
                    ],
                    [
                        'key' => 'products_type',
                        'value' => 'discount',
                    ],
                    [
                        'key' => 'inventory_status',
                        'value' => 'available',
                    ],
                    [
                        'key' => 'sort_type',
                        'value' => 'latest',
                    ],
                    [
                        'key' => 'order_by_stock',
                        'value' => 'yes',
                    ],
                    [
                        'key' => 'link',
                        'value' => '/product/discount',
                    ],
                    [
                        'key' => 'link_title',
                        'value' => 'مشاهده همه',
                    ],
                    [
                        'key' => 'number',
                        'value' => '10',
                    ],
                ]
            ],
            [
                'widget' => [
                    'title' => 'محصولات ویژه',
                    'key' => 'products-colorful-block',
                    'theme' => $theme,
                    'ordering' => 3
                ],
                'options' => [
                    [
                        'key' => 'products_type',
                        'value' => 'special',
                    ],
                    [
                        'key' => 'inventory_status',
                        'value' => 'available',
                    ],
                    [
                        'key' => 'sort_type',
                        'value' => 'latest',
                    ],
                    [
                        'key' => 'order_by_stock',
                        'value' => 'yes',
                    ],
                    [
                        'key' => 'link',
                        'value' => '/product/specials',
                    ],
                    [
                        'key' => 'link_title',
                        'value' => 'مشاهده همه',
                    ],
                    [
                        'key' => 'block_color',
                        'value' => '#ef394e',
                    ],
                    [
                        'key' => 'image',
                        'value' => theme_asset("img/theme/amazing-1.png"),
                    ],
                    [
                        'key' => 'number',
                        'value' => '10',
                    ],
                ]
            ],
            [
                'widget' => [
                    'title' => 'بنر دوتایی',
                    'key' => 'middle-banners',
                    'theme' => $theme,
                    'ordering' => 4
                ],
                'options' => [
                    [
                        'key' => 'number',
                        'value' => '2',
                    ]
                ]
            ],
            [
                'widget' => [
                    'title' => 'دسته بندی ها',
                    'key' => 'categories',
                    'theme' => $theme,
                    'ordering' => 5
                ],
                'options' => [
                    [
                        'key' => 'categories',
                        'value' => 'on',
                        'type' => 'product_categories',
                        'categories' => Category::where('show_in_index', 1)->pluck('id')
                    ]
                ]
            ],
            [
                'widget' => [
                    'title' => 'جدید ترین محصولات',
                    'key' => 'products-default-block',
                    'theme' => $theme,
                    'ordering' => 6
                ],
                'options' => [
                    [
                        'key' => 'title',
                        'value' => 'جدید ترین محصولات',
                    ],
                    [
                        'key' => 'products_type',
                        'value' => 'all',
                    ],
                    [
                        'key' => 'inventory_status',
                        'value' => 'all',
                    ],
                    [
                        'key' => 'sort_type',
                        'value' => 'latest',
                    ],
                    [
                        'key' => 'order_by_stock',
                        'value' => 'no',
                    ],
                    [
                        'key' => 'number',
                        'value' => '10',
                    ],
                ]
            ],
            [
                'widget' => [
                    'title' => 'پرفروش ترین محصولات',
                    'key' => 'products-colorful-block',
                    'theme' => $theme,
                    'ordering' => 7
                ],
                'options' => [
                    [
                        'key' => 'products_type',
                        'value' => 'all',
                    ],
                    [
                        'key' => 'inventory_status',
                        'value' => 'available',
                    ],
                    [
                        'key' => 'sort_type',
                        'value' => 'sell',
                    ],
                    [
                        'key' => 'order_by_stock',
                        'value' => 'yes',
                    ],
                    [
                        'key' => 'block_color',
                        'value' => '#304ffe',
                    ],
                    [
                        'key' => 'image',
                        'value' => theme_asset("img/theme/amazing-2.png"),
                    ],
                    [
                        'key' => 'number',
                        'value' => '10',
                    ],
                ]
            ],
            [
                'widget' => [
                    'title' => 'اسلایدر خدمات',
                    'key' => 'sevices-sliders',
                    'theme' => $theme,
                    'ordering' => 9
                ],
                'options' => [
                    [
                        'key' => 'number',
                        'value' => '4',
                    ],
                ]
            ],
        ];

        foreach ($widgets as $widget) {
            $w = Widget::create($widget['widget']);

            foreach ($widget['options'] as $option) {

                switch ($option['type'] ?? '') {
                    case 'product_categories': {

                        $w_option = $w->options()->create([
                            'key' => $option['key'],
                            'value' => $option['value']
                        ]);

                        $w_option->categories()->sync($option['categories']);

                        break;
                    }

                    default: {
                        $w->options()->create($option);
                    }
                }
            }
        }
    }
}

function theme_first_config()
{
    widget_seeder();

    if (!option('info_footer_text')) {
        option_update('info_footer_text', 'کلیه حقوق این فروشگاه محفوظ است');
    }
}
