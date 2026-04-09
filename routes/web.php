<?php

use App\Http\Controllers\Back\ApikeyController;
use App\Http\Controllers\Back\ProvinceController;
use App\Http\Controllers\Back\MainController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\ProductController;
use App\Http\Controllers\Back\BrandController;
use App\Http\Controllers\Back\FilterController;
use App\Http\Controllers\Back\AttributeGroupController;
use App\Http\Controllers\Back\AttributeController;
use App\Http\Controllers\Back\BackupController;
use App\Http\Controllers\Back\SpecTypeController;
use App\Http\Controllers\Back\PostController;
use App\Http\Controllers\Back\CategoryController;
use App\Http\Controllers\Back\PageController;
use App\Http\Controllers\Back\MenuController;
use App\Http\Controllers\Back\OrderController;
use App\Http\Controllers\Back\TransactionController;
use App\Http\Controllers\Back\SliderController;
use App\Http\Controllers\Back\BannerController;
use App\Http\Controllers\Back\CarrierController;
use App\Http\Controllers\Back\CityController;
use App\Http\Controllers\Back\LinkController;
use App\Http\Controllers\Back\ContactController;
use App\Http\Controllers\Back\StockNotifyController;
use App\Http\Controllers\Back\CommentController;
use App\Http\Controllers\Back\CurrencyController;
use App\Http\Controllers\Back\DeveloperController;
use App\Http\Controllers\Back\DiscountController;
use App\Http\Controllers\Back\InstallController;
use App\Http\Controllers\Back\RoleController;
use App\Http\Controllers\Back\PermissionController;
use App\Http\Controllers\Back\PriceController;
use App\Http\Controllers\Back\ReviewController;
use App\Http\Controllers\Back\SettingController;
use App\Http\Controllers\Back\SizeTypeController;
use App\Http\Controllers\Back\SmsController;
use App\Http\Controllers\Back\StatisticsController;
use App\Http\Controllers\Back\TariffController;
use App\Http\Controllers\Back\ThemeController;
use App\Http\Controllers\Back\TicketController;
use App\Http\Controllers\Back\WalletController;
use App\Http\Controllers\Back\WalletHistoryController;
use App\Http\Controllers\Back\WidgetController;
use App\Http\Controllers\PushSubscriptionController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('province/get-cities', [ProvinceController::class, 'getCities'])->name('provinces.get-cities');

Route::group(['as' => 'admin.', 'prefix' => 'admin/' . admin_route_prefix(), 'middleware' => ['guest']], function () {
    Route::get('login', [MainController::class, 'login'])->middleware(['CheckUserExists'])->name('login');
    Route::get('register', [InstallController::class, 'showRegisterForm'])->name('register')->middleware(['CheckUserNotExists']);
    Route::post('register', [InstallController::class, 'register'])->middleware(['CheckUserNotExists']);
});

// ------------------ Admin Part Routes
Route::group(['as' => 'admin.', 'prefix' => 'admin/' . admin_route_prefix(), 'middleware' => ['auth', 'Admin', 'verified', 'CheckPasswordChange', 'password.confirm']], function () {

    // ------------------ MainController
    Route::get('/', [MainController::class, 'index'])->name('dashboard');
    Route::get('get-tags', [MainController::class, 'get_tags'])->name('get-tags');
    Route::get('get-labels', [MainController::class, 'getLabels'])->name('get-labels');

    Route::get('notifications', [MainController::class, 'notifications'])->name('notifications');

    Route::get('file-manager', [MainController::class, 'fileManager'])->name('file-manager');
    Route::get('file-manager-iframe', [MainController::class, 'fileManagerIframe'])->name('file-manager-iframe');

    // ------------------ backups
    Route::get('backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('backups/create', [BackupController::class, 'create'])->name('backups.create');
    Route::get('backups/{backup}/download', [BackupController::class, 'download'])->name('backups.download');
    Route::delete('backups/{backup}', [BackupController::class, 'destroy'])->name('backups.destroy');

    // ------------------ users
    Route::resource('users', UserController::class);
    Route::get('login/{user}', [UserController::class, 'loginAsUser'])->name('users.login');
    Route::post('users/api/index', [UserController::class, 'apiIndex'])->name('users.apiIndex');
    Route::delete('users/api/multipleDestroy', [UserController::class, 'multipleDestroy'])->name('users.multipleDestroy');
    Route::get('users/export/create', [UserController::class, 'export'])->name('users.export');
    Route::get('users/{user}/views', [UserController::class, 'views'])->name('users.views');
    Route::get('user/profile', [UserController::class, 'showProfile'])->name('user.profile.show');
    Route::put('user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');

    // ------------------ wallets
    Route::resource('wallets', WalletController::class)->only(['show', 'index']);
    Route::get('wallets/histories/{history}', [WalletController::class, 'history'])->name('wallets.history');
    Route::get('wallets/{wallet}/create', [WalletController::class, 'create'])->name('wallets.create');
    Route::post('wallets/{wallet}', [WalletController::class, 'store'])->name('wallets.store');

    // ------------------ products
    Route::resource('products', ProductController::class)->except('show');
    Route::post('products/api/index', [ProductController::class, 'apiIndex'])->name('products.apiIndex');
    Route::delete('products/api/multipleDestroy', [ProductController::class, 'multipleDestroy'])->name('products.multipleDestroy');
    Route::put('products/api/multipleUnavailable', [ProductController::class, 'multipleUnavailable'])->name('products.multipleUnavailable');
    Route::post('products/image-store', [ProductController::class, 'image_store']);
    Route::post('products/image-delete', [ProductController::class, 'image_delete']);
    Route::get('product/categories', [ProductController::class, 'categories'])->name('products.categories.index');
    Route::post('product/prepareBarcode', [ProductController::class, 'prepareBarcode'])->name('products.prepareBarcode');
    Route::post('product/printBarcode', [ProductController::class, 'printBarcode'])->name('product.printBarcode');
    Route::post('product/slug', [ProductController::class, 'generate_slug']);

    Route::get('products/export/create', [ProductController::class, 'export'])->name('products.export');
    Route::get('product/torobPrices', [ProductController::class, 'torobPrices'])->name('product.torobPrices');
    Route::get('product/torobImport', [ProductController::class, 'torobImport'])->name('product.torobImport');
    Route::post('product/torobUpload', [ProductController::class, 'torobUpload'])->name('product.torobUpload');
    Route::get('product/prices', [ProductController::class, 'indexPrices'])->name('product.prices.index');
    Route::put('product/prices', [ProductController::class, 'updatePrices'])->name('product.prices.update');

    // ------------------ prices
    Route::get('prices', [PriceController::class, 'index'])->name('prices.index');
    Route::get('prices/show', [PriceController::class, 'show'])->name('prices.show');
    Route::post('prices', [PriceController::class, 'store'])->name('prices.store');

    // ------------------ discounts
    Route::resource('discounts', DiscountController::class)->except(['show']);

    // ------------------ provinces
    Route::resource('provinces', ProvinceController::class);
    Route::post('provinces/api/index', [ProvinceController::class, 'apiIndex'])->name('provinces.apiIndex');
    Route::delete('provinces/api/multipleDestroy', [ProvinceController::class, 'multipleDestroy'])->name('provinces.multipleDestroy');
    Route::post('provinces/api/sort', [ProvinceController::class, 'sort'])->name('provinces.sort');

    // ------------------ cities
    Route::resource('cities', CityController::class)->except(['index']);
    Route::post('cities/api/{province}/index', [CityController::class, 'apiIndex'])->name('cities.apiIndex');
    Route::delete('cities/api/multipleDestroy', [CityController::class, 'multipleDestroy'])->name('cities.multipleDestroy');
    Route::post('cities/api/sort', [CityController::class, 'sort'])->name('cities.sort');

    // ------------------ brands
    Route::resource('brands', BrandController::class)->except('show');
    Route::get('brands/ajax/get', [BrandController::class, 'ajax_get']);

    // ------------------ filters
    Route::resource('filters', FilterController::class)->except('show');

    // ------------------ attributeGroups
    Route::resource('attributeGroups', AttributeGroupController::class);
    Route::get('attributeGroups/{attributeGroup}/attributes', [AttributeGroupController::class, 'attributesIndex'])->name('attributes.index');
    Route::post('attributeGroup/sort', [AttributeGroupController::class, 'sort']);

    // ------------------ attributes
    Route::resource('attributes', AttributeController::class)->except(['index', 'show']);
    Route::post('attribute/sort', [AttributeController::class, 'sort']);

    // ------------------ spec types
    Route::get('spectypes/spec-type-data', [SpecTypeController::class, 'getData'])->name('spectypes.getdata');
    Route::get('spectypes/ajax/get', [SpecTypeController::class, 'ajax_get']);
    Route::resource('spectypes', SpecTypeController::class)->except(['show', 'create']);

    // ------------------ size types
    Route::resource('sizetypes', SizeTypeController::class);
    Route::get('sizetypes/{sizetype}/values', [SizeTypeController::class, 'editValues'])->name('sizetypes.editValues');
    Route::put('sizetypes/{sizetype}/values', [SizeTypeController::class, 'updateValues'])->name('sizetypes.updateValues');

    // ------------------ posts
    Route::resource('posts', PostController::class)->except(['show']);
    Route::get('post/categories', [PostController::class, 'categories'])->name('posts.categories.index');
    Route::post('post/slug', [PostController::class, 'generate_slug']);

    // ------------------ categories
    Route::group(['prefix' => 'post'], function () {
        Route::get('categories', [PostController::class, 'categories'])->name('posts.categories.index');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('posts.categories.destroy');
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('categories', [ProductController::class, 'categories'])->name('products.categories.index');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('products.categories.destroy');
    });

    Route::resource('categories', CategoryController::class)->only(['update', 'store', 'edit']);
    Route::post('categories/sort', [CategoryController::class, 'sort'])->name('categories.sort');
    Route::post('category/slug', [CategoryController::class, 'generate_slug']);

    // ------------------ pages
    Route::resource('pages', PageController::class)->except(['show']);

    // ------------------ apikeys
    Route::resource('apikeys', ApikeyController::class)->except(['show']);

    // ------------------ tickets
    Route::resource('tickets', TicketController::class)->except(['edit']);
    Route::post('tickets/file/store', [TicketController::class, 'storeFile'])->name('tickets.file.store');
    Route::delete('tickets/file/destroy', [TicketController::class, 'destoryFile'])->name('tickets.file.destroy');

    // ------------------ menus
    Route::resource('menus', MenuController::class)->except(['edit']);
    Route::post('menus/sort', [MenuController::class, 'sort']);

    // ------------------ orders
    Route::resource('orders', OrderController::class);
    Route::get('orders/in-person/create', [OrderController::class, 'inPersonCreate'])->name('orders.inPersonCreate');
    Route::post('orders/in-person/store', [OrderController::class, 'inPersonStore'])->name('orders.inPersonStore');
    Route::get('orders/in-person/{order}/edit', [OrderController::class, 'inPersonEdit'])->name('orders.inPersonEdit');
    Route::put('orders/in-person/{order}', [OrderController::class, 'inPersonUpdate'])->name('orders.inPersonUpdate');
    Route::post('orders/api/shippings-status', [OrderController::class, 'shippingsStatus'])->name('orders.shippings-status');
    Route::post('orders/{order}/shipping-status', [OrderController::class, 'shipping_status'])->name('orders.shipping-status');
    Route::post('orders/{order}/tracking-code', [OrderController::class, 'tracking_code'])->name('orders.tracking-code');
    Route::get('orders/{order}/print', [OrderController::class, 'print'])->name('orders.print');
    Route::get('orders/{order}/shipping-form', [OrderController::class, 'shippingForm'])->name('orders.shipping-form');
    Route::get('orders/{order}/shipping-form-min', [OrderController::class, 'shippingFormMin'])->name('orders.shipping-form-min');
    Route::post('orders/api/index', [OrderController::class, 'apiIndex'])->name('orders.apiIndex');
    Route::delete('orders/api/multipleDestroy', [OrderController::class, 'multipleDestroy'])->name('orders.multipleDestroy');
    Route::get('order/not-completed/products', [OrderController::class, 'notCompleted'])->name('orders.notCompleted');
    Route::get('orders/api/userInfo', [OrderController::class, 'userInfo'])->name('orders.userInfo');
    Route::get('orders/api/productsList', [OrderController::class, 'productsList'])->name('orders.productsList');
    Route::get('orders/api/printAllShippingForms', [OrderController::class, 'printAllShippingForms'])->name('orders.printAllShippingForms');
    Route::get('orders/api/printAllShippingFormsMin', [OrderController::class, 'printAllShippingFormsMin'])->name('orders.printAllShippingFormsMin');
    Route::get('orders/api/printAll', [OrderController::class, 'printAll'])->name('orders.printAll');
    Route::get('orders/export/create', [OrderController::class, 'export'])->name('orders.export');

    // ------------------ carriers
    Route::resource('carriers', CarrierController::class);
    Route::get('carriers/{carrier}/cities', [CarrierController::class, 'cities'])->name('carriers.cities');

    // ------------------ tariffs
    Route::resource('tariffs', TariffController::class);

    // ------------------ transactions
    Route::resource('transactions', TransactionController::class)->only(['index', 'show', 'destroy']);
    Route::post('transactions/api/index', [TransactionController::class, 'apiIndex'])->name('transactions.apiIndex');
    Route::delete('transactions/api/multipleDestroy', [TransactionController::class, 'multipleDestroy'])->name('transactions.multipleDestroy');

    // ------------------ wallet-histories
    Route::resource('wallet-histories', WalletHistoryController::class)->only(['index', 'show']);

    // ------------------ currencies
    Route::resource('currencies', CurrencyController::class)->except(['show']);

    // ------------------ sliders
    Route::resource('sliders', SliderController::class)->except(['show']);
    Route::post('sliders/sort', [SliderController::class, 'sort']);

    // ------------------ banners
    Route::resource('banners', BannerController::class)->except(['show']);
    Route::post('banners/sort', [BannerController::class, 'sort']);

    // ------------------ links
    Route::resource('links', LinkController::class)->except(['show']);
    Route::post('links/sort', [LinkController::class, 'sort']);
    Route::get('links/groups', [LinkController::class, 'groups'])->name('links.groups.index');
    Route::put('links/groups/update', [LinkController::class, 'updateGroups'])->name('links.groups.update');

    // ------------------ statistics
    Route::get('statistics/viewsList', [StatisticsController::class, 'viewsList'])->name('statistics.viewsList');
    Route::get('statistics/views', [StatisticsController::class, 'views'])->name('statistics.views');
    Route::get('statistics/viewCounts', [StatisticsController::class, 'viewCounts'])->name('statistics.viewCounts');
    Route::get('statistics/viewerCounts', [StatisticsController::class, 'viewerCounts'])->name('statistics.viewerCounts');
    Route::get('statistics/viewers', [StatisticsController::class, 'viewers'])->name('statistics.viewers');

    Route::get('statistics/orders', [StatisticsController::class, 'orders'])->name('statistics.orders');
    Route::get('statistics/orderValues', [StatisticsController::class, 'orderValues'])->name('statistics.orderValues');
    Route::get('statistics/orderCounts', [StatisticsController::class, 'orderCounts'])->name('statistics.orderCounts');
    Route::get('statistics/orderUsers', [StatisticsController::class, 'orderUsers'])->name('statistics.orderUsers');
    Route::get('statistics/orderProducts', [StatisticsController::class, 'orderProducts'])->name('statistics.orderProducts');

    Route::get('statistics/users', [StatisticsController::class, 'users'])->name('statistics.users');
    Route::get('statistics/userCounts', [StatisticsController::class, 'userCounts'])->name('statistics.userCounts');

    Route::get('statistics/smsLog', [StatisticsController::class, 'smsLog'])->name('statistics.smsLog');
    Route::get('statistics/bestSellingProducts', [StatisticsController::class, 'bestSellingProducts'])->name('statistics.bestSellingProducts');
    Route::get('statistics/cityReport', [StatisticsController::class, 'cityReport'])->name('statistics.cityReport');
    Route::get('statistics/stockReport', [StatisticsController::class, 'stockReport'])->name('statistics.stockReport');
    Route::get('statistics/userOrders', [StatisticsController::class, 'userOrders'])->name('statistics.userOrders');

    // ------------------ sms
    Route::resource('sms', SmsController::class)->only(['show']);

    // ------------------ contacts
    Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);

    // ------------------ stock-notifies
    Route::resource('stock-notifies', StockNotifyController::class)->only(['index', 'show', 'destroy']);

    // ------------------ comments
    Route::resource('comments', CommentController::class)->only(['show', 'destroy', 'update']);
    Route::get('comments/index/products', [CommentController::class, 'productComments'])->name('comments.products');
    Route::get('comments/index/posts', [CommentController::class, 'postComments'])->name('comments.posts');

    // ------------------ reviews
    Route::resource('reviews', ReviewController::class)->only(['index', 'show', 'destroy', 'update']);

    // ------------------ roles
    Route::resource('roles', RoleController::class);

    // ------------------ permissions
    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::put('permissions', [PermissionController::class, 'update'])->name('permissions.update');

    // ------------------ widgets
    Route::resource('widgets', WidgetController::class)->except(['show']);
    Route::get('widgets/{key}/template', [WidgetController::class, 'template'])->name('widgets.template');
    Route::post('widget/sort', [WidgetController::class, 'sort'])->name('widgets.sort');

    // ------------------ themes
    Route::resource('themes', ThemeController::class)->except(['edit']);

    Route::get('theme/settings', [ThemeController::class, 'showSettings'])->name('themes.settings');
    Route::post('theme/settings', [ThemeController::class, 'updateSettings']);

    // ------------------ settings
    Route::get('settings/information', [SettingController::class, 'showInformation'])->name('settings.information');
    Route::post('settings/information', [SettingController::class, 'updateInformation']);

    Route::get('settings/socials', [SettingController::class, 'showSocials'])->name('settings.socials');
    Route::post('settings/socials', [SettingController::class, 'updateSocials']);

    Route::get('settings/gateways', [SettingController::class, 'showGateways'])->name('settings.gateways');
    Route::post('settings/gateways', [SettingController::class, 'updateGateways']);

    Route::get('settings/others', [SettingController::class, 'showOthers'])->name('settings.others');
    Route::post('settings/others', [SettingController::class, 'updateOthers']);

    Route::get('settings/footer', [SettingController::class, 'showFooter'])->name('settings.footer');
    Route::post('settings/footer', [SettingController::class, 'updateFooter']);
    Route::post('settings/footer/reset', [SettingController::class, 'resetFooter'])->name('settings.footer.reset');

    Route::get('settings/sms', [SettingController::class, 'showSms'])->name('settings.sms');
    Route::post('settings/sms', [SettingController::class, 'updateSms']);

    // ------------------ developer routes
    Route::group(['middleware' => 'CheckCreator'], function () {

        // ------------------ logs
        Route::get('logs', [LogViewerController::class, 'index'])->name('logs.index');

        // ------------------ settings
        Route::get('developer/settings', [DeveloperController::class, 'showSettings'])->name('developer.settings');
        Route::put('developer/settings', [DeveloperController::class, 'updateSettings']);

        Route::post('developer/downApplication', [DeveloperController::class, 'downApplication'])->name('developer.downApplication');
        Route::post('developer/upApplication', [DeveloperController::class, 'upApplication'])->name('developer.upApplication');

        Route::post('developer/webpushNotification', [DeveloperController::class, 'webpushNotification'])->name('developer.webpushNotification');

        // ------------------ old updater
        Route::get('developer/old/updater', [DeveloperController::class, 'oldShowUpdater'])->name('old.developer.showUpdater');
        Route::post('developer/old/updater', [DeveloperController::class, 'oldUpdateApplication'])->name('old.developer.updateApplication');
        // ------------------ updater
        Route::get('developer/updater', [DeveloperController::class, 'showUpdater'])->name('developer.showUpdater');
        Route::post('developer/updater', [DeveloperController::class, 'updateApplication'])->name('developer.updateApplication');
        Route::post('developer/updaterAfter', [DeveloperController::class, 'updaterAfter'])->name('developer.updaterAfter');
        Route::post('developer/checkNextPhpUpdates', [DeveloperController::class, 'checkNextPhpUpdates'])->name('developer.checkNextPhpUpdates');
    });
});

// Push Subscriptions
Route::post('subscriptions', [PushSubscriptionController::class, 'update']);
Route::post('subscriptions/delete', [PushSubscriptionController::class, 'destroy']);

// refresh csrf token
Route::get('refresh-csrf', function () {
    return csrf_token();
})->name('csrf');

Route::get('torob/products', [ProductController::class, 'torobProductsList']);
