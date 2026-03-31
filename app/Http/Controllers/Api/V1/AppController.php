<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function settings()
    {
        $configs = [
            'requireLogin' => false,
            'toggleSidebar' => true,
            'isBeforeNewProduct' => 3,
            'toggleCheckout' => true,
            'facebook' => "https://www.facebook.com/",
            'instagram' => "https://www.instagram.com/",
            'pinterest' => "https://www.pinterest.com/",
            'twitter' => "https://twitter.com/",
            'phone' => "0123 456 789",
            'email' => "youremail@gmail.com",
            "policy" =>  [
                'fa' => 'sdfdsfsd'
            ],
            "term" =>  [
                'fa' => 'sdfdsfsd'
            ],
            "about" =>  [
                'fa' => 'sdfdsfsd'
            ],
            'address' => ["en" => "123456, your store address"],
            'toggleLoginGoogle' => true,
            'toggleLoginFacebook' => true,
            'toggleLoginSMS' => true,
            'webviewCheckout' => true,
            'toggleWishlist' => true,
            'copyright' => [
                'en' => 'sdfsdfsdfsd',
                'fa' => 'sdfsdfsd'
            ],
            'toggleRatingProduct' => true,
            'toggleReviewProduct' => true,
            'toggleShortDescriptionProduct' => true,
            'toggleAddButtonProduct' => 'true'
        ];


        $template = [
            "id" => "4",
            "name" => "New Template",
            'data' => json_encode([
                [
                    "type" => "products",
                    "name" => "Products List",
                    "icon" => "appstore",
                    "layout" => [
                        "value" => "grid",
                        "options" => [
                            [
                                "key" => "onecolumn",
                                "name" => "1 Column"
                            ],
                            [
                                "key" => "twocolumns",
                                "name" => "2 Columns"
                            ],
                            [
                                "key" => "threecolumns",
                                "name" => "3 Columns"
                            ],
                            [
                                "key" => "grid",
                                "name" => "Grid"
                            ],
                            [
                                "key" => "list",
                                "name" => "List"
                            ]
                        ]
                    ],
                    "fields" => [
                        [
                            "key" => "boxed",
                            "field" => "switch",
                            "value" => false,
                            "defaultValue" => false,
                            "name" => "Boxed"
                        ],
                        [
                            "key" => "disable_heading",
                            "field" => "switch",
                            "value" => true,
                            "defaultValue" => true,
                            "name" => "Disable heading"
                        ],
                        [
                            "key" => "text_heading",
                            "field" => "text",
                            "value" => [
                                "text" => [
                                    "fa" => "جدیدترین محصولات"
                                ],
                                "style" => []
                            ],
                            "defaultValue" => [],
                            "name" => "Text heading"
                        ],
                        [
                            "key" => "product_type",
                            "field" => "product_type",
                            "placeholder" => "123,456",
                            "value" => [
                                "type" => "latest",
                                "ids" => ""
                            ],
                            "name" => "Type"
                        ],
                        [
                            "key" => "limit",
                            "field" => "input",
                            "value" => 5,
                            "name" => "Limit"
                        ],
                        [
                            "key" => "width",
                            "field" => "input",
                            "value" => 204,
                            "name" => "Width"
                        ],
                        [
                            "key" => "height",
                            "field" => "input",
                            "value" => 257,
                            "name" => "Height"
                        ]
                    ],
                    "spacing" => [
                        [
                            "key" => "padding",
                            "field" => "spacing",
                            "name" => "Padding",
                            "value" => [
                                "paddingTop" => 0,
                                "paddingRight" => 0,
                                "paddingBottom" => 0,
                                "paddingLeft" => 0
                            ]
                        ],
                        [
                            "key" => "margin",
                            "field" => "spacing",
                            "name" => "Margin",
                            "value" => [
                                "marginTop" => 0,
                                "marginRight" => 10,
                                "marginBottom" => 0,
                                "marginLeft" => 10
                            ]
                        ]
                    ],
                    "id" => "a328504c-db2b-45e3-8a5a-d011a805ff23"
                ]
            ]),
            'settings' => json_encode([
                [
                    "type" => "app_config",
                    "name" => "App config",
                    "fields" => [
                        [
                            "key" => "logo",
                            "field" => "image",
                            "value" => [
                                "fa" => "https://wordpress.ideal-it.ir/wp-content/uploads/2021/12/1613630806_logo.png"
                            ],
                            "name" => "Logo"
                        ],
                        [
                            "key" => "layout_category",
                            "field" => "select",
                            "options" => [
                                [
                                    "name" => "Style 1",
                                    "value" => "category1"
                                ],
                                [
                                    "name" => "Style 2",
                                    "value" => "category2"
                                ],
                                [
                                    "name" => "Style 3",
                                    "value" => "category3"
                                ],
                                [
                                    "name" => "Style 4",
                                    "value" => "category4"
                                ]
                            ],
                            "value" => "category1",
                            "defaultValue" => "category1",
                            "name" => "Layout Category"
                        ],
                        [
                            "key" => "text_category",
                            "field" => "text",
                            "value" => [
                                "text" => [
                                    "en" => "Up to 40% Off Holiday Bit",
                                    "fa" => "نمایش تخفیف دار ها"
                                ],
                                "style" => []
                            ],
                            "defaultValue" => [],
                            "name" => "Category Text"
                        ]
                    ]
                ],
                [
                    "type" => "colors",
                    "name" => "Colors",
                    "fields" => [
                        [
                            "key" => "primary",
                            "field" => "color",
                            // "value" => "#00CFE8",
                            "value" => "#121212",
                            "name" => "Primary Color"
                        ],
                        [
                            "key" => "secondary",
                            "field" => "color",
                            "value" => "#777777",
                            "name" => "Secondary Color"
                        ],
                        [
                            "key" => "bgColor",
                            "field" => "color",
                            "value" => "#ffffff",
                            "name" => "Background Color"
                        ],
                        [
                            "key" => "bgColorSecondary",
                            "field" => "color",
                            "value" => "#f4f4f4",
                            "name" => "Background Secondary Color"
                        ]
                    ]
                ],
                [
                    "type" => "popup",
                    "name" => "Popup",
                    "fields" => [
                        [
                            "key" => "enable",
                            "field" => "switch",
                            "value" => false,
                            "name" => "Enable popup"
                        ],
                        [
                            "key" => "heading",
                            "field" => "text",
                            "value" => [
                                "text" => [
                                    "en" => ""
                                ],
                                "style" => []
                            ],
                            "defaultValue" => [],
                            "name" => "Heading"
                        ],
                        [
                            "key" => "title",
                            "field" => "text",
                            "value" => [
                                "text" => [
                                    "en" => ""
                                ],
                                "style" => []
                            ],
                            "defaultValue" => [],
                            "name" => "Title"
                        ],
                        [
                            "key" => "description",
                            "field" => "text",
                            "value" => [
                                "text" => [
                                    "en" => ""
                                ],
                                "style" => []
                            ],
                            "defaultValue" => [],
                            "name" => "Description"
                        ],
                        [
                            "key" => "text_button",
                            "field" => "text",
                            "value" => [
                                "text" => [
                                    "en" => ""
                                ],
                                "style" => []
                            ],
                            "defaultValue" => [],
                            "name" => "Button Name"
                        ],
                        [
                            "key" => "action_button",
                            "field" => "action",
                            "name" => "Action Button"
                        ]
                    ]
                ]
            ]),
            "status" => "1",
            "date_created" => "2021-12-12 08:27:52",
            "date_updated" => "2021-12-12 08:27:55"
        ];

        $templates = [
            ($template)
        ];

        $settings = [
            'language' => 'fa',
            'languages' => [],
            'currencies' => [],
            'currency' => 'IRR',
            'enable_guest_checkout' => 'yes',
            'timezone_string' => '+00:00',
            'date_format' => 'F j, Y',
            'time_format' => 'g:i a',

            'configs' => $configs,

            'templates' => $templates
        ];

        return $this->apiResponse(['result' => $settings]);
    }
}
