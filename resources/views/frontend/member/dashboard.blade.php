@extends('frontend.layouts.member_panel')
@section('panel_content')
    @php
        $user = Auth::user();
        $col  = 3;
        $profile_picture_privacy = get_setting('profile_picture_privacy');
        $gallery_image_privacy = get_setting('gallery_image_privacy');
        if($profile_picture_privacy == 'only_me'){
            $col++;
        }
        elseif($gallery_image_privacy == 'only_me') {
            $col++;
        }
    @endphp
    <div class="row gutters-5 mt-4 row-cols-xl-{{ $col }} row-cols-2">
        <div class="col mx-auto mb-3" >
            <div class="bg-light rounded overflow-hidden text-center p-3">
                <i class="la la-heart-o la-2x mb-3 text-primary-grad"></i>
                <div class="h4 fw-700 text-primary-grad">{{ get_remaining_package_value($user->id,'remaining_interest') }}</div>
                <div class="opacity-50">{{ translate('Remaining') }} <br> {{ translate('Interest') }}</div>
            </div>
        </div>
        <div class="col mx-auto mb-3" >
            <div class="bg-light rounded overflow-hidden text-center p-3">
                <i class="las la-phone la-2x mb-3 text-primary-grad"></i>
                <div class="h4 fw-700 text-primary-grad">{{ get_remaining_package_value($user->id,'remaining_contact_view') }}</div>
                <div class="opacity-50 ">{{ translate('Remaining') }} <br> {{ translate('Contact View') }}</div>
            </div>
        </div>
        <div class="col mx-auto mb-3" >
            <div class="bg-light rounded overflow-hidden text-center p-3">
                <i class="las la-phone la-2x mb-3 text-primary-grad"></i>
                <div class="h4 fw-700 text-primary-grad">{{ get_remaining_package_value($user->id,'remaining_profile_viewer_view') }}</div>
                <div class="opacity-50 ">{{ translate('Remaining') }} <br> {{ translate('Profile Viewer View') }}</div>
            </div>
        </div>
        <div class="col mx-auto mb-3" >
            <div class="bg-light rounded overflow-hidden text-center p-3">
                <i class="las la-image la-2x mb-3 text-primary-grad"></i>
                <div class="h4 fw-700 text-center text-primary-grad">{{ get_remaining_package_value($user->id,'remaining_photo_gallery') }}</div>
                <div class="opacity-50 text-center">{{ translate('Remaining') }} <br> {{ translate('Gallery Image Upload') }}</div>
            </div>
        </div>
        @if($profile_picture_privacy == 'only_me')
        <div class="col mx-auto mb-3" >
            <div class="bg-light rounded overflow-hidden text-center p-3">
                <i class="las la-user-circle la-2x mb-3 text-primary-grad"></i>
                <div class="h4 fw-700 text-primary-grad">{{ get_remaining_package_value($user->id,'remaining_profile_image_view') }}</div>
                <div class="opacity-50 ">{{ translate('Remaining') }} <br> {{ translate('Profile Picture View') }}</div>
            </div>
        </div>
        @endif
        @if($gallery_image_privacy == 'only_me')
        <div class="col mx-auto mb-3" >
            <div class="bg-light rounded overflow-hidden text-center p-3">
                <i class="las la-images la-2x mb-3 text-primary-grad"></i>
                <div class="h4 fw-700 text-center text-primary-grad">{{ get_remaining_package_value($user->id,'remaining_gallery_image_view') }}</div>
                <div class="opacity-50 text-center">{{ translate('Remaining') }} <br> {{ translate('Gallery Images View') }}</div>
            </div>
        </div>
        @endif
    </div>
    
    

    <div class="row gutters-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="fs-16 mb-0">{{  translate('Current package') }}</h2>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4 mt-3">
                        <img class="mw-100 mx-auto mb-4" src="{{ uploaded_asset($user->member->package->image) }}" height="130">
                        <h5 class="mb-3 h5 fw-600">{{$user->member->package->name}}</h5>
                    </div>
                    <ul class="list-group list-group-raw fs-15 mb-4 pb-4 border-bottom">
                        <li class="list-group-item py-2">
                            <i class="las la-check text-success mr-2"></i>
                            {{ $user->member->package->express_interest }} {{ translate('Express Interests') }}
                        </li>
                        <li class="list-group-item py-2">
                            <i class="las la-check text-success mr-2"></i>
                            {{ $user->member->package->photo_gallery }} {{ translate('Gallery Photo Upload') }}
                        </li>
                        <li class="list-group-item py-2">
                            <i class="las la-check text-success mr-2"></i>
                            {{ $user->member->package->contact }} {{ translate('Contact Info View') }}
                        </li>
                        <li class="list-group-item py-2">
                            <i class="las la-check text-success mr-2"></i>
                            {{ $user->member->package->profile_viewers_view }} {{ translate('Profile Viewer View') }}
                        </li>
                        @if($profile_picture_privacy == 'only_me')
                            <li class="list-group-item py-2">
                                <i class="las la-check text-success mr-2"></i>
                                {{ $user->member->package->profile_image_view }} {{ translate('Profile Image View') }}
                            </li>
                        @endif
                        @if($gallery_image_privacy == 'only_me')
                            <li class="list-group-item py-2">
                                <i class="las la-check text-success mr-2"></i>
                                {{ $user->member->package->gallery_image_view }} {{ translate('Gallery Image View') }}
                            </li>
                        @endif
                        <li class="list-group-item py-2 text-line-through">
                            @if( $user->member->package->auto_profile_match == 0 )
                                <i class="las la-times text-danger mr-2"></i>
                                <del class="opacity-60">{{ translate('Show Auto Profile Match') }}</del>
                            @else
                                <i class="las la-check text-success mr-2"></i>
                                {{ translate('Show Auto Profile Match') }}
                            @endif
                        </li>
                    </ul>
                    <h4 class="fs-18 mb-3">
                      {{ translate('Package expiry date') }}:
                      @if(package_validity($user->id))
                        {{ $user->member->package_validity }}
                      @else
                          <span class="text-danger">{{translate('Expired')}}</span>
                      @endif
                    </h4>
                    <a href="{{ route('packages') }}" class="btn btn-success d-inline-block">{{ translate('Upgrade Package') }}</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if(get_setting('member_verification'))
                <div class="card mb-0 p-5 h-20 d-flex align-items-center justify-content-center mb-2">
                    @if ($user->approved == 0)
                        <div class="my-n4 py-1 text-center">
                            <p class="text-center t-17px ">Aadhaar card needs to be used for verification</p>
                            <img style="margin-left: 120px;" src="{{ static_asset('assets/img/non_verified.png') }}" alt=""
                                class="w-xxl-130px w-90px d-block">
                            <a href="{{ route('member.verification') }}"
                                class="btn btn-sm btn-primary">{{ translate('Verify Now') }}</a>
                        </div>
                    @else
                        <div class="my-2 py-1">
                            <img style="width: 400px; text-center" src="{{ static_asset('assets/img/verified-green-button-with-icon-transparent-template-sticker.png') }}" alt="" width="">
                        </div>
                    @endif
                </div>
            @endif
            
            <div class="card">
                <div class="card-header">
                    <h2 class="fs-16 mb-0">{{  translate('Matched profile') }}</h2>
                </div>
                <div class="card-body">
                    @if(Auth::user()->member->auto_profile_match == 1)
                    <div>
                        @forelse ($similar_profiles->shuffle()->take(5) as $similar_profile)
                          @if($similar_profile->user != null)
                            <a href="{{ route('member_profile', $similar_profile->match_id) }}" class="text-reset border rounded row no-gutters align-items-center mb-3">
                                <div class="col-auto w-100px">
                                  @php
                                      $avatar_image = $similar_profile->user->member->gender == 1 ? 'assets/img/avatar-place.png' : 'assets/img/female-avatar-place.png';
                                      $profile_picture_show = show_profile_picture($similar_profile->user);
                                  @endphp
                                  <img
                                      @if ($profile_picture_show)
                                      src="{{ uploaded_asset($similar_profile->user->photo) }}"
                                      @else
                                      src="{{ static_asset($avatar_image) }}"
                                      @endif
                                      onerror="this.onerror=null;this.src='{{ static_asset($avatar_image) }}';"
                                      class="img-fit w-100 size-100px"
                                  >
                                </div>
                                <div class="col">
                                  <div class="p-3">
                                      <h5 class="fs-16 text-body text-truncate">{{ $similar_profile->user->first_name.' '.$similar_profile->user->last_name }}</h5>
                                      <div class="fs-12 text-truncate-3">
                                          <span class="mr-1 d-inline-block">
                                            @if(!empty($similar_profile->user->member->birthday))
                                              {{ \Carbon\Carbon::parse($similar_profile->user->member->birthday)->age }} {{ translate('yrs') }},
                                            @endif
                                          </span>
                                          <span class="mr-1 d-inline-block">
                                            @if(!empty($similar_profile->user->physical_attributes->height))
                                              {{ $similar_profile->user->physical_attributes->height }} {{ translate('Feet') }},
                                            @endif
                                          </span>
                                          <span class="mr-1 d-inline-block">
                                            @if(!empty($similar_profile->user->member->marital_status->name))
                                              {{ $similar_profile->user->member->marital_status->name }},
                                            @endif
                                          </span>
                                          <span class="mr-1 d-inline-block">
                                            {{ !empty($similar_profile->user->spiritual_backgrounds->religion->name) ? $similar_profile->user->spiritual_backgrounds->religion->name.', ' : "" }}
                                          </span>
                                          <span class="mr-1 d-inline-block">
                                            {{ !empty($similar_profile->user->spiritual_backgrounds->caste->name) ? $similar_profile->user->spiritual_backgrounds->caste->name.', ' : "" }}
                                          </span>
                                          <span class="mr-1 d-inline-block">
                                            <td class="py-1">{{ !empty($similar_profile->user->spiritual_backgrounds->sub_caste->name) ? $similar_profile->user->spiritual_backgrounds->sub_caste->name : "" }}</td>
                                          </span>
                                      </div>
                                  </div>
                                </div>
                            </a>
                          @endif
                        @empty
                            <div class="alert alert-info">{{  translate('Update your partner expectation for auto match making') }}</div>
                        @endforelse
                    </div>
                    @else
                        <div class="alert alert-info">{{  translate('Upgrade your package for auto match making') }}</div>
                    @endif
                </div>
                
                
            </div>
        </div>
        
<style>

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
  .chart-wrapper {
    background-color: #fff;
    border: 8px solid #bd099d;
    border-radius: 20px;
    padding: 10px;
    margin: 20px 0;
  }
  .chart-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 5px;
  }
  .chart-box {
    border: 1px solid #ddd;
    height: 80px;
    position: relative;
    background-color: #f9f9f9;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }
  .chart-value {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    line-height: 1.6;
    display: block;
    white-space: pre-line;
  }
  .merged-box {
    grid-column: 2 / span 2;
    grid-row: 2 / span 2;
    background-color: #f3e5f5;
    color: #bd099d;
    font-weight: bold;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    border: 2px dashed #bd099d;
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
                

<div class="reportContent">
  @if($report)
    <div class="report-header">
      <div class="report-title">Life Matchings Chart Report</div>
      <div class="report-subtitle">Prepared exclusively for {{ $member->first_name ?? '' }}</div>
    </div>

    <div class="info-section">
      <div class="section-title">Personal Details</div>
      <div class="info-grid">
        <div class="info-item">
          <div class="info-label">Name</div>
          <div class="info-value">{{ $member->first_name ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Birth Star/Nakshatra</div>
          <div class="info-value">{{ $report->birth_star ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Life Matchings ID</div>
          <div class="info-value">{{ $report->life_id ?? ($member->code ?? '') }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Birth Rasi/Zodiac Sign</div>
          <div class="info-value">{{ $report->birth_rasi ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Email</div>
          <div class="info-value">{{ $member->email ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Birth Lagnam/Lagna</div>
          <div class="info-value">{{ $report->birth_lagnam ?? '' }}</div>
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

    <div class="info-section">
      <div class="section-title">Astrological Charts</div>
      
      <div class="row">
        <div class="col-md-6">
          <div class="chart-title">Rasi Chart</div>
          <div class="chart-wrapper">
            <div class="chart-grid">
              @php
                $rasiValues = isset($report->rasi) ? json_decode($report->rasi) : array_fill(0, 12, '');
              @endphp
              @for($i = 0; $i < 12; $i++)
                @if($i < 5)
                  <div class="chart-box"><span class="chart-value">{{ str_replace(',', "\n", $rasiValues[$i] ?? '') }}</span></div>
                @elseif($i == 5)
                  <div class="merged-box">Rasi</div>
                  <div class="chart-box"><span class="chart-value">{{ str_replace(',', "\n", $rasiValues[$i] ?? '') }}</span></div>
                @else
                  <div class="chart-box"><span class="chart-value">{{ str_replace(',', "\n", $rasiValues[$i] ?? '') }}</span></div>
                @endif
              @endfor
            </div>
          </div>
        </div>
        
        <div class="col-md-6">
          <div class="chart-title">Navamsa Chart</div>
          <div class="chart-wrapper">
            <div class="chart-grid">
              @php
                $navamsaValues = isset($report->navamsa) ? json_decode($report->navamsa) : array_fill(0, 12, '');
              @endphp
              @for($i = 0; $i < 12; $i++)
                @if($i < 5)
                  <div class="chart-box"><span class="chart-value">{{ str_replace(',', "\n", $navamsaValues[$i] ?? '') }}</span></div>
                @elseif($i == 5)
                  <div class="merged-box">Navamsa</div>
                  <div class="chart-box"><span class="chart-value">{{ str_replace(',', "\n", $navamsaValues[$i] ?? '') }}</span></div>
                @else
                  <div class="chart-box"><span class="chart-value">{{ str_replace(',', "\n", $navamsaValues[$i] ?? '') }}</span></div>
                @endif
              @endfor
            </div>
          </div>
        </div>
      </div>
    </div>

     <!--Recommendations Section -->
    <div class="info-section recommenations">
      <div class="section-title">Recommendations</div>
      <div class="info-grid"></div>
        <div class="info-item">
          <div class="info-label">Recommended Star/Nakshatra</div>
          <div class="info-value">{{ $report->rec_stars ?? '' }}</div>
        </div>
        <div class="info-item">
          <div class="info-label">Recommended Rasi/Zodiac Signs</div>
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

    <div class="text-center">
    <a class="btn btn-sm btn-primary" href="{{ asset('storage/app/public/astrology_reports/' . $report->pdfName) }}" download>Download PDF</a>
  </div>


    <div class="footer">
      L M Royal Matrimony Services Private Limited<br>
      www.lifematchings.com | info@lifematchings.com | +91 9384814536<br>
      Report generated on {{ date('d-m-Y') }}
    </div>
  @else
    <div class="no-data">
      <i class="fas fa-chart-pie fa-3x mb-3" style="color: #800080;"></i>
      <p>Your Life Matchings Chart is not yet prepared.</p>
      <p>Please check back later or contact our support team.</p>
    </div>
  @endif
</div>
        
       
</div>


<script>
  function previewImage(input) {
    const file = input.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const box = input.parentElement;
        let img = box.querySelector('img');
        if (!img) {
          img = document.createElement('img');
          box.appendChild(img);
        }
        img.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  }

  // 👇 Function to toggle blur condition
  function toggleFormVisibility(blurred) {
    const form = document.getElementById('formContainer');
    if (form) {
      if (blurred) {
        form.classList.add('blurred');
      } else {
        form.classList.remove('blurred');
      }
    }
  }

//   Example usage:
//   toggleFormVisibility(true);  // To blur
  toggleFormVisibility(false); // To show
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
  function generatePDF() {
    // Show loading state
    const btn = document.getElementById('downloadBtn');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating PDF...';
    btn.disabled = true;

    // PDF options
    const element = document.getElementById('reportContent');
    const opt = {
      margin: 10,
      filename: 'Life_Matchings_Chart_'+new Date().toISOString().slice(0,10)+'.pdf',
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: { scale: 2, logging: true, useCORS: true },
      jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    // Generate PDF
    html2pdf().set(opt).from(element).save()
      .then(() => {
        btn.innerHTML = '<i class="fas fa-download"></i> Download PDF';
        btn.disabled = false;
      })
      .catch(() => {
        btn.innerHTML = '<i class="fas fa-download"></i> Try Again';
        btn.disabled = false;
      });
  }
</script>
@endsection
