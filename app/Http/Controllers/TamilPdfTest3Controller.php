<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TamilPdfTest3Controller extends Controller
{
    public function generateTamilPdf()
    {
        try {
            // Use mPDF with minimal config - let it handle Tamil automatically
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
            ]);

            // Tamil text
            $tamilText = 'வணக்கம் உலகம்! இது ஒரு தமிழ் PDF.';
            
            // Minimal HTML - let mPDF auto-detect and handle Tamil
            $html = '<html><body style="font-family: sans-serif; padding: 30px;">
                <h1 style="color: #bd099d; text-align: center;">தமிழ் PDF சோதனை</h1>
                <div style="font-size: 20px; padding: 20px; background: #f9f9f9; border: 1px solid #ddd; margin: 20px 0; text-align: center;">' 
                . $tamilText . 
                '</div>
                <p style="text-align: center; color: #666;">Generated: ' . date('d-m-Y H:i:s') . '</p>
                </body></html>';

            $mpdf->WriteHTML($html);
            
            return $mpdf->Output('tamil_test_' . time() . '.pdf', 'D');
            
        } catch (\Exception $e) {
            \Log::error('mPDF Tamil Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

