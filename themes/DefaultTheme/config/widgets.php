<?php

return [
    'main-slider' => [
        'title' => 'اسلایدر اصلی و بنر کناری',
        'image' => 'widgets/slider.jpg',
        'options' => [
            [
                'title' => 'تعداد اسلایدر',
                'key' => 'number',
                'input-type' => 'input',
                'type' => 'number',
                'default' => '5',
                'class' => 'col-md-4 col-6',
                'attributes' => 'required'
            ],
            [
                'title' => 'جایگاه بنر',
                'key' => 'banner_position',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'left',
                        'title' => 'سمت چپ'
                    ],
                    [
                        'value' => 'right',
                        'title' => 'سمت راست'
                    ]
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'ترتیب نمایش',
                'key' => 'ordering',
                'input-type' => 'select',
                'class' => 'col-md-4',
                'options' => [
                    [
                        'value' => 'asc',
                        'title' => 'صعودی'
                    ],
                    [
                        'value' => 'desc',
                        'title' => 'نزولی'
                    ]
                ],
            ],
        ],
        'rules' => [
            'number' => 'required',
            'banner_position' => 'required|in:right,left'
        ]
    ],
    'fullscreen-slider' => [
        'title' => 'اسلایدر تمام صفحه',
        'image' => 'widgets/fullscreen.jpg',
        'options' => [
            [
                'title' => 'تعداد اسلایدر',
                'key' => 'number',
                'input-type' => 'input',
                'type' => 'number',
                'default' => '5',
                'class' => 'col-md-4 col-6',
                'attributes' => 'required'
            ],
            [
                'title' => 'ترتیب نمایش',
                'key' => 'ordering',
                'input-type' => 'select',
                'class' => 'col-md-4',
                'options' => [
                    [
                        'value' => 'asc',
                        'title' => 'صعودی'
                    ],
                    [
                        'value' => 'desc',
                        'title' => 'نزولی'
                    ]
                ],
            ],
        ],
        'rules' => [
            'number' => 'required',
        ]
    ],

    'products-discount-block' => [
        'title' => 'کادر محصولات تخفیف دار',
        'image' => 'widgets/products-default.jpg',
        'options' => [
            [
                'title' => 'عنوان',
                'key' => 'title',
                'input-type' => 'input',
                'type' => 'text',
                'class' => 'col-md-4 col-6',
            ],
            [
                'title' => 'وضعیت موجودی',
                'key' => 'inventory_status',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'all',
                        'title' => 'همه'
                    ],
                    [
                        'value' => 'available',
                        'title' => 'موجود'
                    ],
                    [
                        'value' => 'unavailable',
                        'title' => 'نا موجود'
                    ],
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'نوع مرتب سازی',
                'key' => 'sort_type',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'latest',
                        'title' => 'جدیدترین'
                    ],
                    [
                        'value' => 'sell',
                        'title' => 'پرفروش ترین'
                    ],
                    [
                        'value' => 'view',
                        'title' => 'پربازدید ترین'
                    ],
                    [
                        'value' => 'cheapest',
                        'title' => 'ارزانترین'
                    ],
                    [
                        'value' => 'expensivest',
                        'title' => 'گرانترین'
                    ],
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'لینک',
                'key' => 'link',
                'input-type' => 'input',
                'type' => 'text',
                'class' => 'col-md-4 col-6',
            ],
            [
                'title' => 'عنوان لینک',
                'key' => 'link_title',
                'input-type' => 'input',
                'type' => 'text',
                'class' => 'col-md-4 col-6',
            ],
            [
                'title' => 'نمایش محصولات موجود در اول',
                'key' => 'order_by_stock',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'yes',
                        'title' => 'بله'
                    ],
                    [
                        'value' => 'no',
                        'title' => 'خیر'
                    ]
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'تعداد',
                'key' => 'number',
                'input-type' => 'input',
                'type' => 'number',
                'class' => 'col-md-4 col-6',
                'default' => '10',
                'attributes' => 'required'
            ],
            [
                'title' => 'تخفیف مورد نظر',
                'key' => 'discount_id',
                'input-type' => 'discount_products',
                'class' => 'col-md-9',
                'attributes' => 'required'
            ],
        ],
        'rules' => [
            'inventory_status' => 'required|in:all,available,unavailable',
            'sort_type' => 'required|in:latest,sell,view,cheapest,expensivest',
            'order_by_stock' => 'required|in:yes,no',
            'link' => 'nullable|string',
            'link_title' => 'nullable|string',
            'number' => 'required',
        ]
    ],

    'products-default-block' => [
        'title' => 'کادر محصولات ساده',
        'image' => 'widgets/products-default.jpg',
        'options' => [
            [
                'title' => 'عنوان',
                'key' => 'title',
                'input-type' => 'input',
                'type' => 'text',
                'class' => 'col-md-4 col-6',
            ],
            [
                'title' => 'نوع محصولات',
                'key' => 'products_type',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'all',
                        'title' => 'همه'
                    ],
                    [
                        'value' => 'discount',
                        'title' => 'تخفیف خورده'
                    ],
                    [
                        'value' => 'special',
                        'title' => 'پیشنهاد ویژه'
                    ],
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'وضعیت موجودی',
                'key' => 'inventory_status',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'all',
                        'title' => 'همه'
                    ],
                    [
                        'value' => 'available',
                        'title' => 'موجود'
                    ],
                    [
                        'value' => 'unavailable',
                        'title' => 'نا موجود'
                    ],
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'نوع مرتب سازی',
                'key' => 'sort_type',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'latest',
                        'title' => 'جدیدترین'
                    ],
                    [
                        'value' => 'sell',
                        'title' => 'پرفروش ترین'
                    ],
                    [
                        'value' => 'view',
                        'title' => 'پربازدید ترین'
                    ],
                    [
                        'value' => 'cheapest',
                        'title' => 'ارزانترین'
                    ],
                    [
                        'value' => 'expensivest',
                        'title' => 'گرانترین'
                    ],
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'لینک',
                'key' => 'link',
                'input-type' => 'input',
                'type' => 'text',
                'class' => 'col-md-4 col-6',
            ],
            [
                'title' => 'عنوان لینک',
                'key' => 'link_title',
                'input-type' => 'input',
                'type' => 'text',
                'class' => 'col-md-4 col-6',
            ],
            [
                'title' => 'نمایش محصولات موجود در اول',
                'key' => 'order_by_stock',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'yes',
                        'title' => 'بله'
                    ],
                    [
                        'value' => 'no',
                        'title' => 'خیر'
                    ]
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'تعداد',
                'key' => 'number',
                'input-type' => 'input',
                'type' => 'number',
                'class' => 'col-md-4 col-6',
                'default' => '10',
                'attributes' => 'required'
            ],
            [
                'title' => 'انتخاب دسته بندی ها (اختیاری)',
                'key' => 'categories',
                'input-type' => 'product_categories',
                'class' => 'col-md-9',
            ],
            [
                'title' => 'شامل محصولات زیر دسته ها',
                'key' => 'sub_category_products',
                'input-type' => 'select',
                'class' => 'col-md-3',
                'options' => [
                    [
                        'value' => 'yes',
                        'title' => 'بله'
                    ],
                    [
                        'value' => 'no',
                        'title' => 'خیر'
                    ]
                ],
            ],
        ],
        'rules' => [
            'products_type' => 'required|in:all,discount,special',
            'inventory_status' => 'required|in:all,available,unavailable',
            'sort_type' => 'required|in:latest,sell,view,cheapest,expensivest',
            'order_by_stock' => 'required|in:yes,no',
            'link' => 'nullable|string',
            'link_title' => 'nullable|string',
            'number' => 'required',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]
    ],

    'products-colorful-block' => [
        'title' => 'کادر محصولات با پس زمینه',
        'image' => 'widgets/special.jpg',
        'options' => [
            [
                'title' => 'نوع محصولات',
                'key' => 'products_type',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'all',
                        'title' => 'همه'
                    ],
                    [
                        'value' => 'discount',
                        'title' => 'تخفیف خورده'
                    ],
                    [
                        'value' => 'special',
                        'title' => 'پیشنهاد ویژه'
                    ],
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'وضعیت موجودی',
                'key' => 'inventory_status',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'all',
                        'title' => 'همه'
                    ],
                    [
                        'value' => 'available',
                        'title' => 'موجود'
                    ],
                    [
                        'value' => 'unavailable',
                        'title' => 'نا موجود'
                    ],
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'نوع مرتب سازی',
                'key' => 'sort_type',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'latest',
                        'title' => 'جدیدترین'
                    ],
                    [
                        'value' => 'sell',
                        'title' => 'پرفروش ترین'
                    ],
                    [
                        'value' => 'view',
                        'title' => 'پربازدید ترین'
                    ],
                    [
                        'value' => 'cheapest',
                        'title' => 'ارزانترین'
                    ],
                    [
                        'value' => 'expensivest',
                        'title' => 'گرانترین'
                    ],
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'نمایش محصولات موجود در اول',
                'key' => 'order_by_stock',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'yes',
                        'title' => 'بله'
                    ],
                    [
                        'value' => 'no',
                        'title' => 'خیر'
                    ]
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'لینک',
                'key' => 'link',
                'input-type' => 'input',
                'type' => 'text',
                'class' => 'col-md-4 col-6',
            ],
            [
                'title' => 'عنوان لینک',
                'key' => 'link_title',
                'input-type' => 'input',
                'type' => 'text',
                'class' => 'col-md-4 col-6',
            ],
            [
                'title' => 'رنگ پس زمینه کادر',
                'key' => 'block_color',
                'input-type' => 'input',
                'default' => '#ef394e',
                'type' => 'color',
                'class' => 'col-md-4 col-6',
            ],
            [
                'title' => 'تصویر',
                'key' => 'image',
                'input-type' => 'file',
                'type' => 'file',
                'class' => 'col-md-4 col-6',
                'attributes' => 'accept="image/*"',
                'help' => 'بهترین اندازه 850 * 500'
            ],
            [
                'title' => 'تعداد',
                'key' => 'number',
                'input-type' => 'input',
                'type' => 'number',
                'class' => 'col-md-4 col-6',
                'default' => '10',
                'attributes' => 'required'
            ],
            [
                'title' => 'انتخاب دسته بندی ها (اختیاری)',
                'key' => 'categories',
                'input-type' => 'product_categories',
                'class' => 'col-md-9',
            ],
            [
                'title' => 'شامل محصولات زیر دسته ها',
                'key' => 'sub_category_products',
                'input-type' => 'select',
                'class' => 'col-md-3',
                'options' => [
                    [
                        'value' => 'yes',
                        'title' => 'بله'
                    ],
                    [
                        'value' => 'no',
                        'title' => 'خیر'
                    ]
                ],
            ],
        ],
        'rules' => [
            'products_type' => 'required|in:all,discount,special',
            'inventory_status' => 'required|in:all,available,unavailable',
            'sort_type' => 'required|in:latest,sell,view,cheapest,expensivest',
            'order_by_stock' => 'required|in:yes,no',
            'link' => 'nullable|string',
            'link_title' => 'nullable|string',
            'block_color' => 'nullable|string',
            'number' => 'required',
            'image' => 'nullable|image',
        ]
    ],

    'middle-banners' => [
        'title' => 'بنر دوتایی',
        'image' => 'widgets/banner.jpg',
        'options' => [
            [
                'title' => 'تعداد قابل نمایش',
                'key' => 'number',
                'input-type' => 'input',
                'type' => 'number',
                'default' => '2',
                'class' => 'col-md-4 col-6',
                'attributes' => 'required'
            ],
            [
                'title' => 'ترتیب نمایش',
                'key' => 'ordering',
                'input-type' => 'select',
                'class' => 'col-md-4',
                'options' => [
                    [
                        'value' => 'asc',
                        'title' => 'صعودی'
                    ],
                    [
                        'value' => 'desc',
                        'title' => 'نزولی'
                    ]
                ],
            ],

        ],
        'rules' => [
            'number' => 'required',
        ]
    ],

    'coworker-sliders' => [
        'title' => 'اسلایدر لوگو همکاران',
        'image' => 'widgets/customer.jpg',
        'options' => [
            [
                'title' => 'تعداد قابل نمایش',
                'key' => 'number',
                'input-type' => 'input',
                'type' => 'number',
                'default' => '10',
                'class' => 'col-md-4 col-6',
                'attributes' => 'required'
            ]

        ],
        'rules' => [
            'number' => 'required',
        ]
    ],

    'sevices-sliders' => [
        'title' => 'اسلایدر خدمات',
        'image' => 'widgets/support.jpg',
        'options' => [
            [
                'title' => 'تعداد قابل نمایش',
                'key' => 'number',
                'input-type' => 'input',
                'type' => 'number',
                'default' => '4',
                'class' => 'col-md-4 col-6',
                'attributes' => 'required'
            ]

        ],
        'rules' => [
            'number' => 'required',
        ]
    ],

    'categories' => [
        'title' => 'دسته بندی محصولات',
        'image' => 'widgets/categories.png',
        'options' => [
            [
                'title' => 'انتخاب دسته بندی ها',
                'key' => 'categories',
                'input-type' => 'product_categories',
                'class' => 'col-md-12',
            ],

        ],
        'rules' => [
            'categories' => 'required|array',
            'categories' => 'required',
            'categories.*' => 'exists:categories,id',
        ]
    ],

    'posts' => [
        'title' => 'نوشته های وبلاگ',
        'image' => 'widgets/posts.png',
        'options' => [
            [
                'title' => 'عنوان',
                'key' => 'title',
                'input-type' => 'input',
                'type' => 'text',
                'class' => 'col-md-4 col-6',
            ],
            [
                'title' => 'نوع مرتب سازی',
                'key' => 'sort_type',
                'input-type' => 'select',
                'class' => 'col-md-4 col-6',
                'options' => [
                    [
                        'value' => 'latest',
                        'title' => 'جدیدترین'
                    ],
                    [
                        'value' => 'view',
                        'title' => 'پربازدید ترین'
                    ],
                ],
                'attributes' => 'required'
            ],
            [
                'title' => 'لینک',
                'key' => 'link',
                'input-type' => 'input',
                'type' => 'text',
                'class' => 'col-md-4 col-6',
            ],
            [
                'title' => 'عنوان لینک',
                'key' => 'link_title',
                'input-type' => 'input',
                'type' => 'text',
                'class' => 'col-md-4 col-6',
            ],
            [
                'title' => 'تعداد',
                'key' => 'number',
                'input-type' => 'input',
                'type' => 'number',
                'class' => 'col-md-4 col-6',
                'default' => '10',
                'attributes' => 'required'
            ],
            [
                'title' => 'انتخاب دسته بندی ها (اختیاری)',
                'key' => 'categories',
                'input-type' => 'post_categories',
                'class' => 'col-md-9',
            ],
        ],
        'rules' => [
            'sort_type' => 'required|in:latest,view',
            'link' => 'nullable|string',
            'link_title' => 'nullable|string',
            'number' => 'required',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]
    ],
    'custom-page' => [
        'title' => 'صفحه سفارشی',
        'image' => 'widgets/posts.png',
        'options' => [
            [
                'title' => 'انتخاب صفحه',
                'key' => 'page_id',
                'input-type' => 'custom-page',
                'class' => 'col-md-9',
            ],
            [
                'title' => 'رنگ پس زمینه کادر',
                'key' => 'block_color',
                'input-type' => 'input',
                'default' => '#ef394e',
                'type' => 'color',
                'class' => 'col-md-4 col-6',
            ],
        ],
        'rules' => [
            'page_id' => 'required',
        ]
    ],
];
