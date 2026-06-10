<div class="card-header bg-dark text-white">
    <h5 class="mb-0 h6">{{translate('Astronomic Information')}}</h5>
</div>
<div class="card-body">
    <form action="{{ route('astrologies.update', $member->id) }}" method="POST">
        <input name="_method" type="hidden" value="PATCH">
        @csrf
        <div class="form-group row">
            <div class="col-md-6">
                <label for="sun_sign">{{translate('Rasi/Zodiac Sign')}}</label>
                <select name="sun_sign" id="sun_sign" class="form-control aiz-selectpicker" data-live-search="true" required>
                    <option value="">{{translate('Select Rasi/Zodiac Sign')}}</option>
                    @php
                        $sun_signs = \App\Models\SunSign::orderBy('name')->get();
                        $selected_sun_sign_id = null;
                        if($member->astrologies && $member->astrologies->sun_sign) {
                            if(is_numeric($member->astrologies->sun_sign)) {
                                $selected_sun_sign_id = $member->astrologies->sun_sign;
                            } else {
                                $selected_sun = \App\Models\SunSign::where('name', $member->astrologies->sun_sign)->first();
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
                @error('sun_sign')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="moon_sign">{{translate('Star/Nakshatra')}}</label>
                <select name="moon_sign" id="moon_sign" class="form-control aiz-selectpicker" data-live-search="true" required>
                    <option value="">{{translate('Select Star/Nakshatra')}}</option>
                    @php
                        $moon_signs = \App\Models\MoonSign::orderBy('name')->get();
                        $selected_moon_sign_id = null;
                        if($member->astrologies && $member->astrologies->moon_sign) {
                            if(is_numeric($member->astrologies->moon_sign)) {
                                $selected_moon_sign_id = $member->astrologies->moon_sign;
                            } else {
                                $selected_moon_sign_obj = \App\Models\MoonSign::where('name', $member->astrologies->moon_sign)->first();
                                $selected_moon_sign_id = $selected_moon_sign_obj ? $selected_moon_sign_obj->id : null;
                            }
                        }
                        $selected_sun_sign_id_for_moon = null;
                        if($member->astrologies && $member->astrologies->sun_sign) {
                            if(is_numeric($member->astrologies->sun_sign)) {
                                $selected_sun_sign_id_for_moon = $member->astrologies->sun_sign;
                            } else {
                                $selected_sun_for_moon = \App\Models\SunSign::where('name', $member->astrologies->sun_sign)->first();
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
                @error('moon_sign')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="lagnam">{{translate('Lagnam/Lagna')}}</label>
                <select name="lagnam" id="lagnam" class="form-control aiz-selectpicker" data-live-search="true" required>
                    <option value="">{{translate('Select Lagnam/Lagna')}}</option>
                    @php
                        $selected_lagnam_id = null;
                        if($member->astrologies && $member->astrologies->lagnam) {
                            if(is_numeric($member->astrologies->lagnam)) {
                                $selected_lagnam_id = $member->astrologies->lagnam;
                            } else {
                                $selected_lagnam_obj = \App\Models\SunSign::where('name', $member->astrologies->lagnam)->first();
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
                @error('lagnam')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="time_of_birth">{{translate('Time Of Birth')}}</label>
                <input type="time" class="form-control @error('time_of_birth') is-invalid @enderror" name="time_of_birth" id="time_of_birth" value="{{ $member->astrologies->time_of_birth ?? "" }}" placeholder="{{ translate('HH:MM') }}" required>
                @error('time_of_birth')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="city_of_birth">{{translate('City Of Birth')}}</label>
                <input type="text" name="city_of_birth" value="{{ $member->astrologies->city_of_birth ?? "" }}" placeholder="{{ translate('City Of Birth') }}" class="form-control" required>
                @error('city_of_birth')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
        </div>
    </form>
</div>

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
            var sunSignSelect = $('#sun_sign');
            var moonSignSelect = $('#moon_sign');
            var lagnamSelect = $('#lagnam');
            
            // Get selected moon sign ID for preserving selection
            var selectedMoonSignId = null;
            @if($member->astrologies && $member->astrologies->moon_sign)
                @php
                    if(is_numeric($member->astrologies->moon_sign)) {
                        $selectedMoonSignId = $member->astrologies->moon_sign;
                    } else {
                        $selectedMoonSignObj = \App\Models\MoonSign::where('name', $member->astrologies->moon_sign)->first();
                        $selectedMoonSignId = $selectedMoonSignObj ? $selectedMoonSignObj->id : null;
                    }
                @endphp
                selectedMoonSignId = {{ $selectedMoonSignId ?? 'null' }};
            @endif

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
                    $('.aiz-selectpicker').selectpicker();
                    
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
                    var initialSunSignId = sunSignSelect.val();
                    if (initialSunSignId) {
                        updateMoonSignDropdown(initialSunSignId, true);
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
