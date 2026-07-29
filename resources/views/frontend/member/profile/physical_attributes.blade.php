<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Physical Attributes')}}</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('physical-attribute.update', $member->id) }}" method="POST">
          <input name="_method" type="hidden" value="PATCH">
          @csrf
          <div class="form-group row">
               <div class="col-md-6">
                   <label for="height">{{translate('Height')}} ({{ translate('Ft/Cm') }})</label>
                   @php
                       $height_options = [
                           '4\'0" - 121 cm', '4\'1" - 124 cm', '4\'2" - 127 cm', '4\'3" - 130 cm',
                           '4\'4" - 132 cm', '4\'5" - 135 cm', '4\'6" - 137 cm', '4\'7" - 140 cm',
                           '4\'8" - 142 cm', '4\'9" - 145 cm', '4\'10" - 147 cm', '4\'11" - 150 cm',
                           '5\'0" - 152 cm', '5\'1" - 155 cm', '5\'2" - 157 cm', '5\'3" - 160 cm',
                           '5\'4" - 162 cm', '5\'5" - 165 cm', '5\'6" - 168 cm', '5\'7" - 170 cm',
                           '5\'8" - 173 cm', '5\'9" - 175 cm', '5\'10" - 178 cm', '5\'11" - 180 cm',
                           '6\'0" - 183 cm', '6\'1" - 185 cm', '6\'2" - 188 cm', '6\'3" - 190 cm',
                           '6\'4" - 193 cm', '6\'5" - 195 cm', '6\'6" - 198 cm', '6\'7" - 201 cm',
                           '6\'8" - 203 cm', '6\'9" - 206 cm', '6\'10" - 208 cm', '6\'11" - 211 cm',
                           '7\'0" - 213 cm'
                       ];
                       $user_height = $member->physical_attributes->height ?? '';
                   @endphp
                   <select class="form-control aiz-selectpicker" name="height" data-live-search="true">
                       <option value="">{{ translate('Select Height (Optional)') }}</option>
                       @if($user_height && !in_array($user_height, $height_options))
                           <option value="{{ $user_height }}" selected>{{ $user_height }}</option>
                       @endif
                       @foreach ($height_options as $h_opt)
                           <option value="{{ $h_opt }}" @if($user_height == $h_opt) selected @endif>{{ $h_opt }}</option>
                       @endforeach
                   </select>
                   @error('height')
                       <small class="form-text text-danger">{{ $message }}</small>
                   @enderror
               </div>
              <div class="col-md-6">
                  <label for="weight">{{translate('Weight')}} ({{ translate('Kg')}})</label>
                  <input type="number" name="weight" value="{{ $member->physical_attributes->weight ?? "" }}" step="any" placeholder="{{ translate('Weight') }}" class="form-control" required>
                  @error('weight')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
          </div>

          {{-- <div class="form-group row">
              <div class="col-md-6">
                  <label for="eye_color">{{translate('Eye color')}}</label>
                  <input type="text" name="eye_color" value="{{ $member->physical_attributes->eye_color ?? "" }}" class="form-control" placeholder="{{translate('Eye Color')}}" required>
                  @error('eye_color')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label for="hair_color">{{translate('Hair Color')}}</label>
                  <input type="text" name="hair_color" value="{{ $member->physical_attributes->hair_color ?? "" }}" placeholder="{{ translate('Hair Color') }}" class="form-control" required>
                  @error('hair_color')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
          </div> --}}

          <div class="form-group row">
              <div class="col-md-6">
                  <label for="complexion">{{translate('Complexion')}}</label>
                  <input type="text" name="complexion" value="{{ $member->physical_attributes->complexion ?? "" }}" class="form-control" placeholder="{{translate('Complexion')}}" required>
                  @error('complexion')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
              {{-- <div class="col-md-6">
                  <label for="blood_group">{{translate('Blood Group')}}</label>
                  <input type="text" name="blood_group" value="{{ $member->physical_attributes->blood_group ?? "" }}" placeholder="{{ translate('Blood Group') }}" class="form-control" required>
                  @error('blood_group')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div> --}}
          </div>

          <div class="form-group row">
              <div class="col-md-6">
                  <label for="body_type">{{translate('Body Type')}}</label>
                  <input type="text" name="body_type" value="{{ $member->physical_attributes->body_type ?? "" }}" class="form-control" placeholder="{{translate('Body Type')}}" required>
                  @error('body_type')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
              {{-- <div class="col-md-6">
                  <label for="body_art">{{translate('Body Art')}}</label>
                  <input type="text" name="body_art" value="{{ $member->physical_attributes->body_art ?? "" }}" placeholder="{{ translate('Body Art') }}" class="form-control" required>
                  @error('body_art')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div> --}}
          </div>
          <div class="form-group row">
              <div class="col-md-6">
                  <label for="disability">{{translate('Disability')}}</label>
                  <input type="text" name="disability" value="{{ $member->physical_attributes->disability ?? "" }}" class="form-control" placeholder="{{translate('Disability')}}">
                  @error('disability')
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
