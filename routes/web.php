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

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::get('/config-cache', function() {
    Artisan::call('config:cache');
    return "Config is cleared";
});

Route::get('/view', function() {
    Artisan::call('view:clear');
    return "View is cleared";
});

Auth::routes();

/* Route::group(['prefix' => 'api/v1', 'namespace' => 'Api\v1'], function () {
	Route::get('getAllStores', 'ApiStoreController@getAllStores')->middleware('cors');
	
}); */
Route::get('/select-cause', function() {
    return view('select-cause');
});

Route::post('/social-register-select-cause', 'CommonController@selectCauseOnSocialRegister');

Route::get('send-buy-later-email', 'CronController@sendBuyLaterEmail');
Route::get('end-campaign-cron', 'CronController@endCampaignOnDate');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::post('/search-stores', 'CommonController@searchStores');
Route::get('/about-us', 'PageController@getAboutUsPageContent');
Route::get('/how-it-works', 'PageController@getHowItWorksPageContent');
Route::get('/blogs', 'PageController@getAllBlogs');
Route::get('/blogs/{slug}', 'PageController@getBlogDetail');
Route::get('/our-team', 'PageController@getAllTeams');
Route::get('/terms-and-conditions', 'PageController@getTermsAndConditions');
Route::get('/privacy-policy', 'PageController@getPrivacyPolicyPageContent');
Route::get('/cookies', 'PageController@getCookiesPageContent');
Route::get('/contact-us', 'PageController@getContactUsPageContent');
Route::get('stores', 'StoreController@getAllStores');
Route::get('stores/{slug}', 'StoreController@getStoreDetail');
Route::get('stores/store-cat/{slug}', 'StoreController@getStoresByStoreCat');
Route::get('store-deals', 'StoreController@getStoreAllDeals');
Route::get('campaigns', 'CampaignController@getAllCampaigns');
Route::get('campaigns/{slug}', 'CampaignController@getCampaignDetail');
Route::get('campaigns/cause-cat/{slug}', 'CampaignController@getCampaignsByCauseCat');
Route::get('impact-products/{slug}', 'StoreController@getImpactProductDetail');
Route::get('reports', 'PageController@getAllReports');
Route::get('start-campaign', 'PageController@getStartCampaignContent');
Route::get('thank-you/{name?}', 'PageController@getShopThankYouPage');

Route::post('login', 'CommonController@loginUser');

Route::get('register', 'CommonController@getRegistartionForm');
Route::post('checkEmailExists', 'CommonController@checkEmailExists');
Route::post('checkContactNumberExists', 'CommonController@checkContactNumberExists');
Route::post('register-user', 'CommonController@registerUser');
Route::post('logoutuser', 'CommonController@logoutUser');

Route::post('forgot-password', 'CommonController@forgotPassword');
Route::get('reset-password/{token}', 'CommonController@resetPassword');
Route::post('reset-password', 'CommonController@updateNewPassword');

Route::post('support-enquiry', 'CommonController@submitSupportEnquiry');
Route::post('store-enquiry', 'CommonController@submitStoreEnquiry');

Route::get ( '/redirect/{service}', 'SocialAuthController@redirect' );
Route::get ( '/callback/{service}', 'SocialAuthController@callback' );

Route::group(['namespace' => 'User','middleware' => 'auth'], function () {
	Route::get('dashboard', 'DashboardController@dashboard');
	Route::get('my-account', 'ProfileController@myAccount');
	Route::post('update-profile', 'ProfileController@updateProfile');
	Route::post('change-user-cause', 'ProfileController@changeUserCause');
	Route::post('add-to-favourite', 'FavouriteController@addToFavourite');
	Route::post('remove-from-favourite', 'FavouriteController@removeFromFavourite');
	Route::post('add-to-favourite-from-my-account', 'FavouriteController@addStoreToFavouriteFromMyAccount');
});

Route::group(['prefix' => 'siteadmin', 'namespace' => 'Admin'], function () {
	
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('login', 'Auth\LoginController@login')->name('admin.login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');
});

Route::group(['prefix'=>'siteadmin', 'namespace' => 'Admin','middleware' => 'auth'], function () {	
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
	Route::get('/edit-profile', 'CommonController@editProfile');
	Route::post('/updateprofile', 'CommonController@updateprofile');
	Route::post('/upload-editor-image', 'CommonController@uploadEditorImage');
	
	// Route For Store Categories Module Start
	Route::get('/store-categories', ['middleware'=>'auth','uses'=>'StoreCategoryController@index'])->name('store-categories.index');
	Route::get('/store-categories/create',['middleware'=>'auth','uses'=>'StoreCategoryController@create'])->name('store-categories.create');
	Route::post('/store-categories/store', ['middleware'=>'auth','uses'=>'StoreCategoryController@store'])->name('store-categories.store');
	Route::get('/store-categories/edit/{id}',['middleware'=>'auth','uses'=>'StoreCategoryController@edit'])->name('store-categories.edit');
	Route::post('/store-categories/update/{id}', ['middleware'=>'auth','uses'=>'StoreCategoryController@update'])->name('store-categories.update');
	Route::get('/store-categories/delete/{id}',['middleware'=>'auth','uses'=>'StoreCategoryController@destroy']);
	Route::get('/store-categories/show/{id}',['middleware'=>'auth','uses'=>'StoreCategoryController@show'])->name('store-categories.show');
	Route::get('/store-categories/changestatus/{id}',['middleware'=>'auth','uses'=>'StoreCategoryController@changeCategoryStatus']);
	Route::post('/store-categories/delete-cat-image/{id}',['middleware'=>'auth','uses'=>'StoreCategoryController@deleteCategoryImage']);
	Route::post('/store-categories/delete-cat-icon/{id}',['middleware'=>'auth','uses'=>'StoreCategoryController@deleteCategoryIcon']);
	//Route For Store Categories End
	
	// Route For Stores Module Start
	Route::get('/stores', ['middleware'=>'auth','uses'=>'StoreController@index'])->name('stores.index');
	Route::get('/stores/create',['middleware'=>'auth','uses'=>'StoreController@create'])->name('stores.create');
	Route::post('/stores/store', ['middleware'=>'auth','uses'=>'StoreController@store'])->name('stores.store');
	Route::get('/stores/edit/{id}',['middleware'=>'auth','uses'=>'StoreController@edit'])->name('stores.edit');
	Route::post('/stores/update/{id}', ['middleware'=>'auth','uses'=>'StoreController@update'])->name('stores.update');
	Route::get('/stores/delete/{id}',['middleware'=>'auth','uses'=>'StoreController@destroy']);
	Route::get('/stores/show/{id}',['middleware'=>'auth','uses'=>'StoreController@show'])->name('stores.show');
	Route::get('/stores/changestatus/{id}',['middleware'=>'auth','uses'=>'StoreController@changeStoreStatus']);
	Route::post('/stores/delete-store-image/{id}',['middleware'=>'auth','uses'=>'StoreController@deleteStoreImage']);
	Route::post('/stores/delete-store-logo/{id}',['middleware'=>'auth','uses'=>'StoreController@deleteStoreLogo']);
	Route::post('/stores/delete-donation-rates',['middleware'=>'auth','uses'=>'StoreController@deleteDonationRates']);
	//Route For Stores End
	
	// Route For Donation Rates Module Start
	Route::get('/donation-rates', ['middleware'=>'auth','uses'=>'DonationRatesController@index'])->name('donation-rates.index');
	Route::get('/donation-rates/create',['middleware'=>'auth','uses'=>'DonationRatesController@create'])->name('donation-rates.create');
	Route::post('/donation-rates/store', ['middleware'=>'auth','uses'=>'DonationRatesController@store'])->name('donation-rates.store');
	Route::get('/donation-rates/edit/{id}',['middleware'=>'auth','uses'=>'DonationRatesController@edit'])->name('donation-rates.edit');
	Route::post('/donation-rates/update/{id}', ['middleware'=>'auth','uses'=>'DonationRatesController@update'])->name('donation-rates.update');
	Route::get('/donation-rates/delete/{id}',['middleware'=>'auth','uses'=>'DonationRatesController@destroy']);
	Route::get('/donation-rates/changestatus/{id}',['middleware'=>'auth','uses'=>'DonationRatesController@changeDonationRateStatus']);
	//Route For Donation Rates End
	
	// Route For Impact Products Module Start
	Route::get('/impact-products', ['middleware'=>'auth','uses'=>'ImpactProductController@index'])->name('impact-products.index');
	Route::get('/impact-products/create',['middleware'=>'auth','uses'=>'ImpactProductController@create'])->name('impact-products.create');
	Route::post('/impact-products/store', ['middleware'=>'auth','uses'=>'ImpactProductController@store'])->name('impact-products.store');
	Route::get('/impact-products/edit/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@edit'])->name('impact-products.edit');
	Route::post('/impact-products/update/{id}', ['middleware'=>'auth','uses'=>'ImpactProductController@update'])->name('impact-products.update');
	Route::get('/impact-products/delete/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@destroy']);
	Route::get('/impact-products/show/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@show'])->name('impact-products.show');
	Route::get('/impact-products/changestatus/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@changeImpactProductStatus']);
	Route::post('/impact-products/delete-impact-product-image/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@deleteImpactProductImage']);
	Route::post('/impact-products/delete-impact-product-logo/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@deleteImpactProductLogo']);
	Route::get('/impact-products/remove-from-verified/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@removeProductFromVerified']);
	Route::get('/impact-products/add-to-verified/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@addProductToVerified']);
	Route::post('/impact-products/delete-pros-and-cons',['middleware'=>'auth','uses'=>'ImpactProductController@deleteProsAndCons']);
	Route::get('/impact-products/remove-from-featured/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@removeProductFromFeatured']);
	Route::get('/impact-products/add-to-featured/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@addProductToFeatured']);
	Route::post('/impact-products/delete-impact-image/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@deleteImpactImage']);
	Route::post('/impact-products/delete-product-photo/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@deleteProductPhoto']);
	//Route For Impact Products End
	
	// Route For Impact Products Reviwes Module Start
	Route::get('/impact-products/reviews', ['middleware'=>'auth','uses'=>'ImpactProductReviewController@index'])->name('impact-products.reviews');
	Route::get('/impact-products/reviews/create',['middleware'=>'auth','uses'=>'ImpactProductReviewController@create'])->name('impact-products.create-review');
	Route::post('/impact-products/reviews/store', ['middleware'=>'auth','uses'=>'ImpactProductReviewController@store'])->name('impact-products.store-reviews');
	Route::get('/impact-products/reviews/edit/{id}',['middleware'=>'auth','uses'=>'ImpactProductReviewController@edit'])->name('impact-products.edit-review');
	Route::post('/impact-products/reviews/update/{id}', ['middleware'=>'auth','uses'=>'ImpactProductReviewController@update'])->name('impact-products.update-reviews');
	Route::get('/impact-products/reviews/delete/{id}',['middleware'=>'auth','uses'=>'ImpactProductReviewController@destroy']);
	Route::get('/impact-products/reviews/change-status/{id}',['middleware'=>'auth','uses'=>'ImpactProductReviewController@changeStatus']);
	Route::post('/impact-products/reviews/delete-image/{id}',['middleware'=>'auth','uses'=>'ImpactProductReviewController@deleteImage']);
	// Route For Impact Products Reviwes Module Start
	
	// Route For Impact Products Module Start
	Route::get('/impact-products/pros-and-cons', ['middleware'=>'auth','uses'=>'ImpactProductController@getProsAndCons'])->name('impact-products.pros-and-cons');
	Route::get('/impact-products/create-pros-and-cons',['middleware'=>'auth','uses'=>'ImpactProductController@createProsAndCons'])->name('impact-products.create-pros-and-cons');
	Route::post('/impact-products/store-pros-and-cons', ['middleware'=>'auth','uses'=>'ImpactProductController@storeProsAndCons'])->name('impact-products.store-pros-and-cons');
	Route::get('/impact-products/edit-pros-and-cons/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@editProsAndCons'])->name('impact-products.edit-pros-and-cons');
	Route::post('/impact-products/update-pros-and-cons/{id}', ['middleware'=>'auth','uses'=>'ImpactProductController@updateProsAndCons'])->name('impact-products.update-pros-and-cons');
	Route::get('/impact-products/pros-and-cons/delete/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@destroyProsAndCons']);
	Route::get('/impact-products/pros-and-cons/changestatus/{id}',['middleware'=>'auth','uses'=>'ImpactProductController@changeImpactProductProsAndConStatusStatus']);
	//Route For Impact Products End
	
	// Route For Cause Categories Module Start
	Route::get('/cause-categories', ['middleware'=>'auth','uses'=>'CauseCategoryController@index'])->name('cause-categories.index');
	Route::get('/cause-categories/create',['middleware'=>'auth','uses'=>'CauseCategoryController@create'])->name('cause-categories.create');
	Route::post('/cause-categories/store', ['middleware'=>'auth','uses'=>'CauseCategoryController@store'])->name('cause-categories.store');
	Route::get('/cause-categories/edit/{id}',['middleware'=>'auth','uses'=>'CauseCategoryController@edit'])->name('cause-categories.edit');
	Route::post('/cause-categories/update/{id}', ['middleware'=>'auth','uses'=>'CauseCategoryController@update'])->name('cause-categories.update');
	Route::get('/cause-categories/delete/{id}',['middleware'=>'auth','uses'=>'CauseCategoryController@destroy']);
	Route::get('/cause-categories/show/{id}',['middleware'=>'auth','uses'=>'CauseCategoryController@show'])->name('cause-categories.show');
	Route::get('/cause-categories/changestatus/{id}',['middleware'=>'auth','uses'=>'CauseCategoryController@changeCategoryStatus']);
	Route::post('/cause-categories/delete-cat-image/{id}',['middleware'=>'auth','uses'=>'CauseCategoryController@deleteCategoryImage']);
	Route::post('/cause-categories/delete-cat-icon/{id}',['middleware'=>'auth','uses'=>'CauseCategoryController@deleteCategoryIcon']);
	Route::post('/cause-categories/delete-cat-thumbnail/{id}',['middleware'=>'auth','uses'=>'CauseCategoryController@deleteCategoryThumbnail']);
	//Route For Cause Categories End
	
	// Route For Campaigns Module Start
	Route::get('/campaigns', ['middleware'=>'auth','uses'=>'CharityController@index'])->name('campaigns.index');
	Route::get('/campaigns/create',['middleware'=>'auth','uses'=>'CharityController@create'])->name('campaigns.create');
	Route::post('/campaigns/store', ['middleware'=>'auth','uses'=>'CharityController@store'])->name('campaigns.store');
	Route::get('/campaigns/edit/{id}',['middleware'=>'auth','uses'=>'CharityController@edit'])->name('campaigns.edit');
	Route::post('/campaigns/update/{id}', ['middleware'=>'auth','uses'=>'CharityController@update'])->name('campaigns.update');
	Route::get('/campaigns/delete/{id}',['middleware'=>'auth','uses'=>'CharityController@destroy']);
	Route::get('/campaigns/show/{id}',['middleware'=>'auth','uses'=>'CharityController@show'])->name('campaigns.show');
	Route::get('/campaigns/changestatus/{id}',['middleware'=>'auth','uses'=>'CharityController@changeCharityStatus']);
	Route::post('/campaigns/delete-charity-image/{id}',['middleware'=>'auth','uses'=>'CharityController@deleteCharityImage']);
	Route::post('/campaigns/delete-charity-logo/{id}',['middleware'=>'auth','uses'=>'CharityController@deleteCharityLogo']);
	Route::post('/campaigns/delete-chairty-photo/{id}',['middleware'=>'auth','uses'=>'CharityController@deleteCharityPhoto']);
	Route::get('/campaigns/remove-from-verified/{id}',['middleware'=>'auth','uses'=>'CharityController@removeFromVerified']);
	Route::get('/campaigns/add-to-verified/{id}',['middleware'=>'auth','uses'=>'CharityController@addToVerified']);
	Route::get('/campaigns/complete-chairty/{id}',['middleware'=>'auth','uses'=>'CharityController@completeCharity']);
	Route::post('/campaigns/delete-thank-you-image/{id}',['middleware'=>'auth','uses'=>'CharityController@deleteCampaignThankYouImage']);
	//Route For Campaigns End
	
	// Route For Blogs Module Start
	Route::get('/blogs', ['middleware'=>'auth','uses'=>'BlogsController@index'])->name('blogs.index');
	Route::get('/blogs/create',['middleware'=>'auth','uses'=>'BlogsController@create'])->name('blogs.create');
	Route::post('/blogs/store', ['middleware'=>'auth','uses'=>'BlogsController@store'])->name('blogs.store');
	Route::get('/blogs/edit/{id}',['middleware'=>'auth','uses'=>'BlogsController@edit'])->name('blogs.edit');
	Route::post('/blogs/update/{id}', ['middleware'=>'auth','uses'=>'BlogsController@update'])->name('blogs.update');
	Route::get('/blogs/delete/{id}',['middleware'=>'auth','uses'=>'BlogsController@destroy']);
	Route::get('/blogs/show/{id}',['middleware'=>'auth','uses'=>'BlogsController@show'])->name('blogs.show');
	Route::get('/blogs/changestatus/{id}',['middleware'=>'auth','uses'=>'BlogsController@changeBlogStatus']);
	Route::post('/blogs/delete-blog-image/{id}',['middleware'=>'auth','uses'=>'BlogsController@deleteBlogImage']);
	Route::post('/blogs/delete-blog-author-image/{id}',['middleware'=>'auth','uses'=>'BlogsController@deleteBlogAuthorImage']);
	//Route For Blogs End
	
	// Route For Users Module Start
	Route::get('/users', ['middleware'=>'auth','uses'=>'UserController@index'])->name('users.index');
	Route::get('/users/delete/{id}', ['middleware'=>'auth','uses'=>'UserController@destroy'])->name('users.delete');
	Route::get('/users/changestatus/{id}', ['middleware'=>'auth','uses'=>'UserController@changeUserStatus']);
	//Route For Users End
	
	// Route For Site Settings Module Start
	Route::get('/site-settings', ['middleware'=>'auth','uses'=>'SiteSettingsController@index'])->name('site-settings.index');
	Route::post('/site-settings/store', ['middleware'=>'auth','uses'=>'SiteSettingsController@store'])->name('site-settings.store');
	//Route For Site Settings End
	
	// Route For Pages Module Start
	Route::get('/pages/{type}', ['middleware'=>'auth','uses'=>'PageController@index'])->name('pages.index');
	Route::post('/pages/update-content', ['middleware'=>'auth','uses'=>'PageController@updatePageContent'])->name('pages.update-content');
	Route::post('/pages/delete-page-featured-image/{id}', ['middleware'=>'auth','uses'=>'PageController@deleteFeaturedImage']);
	//Route For Pages End
	
	// Route For Team Module Start
	Route::get('/our-team', ['middleware'=>'auth','uses'=>'OurTeamController@index'])->name('our-team.index');
	Route::get('/our-team/create',['middleware'=>'auth','uses'=>'OurTeamController@create'])->name('our-team.create');
	Route::post('/our-team/store', ['middleware'=>'auth','uses'=>'OurTeamController@store'])->name('our-team.store');
	Route::get('/our-team/edit/{id}',['middleware'=>'auth','uses'=>'OurTeamController@edit'])->name('our-team.edit');
	Route::post('/our-team/update/{id}', ['middleware'=>'auth','uses'=>'OurTeamController@update'])->name('our-team.update');
	Route::get('/our-team/delete/{id}',['middleware'=>'auth','uses'=>'OurTeamController@destroy']);
	Route::get('/our-team/show/{id}',['middleware'=>'auth','uses'=>'OurTeamController@show'])->name('our-team.show');
	Route::get('/our-team/changestatus/{id}',['middleware'=>'auth','uses'=>'OurTeamController@changeTeamStatus']);
	Route::post('/our-team/delete-team-image/{id}',['middleware'=>'auth','uses'=>'OurTeamController@deleteTeamImage']);
	//Route For Team End
	
	// Route For Campaigners Module Start
	Route::get('/campaginers', ['middleware'=>'auth','uses'=>'CampaignerController@index'])->name('campaginers.index');
	Route::get('/campaginers/create',['middleware'=>'auth','uses'=>'CampaignerController@create'])->name('campaginers.create');
	Route::post('/campaginers/store', ['middleware'=>'auth','uses'=>'CampaignerController@store'])->name('campaginers.store');
	Route::get('/campaginers/edit/{id}',['middleware'=>'auth','uses'=>'CampaignerController@edit'])->name('campaginers.edit');
	Route::post('/campaginers/update/{id}', ['middleware'=>'auth','uses'=>'CampaignerController@update'])->name('campaginers.update');
	Route::get('/campaginers/delete/{id}',['middleware'=>'auth','uses'=>'CampaignerController@destroy']);
	Route::get('/campaginers/show/{id}',['middleware'=>'auth','uses'=>'CampaignerController@show'])->name('campaginers.show');
	Route::get('/campaginers/changestatus/{id}',['middleware'=>'auth','uses'=>'CampaignerController@changeCampaignerStatus']);
	Route::get('/campaginers/remove-from-verified/{id}',['middleware'=>'auth','uses'=>'CampaignerController@removeFromVerified']);
	Route::get('/campaginers/add-to-verified/{id}',['middleware'=>'auth','uses'=>'CampaignerController@addToVerified']);
	Route::post('/campaginers/delete-campaginer-image/{id}',['middleware'=>'auth','uses'=>'CampaignerController@deleteCampaignerImage']);
	//Route For Campaigners End
	
	// Route For Beneficiaries Module Start
	Route::get('/beneficiaries', ['middleware'=>'auth','uses'=>'BeneficiaryController@index'])->name('beneficiaries.index');
	Route::get('/beneficiaries/create',['middleware'=>'auth','uses'=>'BeneficiaryController@create'])->name('beneficiaries.create');
	Route::post('/beneficiaries/store', ['middleware'=>'auth','uses'=>'BeneficiaryController@store'])->name('beneficiaries.store');
	Route::get('/beneficiaries/edit/{id}',['middleware'=>'auth','uses'=>'BeneficiaryController@edit'])->name('beneficiaries.edit');
	Route::post('/beneficiaries/update/{id}', ['middleware'=>'auth','uses'=>'BeneficiaryController@update'])->name('beneficiaries.update');
	Route::get('/beneficiaries/delete/{id}',['middleware'=>'auth','uses'=>'BeneficiaryController@destroy']);
	Route::get('/beneficiaries/show/{id}',['middleware'=>'auth','uses'=>'BeneficiaryController@show'])->name('beneficiaries.show');
	Route::get('/beneficiaries/changestatus/{id}',['middleware'=>'auth','uses'=>'BeneficiaryController@changeBeneficiaryStatus']);
	Route::get('/beneficiaries/remove-from-verified/{id}',['middleware'=>'auth','uses'=>'BeneficiaryController@removeFromVerified']);
	Route::get('/beneficiaries/add-to-verified/{id}',['middleware'=>'auth','uses'=>'BeneficiaryController@addToVerified']);
	Route::post('/beneficiaries/delete-beneficiary-image/{id}',['middleware'=>'auth','uses'=>'BeneficiaryController@deleteBeneficiaryImage']);
	//Route For Beneficiaries End
	
	// Route For Team Module Start
	Route::get('/testimonials', ['middleware'=>'auth','uses'=>'TestimonialController@index'])->name('testimonials.index');
	Route::get('/testimonials/create',['middleware'=>'auth','uses'=>'TestimonialController@create'])->name('testimonials.create');
	Route::post('/testimonials/store', ['middleware'=>'auth','uses'=>'TestimonialController@store'])->name('testimonials.store');
	Route::get('/testimonials/edit/{id}',['middleware'=>'auth','uses'=>'TestimonialController@edit'])->name('testimonials.edit');
	Route::post('/testimonials/update/{id}', ['middleware'=>'auth','uses'=>'TestimonialController@update'])->name('testimonials.update');
	Route::get('/testimonials/delete/{id}',['middleware'=>'auth','uses'=>'TestimonialController@destroy']);
	Route::get('/testimonials/show/{id}',['middleware'=>'auth','uses'=>'TestimonialController@show'])->name('testimonials.show');
	Route::get('/testimonials/changestatus/{id}',['middleware'=>'auth','uses'=>'TestimonialController@changeTestimonialStatus']);
	Route::post('/testimonials/delete-image/{id}',['middleware'=>'auth','uses'=>'TestimonialController@deleteImage']);
	//Route For Team End
	
	// Route For Guide Module Start
	Route::get('/guides', ['middleware'=>'auth','uses'=>'GuideController@index'])->name('guides.index');
	Route::get('/guides/create',['middleware'=>'auth','uses'=>'GuideController@create'])->name('guides.create');
	Route::post('/guides/store', ['middleware'=>'auth','uses'=>'GuideController@store'])->name('guides.store');
	Route::get('/guides/edit/{id}',['middleware'=>'auth','uses'=>'GuideController@edit'])->name('guides.edit');
	Route::post('/guides/update/{id}', ['middleware'=>'auth','uses'=>'GuideController@update'])->name('guides.update');
	Route::get('/guides/delete/{id}',['middleware'=>'auth','uses'=>'GuideController@destroy']);
	Route::get('/guides/show/{id}',['middleware'=>'auth','uses'=>'GuideController@show'])->name('guides.show');
	Route::get('/guides/changestatus/{id}',['middleware'=>'auth','uses'=>'GuideController@changeGuideStatus']);
	Route::post('/guides/delete-guide-image/{id}',['middleware'=>'auth','uses'=>'GuideController@deleteGuideImage']);
	//Route For Guide End
	
	// Route For Contact Emails Module Start
	Route::get('/contact-emails', ['middleware'=>'auth','uses'=>'ContactEmailController@index'])->name('contact-emails.index');
	Route::get('/contact-emails/create',['middleware'=>'auth','uses'=>'ContactEmailController@create'])->name('contact-emails.create');
	Route::post('/contact-emails/store', ['middleware'=>'auth','uses'=>'ContactEmailController@store'])->name('contact-emails.store');
	Route::get('/contact-emails/edit/{id}',['middleware'=>'auth','uses'=>'ContactEmailController@edit'])->name('contact-emails.edit');
	Route::post('/contact-emails/update/{id}', ['middleware'=>'auth','uses'=>'ContactEmailController@update'])->name('contact-emails.update');
	Route::get('/contact-emails/delete/{id}',['middleware'=>'auth','uses'=>'ContactEmailController@destroy']);
	Route::get('/contact-emails/show/{id}',['middleware'=>'auth','uses'=>'ContactEmailController@show'])->name('contact-emails.show');
	Route::get('/contact-emails/changestatus/{id}',['middleware'=>'auth','uses'=>'ContactEmailController@changeContactEmailStatus']);
	Route::post('/contact-emails/delete-contact-email-image/{id}',['middleware'=>'auth','uses'=>'ContactEmailController@deleteEmailImage']);
	//Route For Contact Emails End
	
	// Route For Store Deals and Sales Module Start
	Route::get('/deals-and-sales', ['middleware'=>'auth','uses'=>'StoreDealAndSaleController@index'])->name('deals-and-sales.index');
	Route::get('/deals-and-sales/create',['middleware'=>'auth','uses'=>'StoreDealAndSaleController@create'])->name('deals-and-sales.create');
	Route::post('/deals-and-sales/store', ['middleware'=>'auth','uses'=>'StoreDealAndSaleController@store'])->name('deals-and-sales.store');
	Route::get('/deals-and-sales/edit/{id}',['middleware'=>'auth','uses'=>'StoreDealAndSaleController@edit'])->name('deals-and-sales.edit');
	Route::post('/deals-and-sales/update/{id}', ['middleware'=>'auth','uses'=>'StoreDealAndSaleController@update'])->name('deals-and-sales.update');
	Route::get('/deals-and-sales/delete/{id}',['middleware'=>'auth','uses'=>'StoreDealAndSaleController@destroy']);
	Route::get('/deals-and-sales/show/{id}',['middleware'=>'auth','uses'=>'StoreDealAndSaleController@show'])->name('deals-and-sales.show');
	Route::get('/deals-and-sales/changestatus/{id}',['middleware'=>'auth','uses'=>'StoreDealAndSaleController@changeDealAndSaleStatus']);
	Route::post('/deals-and-sales/delete-image/{id}',['middleware'=>'auth','uses'=>'StoreDealAndSaleController@deleteImage']);
	//Route For Store Deals and Sales End
	
	// Route For Sliders Module Start
	Route::get('/sliders', ['middleware'=>'auth','uses'=>'SliderController@index'])->name('sliders.index');
	Route::get('/sliders/create',['middleware'=>'auth','uses'=>'SliderController@create'])->name('sliders.create');
	Route::post('/sliders/store', ['middleware'=>'auth','uses'=>'SliderController@store'])->name('sliders.store');
	Route::get('/sliders/edit/{id}',['middleware'=>'auth','uses'=>'SliderController@edit'])->name('sliders.edit');
	Route::post('/sliders/update/{id}', ['middleware'=>'auth','uses'=>'SliderController@update'])->name('sliders.update');
	Route::get('/sliders/delete/{id}',['middleware'=>'auth','uses'=>'SliderController@destroy']);
	Route::get('/sliders/show/{id}',['middleware'=>'auth','uses'=>'SliderController@show'])->name('sliders.show');
	Route::get('/sliders/changestatus/{id}',['middleware'=>'auth','uses'=>'SliderController@changeSliderStatus']);
	Route::post('/sliders/delete-slider-image/{id}',['middleware'=>'auth','uses'=>'SliderController@deleteSliderImage']);
	//Route For Sliders End
	
	// Route For Monthly Reports Module Start
	Route::get('/monthly-reports', ['middleware'=>'auth','uses'=>'MonthlyReportController@index'])->name('monthly-reports.index');
	Route::get('/monthly-reports/create',['middleware'=>'auth','uses'=>'MonthlyReportController@create'])->name('monthly-reports.create');
	Route::post('/monthly-reports/store', ['middleware'=>'auth','uses'=>'MonthlyReportController@store'])->name('monthly-reports.store');
	Route::get('/monthly-reports/edit/{id}',['middleware'=>'auth','uses'=>'MonthlyReportController@edit'])->name('monthly-reports.edit');
	Route::post('/monthly-reports/update/{id}', ['middleware'=>'auth','uses'=>'MonthlyReportController@update'])->name('monthly-reports.update');
	Route::get('/monthly-reports/delete/{id}',['middleware'=>'auth','uses'=>'MonthlyReportController@destroy']);
	Route::get('/monthly-reports/show/{id}',['middleware'=>'auth','uses'=>'MonthlyReportController@show'])->name('monthly-reports.show');
	Route::get('/monthly-reports/changestatus/{id}',['middleware'=>'auth','uses'=>'MonthlyReportController@changeReportStatus']);
	Route::post('/monthly-reports/delete-monthly-report-image/{id}',['middleware'=>'auth','uses'=>'MonthlyReportController@deleteReportImage']);
	//Route For Monthly Reports End
	
	// Route For Enquiries Module Start
	Route::get('/support-enquiries', ['middleware'=>'auth','uses'=>'SupportEnquiryController@getSuuportEnquiries'])->name('support-enquiries.index');
	Route::get('/support-enquiries/{id}', ['middleware'=>'auth','uses'=>'SupportEnquiryController@showSupportEnquiryDetail'])->name('support-enquiries.show');
	
	Route::get('/store-enquiries', ['middleware'=>'auth','uses'=>'SupportEnquiryController@getStoreEnquiries'])->name('store-enquiries.index');
	
	//Route For Enquiries Reports End
	
	// Route For Banners Module Start
	Route::get('/banners', ['middleware'=>'auth','uses'=>'BannerController@index'])->name('banners.index');
	Route::get('/banners/create',['middleware'=>'auth','uses'=>'BannerController@create'])->name('banners.create');
	Route::post('/banners/store', ['middleware'=>'auth','uses'=>'BannerController@store'])->name('banners.store');
	Route::get('/banners/edit/{id}',['middleware'=>'auth','uses'=>'BannerController@edit'])->name('banners.edit');
	Route::post('/banners/update/{id}', ['middleware'=>'auth','uses'=>'BannerController@update'])->name('banners.update');
	Route::get('/banners/delete/{id}',['middleware'=>'auth','uses'=>'BannerController@destroy']);
	Route::get('/banners/show/{id}',['middleware'=>'auth','uses'=>'BannerController@show'])->name('banners.show');
	Route::get('/banners/changestatus/{id}',['middleware'=>'auth','uses'=>'BannerController@changeBannerStatus']);
	Route::post('/banners/delete-banner-image/{id}',['middleware'=>'auth','uses'=>'BannerController@deleteBannerImage']);
	//Route For Banners End
	
	// Route For Donation Module Start
	Route::get('/store-donations', ['middleware'=>'auth','uses'=>'DonationController@getStoreDonations'])->name('store-donations.index');
	Route::post('/store-donations/import-donations', ['middleware'=>'auth','uses'=>'DonationController@importStoreDonation'])->name('store-donations.import-donations');
	Route::get('/user-donations', ['middleware'=>'auth','uses'=>'DonationController@getUserDonations'])->name('user-donations.index');
	Route::post('/user-donations/import-donations', ['middleware'=>'auth','uses'=>'DonationController@importUserDonation'])->name('user-donations.import-donations');
	//Route For Donation End
	
	// Route For Faq Module Start
	Route::get('/faqs', ['middleware'=>'auth','uses'=>'FaqController@index'])->name('faqs.index');
	Route::get('/faqs/create',['middleware'=>'auth','uses'=>'FaqController@create'])->name('faqs.create');
	Route::post('/faqs/store', ['middleware'=>'auth','uses'=>'FaqController@store'])->name('faqs.store');
	Route::get('/faqs/edit/{id}',['middleware'=>'auth','uses'=>'FaqController@edit'])->name('faqs.edit');
	Route::post('/faqs/update/{id}', ['middleware'=>'auth','uses'=>'FaqController@update'])->name('faqs.update');
	Route::get('/faqs/delete/{id}',['middleware'=>'auth','uses'=>'FaqController@destroy']);
	Route::get('/faqs/show/{id}',['middleware'=>'auth','uses'=>'FaqController@show'])->name('faqs.show');
	Route::get('/faqs/changestatus/{id}',['middleware'=>'auth','uses'=>'FaqController@changeFaqStatus']);
	Route::post('/faqs/delete-faq-image/{id}',['middleware'=>'auth','uses'=>'FaqController@deleteFaqImage']);
	Route::post('/faqs/delete-faq-number-image/{id}',['middleware'=>'auth','uses'=>'FaqController@deleteFaqNumberImage']);
	// Route For Faq Module End
	
	// Route For Home Page Module Start
	Route::get('/home-page/{type}', ['middleware'=>'auth','uses'=>'PageController@getHomePageContent'])->name('home-page.index');
	Route::post('/home-page/update-content', ['middleware'=>'auth','uses'=>'PageController@updateHomePageContent'])->name('home-page.update-content');
	Route::post('/home-page/delete-page-featured-image/{id}', ['middleware'=>'auth','uses'=>'PageController@deleteHomePageFeaturedImage']);
	Route::post('/home-page/delete-page-phone-featured-image/{id}', ['middleware'=>'auth','uses'=>'PageController@deleteHomePagePhoneFeaturedImage']);
	//Route For Home Page End
});