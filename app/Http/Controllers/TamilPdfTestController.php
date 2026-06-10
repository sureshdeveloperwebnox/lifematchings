<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TamilPdfTestController extends Controller
{
    public function generateTamilPdf()
    {
        try {
            // Create mPDF instance directly with NotoSansTamil font
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'default_font' => 'freeserif',
                'tempDir' => base_path('temp/'),
            ]);

            // Tamil text
            $tamilText = 'வணக்கம் உலகம்! இது ஒரு தமிழ் PDF.';
            
            // Simple HTML - mPDF will auto-detect Tamil and use appropriate font
            $html = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <style>
                    body { font-size: 18px; padding: 30px; }
                    h1 { color: #bd099d; font-size: 24px; text-align: center; }
                    .message { font-size: 20px; padding: 20px; background: #f9f9f9; border: 1px solid #ddd; margin: 20px 0; text-align: center; }
                </style>
            </head>
            <body>
                <h1>தமிழ் PDF சோதனை</h1>
                <div class="message">' . $tamilText . '</div>
                <p style="text-align: center; color: #666;">Generated: ' . date('d-m-Y H:i:s') . '</p>
            </body>
            </html>';

            $mpdf->WriteHTML($html);
            
            return $mpdf->Output('tamil_test_' . time() . '.pdf', 'D');
            
        } catch (\Exception $e) {
            \Log::error('Direct mPDF Tamil Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

