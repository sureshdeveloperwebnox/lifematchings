<!DOCTYPE html>
<html>
<head>
  <title>Life Matchings Chart</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style>
  * {
    font-family: droidsansfallback, notosanstamil, Arial, sans-serif !important;
  }
  body {
    font-family: droidsansfallback, notosanstamil, Arial, sans-serif !important;
  }
  .info-value, .info-label, .section-title, .report-title, .report-subtitle, .chart-value {
    font-family: droidsansfallback, notosanstamil, Arial, sans-serif !important;
  }

  .reportContent{
      border: 1px solid black;
      margin-left: -15px;
      padding: 30px;
      margin-top: 50px;
  }
  .report-container {
    background: #fff;
    border: 2px solid #bd099d;
    border-radius: 10px;
    padding: 30px;
    margin: 20px auto;
    max-width: 1000px;
    box-shadow: 0 0 15px rgba(128, 0, 128, 0.1);
  }
  .report-header {
    text-align: center;
    margin-bottom: 30px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 20px;
  }
  .report-title {
    font-size: 28px;
    color: #bd099d;
    font-weight: bold;
    margin-bottom: 10px;
  }
  .report-subtitle {
    color: #6c757d;
    font-size: 16px;
  }
  .info-section {
    margin-bottom: 30px;
    margin-left: 40px;
    page-break-inside: avoid;
  }
  .section-title {
    color: #bd099d;
    font-weight: bold;
    font-size: 18px;
    border-bottom: 1px solid #eee;
    padding-bottom: 8px;
    margin-bottom: 15px;
  }
  .info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
  @media (max-width: 768px) {
    .info-grid {
      grid-template-columns: 1fr;
    }
  }
  .info-item {
    margin-bottom: 15px;
  }
  .info-label {
    font-weight: 600;
    color: #bd099d;
    margin-bottom: 5px;
    font-size: 17px;
  }
  .info-value {
      margin-top: 10px;
    font-size: 16px;
    width: 400px;
    color: #333;
    padding: 10px 20px;
    background-color: #f9f9f9;
    border-radius: 5px;
    /*border-left: 3px solid #800080;*/
    border: 1px solid #D3D3D3;
  }
  .row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
    page-break-inside: avoid;
  }
  .col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
    padding: 0 15px;
    box-sizing: border-box;
    page-break-inside: avoid;
  }
  .chart-wrapper {
    background-color: #fff;
    border: 8px solid #bd099d;
    border-radius: 20px;
    padding: 10px;
    margin: 20px 0;
    page-break-inside: avoid;
  }
  .chart-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    page-break-inside: avoid;
  }
  .chart-table td {
    border: 1px solid #ddd;
    padding: 15px;
    text-align: center;
    vertical-align: middle;
    background-color: #f9f9f9;
    height: 80px;
    width: 25%;
  }
  .chart-value {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    line-height: 1.6;
    display: block;
  }
  .merged-cell {
    background-color: #f3e5f5;
    color: #bd099d;
    font-weight: bold;
    font-size: 24px;
    border: 2px dashed #bd099d;
  }
  .page-break {
    page-break-before: always;
  }
  .chart-title {
    text-align: center;
    font-weight: bold;
    color: #bd099d;
    margin: 15px 0 5px;
    font-size: 18px;
  }
  .recommendations {
    margin-top: 30px;
  }
  .rec-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
  }
  @media (max-width: 768px) {
    .rec-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  @media (max-width: 576px) {
    .rec-grid {
      grid-template-columns: 1fr;
    }
  }
  .footer {
    text-align: center;
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid #eee;
    color: #666;
    font-size: 14px;
  }
  .download-btn {
    background-color: #bd099d;
    color: white;
    padding: 10px 25px;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 20px;
    display: inline-block;
  }
  .download-btn:hover {
    background-color: #6a006a;
  }
  .no-data {
    text-align: center;
    color: #666;
    padding: 40px;
    font-size: 18px;
  }
</style>   
</head>
<body>
  <div class="report-container">
   <div class="report-header">
      <div class="report-title">Life Matchings Chart Report</div>
      <div class="report-subtitle">Prepared exclusively for {{ $member->first_name ?? '' }}</div>
    </div>

    <div class="row">
      <div class="col-md-6">
    <div class="info-section">
      <div class="section-title">Personal Details</div>
          <div class="info-grid" style="grid-template-columns: 1fr;">
        <div class="info-item">
          <div class="info-label">Name</div>
          <div class="info-value">{{ $member->first_name ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Birth Star/Nakshatra</div>
          <div class="info-value">{{ $birth_star_name ?? ($report->birth_star ?? '') }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Life Matchings ID</div>
          <div class="info-value">{{ $report->life_id ?? ($member->code ?? '') }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Birth Rasi/Zodiac Signs</div>
          <div class="info-value">{{ $birth_rasi_name ?? ($report->birth_rasi ?? '') }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Email</div>
          <div class="info-value">{{ $member->email ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Birth Lagnam/Lagna</div>
          <div class="info-value">{{ $birth_lagnam_name ?? ($report->birth_lagnam ?? '') }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Birth Date</div>
          <div class="info-value">
            @if(!empty($member->member->birthday)) 
              {{date('d-m-Y', strtotime($member->member->birthday))}} 
            @else
              
            @endif
          </div>
        </div>
        <div class="info-item">
          <div class="info-label">Current Dasa Bukthi</div>
          <div class="info-value">{{ $report->dasa_bukthi ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Birth Time</div>
          <div class="info-value">{{ $member->astrologies->time_of_birth ?? "" }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Dosham</div>
          <div class="info-value">{{ $report->dosham ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Birth Place</div>
          <div class="info-value">{{ $member->astrologies->city_of_birth ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Parigaram</div>
          <div class="info-value">{{ $report->parigaram ?? '' }}</div>
        </div>
      </div>
    </div>
      </div>
      
        <div class="col-md-6">
          <div class="chart-title">Rasi Chart</div>
          <div class="chart-wrapper">
            <table class="chart-table">
              @php
                $rasiValues = isset($report->rasi) ? json_decode($report->rasi) : array_fill(0, 12, '');
              @endphp
              
              <tr>
                <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $rasiValues[0] ?? '')) !!}</span></td>
                <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $rasiValues[1] ?? '')) !!}</span></td>
                <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $rasiValues[2] ?? '')) !!}</span></td>
                <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $rasiValues[3] ?? '')) !!}</span></td>
              </tr>
              <tr>
                <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $rasiValues[4] ?? '')) !!}</span></td>
                <td colspan="2" rowspan="2" class="merged-cell">Rasi</td>
                <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $rasiValues[5] ?? '')) !!}</span></td>
              </tr>
              <tr>
                <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $rasiValues[6] ?? '')) !!}</span></td>
                <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $rasiValues[7] ?? '')) !!}</span></td>
              </tr>
              <tr>
                <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $rasiValues[8] ?? '')) !!}</span></td>
                <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $rasiValues[9] ?? '')) !!}</span></td>
                <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $rasiValues[10] ?? '')) !!}</span></td>
                <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $rasiValues[11] ?? '')) !!}</span></td>
              </tr>
            </table>
          </div>
          </div>
        </div>
        
    <div class="info-section">
      <div class="section-title">Navamsa Chart</div>
      <div class="chart-wrapper" style="max-width: 600px; margin: 20px auto;">
            <table class="chart-table">
              @php
                $navamsaValues = isset($report->navamsa) ? json_decode($report->navamsa) : array_fill(0, 12, '');
              @endphp
              
              <tr>
            <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $navamsaValues[0] ?? '')) !!}</span></td>
            <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $navamsaValues[1] ?? '')) !!}</span></td>
            <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $navamsaValues[2] ?? '')) !!}</span></td>
            <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $navamsaValues[3] ?? '')) !!}</span></td>
              </tr>
              <tr>
            <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $navamsaValues[4] ?? '')) !!}</span></td>
                <td colspan="2" rowspan="2" class="merged-cell">Navamsa</td>
            <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $navamsaValues[5] ?? '')) !!}</span></td>
              </tr>
              <tr>
            <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $navamsaValues[6] ?? '')) !!}</span></td>
            <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $navamsaValues[7] ?? '')) !!}</span></td>
              </tr>
              <tr>
            <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $navamsaValues[8] ?? '')) !!}</span></td>
            <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $navamsaValues[9] ?? '')) !!}</span></td>
            <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $navamsaValues[10] ?? '')) !!}</span></td>
            <td><span class="chart-value">{!! nl2br(str_replace(',', "\n", $navamsaValues[11] ?? '')) !!}</span></td>
              </tr>
            </table>
      </div>
    </div>

     <!--Recommendations Section -->
    <div class="info-section recommenations">
      <div class="section-title">Recommendations</div>
      <div class="info-grid">
        <div class="info-item">
          <div class="info-label">Recommended Stars</div>
          <div class="info-value">{{ $report->rec_stars ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Recommended Rasi Signs</div>
          <div class="info-value">{{ $report->rec_rasi ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Recommended Lagnam/Lagna</div>
          <div class="info-value">{{ $report->rec_lagnams ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Dosham</div>
          <div class="info-value">{{ $report->rec_dosham ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Direction of the Bride/Groom</div>
          <div class="info-value">{{ $report->direction ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Local or Abroad</div>
          <div class="info-value">{{ $report->location ?? '' }}</div>
        </div>
      </div>
    </div>

    {{-- <div class="text-center">
     <a class="btn btn-sm btn-primary" href="{{ asset('storage/app/public/astrology_reports/' . $report->pdfName) }}" download>Download PDF</a>
    </div> --}}


    <div class="footer">
      L M Royal Matrimony Services Private Limited<br>
      www.lifematchings.com | info@lifematchings.com | +91 9384814536<br>
      Report generated on {{ date('d-m-Y') }}
    </div>
  </div>
</body>
</html>
