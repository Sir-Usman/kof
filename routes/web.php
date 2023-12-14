<?php

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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Web\WebController;
use App\Http\Controllers\Web\CryptoAffiliateController;


Route::get('transfer', function () {

    /**
     * Transfer (Export) Files Server to Server using PHP FTP
     * @link https://shellcreeper.com/?p=1249
     */

    /* Remote File Name and Path */

    $remote_file = 'favicon.ico';

    /* FTP Account (Remote Server) */
    /* FTP Account (Remote Server) */

    $ftp_host = 'access868595624.webspace-data.io'; /* host */
    $ftp_user_name = 'u104501138'; /* username */
    $ftp_user_pass = 'i3)))@*#JRf!#f45'; /* password */
    $local_file = 'favicon.ico';
    $target_server_file = 'favicon.ico';

    include('Net/SSH2.php');

    $ssh = new Net_SSH2($ftp_host);
    if (!$ssh->login($ftp_user_name, $ftp_user_pass)) {
        exit('Login Failed');
    }

    $ssh->put($target_server_file, $local_file);

    echo $ssh->exec('pwd');
    echo $ssh->exec('ls -la');


    return;
    $connection = ssh2_connect($ftp_host, 22);
    ssh2_auth_password($connection, $ftp_user_name, $ftp_user_pass);

    $sftp = ssh2_sftp($connection);

    $stream = fopen('ssh2.sftp://' . intval($sftp) . '/path/to/file', 'r');

    return;
    /* File and path to send to remote FTP server */
    $local_file = 'favicon.ico';

    /* Connect using basic FTP */
    $connect_it = ftp_connect($ftp_host);

    /* Login to FTP */
    $login_result = ftp_login($connect_it, $ftp_user_name, $ftp_user_pass);

    /* Send $local_file to FTP */
    if (ftp_put($connect_it, $remote_file, $local_file, FTP_BINARY)) {
        echo "WOOT! Successfully transfer $local_file\n";
    } else {
        echo "Doh! There was a problem\n";
    }

    /* Close the connection */
    ftp_close($connect_it);
});



//for maintenance mode
Route::get('maintenance-mode', 'Web\WebController@maintenance_mode')->name('maintenance-mode');
Route::get('privacy-n-policy', 'Web\WebController@privacy_policy_2');



Route::get('test-event', function () {
    event(new App\Events\RealTimeNotification('Hello World'));
    return "Event has been sent!";
});
Route::group(['namespace' => 'Web', 'middleware' => ['maintenance_mode']], function () {
    Route::get('/', 'WebController@home')->name('home');

    Route::get('quick-view', 'WebController@quick_view')->name('quick-view');
    Route::get('searched-products', 'WebController@searched_products')->name('searched-products');

    Route::group(['middleware' => ['customer']], function () {
        Route::get('checkout-details', 'WebController@checkout_details')->name('checkout-details');
        Route::get('checkout-shipping', 'WebController@checkout_shipping')->name('checkout-shipping');
        Route::get('checkout-payment', 'WebController@checkout_payment')->name('checkout-payment');
        Route::get('checkout-review', 'WebController@checkout_review')->name('checkout-review');
        Route::get('checkout-complete', 'WebController@checkout_complete')->name('checkout-complete');
        Route::get('order-placed', 'WebController@order_placed')->name('order-placed');
        Route::get('shop-cart', 'WebController@shop_cart')->name('shop-cart');
        Route::post('order_note', 'WebController@order_note')->name('order_note');
        Route::get('digital-product-download/{id}', 'WebController@digital_product_download')->name('digital-product-download');
        Route::get('submit-review/{id}', 'UserProfileController@submit_review')->name('submit-review');
        Route::post('review', 'ReviewController@store')->name('review.store');
        Route::get('deliveryman-review/{id}', 'ReviewController@delivery_man_review')->name('deliveryman-review');
        Route::post('submit-deliveryman-review', 'ReviewController@delivery_man_submit')->name('submit-deliveryman-review');
        Route::get('sell-now', 'WebController@sellnow')->name('sell-now');
        Route::get('product-details/{category_id}', 'WebController@product_details')->name('product-details');
        Route::post('/product-details', 'WebController@store')->name('product-details.store')->middleware('customer');
    });

    //wallet payment
    Route::get('checkout-complete-wallet', 'WebController@checkout_complete_wallet')->name('checkout-complete-wallet');

    Route::post('subscription', 'WebController@subscription')->name('subscription');
    Route::get('search-shop', 'WebController@search_shop')->name('search-shop');
    Route::get('search-brand', 'WebController@search_brand')->name('search-brand');
    Route::get('categories', 'WebController@all_categories')->name('categories');
    Route::get('category-ajax/{id}', 'WebController@categories_by_category')->name('category-ajax');

    Route::get('brands', 'WebController@all_brands')->name('brands');
    Route::get('sellers', 'WebController@all_sellers')->name('sellers');
    
    

    Route::get('seller-profile/{id}', 'WebController@seller_profile')->name('seller-profile');

    Route::get('flash-deals/{id}', 'WebController@flash_deals')->name('flash-deals');
    Route::get('terms', 'WebController@termsandCondition')->name('terms');
    Route::get('privacy-policy', 'WebController@privacy_policy')->name('privacy-policy');

    Route::get('/product/{slug}', 'WebController@product')->name('product');
    Route::get('products', 'WebController@products')->name('products');
    Route::get('orderDetails', 'WebController@orderdetails')->name('orderdetails');
    Route::get('discounted-products', 'WebController@discounted_products')->name('discounted-products');

    Route::post('review-list-product', 'WebController@review_list_product')->name('review-list-product');
    //Chat with seller from product details
    Route::get('chat-for-product', 'WebController@chat_for_product')->name('chat-for-product');

    Route::get('wishlists', 'WebController@viewWishlist')->name('wishlists')->middleware('customer');
    Route::post('store-wishlist', 'WebController@storeWishlist')->name('store-wishlist');
    Route::post('delete-wishlist', 'WebController@deleteWishlist')->name('delete-wishlist');

    Route::post('/currency', 'CurrencyController@changeCurrency')->name('currency.change');

    Route::get('about-us', 'WebController@about_us')->name('about-us');

    //profile Route
    Route::get('user-account', 'UserProfileController@user_account')->name('user-account');
    Route::post('user-account-update', 'UserProfileController@user_update')->name('user-update');
    Route::post('user-account-picture', 'UserProfileController@user_picture')->name('user-picture');
    Route::get('account-address', 'UserProfileController@account_address')->name('account-address');
    Route::post('account-address-store', 'UserProfileController@address_store')->name('address-store');
    Route::get('account-address-delete', 'UserProfileController@address_delete')->name('address-delete');
    ROute::get('account-address-edit/{id}', 'UserProfileController@address_edit')->name('address-edit');
    Route::post('account-address-update', 'UserProfileController@address_update')->name('address-update');
    Route::get('account-payment', 'UserProfileController@account_payment')->name('account-payment');
    Route::get('account-oder', 'UserProfileController@account_oder')->name('account-oder');
    Route::get('account-order-details', 'UserProfileController@account_order_details')->name('account-order-details')->middleware('customer');
    Route::get('generate-invoice/{id}', 'UserProfileController@generate_invoice')->name('generate-invoice');
    Route::get('account-wishlist', 'UserProfileController@account_wishlist')->name('account-wishlist'); //add to card not work
    Route::get('refund-request/{id}', 'UserProfileController@refund_request')->name('refund-request');
    Route::get('refund-details/{id}', 'UserProfileController@refund_details')->name('refund-details');
    Route::post('refund-store', 'UserProfileController@store_refund')->name('refund-store');
    Route::get('account-tickets', 'UserProfileController@account_tickets')->name('account-tickets');
    Route::get('order-cancel/{id}', 'UserProfileController@order_cancel')->name('order-cancel');
    Route::post('ticket-submit', 'UserProfileController@ticket_submit')->name('ticket-submit');
    Route::get('account-delete/{id}', 'UserProfileController@account_delete')->name('account-delete');
    Route::get('selling-details', 'UserProfileController@selling_details')->name('selling-details');

    // Chatting start
    Route::get('chat/{type}', 'ChattingController@chat_list')->name('chat');
    Route::get('messages', 'ChattingController@messages')->name('messages');
    Route::post('messages-store', 'ChattingController@messages_store')->name('messages_store');
    // chatting end

    //Support Ticket
    Route::group(['prefix' => 'support-ticket', 'as' => 'support-ticket.'], function () {
        Route::get('{id}', 'UserProfileController@single_ticket')->name('index');
        Route::post('{id}', 'UserProfileController@comment_submit')->name('comment');
        Route::get('delete/{id}', 'UserProfileController@support_ticket_delete')->name('delete');
        Route::get('close/{id}', 'UserProfileController@support_ticket_close')->name('close');
    });

    Route::get('account-transaction', 'UserProfileController@account_transaction')->name('account-transaction');
    Route::get('account-wallet-history', 'UserProfileController@account_wallet_history')->name('account-wallet-history');

    Route::get('wallet', 'UserWalletController@index')->name('wallet');
    Route::get('loyalty', 'UserLoyaltyController@index')->name('loyalty');
    Route::post('loyalty-exchange-currency', 'UserLoyaltyController@loyalty_exchange_currency')->name('loyalty-exchange-currency');

    Route::group(['prefix' => 'track-order', 'as' => 'track-order.'], function () {
        Route::get('', 'UserProfileController@track_order')->name('index');
        Route::get('result-view', 'UserProfileController@track_order_result')->name('result-view');
        Route::get('last', 'UserProfileController@track_last_order')->name('last');
        Route::any('result', 'UserProfileController@track_order_result')->name('result');
    });
    //FAQ route
    Route::get('helpTopic', 'WebController@helpTopic')->name('helpTopic');
    //Contacts
    Route::get('contacts', 'WebController@contacts')->name('contacts');

    //sellerShop
    Route::get('shopView/{id}', 'WebController@seller_shop')->name('shopView');
    Route::post('shopView/{id}', 'WebController@seller_shop_product');

    //top Rated
    Route::get('top-rated', 'WebController@top_rated')->name('topRated');
    Route::get('best-sell', 'WebController@best_sell')->name('bestSell');
    Route::get('new-product', 'WebController@new_product')->name('newProduct');

    Route::group(['prefix' => 'contact', 'as' => 'contact.'], function () {
        Route::post('store', 'WebController@contact_store')->name('store');
        Route::get('/code/captcha/{tmp}', 'WebController@captcha')->name('default-captcha');
    });
});

//Seller shop apply
Route::group(['prefix' => 'shop', 'as' => 'shop.', 'namespace' => 'Seller\Auth'], function () {
    Route::get('apply', 'RegisterController@create')->name('apply');
    Route::post('apply', 'RegisterController@store');
});

//check done
Route::group(['prefix' => 'cart', 'as' => 'cart.', 'namespace' => 'Web'], function () {
    Route::post('variant_price', 'CartController@variant_price')->name('variant_price');
    Route::post('add', 'CartController@addToCart')->name('add');
    Route::post('remove', 'CartController@removeFromCart')->name('remove');
    Route::post('nav-cart-items', 'CartController@updateNavCart')->name('nav-cart');
    Route::post('updateQuantity', 'CartController@updateQuantity')->name('updateQuantity');
});

//Seller shop apply
Route::group(['prefix' => 'coupon', 'as' => 'coupon.', 'namespace' => 'Web'], function () {
    Route::post('apply', 'CouponController@apply')->name('apply');
});
//check done

// SSLCOMMERZ Start
/*Route::get('/example1', 'SslCommerzPaymentController@exampleEasyCheckout');
Route::get('/example2', 'SslCommerzPaymentController@exampleHostedCheckout');*/
Route::post('pay-ssl', 'SslCommerzPaymentController@index');
Route::post('/success', 'SslCommerzPaymentController@success')->name('ssl-success');
Route::post('/fail', 'SslCommerzPaymentController@fail')->name('ssl-fail');
Route::post('/cancel', 'SslCommerzPaymentController@cancel')->name('ssl-cancel');
Route::post('/ipn', 'SslCommerzPaymentController@ipn')->name('ssl-ipn');
//SSLCOMMERZ END

/*paypal*/
/*Route::get('/paypal', function (){return view('paypal-test');})->name('paypal');*/
Route::post('pay-paypal', 'PaypalPaymentController@payWithpaypal')->name('pay-paypal');
Route::get('paypal-status', 'PaypalPaymentController@getPaymentStatus')->name('paypal-status');
Route::get('paypal-success', 'PaypalPaymentController@success')->name('paypal-success');
Route::get('paypal-fail', 'PaypalPaymentController@fail')->name('paypal-fail');
/*paypal*/

/*Route::get('stripe', function (){
return view('stripe-test');
});*/
Route::get('pay-stripe', 'StripePaymentController@payment_process_3d')->name('pay-stripe');
Route::get('pay-stripe/success', 'StripePaymentController@success')->name('pay-stripe.success');
Route::get('pay-stripe/fail', 'StripePaymentController@success')->name('pay-stripe.fail');

// Get Route For Show Payment razorpay Form
Route::get('paywithrazorpay', 'RazorPayController@payWithRazorpay')->name('paywithrazorpay');
Route::post('payment-razor', 'RazorPayController@payment')->name('payment-razor');
Route::post('payment-razor/payment2', 'RazorPayController@payment_mobile')->name('payment-razor.payment2');
Route::get('payment-razor/success', 'RazorPayController@success')->name('payment-razor.success');
Route::get('payment-razor/fail', 'RazorPayController@success')->name('payment-razor.fail');

Route::get('payment-success', 'Customer\PaymentController@success')->name('payment-success');
Route::get('payment-fail', 'Customer\PaymentController@fail')->name('payment-fail');


//senang pay
Route::match(['get', 'post'], '/return-senang-pay', 'SenangPayController@return_senang_pay')->name('return-senang-pay');

//paystack
Route::post('/paystack-pay', 'PaystackController@redirectToGateway')->name('paystack-pay');
Route::get('/paystack-callback', 'PaystackController@handleGatewayCallback')->name('paystack-callback');
Route::get('/paystack', function () {
    return view('paystack');
});

// paymob
Route::post('/paymob-credit', 'PaymobController@credit')->name('paymob-credit');
Route::get('/paymob-callback', 'PaymobController@callback')->name('paymob-callback');


//paytabs
Route::any('/paytabs-payment', 'PaytabsController@payment')->name('paytabs-payment');
Route::any('/paytabs-response', 'PaytabsController@callback_response')->name('paytabs-response');

//bkash
Route::group(['prefix' => 'bkash'], function () {
    // Payment Routes for bKash
    Route::post('get-token', 'BkashPaymentController@getToken')->name('bkash-get-token');
    Route::post('create-payment', 'BkashPaymentController@createPayment')->name('bkash-create-payment');
    Route::post('execute-payment', 'BkashPaymentController@executePayment')->name('bkash-execute-payment');
    Route::get('query-payment', 'BkashPaymentController@queryPayment')->name('bkash-query-payment');
    Route::post('success', 'BkashPaymentController@bkashSuccess')->name('bkash-success');

    // Refund Routes for bKash
    Route::get('refund', 'BkashRefundController@index')->name('bkash-refund');
    Route::post('refund', 'BkashRefundController@refund')->name('bkash-refund');
});

//fawry
Route::get('/fawry', 'FawryPaymentController@index')->name('fawry');
Route::any('/fawry-payment', 'FawryPaymentController@payment')->name('fawry-payment');

// The callback url after a payment
Route::get('mercadopago/home', 'MercadoPagoController@index')->name('mercadopago.index');
Route::post('mercadopago/make-payment', 'MercadoPagoController@make_payment')->name('mercadopago.make_payment');
Route::get('mercadopago/get-user', 'MercadoPagoController@get_test_user')->name('mercadopago.get-user');

// The route that the button calls to initialize payment
Route::post('/flutterwave-pay', 'FlutterwaveController@initialize')->name('flutterwave_pay');
// The callback url after a payment
Route::get('/rave/callback', 'FlutterwaveController@callback')->name('flutterwave_callback');

// The callback url after a payment PAYTM
Route::get('paytm-payment', 'PaytmController@payment')->name('paytm-payment');
Route::any('paytm-response', 'PaytmController@callback')->name('paytm-response');

// The callback url after a payment LIQPAY
Route::get('liqpay-payment', 'LiqPayController@payment')->name('liqpay-payment');
Route::any('liqpay-callback', 'LiqPayController@callback')->name('liqpay-callback');

// Route::get('/test', function (){
//     $product = \App\Model\Product::find(116);
//     $quantity = 6;
//     return view('seller-views.product.barcode-pdf', compact('product', 'quantity'));
// });

// Route::get('/fcm-token', [WebController::class, 'updateFcmToken']);// for testing
Route::get('/sendnotification', [WebController::class, 'notification']); // for testing
Route::patch('/fcm-web-token', [WebController::class, 'updateFcmToken']);
Route::post('/send-notification', [WebController::class, 'notification']);

Route::group(['namespace' => 'Web', 'middleware' => ['maintenance_mode']], function () {
    Route::get('crypto', [CryptoAffiliateController::class, 'view'])->name('crypto-affiliates');
    Route::get('crypto/{id}', [CryptoAffiliateController::class, 'show'])->name('crypto-affiliates.show');
});

// Route::get('/php artisan {artisan}', function ($artisan) {
// 	\Artisan::call($artisan);
// 	return \Artisan::output();
// });
