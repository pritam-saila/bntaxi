{{--
    TaxiService structured data (JSON-LD) for the homepage, so Google understands the business,
    its 24/7 hours and the areas served. Business details come from config/services.php ("business"),
    which reads .env, so they can be completed without touching this file.
    Test after deploying: https://search.google.com/test/rich-results
--}}
@php
    $biz = config('services.business');
    $siteUrl = rtrim(config('app.url'), '/');

    $address = array_filter([
        '@type' => 'PostalAddress',
        'streetAddress' => $biz['street_address'] ?? null,
        'addressLocality' => 'Brighton',
        'addressRegion' => 'East Sussex',
        'postalCode' => $biz['postcode'] ?? null,
        'addressCountry' => 'GB',
    ]);

    $sameAs = array_values(array_filter([
        $biz['google_business_url'] ?? null,
        $biz['facebook_url'] ?? null,
        $biz['instagram_url'] ?? null,
        $biz['twitter_url'] ?? null,
    ]));

    $business = array_filter([
        '@type' => 'LocalBusiness',
        '@id' => $siteUrl . '/#business',
        'name' => 'BN Taxi Anytime',
        'url' => $siteUrl . '/',
        'telephone' => '+441273757373',
        'email' => 'info@bntaxianytime.com',
        'image' => $siteUrl . '/goods/images/og-share.jpg',
        'logo' => $siteUrl . '/goods/images/logo.png',
        'priceRange' => '££',
        'address' => $address,
        'openingHoursSpecification' => [
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'opens' => '00:00',
            'closes' => '23:59',
        ],
        'sameAs' => $sameAs ?: null,
    ]);

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'TaxiService',
        'name' => 'BN Taxi Anytime',
        'url' => $siteUrl . '/',
        'description' => '24/7 Brighton taxi service with fixed-price airport transfers to Gatwick, Heathrow, Luton, Stansted and London City.',
        'provider' => $business,
        'areaServed' => array_map(fn ($town) => ['@type' => 'City', 'name' => $town], [
            'Brighton', 'Hove', 'Lewes', 'Worthing', 'Eastbourne', 'Haywards Heath', 'Burgess Hill',
            'Hassocks', 'Lancing', 'Newhaven', 'Horsham', 'Falmer', 'Saltdean',
        ]),
    ];
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
