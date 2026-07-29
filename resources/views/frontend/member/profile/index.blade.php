@extends('frontend.layouts.member_panel')
@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Introduction')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('member.introduction.update', $member->member->id) }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">{{translate('Introduction')}}</label>
                    <div class="col-md-10">
                        <textarea type="text" name="introduction" class="form-control" rows="4" placeholder="{{translate('Introduction')}}" required>{{ $member->member->introduction }}</textarea>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Email Change -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Change your email')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user.change.email') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Your Email') }}</label>
                    </div>
                    <div class="col-md-10">
                        <div class="input-group mb-3">
                          <input type="email" class="form-control" placeholder="{{ translate('Your Email')}}" name="email" value="{{ Auth::user()->email }}" />
                          <div class="input-group-append">
                             <button type="button" class="btn btn-outline-secondary new-email-verification">
                                 <span class="d-none loading">
                                     <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                     {{ translate('Sending Email...') }}
                                 </span>
                                 <span class="default">{{ translate('Verify') }}</span>
                             </button>
                          </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Update')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Basic Information -->
    @include('frontend.member.profile.basic_info')

    <!-- Present Address -->
    @php
        $present_address      = \App\Models\Address::where('type','present')->where('user_id',$member->id)->first();
        $present_country_id   = $present_address->country_id ?? "";
        $present_state_id     = $present_address->state_id ?? "";
        $present_city_id      = $present_address->city_id ?? "";
        $present_postal_code  = $present_address->postal_code ?? "";
        $present_address_value = $present_address->address ?? "";
    @endphp
    @if(get_setting('member_present_address_section') == 'on')
      @include('frontend.member.profile.present_address')
    @endif

    <!-- Education -->
    @if(get_setting('member_education_section') == 'on')
      @include('frontend.member.profile.education.index')
    @endif

    <!-- Career -->
    @if(get_setting('member_career_section') == 'on')
      @include('frontend.member.profile.career.index')
    @endif

    <!-- Physical Attributes -->
    @if(get_setting('member_physical_attributes_section') == 'on')
      @include('frontend.member.profile.physical_attributes')
    @endif

    <!-- Language -->
    @if(get_setting('member_language_section') == 'on')
      @include('frontend.member.profile.language')
    @endif

    <!-- Hobbies  -->
    @if(get_setting('member_hobbies_and_interests_section') == 'on')
      @include('frontend.member.profile.hobbies_interest')
    @endif

    <!-- Personal Attitude & Behavior -->
    @if(get_setting('member_personal_attitude_and_behavior_section') == 'on')
      @include('frontend.member.profile.attitudes_behavior')
    @endif

    <!-- Residency Information -->
    @if(get_setting('member_residency_information_section') == 'on')
      @include('frontend.member.profile.residency_information')
    @endif

    <!-- Spiritual & Social Background -->
    @php
        $member_religion_id   =  $member->spiritual_backgrounds->religion_id ?? "";
        $member_caste_id      =  $member->spiritual_backgrounds->caste_id ?? "";
        $member_sub_caste_id  =  $member->spiritual_backgrounds->sub_caste_id ?? "";
    @endphp
    @if(get_setting('member_spiritual_and_social_background_section') == 'on')
      @include('frontend.member.profile.spiritual_backgrounds')
    @endif

    <!-- Life Style -->
    @if(get_setting('member_life_style_section') == 'on')
      @include('frontend.member.profile.lifestyle')
    @endif

    <!-- Astronomic Information  -->
    @if(get_setting('member_astronomic_information_section') == 'on')
      @include('frontend.member.profile.astronomic_information')
    @endif

    <!-- Permanent Address -->
    @php
        $permanent_address      = \App\Models\Address::where('type','permanent')->where('user_id',$member->id)->first();
        $permanent_country_id   = $permanent_address->country_id ?? "";
        $permanent_state_id     = $permanent_address->state_id ?? "";
        $permanent_city_id      = $permanent_address->city_id ?? "";
        $permanent_postal_code  = $permanent_address->postal_code ?? "";
    @endphp
    @if(get_setting('member_permanent_address_section') == 'on')
      @include('frontend.member.profile.permanent_address')
    @endif

    <!-- Family Information -->
    @if(get_setting('member_family_information_section') == 'on')
      @include('frontend.member.profile.family_information')
    @endif

    <!-- Partner Expectation -->
    @php
        $partner_religion_id   = $member->partner_expectations->religion_id ?? "";
        $partner_caste_id      = $member->partner_expectations->caste_id ?? "";
        $partner_sub_caste_id  = $member->partner_expectations->sub_caste_id ?? "";
        $partner_country_id    = $member->partner_expectations->preferred_country_id ?? "";
        $partner_state_id      = $member->partner_expectations->preferred_state_id ?? "";
    @endphp
    @if(get_setting('member_partner_expectation_section') == 'on')
      @include('frontend.member.profile.partner_expectation')
    @endif

    @if(get_setting('additional_profile_section') == 'on')
      @include('frontend.member.profile.additional_attributes')
    @endif

@endsection

@section('modal')
    @include('modals.create_edit_modal')
    @include('modals.delete_modal')
@endsection

@section('script')
<script type="text/javascript">

    $(document).ready(function(){
        get_states_by_country_for_present_address();
        get_cities_by_state_for_present_address();
        get_states_by_country_for_permanent_address();
        get_cities_by_state_for_permanent_address();
        get_castes_by_religion_for_member();
        get_sub_castes_by_caste_for_member();
        get_castes_by_religion_for_partner();
        get_sub_castes_by_caste_for_partner();
        get_states_by_country_for_partner();

        if (typeof window.intlTelInputGlobals !== 'undefined') {
            var countryData = window.intlTelInputGlobals.getCountryData(),
                input = document.querySelector("#phone-code");

            if (input) {
                for (var i = 0; i < countryData.length; i++) {
                    var country = countryData[i];
                    if (country.iso2 == 'bd') {
                        country.dialCode = '88';
                    }
                }

                var iti = intlTelInput(input, {
                    initialCountry: "auto",
                    geoIpLookup: function(callback) {
                        $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                            var countryCode = (resp && resp.country) ? resp.country : "us";
                            callback(countryCode);
                        });
                    },
                    separateDialCode: true,
                    utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
                    onlyCountries: @php echo json_encode(\App\Models\Country::where('status', 1)->pluck('code')->toArray()) @endphp,
                    customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                        if (selectedCountryData.iso2 == 'bd') {
                            return "01xxxxxxxxx";
                        }
                        return selectedCountryPlaceholder;
                    }
                });

                var initialVal = input.value || '';
                if (initialVal && initialVal.indexOf('+') === 0) {
                    iti.setNumber(initialVal);
                }

                var country = iti.getSelectedCountryData();
                $('input[name=country_code]').val(country.dialCode);

                input.addEventListener("countrychange", function(e) {
                    var country = iti.getSelectedCountryData();
                    $('input[name=country_code]').val(country.dialCode);
                });
            }
        }
    });

    // For Present address
    function get_states_by_country_for_present_address(){
        var present_country_id = $('#present_country_id').val();
            $.post('{{ route('states.get_state_by_country') }}',{_token:'{{ csrf_token() }}', country_id:present_country_id}, function(data){
                $('#present_state_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#present_state_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#present_state_id > option").each(function() {
                    if(this.value == '{{$present_state_id}}'){
                        $("#present_state_id").val(this.value).change();
                    }
                });

                AIZ.plugins.bootstrapSelect('refresh');

                get_cities_by_state_for_present_address();
            });
        }

    function get_cities_by_state_for_present_address(){
		var present_state_id = $('#present_state_id').val();
    		$.post('{{ route('cities.get_cities_by_state') }}',{_token:'{{ csrf_token() }}', state_id:present_state_id}, function(data){
    		    $('#present_city_id').html(null);
    		    for (var i = 0; i < data.length; i++) {
    		        $('#present_city_id').append($('<option>', {
    		            value: data[i].id,
    		            text: data[i].name
    		        }));
    		    }
    		    $("#present_city_id > option").each(function() {
    		        if(this.value == '{{$present_city_id}}'){
    		            $("#present_city_id").val(this.value).change();
    		        }
    		    });

    		    AIZ.plugins.bootstrapSelect('refresh');
    		});
    	}

    $('#present_country_id').on('change', function() {
  	    get_states_by_country_for_present_address();
  	});

    $('#present_state_id').on('change', function() {
  	    get_cities_by_state_for_present_address();
  	});

    // For permanent address
    function get_states_by_country_for_permanent_address(){
        var permanent_country_id = $('#permanent_country_id').val();
            $.post('{{ route('states.get_state_by_country') }}',{_token:'{{ csrf_token() }}', country_id:permanent_country_id}, function(data){
                $('#permanent_state_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#permanent_state_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#permanent_state_id > option").each(function() {
                    if(this.value == '{{$permanent_state_id}}'){
                        $("#permanent_state_id").val(this.value).change();
                    }
                });

                AIZ.plugins.bootstrapSelect('refresh');

                get_cities_by_state_for_permanent_address();
            });
    }

    function get_cities_by_state_for_permanent_address(){
        var permanent_state_id = $('#permanent_state_id').val();
            $.post('{{ route('cities.get_cities_by_state') }}',{_token:'{{ csrf_token() }}', state_id:permanent_state_id}, function(data){
                $('#permanent_city_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#permanent_city_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#permanent_city_id > option").each(function() {
                    if(this.value == '{{$permanent_city_id}}'){
                        $("#permanent_city_id").val(this.value).change();
                    }
                });

                AIZ.plugins.bootstrapSelect('refresh');
            });
    }

    $('#permanent_country_id').on('change', function() {
        get_states_by_country_for_permanent_address();
    });

    $('#permanent_state_id').on('change', function() {
        get_cities_by_state_for_permanent_address();
    });

    // get castes and subcastes For member
    function get_castes_by_religion_for_member(){
        var member_religion_id = $('#member_religion_id').val();
        if (!member_religion_id) return;
        $.post('{{ route('castes.get_caste_by_religion') }}',{_token:'{{ csrf_token() }}', religion_id:member_religion_id}, function(data){
            $('#member_caste_id').html(null);
            $('#member_caste_id').append($('<option>', {
                value: '',
                text: '{{ translate("Select One") }}'
            }));
            for (var i = 0; i < data.length; i++) {
                $('#member_caste_id').append($('<option>', {
                    value: data[i].id,
                    text: data[i].name
                }));
            }
            $("#member_caste_id > option").each(function() {
                if(this.value == '{{$member_caste_id}}'){
                    $("#member_caste_id").val(this.value).change();
                }
            });
            AIZ.plugins.bootstrapSelect('refresh');

            get_sub_castes_by_caste_for_member();
        });
    }

    function get_sub_castes_by_caste_for_member(){
        var member_caste_id = $('#member_caste_id').val();
        if (!member_caste_id) return;
        $.post('{{ route('sub_castes.get_sub_castes_by_religion') }}',{_token:'{{ csrf_token() }}', caste_id:member_caste_id}, function(data){
            $('#member_sub_caste_id').html(null);
            $('#member_sub_caste_id').append($('<option>', {
                value: '',
                text: '{{ translate("Select One") }}'
            }));
            for (var i = 0; i < data.length; i++) {
                $('#member_sub_caste_id').append($('<option>', {
                    value: data[i].id,
                    text: data[i].name
                }));
            }
            $("#member_sub_caste_id > option").each(function() {
                if(this.value == '{{$member_sub_caste_id}}'){
                    $("#member_sub_caste_id").val(this.value).change();
                }
            });
            AIZ.plugins.bootstrapSelect('refresh');
        });
    }

    $('#member_religion_id').on('change', function() {
        get_castes_by_religion_for_member();
    });

    $('#member_caste_id').on('change', function() {
        get_sub_castes_by_caste_for_member();
    });

    // get castes and subcastes For partner
    function get_castes_by_religion_for_partner(){
        var partner_religion_id = $('#partner_religion_id').val();
        if (!partner_religion_id) return;
        $.post('{{ route('castes.get_caste_by_religion') }}',{_token:'{{ csrf_token() }}', religion_id:partner_religion_id}, function(data){
            $('#partner_caste_id').html(null);
            $('#partner_caste_id').append($('<option>', {
                value: '',
                text: '{{ translate("Select One") }}'
            }));
            for (var i = 0; i < data.length; i++) {
                $('#partner_caste_id').append($('<option>', {
                    value: data[i].id,
                    text: data[i].name
                }));
            }
            $("#partner_caste_id > option").each(function() {
                if(this.value == '{{$partner_caste_id}}'){
                    $("#partner_caste_id").val(this.value).change();
                }
            });
            AIZ.plugins.bootstrapSelect('refresh');

            get_sub_castes_by_caste_for_partner();
        });
    }

    function get_sub_castes_by_caste_for_partner(){
        var partner_caste_id = $('#partner_caste_id').val();
        if (!partner_caste_id) return;
        $.post('{{ route('sub_castes.get_sub_castes_by_religion') }}',{_token:'{{ csrf_token() }}', caste_id:partner_caste_id}, function(data){
            $('#partner_sub_caste_id').html(null);
            $('#partner_sub_caste_id').append($('<option>', {
                value: '',
                text: '{{ translate("Select One") }}'
            }));
            for (var i = 0; i < data.length; i++) {
                $('#partner_sub_caste_id').append($('<option>', {
                    value: data[i].id,
                    text: data[i].name
                }));
            }
            $("#partner_sub_caste_id > option").each(function() {
                if(this.value == '{{$partner_sub_caste_id}}'){
                    $("#partner_sub_caste_id").val(this.value).change();
                }
            });
            AIZ.plugins.bootstrapSelect('refresh');
        });
    }

    $('#partner_religion_id').on('change', function() {
        get_castes_by_religion_for_partner();
    });

    $('#partner_caste_id').on('change', function() {
        get_sub_castes_by_caste_for_partner();
    });

    // For partner address
    function get_states_by_country_for_partner(){
        var partner_country_id = $('#partner_country_id').val();
            $.post('{{ route('states.get_state_by_country') }}',{_token:'{{ csrf_token() }}', country_id:partner_country_id}, function(data){
                $('#partner_state_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#partner_state_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#partner_state_id > option").each(function() {
                    if(this.value == '{{$partner_state_id}}'){
                        $("#partner_state_id").val(this.value).change();
                    }
                });

                AIZ.plugins.bootstrapSelect('refresh');
            });
    }

    $('#partner_country_id').on('change', function() {
        get_states_by_country_for_partner();
    });

    //  education Add edit , status change
    function education_add_modal(id){
       $.post('{{ route('education.create') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
           $('.create_edit_modal_content').html(data);
           $('.create_edit_modal').modal('show');
       });
    }

    function education_edit_modal(id){
        $.post('{{ route('education.edit') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
            $('.create_edit_modal_content').html(data);
            $('.create_edit_modal').modal('show');
        });
    }

    function update_education_present_status(el) {
        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.post('{{ route('education.update_education_present_status') }}', {
            _token: '{{ csrf_token() }}',
            id: el.value,
            status: status
        }, function (data) {
            if (data == 1) {
                location.reload();
            } else {
                AIZ.plugins.notify('danger', 'Something went wrong');
            }
        });
    }

    function update_highest_degree(el) {
        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.post('{{ route('education.update_highest_degree') }}', {
            _token: '{{ csrf_token() }}',
            id: el.value,
            status: status
        }, function(data) {
            if (data == 1) {
                AIZ.plugins.notify('success', 'Data updated successfully');
                location.reload();
            } else {
                AIZ.plugins.notify('danger', 'Something went wrong');
            }
        });
    }


    //  Career Add edit , status change
    function career_add_modal(id){
       $.post('{{ route('career.create') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
           $('.create_edit_modal_content').html(data);
           $('.create_edit_modal').modal('show');
           AIZ.plugins.bootstrapSelect();
       });
    }

    function career_edit_modal(id){
        $.post('{{ route('career.edit') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
            $('.create_edit_modal_content').html(data);
            $('.create_edit_modal').modal('show');
            AIZ.plugins.bootstrapSelect();
        });
    }

    function update_career_present_status(el) {
        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.post('{{ route('career.update_career_present_status') }}', {
            _token: '{{ csrf_token() }}',
            id: el.value,
            status: status
        }, function (data) {
            if (data == 1) {
                location.reload();
            } else {
                AIZ.plugins.notify('danger', 'Something went wrong');
            }
        });
    }

    $('.new-email-verification').on('click', function() {
        $(this).find('.loading').removeClass('d-none');
        $(this).find('.default').addClass('d-none');
        var email = $("input[name=email]").val();

        $.post('{{ route('user.new.verify') }}', {_token:'{{ csrf_token() }}', email: email}, function(data){
            data = JSON.parse(data);
            $('.default').removeClass('d-none');
            $('.loading').addClass('d-none');
            if(data.status == 2)
                AIZ.plugins.notify('warning', data.message);
            else if(data.status == 1)
                AIZ.plugins.notify('success', data.message);
            else
                AIZ.plugins.notify('danger', data.message);
        });
    });

    function totalSibling(){
        var brothers = parseInt($('#no_of_brothers').val()) || 0;
        var sisters = parseInt($('#no_of_sisters').val()) || 0 ;
        var sibling = brothers + sisters;
        $('#sibling').val(sibling);
    }

    function handleMaritalStatusChange() {
        var selectedText = $('#marital_status option:selected').text().trim().toLowerCase();
        if (selectedText === 'never married') {
            $('#children_mandatory').hide();
            $('#children').val(0);
            $('#children_form_group').hide();
        } else {
            $('#children_mandatory').show();
            $('#children_form_group').show();
        }
    }

    function handlePartnerMaritalStatusChange() {
        var selectedText = $('#partner_marital_status option:selected').text().trim().toLowerCase();
        var selectedVal = $('#partner_marital_status').val();
        if (selectedText === 'never married' || selectedVal == '1' || selectedText.indexOf('never married') !== -1) {
            $('#partner_children_acceptable_div').hide();
        } else {
            $('#partner_children_acceptable_div').show();
        }
    }

    $(document).ready(function() {
        get_castes_by_religion_for_member();
        get_castes_by_religion_for_partner();

        $('#marital_status').on('change', function() {
            handleMaritalStatusChange();
        });
        handleMaritalStatusChange();

        $('#partner_marital_status').on('change', function() {
            handlePartnerMaritalStatusChange();
        });
        handlePartnerMaritalStatusChange();
    });
</script>
@endsection
