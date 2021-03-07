<?php
// Admin
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProducerController;
use App\Http\Controllers\Admin\AdvertiseController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\CollectionProductController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TagProductController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PasswordController as AdminPasswordController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;;

// Customer
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\CheckOutController;
use App\Http\Controllers\Customer\CompareController;
use App\Http\Controllers\Customer\DeliveryController;
use App\Http\Controllers\Customer\DetailController;
use App\Http\Controllers\Customer\FilterController;
use App\Http\Controllers\Customer\Info\AboutUsController;
use App\Http\Controllers\Customer\Info\AdvancedSearchController;
use App\Http\Controllers\Customer\Info\ContactUsController;
use App\Http\Controllers\Customer\Info\SearchTermsController;
use App\Http\Controllers\Customer\Info\SiteMapController;
use App\Http\Controllers\Customer\SearchController;
use App\Http\Controllers\Customer\SearchTagController;
use App\Http\Controllers\Customer\NewsController;
use App\Http\Controllers\Customer\Account\DashboardController;
use App\Http\Controllers\Customer\Account\InformationController;
use App\Http\Controllers\Customer\Account\AddressController;
use App\Http\Controllers\Customer\Account\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\Account\PasswordController;
// auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);
Route::get('home', [HomeController::class, 'index'])->name('home');
// end of home

// search 
Route::get('filter/{category_id}/{collection_id?}', [FilterController::class, 'index'])->name('filter');
Route::get('search', [SearchController::class, 'index'])->name('search');
Route::get('tag/{tag_id}', [SearchTagController::class, 'index'])->name('tag');
// end of search

// coupon page
Route::get('/coupon', [NewsController::class, 'index'])->name('coupon');
// coupon

// detail product
Route::get('product-details/{id}', [DetailController::class, 'index'])->name('product_details');
Route::get('quick-view', [DetailController::class, 'quick_view']);

// // end of detail

Route::prefix('authentication')->as('auth.')->group(function() {
    Route::prefix('admin')->as('admin.')->group(function() {
        Route::get('login', [LoginController::class, 'showAdminLogin'])->name('index');
        Route::post('login', [LoginController::class, 'adminLogin'])->name('login');
        Route::get('logout',[LogoutController::class,'adminLogout'])->name('logout');
    });

    Route::prefix('customer')->as('customer.')->group(function() {
        Route::get('login', [LoginController::class, 'index'])->name('index');
        Route::post('login', [LoginController::class, 'customerLogin'])->name('login'); 
        Route::get('logout', [LogoutController::class, 'customerLogout'])->name('logout'); 
        Route::post('register', [RegisterController::class, 'register'])->name('register'); 
    });
});

Route::group(['prefix' => 'compare', 'as' => 'compare.'], function () {
    Route::get('/', [CompareController::class, 'index'])->name('index');
    Route::get('/add',  [CompareController::class, 'add'])->name('add');
    Route::get('/remove',  [CompareController::class, 'remove'])->name('remove');
    Route::get('/delete',  [CompareController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'information', 'as' => 'info.'], function () {
    Route::get('/search-terms', [SearchTermsController::class, 'index'])->name('search_terms');
    Route::group(['prefix' => 'advanced-search', 'as' => 'advanced_search.'], function () {
        Route::get('/index',  [AdvancedSearchController::class, 'index'])->name('index');
        Route::get('/result',  [AdvancedSearchController::class, 'result'])->name('result');
    });
    Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact_us');
    Route::post('/contact-us', [ContactUsController::class, 'contact']);
    Route::get('/about-us', [AboutUsController::class, 'index'])->name('about_us');
    Route::group(['prefix' => 'site-map', 'as' => 'site_map.'], function () {
        Route::get('/index', [SiteMapController::class, 'category'])->name('category');
        Route::get('/result', [SiteMapController::class, 'product'])->name('product');
    });
});
// account
Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // info
    Route::group(['prefix' => 'information', 'as' => 'info.'], function () {
        Route::get('/', [InformationController::class, 'index'])->name('index');
        Route::post('/{id}', [InformationController::class, 'update'])->name('update');
    });

    // address
    Route::group(['prefix' => 'addresses', 'as' => 'address.'], function () {
        Route::get('/', [AddressController::class, 'index'])->name('index');
        Route::get('/create', [AddressController::class, 'create'])->name('create');
        Route::post('/store', [AddressController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AddressController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [AddressController::class, 'update'])->name('update');
        Route::get('/shipping-address/{id}', [AddressController::class, 'set_primary_shipping_address'])->name('shipping_address');
        Route::get('/{id}/destroy', [AddressController::class, 'destroy'])->name('destroy');
    });

    // logout
    Route::get('/logout', [LogoutController::class, 'index'])->name('logout');

    //wish list 
    Route::group(['prefix' => 'wish-list','as'=>'wishlist.'], function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::get('/add', [WishlistController::class, 'add_to_wish_list']);
        Route::post('/edit', [WishlistController::class, 'edit_wish_list']);
        Route::get('/remove/{id}', [WishlistController::class, 'remove_wish_list']);
        Route::get('/all-to-cart', [WishlistController::class, 'wish_list_to_cart']);
    });


    // reivew
    Route::group(['prefix' => 'review','as'=>'review.'], function () {
        Route::post('/', [ReviewController::class, 'review'])->name('review');
        Route::get('/', [ReviewController::class, 'index'])->name('index');
    });

    // order
    Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
        Route::get('/', [CustomerOrderController::class, 'index'])->name('index');
        Route::get('/{id}/details', [CustomerOrderController::class, 'detail'])->name('detail');
        Route::get('/{id}/cancel', [CustomerOrderController::class, 'cancel'])->name('cancel');
        Route::get('/{id}/re-order', [CustomerOrderController::class, 'reOrder'])->name('re_order');
    });

    // password
    Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
        Route::get('/', [PasswordController::class, 'index'])->name('index');
        Route::post('/', [PasswordController::class, 'changePassword'])->name('change');
    });
});
// end account

// cart
Route::group(['prefix' => 'cart', 'as' => 'cart.'], function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::get('create', [CartController::class, 'create'])->name('create');
    Route::post('/update', [CartController::class, 'update_cart'])->name('update');
    Route::post('/apply-coupon', [CartController::class, 'apply_coupon'])->name('apply_coupon');
    Route::get('/remove', [CartController::class, 'remove_item_from_cart'])->name('remove_cart');
    Route::get('/remove-coupon', [CartController::class, 'remove_coupon'])->name('remove_coupon');
    Route::get('/delete', [CartController::class, 'remove_cart'])->name('delete');
    Route::get('/check', [CartController::class, 'check'])->name('check');
});
// end cart

// check out
Route::group(['prefix' => 'check-out', 'as' => 'checkout.'], function () {
    Route::get('/', [CheckOutController::class, 'index'])->name('index');
    Route::post('/old-address', [CheckOutController::class, 'oldAddress'])->name('old_address');
    Route::post('/new-address', [CheckOutController::class, 'newAddress'])->name('new_address');
    Route::post('/payment-checkout', [CheckOutController::class, 'payment'])->name('payment');
    Route::get('/final-check', [CheckOutController::class, 'final_check'])->name('final_check');
});
// end check out

// thanks page
Route::get('delivery/{id}', [DeliveryController::class, 'index'])->name('delivery');
// end

Route::prefix('administrator')->as('admin.')->group(function () {
    Route::get('/',[AdminDashboardController::class,'index'])->name('index');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class,'index'])->name('index');
        Route::post('/', [ProfileController::class,'update'])->name('update');
        Route::get('/password',[AdminPasswordController::class,'index'])->name('password.index');
        Route::post('/password',[AdminPasswordController::class,'changePassword'])->name('password.update');
    });

    Route::group(['prefix' => 'panel','as'=>'admin.'], function () {
        Route::get('/', 'AdminController@index')->name('index');
        Route::get('/activate/{id}', 'AdminController@doActivate')->name('activate');
        Route::get('/deactivate/{id}', 'AdminController@doDeactivate')->name('deactivate');
        Route::get('/bulk-action', 'AdminController@bulk_action')->name('bulk_action');
        Route::get('/remove/{id}', 'AdminController@doRemove')->name('remove');
        Route::get('/restore/{id}', 'AdminController@doRestore')->name('restore');
        Route::get('/delete/{id}', 'AdminController@doDelete')->name('delete');
        Route::get('/recycle', 'AdminController@recycle')->name('recycle');

    });

    Route::prefix('products')->as('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/{id}/verify/{verified}', [ProductController::class, 'verify'])->name('verify');
        Route::get('/bulk-action', [ProductController::class, 'bulk_action'])->name('bulk_action');
        Route::post('/import', [ProductController::class, 'import'])->name('import');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::post('/{id}', [ProductController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [ProductController::class, 'delete'])->name('delete');
        Route::get('/recycle', [ProductController::class, 'recycle'])->name('recycle');
        Route::get('/{id}/restore', [ProductController::class, 'restore'])->name('restore');
        Route::get('/{id}/destroy', [ProductController::class, 'destroy'])->name('destroy');

        Route::prefix('/{id}/images')->as('image.')->group(function () {
            Route::get('/', [ProductImageController::class, 'index'])->name('index');
            Route::get('/{image_id}/verify/{verified}', [ProductImageController::class, 'verify'])->name('verify');
            Route::get('/bulk-action', [ProductImageController::class, 'bulk_action'])->name('bulk_action');
            Route::get('/create', [ProductImageController::class, 'create'])->name('create');
            Route::post('/', [ProductImageController::class, 'store'])->name('store');
            Route::get('/{image_id}/edit', [ProductImageController::class, 'edit'])->name('edit');
            Route::post('/{image_id}', [ProductImageController::class, 'update'])->name('update');
            Route::get('/{image_id}/delete', [ProductImageController::class, 'delete'])->name('delete');
            Route::get('/recycle', [ProductImageController::class, 'recycle'])->name('recycle');
            Route::get('/{image_id}/restore', [ProductImageController::class, 'restore'])->name('restore');
            Route::get('/{image_id}/destroy', [ProductImageController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('categories')->as('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/{id}/verify/{verified}', [CategoryController::class, 'verify'])->name('verify');
        Route::get('/bulk-action', [CategoryController::class, 'bulk_action'])->name('bulk_action');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [CategoryController::class, 'delete'])->name('delete');
        Route::get('/recycle', [CategoryController::class, 'recycle'])->name('recycle');
        Route::get('/{id}/restore', [CategoryController::class, 'restore'])->name('restore');
        Route::get('/{id}/destroy', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('producers')->as('producer.')->group(function () {
        Route::get('/', [ProducerController::class, 'index'])->name('index');
        Route::get('/{id}/verify/{verified}', [ProducerController::class, 'verify'])->name('verify');
        Route::get('/bulk-action', [ProducerController::class, 'bulk_action'])->name('bulk_action');
        Route::get('/create', [ProducerController::class, 'create'])->name('create');
        Route::post('/', [ProducerController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProducerController::class, 'edit'])->name('edit');
        Route::post('/{id}', [ProducerController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [ProducerController::class, 'delete'])->name('delete');
        Route::get('/recycle', [ProducerController::class, 'recycle'])->name('recycle');
        Route::get('/{id}/restore', [ProducerController::class, 'restore'])->name('restore');
        Route::get('/{id}/destroy', [ProducerController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('advertises')->as('advertise.')->group(function () {
        Route::get('/', [AdvertiseController::class, 'index'])->name('index');
        Route::get('/{id}/verify/{verified}', [AdvertiseController::class, 'verify'])->name('verify');
        Route::get('/bulk-action', [AdvertiseController::class, 'bulk_action'])->name('bulk_action');
        Route::get('/create', [AdvertiseController::class, 'create'])->name('create');
        Route::post('/', [AdvertiseController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdvertiseController::class, 'edit'])->name('edit');
        Route::post('/{id}', [AdvertiseController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [AdvertiseController::class, 'delete'])->name('delete');
        Route::get('/recycle', [AdvertiseController::class, 'recycle'])->name('recycle');
        Route::get('/{id}/restore', [AdvertiseController::class, 'restore'])->name('restore');
        Route::get('/{id}/destroy', [AdvertiseController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('coupons')->as('coupon.')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('index');
        Route::get('/{id}/verify/{verified}', [CouponController::class, 'verify'])->name('verify');
        Route::get('/bulk-action', [CouponController::class, 'bulk_action'])->name('bulk_action');
        Route::get('/create', [CouponController::class, 'create'])->name('create');
        Route::post('/', [CouponController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CouponController::class, 'edit'])->name('edit');
        Route::post('/{id}', [CouponController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [CouponController::class, 'delete'])->name('delete');
        Route::get('/recycle', [CouponController::class, 'recycle'])->name('recycle');
        Route::get('/{id}/restore', [CouponController::class, 'restore'])->name('restore');
        Route::get('/{id}/destroy', [CouponController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('contacts')->as('contact.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/{id}/verify/{verified}', [ContactController::class, 'verify'])->name('verify');
        Route::get('/bulk-action', [ContactController::class, 'bulk_action'])->name('bulk_action');
        Route::get('/{id}/show', [ContactController::class, 'show'])->name('show');
        Route::get('/{id}/delete', [ContactController::class, 'delete'])->name('delete');
        Route::get('/recycle', [ContactController::class, 'recycle'])->name('recycle');
        Route::get('/{id}/restore', [ContactController::class, 'restore'])->name('restore');
        Route::get('/{id}/destroy', [ContactController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('reviews')->as('review.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/{id}/verify/{verified}', [ReviewController::class, 'verify'])->name('verify');
        Route::get('/bulk-action', [ReviewController::class, 'bulk_action'])->name('bulk_action');
        Route::get('/{id}/show', [ReviewController::class, 'show'])->name('show');
        Route::get('/{id}/delete', [ReviewController::class, 'delete'])->name('delete');
        Route::get('/recycle', [ReviewController::class, 'recycle'])->name('recycle');
        Route::get('/{id}/restore', [ReviewController::class, 'restore'])->name('restore');
        Route::get('/{id}/destroy', [ReviewController::class, 'destroy'])->name('destroy');
    });

    // Order
    Route::prefix('order')->as('order.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/bulk-action', [AdminOrderController::class, 'bulk_action'])->name('bulk_action');
        Route::get('/{id}/verify/{verified}', [AdminOrderController::class, 'verify'])->name('verify');
        Route::get('/{id}/confirm/{confirmed}', [AdminOrderController::class, 'confirm'])->name('confirm');
        Route::get('/{id}/pay/{paid}', [AdminOrderController::class, 'pay'])->name('pay');
        Route::get('/create', [AdminOrderController::class, 'create'])->name('create');
        Route::post('/store', [AdminOrderController::class, 'store'])->name('store');
        Route::get('/history', [AdminOrderController::class, 'history'])->name('history');
        Route::get('/cancel', [AdminOrderController::class, 'cancel'])->name('cancel');
        Route::get('/{id}/edit', [AdminOrderController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [AdminOrderController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [AdminOrderController::class, 'delete'])->name('delete');
        Route::get('/recycle', [AdminOrderController::class, 'recycle'])->name('recycle');
        Route::get('/{id}/restore', [AdminOrderController::class, 'restore'])->name('restore');
        Route::get('/{id}/destroy', [AdminOrderController::class, 'destroy'])->name('destroy');
    });

    // users
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', 'UserController@index')->name('index');
        Route::get('/activate/{id}', 'UserController@doActivate')->name('activate');
        Route::get('/deactivate/{id}', 'UserController@doDeactivate')->name('deactivate');
        Route::get('/promote/{id}', 'UserController@doPromote')->name('promote');
        Route::get('/bulk-action', 'UserController@bulk_action')->name('bulk_action');
        Route::get('/remove/{id}', 'UserController@doRemove')->name('remove');
        Route::get('/restore/{id}', 'UserController@doRestore')->name('restore');
        Route::get('/delete/{id}', 'UserController@doDelete')->name('delete');
        Route::get('/recycle', 'UserController@recycle')->name('recycle');
    });

    Route::prefix('users')->as('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{id}/verify/{verified}', [UserController::class, 'verify'])->name('verify');
        Route::get('/{id}/promote/{promoted}', [UserController::class, 'promote'])->name('promote');
        Route::get('/bulk-action', [UserController::class, 'bulk_action'])->name('bulk_action');
        Route::get('/{id}/show', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/delete', [UserController::class, 'delete'])->name('delete');
        Route::get('/recycle', [UserController::class, 'recycle'])->name('recycle');
        Route::get('/{id}/restore', [UserController::class, 'restore'])->name('restore');
        Route::get('/{id}/destroy', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('collections')->as('collection.')->group(function () {
        Route::get('/', [CollectionController::class, 'index'])->name('index');
        Route::get('/{id}/verify/{verified}', [CollectionController::class, 'verify'])->name('verify');
        Route::get('/bulk-action', [CollectionController::class, 'bulk_action'])->name('bulk_action');
        Route::get('/create', [CollectionController::class, 'create'])->name('create');
        Route::post('/', [CollectionController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CollectionController::class, 'edit'])->name('edit');
        Route::post('/{id}', [CollectionController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [CollectionController::class, 'delete'])->name('delete');
        Route::get('/recycle', [CollectionController::class, 'recycle'])->name('recycle');
        Route::get('/{id}/restore', [CollectionController::class, 'restore'])->name('restore');
        Route::get('/{id}/destroy', [CollectionController::class, 'destroy'])->name('destroy');

        Route::prefix('/{id}/products')->as('product.')->group(function () {
            Route::get('/', [CollectionProductController::class, 'index'])->name('index');
            Route::get('/{product_id}/verify/{verified}', [CollectionProductController::class, 'verify'])->name('verify');
            Route::get('/bulk-action', [CollectionProductController::class, 'bulk_action'])->name('bulk_action');
            Route::get('/create', [CollectionProductController::class, 'create'])->name('create');
            Route::post('/', [CollectionProductController::class, 'store'])->name('store');
            Route::get('/{product_id}/edit', [CollectionProductController::class, 'edit'])->name('edit');
            Route::post('/{product_id}', [CollectionProductController::class, 'update'])->name('update');
            Route::get('/{product_id}/delete', [CollectionProductController::class, 'delete'])->name('delete');
            Route::get('/recycle', [CollectionProductController::class, 'recycle'])->name('recycle');
            Route::get('/{product_id}/restore', [CollectionProductController::class, 'restore'])->name('restore');
            Route::get('/{product_id}/destroy', [CollectionProductController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('tags')->as('tag.')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::get('/{id}/verify/{verified}', [TagController::class, 'verify'])->name('verify');
        Route::get('/bulk-action', [TagController::class, 'bulk_action'])->name('bulk_action');
        Route::get('/create', [TagController::class, 'create'])->name('create');
        Route::post('/', [TagController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TagController::class, 'edit'])->name('edit');
        Route::post('/{id}', [TagController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [TagController::class, 'delete'])->name('delete');
        Route::get('/recycle', [TagController::class, 'recycle'])->name('recycle');
        Route::get('/{id}/restore', [TagController::class, 'restore'])->name('restore');
        Route::get('/{id}/destroy', [TagController::class, 'destroy'])->name('destroy');

        Route::prefix('/{id}/products')->as('product.')->group(function () {
            Route::get('/', [TagProductController::class, 'index'])->name('index');
            Route::get('/{product_id}/verify/{verified}', [TagProductController::class, 'verify'])->name('verify');
            Route::get('/bulk-action', [TagProductController::class, 'bulk_action'])->name('bulk_action');
            Route::get('/create', [TagProductController::class, 'create'])->name('create');
            Route::post('/', [TagProductController::class, 'store'])->name('store');
            Route::get('/{product_id}/edit', [TagProductController::class, 'edit'])->name('edit');
            Route::post('/{product_id}', [TagProductController::class, 'update'])->name('update');
            Route::get('/{product_id}/delete', [TagProductController::class, 'delete'])->name('delete');
            Route::get('/recycle', [TagProductController::class, 'recycle'])->name('recycle');
            Route::get('/{product_id}/restore', [TagProductController::class, 'restore'])->name('restore');
            Route::get('/{product_id}/destroy', [TagProductController::class, 'destroy'])->name('destroy');
        });
    });
});