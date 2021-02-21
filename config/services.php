<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
	
	'facebook' => [
        'client_id'     => '1332843243533071',
        'client_secret' => '604b302adf01356b716cfb82a1adbea9',
        'redirect'      => 'https://www.charitism.com/callback/facebook',
    ],
	
	'google' => [
        'client_id'     => '358382154459-gsco4jllefe1ggj6lkb2ipccvbkj8gcj.apps.googleusercontent.com',
        'client_secret' => 'jxWf7ObLm-eJUIe4-iod-wEO',
        'redirect'      =>'https://www.charitism.com/callback/google',
    ],

];
