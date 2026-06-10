@extends('admin.layouts.app')
@section('content')

<style>
  .main-box {
    background: #fff;
    border: 2px solid #ccc;
    border-radius: 10px;
    padding: 30px;
    margin: 20px auto;
    max-width: 1000px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }
  .section-title {
    text-align: center;
    font-size: 28px;
    color: #800080;
    font-weight: bold;
    margin-bottom: 20px;
  }
  label {
    font-weight: 500;
    color: #6c757d;
    margin-bottom: 5px;
    display: block;
  }
  .chart-wrapper {
    background-color: #fff;
    border: 8px solid #800080;
    border-radius: 20px;
    padding: 10px;
    margin-top: 20px;
  }
  .chart-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 5px;
  }
  .chart-box {
    border: 1px solid #ccc;
    height: 80px;
    position: relative;
    background-color: #f9f9f9;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }
  .chart-box input[type="text"] {
    width: 100%;
    height: 100%;
    border: none;
    text-align: center;
    background: transparent;
    font-size: 14px;
    padding: 5px;
  }
  .chart-title {
    text-align: center;
    font-weight: bold;
    color: #800080;
    margin-top: 10px;
  }
  .merged-box {
    grid-column: 2 / span 2;
    grid-row: 2 / span 2;
    background-color: #f3e5f5;
    color: #800080;
    font-weight: bold;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    border: 2px dashed #800080;
  }
  .footer-note {
    text-align: center;
    font-size: 14px;
    margin-top: 30px;
    color: #555;
  }
  .form-actions {
    display: flex;
    justify-content: center;
    margin-top: 30px;
    gap: 15px;
  }
  .btn-submit {
    background-color: #800080;
    color: white;
    padding: 10px 25px;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
  }
  .btn-submit:hover {
    background-color: #6a006a;
  }
  @media (max-width: 576px) {
    .chart-box {
      height: 60px;
    }
    .form-actions {
      flex-direction: column;
    }
  }

  /* Blur effect */
  .blurred {
    filter: blur(5px);
    pointer-events: none;
    user-select: none;
  }
</style>        

<form id="lifeMatchingForm" method="POST" action="{{ route('storeAstrologyReport') }}">
  @csrf
  <div id="formContainer" class="container main-box">
    <div class="section-title">Life Matchings Chart</div>

    <div class="row g-3">
      <div class="col-md-6">
        <label>Name</label>
        <input type="hidden" class="form-control" name="memberId" value="{{ $memberId }}"  >
        <input type="text" class="form-control" name="name" value="{{ $member->first_name ?? '' }}"  disabled>
      </div>
      

      <div class="col-md-6">
        <label>Life Matchings ID</label>
        <input type="text" class="form-control" name="life_id" value="{{ $report->life_id ?? ($member->code ?? '') }}"  disabled>
      </div>
      <div class="col-md-6">
        <label>Birth Rasi/Zodiac Sign</label>
        <select name="birth_rasi" id="birth_rasi" class="form-control aiz-selectpicker" data-live-search="true">
          <option value="">{{translate('Select Rasi/Zodiac Sign')}}</option>
          @php
            $selected_sun_sign_id = null;
            if(isset($report->birth_rasi) && $report->birth_rasi) {
              if(is_numeric($report->birth_rasi)) {
                $selected_sun_sign_id = $report->birth_rasi;
              } else {
                $selected_sun = \App\Models\SunSign::where('name', $report->birth_rasi)->first();
                $selected_sun_sign_id = $selected_sun ? $selected_sun->id : null;
              }
            } elseif(isset($astrologies) && $astrologies && $astrologies->sun_sign_id) {
              $selected_sun_sign_id = $astrologies->sun_sign_id;
            } elseif(isset($astrologies) && $astrologies && $astrologies->sun_sign) {
              if(is_numeric($astrologies->sun_sign)) {
                $selected_sun_sign_id = $astrologies->sun_sign;
              } else {
                $selected_sun = \App\Models\SunSign::where('name', $astrologies->sun_sign)->first();
                $selected_sun_sign_id = $selected_sun ? $selected_sun->id : null;
              }
            }
          @endphp
          @foreach($sun_signs as $sun_sign)
            <option value="{{ $sun_sign->id }}" {{ $selected_sun_sign_id == $sun_sign->id ? 'selected' : '' }}>
              {{ $sun_sign->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label>Birth Star/Nakshatra</label>
        <select name="birth_star" id="birth_star" class="form-control aiz-selectpicker" data-live-search="true">
          <option value="">{{translate('Select Star/Nakshatra')}}</option>
          @php
            $selected_moon_sign_id = null;
            if(isset($report->moon_sign) && $report->moon_sign) {
              if(is_numeric($report->moon_sign)) {
                $selected_moon_sign_id = $report->moon_sign;
              } else {
                $selected_moon_sign_obj = \App\Models\MoonSign::where('name', $report->moon_sign)->first();
                $selected_moon_sign_id = $selected_moon_sign_obj ? $selected_moon_sign_obj->id : null;
              }
            } elseif(isset($astrologies) && $astrologies && $astrologies->moon_sign_id) {
              $selected_moon_sign_id = $astrologies->moon_sign_id;
            } elseif(isset($astrologies) && $astrologies && $astrologies->moon_sign) {
              if(is_numeric($astrologies->moon_sign)) {
                $selected_moon_sign_id = $astrologies->moon_sign;
              } else {
                $selected_moon_sign_obj = \App\Models\MoonSign::where('name', $astrologies->moon_sign)->first();
                $selected_moon_sign_id = $selected_moon_sign_obj ? $selected_moon_sign_obj->id : null;
              }
            }
            $selected_sun_sign_id_for_moon = null;
            if(isset($report->birth_rasi) && $report->birth_rasi) {
              if(is_numeric($report->birth_rasi)) {
                $selected_sun_sign_id_for_moon = $report->birth_rasi;
              } else {
                $selected_sun_for_moon = \App\Models\SunSign::where('name', $report->birth_rasi)->first();
                $selected_sun_sign_id_for_moon = $selected_sun_for_moon ? $selected_sun_for_moon->id : null;
              }
            } elseif(isset($astrologies) && $astrologies && $astrologies->sun_sign_id) {
              $selected_sun_sign_id_for_moon = $astrologies->sun_sign_id;
            } elseif(isset($astrologies) && $astrologies && $astrologies->sun_sign) {
              if(is_numeric($astrologies->sun_sign)) {
                $selected_sun_sign_id_for_moon = $astrologies->sun_sign;
              } else {
                $selected_sun_for_moon = \App\Models\SunSign::where('name', $astrologies->sun_sign)->first();
                $selected_sun_sign_id_for_moon = $selected_sun_for_moon ? $selected_sun_for_moon->id : null;
              }
            }
          @endphp
          @if($selected_sun_sign_id_for_moon)
            @php
              $selected_sun_obj = \App\Models\SunSign::find($selected_sun_sign_id_for_moon);
              $mapped_moon_sign_ids = $selected_sun_obj->moon_sign_ids ?? [];
            @endphp
            @foreach($moon_signs as $moon_sign)
              @if(in_array($moon_sign->id, $mapped_moon_sign_ids))
                <option value="{{ $moon_sign->id }}" {{ $selected_moon_sign_id == $moon_sign->id ? 'selected' : '' }}>
                  {{ $moon_sign->name }}
                </option>
              @endif
            @endforeach
          @endif
        </select>
      </div>

      <div class="col-md-6">
        <label>Birth Lagnam/Lagna</label>
        <select name="birth_lagnam" id="birth_lagnam" class="form-control aiz-selectpicker" data-live-search="true">
          <option value="">{{translate('Select Lagnam/Lagna')}}</option>
          @php
            $selected_lagnam_id = null;
            if(isset($report->birth_lagnam) && $report->birth_lagnam) {
              if(is_numeric($report->birth_lagnam)) {
                $selected_lagnam_id = $report->birth_lagnam;
              } else {
                $selected_lagnam_obj = \App\Models\SunSign::where('name', $report->birth_lagnam)->first();
                $selected_lagnam_id = $selected_lagnam_obj ? $selected_lagnam_obj->id : null;
              }
            } elseif(isset($astrologies) && $astrologies && $astrologies->lagnam_id) {
              $selected_lagnam_id = $astrologies->lagnam_id;
            } elseif(isset($astrologies) && $astrologies && $astrologies->lagnam) {
              if(is_numeric($astrologies->lagnam)) {
                $selected_lagnam_id = $astrologies->lagnam;
              } else {
                $selected_lagnam_obj = \App\Models\SunSign::where('name', $astrologies->lagnam)->first();
                $selected_lagnam_id = $selected_lagnam_obj ? $selected_lagnam_obj->id : null;
              }
            }
          @endphp
          @foreach($sun_signs as $sun_sign)
            <option value="{{ $sun_sign->id }}" {{ $selected_lagnam_id == $sun_sign->id ? 'selected' : '' }}>
              {{ $sun_sign->name }}
            </option>
          @endforeach
        </select>
      </div>
      
      <div class="col-md-6">
        <label>Email ID</label>
        <input type="email" class="form-control" name="email" value="{{ $member->email ?? '' }}"  disabled>
      </div>
      

      <div class="col-md-6">
        <label>Birth Date</label>
        <input type="text" class="aiz-date-range form-control" name="date_of_birth" 
               value="@if(!empty($member->member->birthday)) {{date('Y-m-d', strtotime($member->member->birthday))}} @endif" 
               placeholder="Select Date" data-single="true" data-show-dropdown="true" 
               data-max-date="{{ get_max_date() }}" autocomplete="off"  disabled> 
      </div>
      <div class="col-md-6">
        <label>Current Dasa Bukthi</label>
        <input type="text" class="form-control" name="dasa_bukthi" value="{{ $report->dasa_bukthi ?? "" }}" >
      </div>

      <div class="col-md-6">
        <label>Birth Time</label>
        <input type="time" class="form-control" name="birth_time" value="{{ $member->astrologies->time_of_birth ?? "" }}" disabled>
      </div>
      <div class="col-md-6">
        <label>Dosham</label>
        <input type="text" class="form-control" name="dosham" value="{{ $report->dosham ?? ""}}" >
      </div>

      <div class="col-md-6">
        <label>Birth Place</label>
        <input type="text" class="form-control" name="birth_place" value="{{ $member->astrologies->city_of_birth ?? '' }}"  disabled>
      </div>
      <div class="col-md-6">
        <label>Parigaram</label>
        <input type="text" class="form-control" name="parigaram" value="{{ $report->parigaram ?? "" }}" >
      </div>
    </div>

    <!-- Charts -->
    <div class="row mt-4">
      <div class="col-md-6">
        <div class="chart-wrapper">
          <div class="chart-grid">
            <!-- 12 Rasi Text Boxes -->
            @php
              $rasiValues = isset($report->rasi) ? json_decode($report->rasi) : ['','','','','','','','','','','',''];
            @endphp
            @for($i = 0; $i < 12; $i++)
              @if($i < 5)
                <div class="chart-box"><input type="text" name="rasi[]" value="{{ $rasiValues[$i] ?? '' }}" ></div>
              @elseif($i == 5)
                <div class="merged-box">Rasi</div>
                <div class="chart-box"><input type="text" name="rasi[]" value="{{ $rasiValues[$i] ?? '' }}" ></div>
              @else
                <div class="chart-box"><input type="text" name="rasi[]" value="{{ $rasiValues[$i] ?? '' }}" ></div>
              @endif
            @endfor
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="chart-wrapper">
          <div class="chart-grid">
            <!-- 12 Navamsa Text Boxes -->
            @php
              $navamsaValues = isset($report->navamsa) ? json_decode($report->navamsa) : ['','','','','','','','','','','',''];
            @endphp
            @for($i = 0; $i < 12; $i++)
              @if($i < 5)
                <div class="chart-box"><input type="text" name="navamsa[]" value="{{ $navamsaValues[$i] ?? '' }}" ></div>
              @elseif($i == 5)
                <div class="merged-box">Navamsa</div>
                <div class="chart-box"><input type="text" name="navamsa[]" value="{{ $navamsaValues[$i] ?? '' }}" ></div>
              @else
                <div class="chart-box"><input type="text" name="navamsa[]" value="{{ $navamsaValues[$i] ?? '' }}" ></div>
              @endif
            @endfor
          </div>
        </div>
      </div>
    </div>

    <!-- Recommendations -->
    <div class="row g-3 mt-4">
      <div class="col-md-4">
        <label>Recommended Star/Nakshatra</label>
        <input type="text" class="form-control" name="rec_stars" value="{{ $report->rec_stars ?? "" }}" >
      </div>
      <div class="col-md-4">
        <label>Recommended Rasi/Zodiac Sign</label>
        <input type="text" class="form-control" name="rec_rasi" value="{{ $report->rec_rasi ?? "" }}" >
      </div>
      <div class="col-md-4">
        <label>Recommended Lagnams</label>
        <input type="text" class="form-control" name="rec_lagnams" value="{{ $report->rec_lagnams ?? "" }}" >
      </div>

      <div class="col-md-4">
        <label>Dosham</label>
        <input type="text" class="form-control" name="rec_dosham" value="{{ $report->rec_dosham ?? "" }}" >
      </div>
      <div class="col-md-4">
        <label>Direction of the Bride/Groom</label>
        <input type="text" class="form-control" name="direction" value="{{ $report->direction ?? "" }}" >
      </div>
      <div class="col-md-4">
        <label>Local or Abroad</label>
        <input type="text" class="form-control" name="location" value="{{ $report->location ?? "" }}" >
      </div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-submit">Submit Chart</button>
      <button type="button" class="btn-submit" onclick="resetForm()">Reset Form</button>
    </div>

    <div class="footer-note">
      L M Royal Matrimony Services Private Limited<br>
      www.lifematchings.com | info@lifematchings.com | +91 9384814536
    </div>
  </div>
</form>
        
<script>
  // Function to toggle blur condition
  function toggleFormVisibility(blurred) {
    const form = document.getElementById('formContainer');
    if (blurred) {
      form.classList.add('blurred');
    } else {
      form.classList.remove('blurred');
    }
  }

  // Function to reset the form
  function resetForm() {
    document.getElementById('lifeMatchingForm').reset();
  }

  // Form submission handling
  document.getElementById('lifeMatchingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // You can add form validation here if needed
    
    // Submit the form via AJAX or standard form submission
    this.submit();
  });

  // Initialize with form visible
  toggleFormVisibility(false);
</script>

<script type="text/javascript">
(function() {
    'use strict';
    
    // Wait for jQuery to be available
    function initAstronomicDropdowns() {
        if (typeof jQuery === 'undefined') {
            setTimeout(initAstronomicDropdowns, 100);
            return;
        }
        
        var $ = jQuery;
        
        $(document).ready(function() {
            var sunSignSelect = $('#birth_rasi');
            var moonSignSelect = $('#birth_star');
            var lagnamSelect = $('#birth_lagnam');
            
            // Get selected moon sign ID for preserving selection
            var selectedMoonSignId = null;
            @php
              $selectedMoonSignId = null;
              if(isset($report->birth_star) && $report->birth_star) {
                if(is_numeric($report->birth_star)) {
                  $selectedMoonSignId = $report->birth_star;
                } else {
                  $selectedMoonSignObj = \App\Models\MoonSign::where('name', $report->birth_star)->first();
                  $selectedMoonSignId = $selectedMoonSignObj ? $selectedMoonSignObj->id : null;
                }
              } elseif(isset($astrologies) && $astrologies && $astrologies->moon_sign_id) {
                $selectedMoonSignId = $astrologies->moon_sign_id;
              } elseif(isset($astrologies) && $astrologies && $astrologies->moon_sign) {
                if(is_numeric($astrologies->moon_sign)) {
                  $selectedMoonSignId = $astrologies->moon_sign;
                } else {
                  $selectedMoonSignObj = \App\Models\MoonSign::where('name', $astrologies->moon_sign)->first();
                  $selectedMoonSignId = $selectedMoonSignObj ? $selectedMoonSignObj->id : null;
                }
              }
            @endphp
            @if(isset($selectedMoonSignId) && $selectedMoonSignId)
                selectedMoonSignId = {{ $selectedMoonSignId }};
            @else
                selectedMoonSignId = null;
            @endif
            
            // Also get the value from the select element itself (in case it's already set)
            var initialMoonSignValue = moonSignSelect.val();
            if (initialMoonSignValue && !selectedMoonSignId) {
                selectedMoonSignId = initialMoonSignValue;
            }

            // Function to update moon sign dropdown via AJAX
            function updateMoonSignDropdown(sunSignId, preserveSelection) {
                if (!sunSignId) {
                    // Clear moon sign if no sun sign selected
                    moonSignSelect.find('option:not(:first)').remove();
                    if (typeof $.fn.selectpicker !== 'undefined') {
                        moonSignSelect.selectpicker('refresh');
                    }
                    return;
                }

                // Show loading state
                moonSignSelect.prop('disabled', true);
                if (typeof $.fn.selectpicker !== 'undefined') {
                    moonSignSelect.selectpicker('refresh');
                }

                // AJAX call to fetch moon signs
                $.ajax({
                    url: '/get-moon-signs/' + sunSignId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.moon_signs) {
                            // Clear existing options except the first one
                            moonSignSelect.find('option:not(:first)').remove();
                            
                            // Add moon signs from response
                            if (response.moon_signs.length > 0) {
                                response.moon_signs.forEach(function(moonSign) {
                                    var option = $('<option>', {
                                        value: moonSign.id,
                                        text: moonSign.name
                                    });
                                    // Preserve selection if needed
                                    if (preserveSelection && selectedMoonSignId && selectedMoonSignId == moonSign.id) {
                                        option.attr('selected', true);
                                    }
                                    moonSignSelect.append(option);
                                });
                            }
                        }
                        
                        // Re-enable and refresh selectpicker
                        moonSignSelect.prop('disabled', false);
                        if (typeof $.fn.selectpicker !== 'undefined') {
                            moonSignSelect.selectpicker('refresh');
                            moonSignSelect.selectpicker('render');
                            
                            // Set the value if we're preserving selection
                            if (preserveSelection && selectedMoonSignId) {
                                moonSignSelect.val(selectedMoonSignId);
                                moonSignSelect.selectpicker('refresh');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching moon signs:', error);
                        // Clear options on error
                        moonSignSelect.find('option:not(:first)').remove();
                        moonSignSelect.prop('disabled', false);
                        if (typeof $.fn.selectpicker !== 'undefined') {
                            moonSignSelect.selectpicker('refresh');
                        }
                    }
                });
            }

            // Initialize selectpicker after a short delay
            setTimeout(function() {
                if (typeof $.fn.selectpicker !== 'undefined') {
                    // Get initial values BEFORE initializing selectpicker
                    var initialSunSignId = sunSignSelect.val();
                    // Get selected moon sign from the selected attribute in the option
                    var selectedMoonOption = moonSignSelect.find('option:selected');
                    var initialMoonSignId = selectedMoonOption.length > 0 && selectedMoonOption.val() !== '' ? selectedMoonOption.val() : null;
                    
                    // Use the PHP-set value if available, otherwise use the selected option
                    if (!selectedMoonSignId && initialMoonSignId) {
                        selectedMoonSignId = parseInt(initialMoonSignId);
                    }
                    
                    // Initialize all selectpickers
                    $('.aiz-selectpicker').selectpicker();
                    
                    // Set the moon sign value after selectpicker initialization
                    setTimeout(function() {
                        if (selectedMoonSignId) {
                            var moonOption = moonSignSelect.find('option[value="' + selectedMoonSignId + '"]');
                            if (moonOption.length > 0) {
                                moonSignSelect.val(selectedMoonSignId);
                                moonSignSelect.selectpicker('refresh');
                            }
                        }
                    }, 200);
                    
                    // Handle sun sign change
                    sunSignSelect.on('changed.bs.select', function(e) {
                        var selectedSunSignId = $(this).val();
                        updateMoonSignDropdown(selectedSunSignId, false);
                    });
                    
                    // Also listen to native change event as fallback
                    sunSignSelect.on('change', function() {
                        var selectedSunSignId = $(this).val();
                        updateMoonSignDropdown(selectedSunSignId, false);
                    });

                    // Initialize moon sign dropdown on page load if sun sign is already selected
                    // Only update if moon sign dropdown is empty or needs refresh
                    if (initialSunSignId) {
                        var currentMoonOptions = moonSignSelect.find('option').length;
                        // If dropdown has options (from PHP), just ensure value is set
                        // Otherwise, fetch via AJAX
                        if (currentMoonOptions > 1) {
                            // Options already loaded from PHP, ensure value is set with a delay
                            setTimeout(function() {
                                if (selectedMoonSignId && moonSignSelect.find('option[value="' + selectedMoonSignId + '"]').length > 0) {
                                    moonSignSelect.val(selectedMoonSignId);
                                    moonSignSelect.selectpicker('refresh');
                                }
                            }, 300);
                        } else {
                            // No options, fetch via AJAX
                            updateMoonSignDropdown(initialSunSignId, true);
                        }
                    }
                }
            }, 300);
        });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAstronomicDropdowns);
    } else {
        initAstronomicDropdowns();
    }
})();
</script>
@endsection