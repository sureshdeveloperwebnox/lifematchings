<?php
return
    [
        'mode'                  => 'utf-8',
        'format'                => 'A4',
        'author'                => '',
        'subject'               => '',
        'keywords'              => '',
        'creator'               => 'Laravel Pdf',
        'display_mode'          => 'fullpage',
        'tempDir'               => base_path('temp/'),
        'font_path' => base_path('public/assets/fonts/'),
        'autoScriptToLang' => true,
        'autoLangToFont' => true,
        'useSubstitutions' => true,
        'simpleTables' => false,
        'useFixedNormalLineHeight' => false,
        'useFixedTextBaseline' => false,
        'useKerning' => true,
        'default_font' => 'droidsansfallback',
        'useSubsets' => false,  // CRITICAL: Disable font subsetting to include all Tamil glyphs
        'font_data' => [
            'roboto' => [
                'R'  => 'Roboto-Regular.ttf',    // regular font
                'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
                'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
            ],
            'hindsiliguri' => [
                'R'  => 'HindSiliguri-Regular.ttf',    // regular font
                'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
                'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
            ],
            'notosanstamil' => [
                'R'  => 'NotoSansTamil-Regular.ttf',    // regular font - Tamil only
                'useOTL' => 0xFF,    // required for complex scripts like Tamil
                'useKashida' => 75,
                'indic' => true,     // Enable Indic script support
                'RTL' => false,
            ],
            'droidsansfallback' => [
                'R'  => 'DroidSansFallback.ttf',    // comprehensive font - includes English, Tamil, and many other scripts
                'useOTL' => 0xFF,    // required for complex scripts like Tamil
                'useKashida' => 75,
                'RTL' => false,      // Tamil is left-to-right
                'indic' => true,     // Enable Indic script support (Tamil, Hindi, etc)
                'sip' => false,      // Supplementary Ideographic Plane
                'smp' => false,      // Supplementary Multilingual Plane  
            ],
            'varelaround' => [
                'R'  => 'VarelaRound-Regular.ttf',    // regular font
                'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
                'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
            ],
        ]
    ];