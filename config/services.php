<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // Public business details used by the footer and the homepage's structured data (SEO).
    // Leave a value empty and it is simply not shown / not added to the schema.
    'business' => [
        'street_address' => env('BUSINESS_STREET_ADDRESS'),
        'postcode' => env('BUSINESS_POSTCODE', 'BN2 4AY'),
        'licence' => env('BUSINESS_LICENCE_NUMBER'),
        'google_business_url' => env('GOOGLE_BUSINESS_URL'),
        'google_review_url' => env('GOOGLE_REVIEW_URL'),
        'whatsapp_url' => env('WHATSAPP_URL', 'https://wa.me/447491757373'),
        'facebook_url' => env('SOCIAL_FACEBOOK_URL'),
        'instagram_url' => env('SOCIAL_INSTAGRAM_URL'),
        'twitter_url' => env('SOCIAL_TWITTER_URL'),
    ],

];
