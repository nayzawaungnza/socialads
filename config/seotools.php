<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        'defaults' => [
            'title' => 'Social Ads Marketing Myanmar',
            'titleBefore' => false,
            'description' => 'Boost your brand with top-notch Social Ads Marketing in Myanmar! Reach targeted audiences, increase engagement, and drive sales with expert strategies. Get started today!',
            'keywords' => [
                'Social Ads Myanmar',
                'Digital Marketing Myanmar',
                'Facebook Ads Myanmar',
                'Social Media Marketing Myanmar',
                'Online Advertising Myanmar',
                'Facebook Marketing Myanmar',
                'Instagram Ads Myanmar',
                'Google Ads Myanmar',
                'Paid Advertising Myanmar',
                'Targeted Ads Myanmar',
                'PPC Advertising Myanmar',
                'Brand Promotion Myanmar',
                'Lead Generation Myanmar',
                'Social Media Growth Myanmar',
                'Online Business Promotion Myanmar',
                'Digital Strategy Myanmar',
                'E-commerce Marketing Myanmar',
                'Social Ads Campaign Myanmar',
                'Performance Marketing Myanmar',
                'Advertising Agency Myanmar'
            ],
            'separator' => ' - ', // Added separator for title concatenation
            'canonical' => 'https://www.socialadsdigital.com',
            'robots' => 'index, follow',
            'image' => 'https://socialadsdigital.com/assets/frontend/images/Social_Ads_Marketing_Myanmar.png', // Added default image
        ],
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],
        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        'defaults' => [
            'title' => 'Social Ads Marketing Myanmar',
            'description' => 'Boost your brand with top-notch Social Ads Marketing in Myanmar! Reach targeted audiences, increase engagement, and drive sales with expert strategies. Get started today!',
            'url' => null,
            'type' => 'website', // Changed from false to a valid type
            'site_name' => 'Social Ads Marketing Myanmar', // Added site name
            'images' => ['https://socialadsdigital.com/assets/frontend/images/Social_Ads_Marketing_Myanmar.png'],
            'locale' => 'en_US', // Added default locale
        ],
    ],
    'twitter' => [
        'defaults' => [
            'card' => 'summary_large_image',
            'site' => '@YourTwitterHandle', // Replace with actual handle
            'title' => 'Social Ads Marketing Myanmar', // Added title
            'description' => 'Boost your brand with top-notch Social Ads Marketing in Myanmar! Reach targeted audiences, increase engagement, and drive sales with expert strategies. Get started today!', // Added description
            'image' => 'https://socialadsdigital.com/assets/frontend/images/Social_Ads_Marketing_Myanmar.png',
            'creator' => '@YourTwitterHandle', // Added creator handle
        ],
    ],
    'json-ld' => [
        'defaults' => [
            'title' => 'Social Ads Marketing Myanmar',
            'description' => 'Boost your brand with top-notch Social Ads Marketing in Myanmar! Reach targeted audiences, increase engagement, and drive sales with expert strategies. Get started today!',
            'url' => null,
            'type' => 'WebPage',
            'images' => ['https://socialadsdigital.com/assets/frontend/images/Social_Ads_Marketing_Myanmar.png'],
            '@context' => 'https://schema.org', // Added context
            'sameAs' => [ // Added social profiles
                'https://twitter.com/YourTwitterHandle',
                'https://facebook.com/YourFacebookPage',
                'https://instagram.com/YourInstagramHandle'
            ]
        ],
    ],
];