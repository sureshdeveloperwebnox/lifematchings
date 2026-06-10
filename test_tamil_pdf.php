<?php
require __DIR__.'/vendor/autoload.php';

use Mpdf\Mpdf;

try {
    // Load config
    $config = require __DIR__.'/config/pdf.php';
    
    echo "Testing Tamil PDF Generation...\n";
    echo "Font file exists: " . (file_exists(__DIR__.'/public/assets/fonts/DroidSansFallback.ttf') ? 'YES' : 'NO') . "\n";
    
    // Create mPDF with Tamil support
    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'tempDir' => __DIR__.'/temp/',
        'fontDir' => [__DIR__.'/public/assets/fonts/'],
        'fontdata' => $config['font_data'] ?? [],
        'default_font' => 'droidsansfallback',
        'autoScriptToLang' => true,
        'autoLangToFont' => true,
    ]);
    
    $html = '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <style>
            body { font-family: droidsansfallback, sans-serif; }
            .test { font-size: 20px; margin: 20px; }
        </style>
    </head>
    <body>
        <div class="test">
            <h1>Tamil Text Test</h1>
            <p>English: Hello World</p>
            <p>Tamil: வணக்கம் உலகம்</p>
            <p>Birth Star: பூரம்</p>
            <p>Rasi: சிம்மம்</p>
            <p>Lagnam: மகரம்</p>
        </div>
    </body>
    </html>';
    
    $mpdf->WriteHTML($html);
    
    $testFile = __DIR__.'/storage/app/public/tamil_test_'.time().'.pdf';
    file_put_contents($testFile, $mpdf->Output('', 'S'));
    
    echo "✓ PDF generated successfully: $testFile\n";
    echo "File size: " . filesize($testFile) . " bytes\n";
    echo "\nPlease download and check the PDF to verify Tamil characters display correctly.\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
