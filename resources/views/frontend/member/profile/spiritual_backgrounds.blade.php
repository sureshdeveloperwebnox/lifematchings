<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Spiritual & Social Background')}}</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('spiritual_backgrounds.update', $member->id) }}" method="POST">
          <input name="_method" type="hidden" value="PATCH">
          @csrf
          <input type="hidden" name="address_type" value="present">
          <div class="form-group row">
              <div class="col-md-6">
                  <label for="member_religion_id">{{translate('Religion')}}</label>
                  <select class="form-control aiz-selectpicker" name="member_religion_id" id="member_religion_id" data-selected="{{ $member_religion_id }}" data-live-search="true" required>
                      <option value="">{{translate('Select One')}}</option>
                      @foreach ($religions as $religion)
                          <option value="{{$religion->id}}" @if($religion->id == $member_religion_id) selected @endif> {{ $religion->name }} </option>
                      @endforeach
                  </select>
                  @error('member_religion_id')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label for="member_caste_id">{{translate('Caste')}}</label>
                  <select class="form-control aiz-selectpicker" name="member_caste_id" id="member_caste_id" data-live-search="true" required>

                  </select>
                  @error('member_caste_id')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
          </div>
          <div class="form-group row">
              <div class="col-md-6">
                  <label for="member_sub_caste_id">{{translate('Sub Caste')}}</label>
                  <select class="form-control aiz-selectpicker" name="member_sub_caste_id" id="member_sub_caste_id" data-live-search="true">

                  </select>
              </div>
              {{-- <div class="col-md-6">
                  <label for="ethnicity">{{translate('Ethnicity')}}</label>
                  <input type="text" name="ethnicity" value="{{ $member->spiritual_backgrounds->ethnicity ?? "" }}" class="form-control" placeholder="{{translate('Ethnicity')}}">
                  @error('ethnicity')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div> --}}
              <div class="col-md-6">
                  <label for="mother_tongue">{{translate('Mother Tongue')}}</label>
                  <input type="text" name="mother_tongue" value="{{ $member->spiritual_backgrounds->mother_tongue ?? "" }}" class="form-control" placeholder="{{translate('Mother Tongue')}}">
                  @error('mother_tongue')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
          </div>
          {{-- <div class="form-group row">
              <div class="col-md-6">
                  <label for="personal_value">{{translate('Personal Value')}}</label>
                  <input type="text" name="personal_value" value="{{$member->spiritual_backgrounds->personal_value ?? "" }}" class="form-control" placeholder="{{translate('Personal Value')}}">
                  @error('personal_value')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label for="family_value_id">{{translate('Family Value')}}</label>
                  <select class="form-control aiz-selectpicker" name="family_value_id" data-selected="{{ $member->spiritual_backgrounds->family_value_id ?? '' }}" data-live-search="true">
                      <option value="">{{translate('Select One')}}</option>
                      @foreach ($family_values as $family_value)
                          <option value="{{$family_value->id}}"> {{ $family_value->name }}</option>
                      @endforeach
                  </select>
              </div>
          </div> --}}
          <div class="form-group row">
              <div class="col-md-6">
                  <label for="gothram">{{translate('Gothram')}}</label>
                  @php
                      $gothram_options = [
                          'Agastya', 'Angirasa', 'Atri', 'Bharadwaja', 'Bhrigu',
                          'Dhananjaya', 'Gargya', 'Gautama', 'Harita', 'Jamadagni',
                          'Kanva', 'Kapila', 'Kashyapa', 'Kaundinya', 'Kutsasa',
                          'Moudgalya', 'Naidhruva', 'Nithyandhana', 'Parashara', 'Sandilya',
                          'Sankriti', 'Shatamarshana', 'Siva', 'Srivastava', 'Upamanyu',
                          'Vadoolas', 'Vashishta', 'Vatsa', 'Vishnuvardhana', 'Viswamitra',
                          'Other / Don\'t Know'
                      ];
                      $user_gothram = $member->spiritual_backgrounds->gothram ?? '';
                  @endphp
                  <select class="form-control aiz-selectpicker" name="gothram" data-live-search="true">
                      <option value="">{{ translate('Select Gothram (Optional)') }}</option>
                      @if($user_gothram && !in_array($user_gothram, $gothram_options))
                          <option value="{{ $user_gothram }}" selected>{{ $user_gothram }}</option>
                      @endif
                      @foreach ($gothram_options as $g_opt)
                          <option value="{{ $g_opt }}" @if($user_gothram == $g_opt) selected @endif>{{ $g_opt }}</option>
                      @endforeach
                  </select>
                  @error('gothram')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label for="diet">{{translate('Diet')}}</label>
                  <input type="text" name="diet" value="{{ $member->spiritual_backgrounds->diet ?? "" }}" class="form-control" placeholder="{{translate('Diet')}}">
                  @error('diet')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
          </div>
          {{-- <div class="form-group row">
              <div class="col-md-6">
                  <label for="community_value">{{translate('Community Value')}}</label>
                  <input type="text" name="community_value" value="{{$member->spiritual_backgrounds->community_value ?? "" }}" class="form-control" placeholder="{{translate('Community Value')}}">
                  @error('community_value')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
          </div> --}}
          <div class="form-group row">
              <div class="col-md-6">
                  <label for="living_in">{{translate('Living in')}}</label>
                  <input type="text" name="living_in" value="{{ $member->spiritual_backgrounds->living_in ?? "" }}" class="form-control" placeholder="{{translate('Living in')}}">
                  @error('living_in')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label for="nationality">{{translate('Nationality')}}</label>
                  <input type="text" name="nationality" value="{{ $member->spiritual_backgrounds->nationality ?? "" }}" class="form-control" placeholder="{{translate('Nationality')}}">
                  @error('nationality')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
          </div>
          <div class="text-right">
              <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
          </div>
      </form>
    </div>
</div>
