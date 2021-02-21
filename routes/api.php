<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {
	
	/**
		API Routes For Chrome Extension ---Start
	**/
	
	Route::post('checkUserLoggedIn', 'ApiUserController@checkUserLoggedIn')->middleware('cors'); 
	Route::post('getAllStores', 'ApiStoreController@getAllStores')->middleware('cors'); 
	Route::post('getUserFavouriteStores', 'ApiStoreController@getUserFavouriteStores')->middleware('cors');
	Route::post('addStoreInFavourite', 'ApiStoreController@addStoreInFavourite')->middleware('cors');
	Route::post('removeStoreFromFavourite', 'ApiStoreController@removeStoreFromFavourite')->middleware('cors');
	Route::post('getStoreDetails/{id}', 'ApiStoreController@getStoreDetails')->middleware('cors');
	Route::post('getStoreDeals/{store_id}', 'ApiStoreController@getStoreDeals')->middleware('cors');
	Route::post('getStoreDonations/{store_id}', 'ApiStoreController@getStoreDonations')->middleware('cors');
	Route::post('getSimilarStores/{store_id}', 'ApiStoreController@getSimilarStores')->middleware('cors');
	Route::post('getUserDetails/{user_id}', 'ApiUserController@getUserDetails')->middleware('cors');
	Route::post('getStores', 'ApiStoreController@getStores')->middleware('cors');
	Route::post('getStoresByKeyword', 'ApiStoreController@getStoresByKeyword')->middleware('cors');
	Route::post('getShopLink', 'ApiStoreController@getShopLink')->middleware('cors');
	
	/**
		API Routes For Chrome Extension ---End
	**/
	
	
	/**
		API Routes For Mobile Application ---Start
	**/
	Route::post('login', 'UserController@loginUser')->middleware('cors');
	Route::get('home', 'UserController@getHomeScreenData')->middleware('cors');
	Route::get('getAllCampaigns', 'CampaignController@getAllCampaigns')->middleware('cors');
	Route::get('campaignDetails/{id}', 'CampaignController@getCampaignDetails')->middleware('cors');
	Route::get('getAllCauses', 'CampaignController@getAllCauses')->middleware('cors');
	Route::post('searchStores', 'StoreController@searchStores')->middleware('cors');
	Route::post('checkStoreForNotificationPopup', 'StoreController@checkStoreForNotificationPopup')->middleware('cors');
	Route::post('loginWithSocialMedia', 'UserController@loginWithSocialMedia')->middleware('cors');
	Route::get('getUserAllNotifications', 'UserController@getUserAllNotifications')->middleware('cors');
	Route::get('getNotificationDetails/{id}', 'UserController@getNotiicationDetails')->middleware('cors');
	Route::post('change-cause', 'UserController@changeUserCause')->middleware('cors');
	
	
	/**
		API Routes For Mobile Application ---End
	**/
});
