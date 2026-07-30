<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Family Information')}}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('families.update', $member->id) }}" method="POST">
            <input name="_method" type="hidden" value="PATCH">
            @csrf
            <div class="form-group row">
                {{-- Father --}}
                <div class="col-md-6">
                    <label for="father">{{translate('Father')}}</label>
                    <input type="text" name="father" value="{{ $member->families->father ?? "" }}" class="form-control" placeholder="{{translate('Father')}}" required>
                    @error('father')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="mother">{{translate('Father Occupation')}}</label>
                    <input type="text" name="father_occupation" value="{{ $member->families->father_occupation ?? "" }}" placeholder="{{ translate('Father Occupation') }}" class="form-control" required>
                    @error('father_occupation')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
    
                {{-- Mother --}}
                <div class="col-md-6 mt-3">
                    <label for="mother">{{translate('Mother')}}</label>
                    <input type="text" name="mother" value="{{ $member->families->mother ?? "" }}" placeholder="{{ translate('Mother') }}" class="form-control" required>
                    @error('mother')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label for="mother">{{translate('Mother Occupation')}}</label>
                    <input type="text" name="mother_occupation" value="{{ $member->families->mother_occupation ?? "" }}" placeholder="{{ translate('Mother Occupation') }}" class="form-control" required>
                    @error('mother_occupation')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                <div class="col-md-6 mt-3">
                    <label for="no_of_married">{{translate('No. of Married')}}</label>
                    @php
                        $sel_married = isset($member->families->no_of_married) && $member->families->no_of_married !== '' ? $member->families->no_of_married : 0;
                    @endphp
                    <select class="form-control aiz-selectpicker" name="no_of_married" id="no_of_married" data-live-search="true" data-selected="{{ $sel_married }}">
                        @for($i=0; $i<=20; $i++)
                            <option value="{{ $i }}" {{ (string)$sel_married === (string)$i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('no_of_married')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label for="no_of_unmarried">{{translate('No. of Unmarried')}}</label>
                    @php
                        $sel_unmarried = isset($member->families->no_of_unmarried) && $member->families->no_of_unmarried !== '' ? $member->families->no_of_unmarried : 0;
                    @endphp
                    <select class="form-control aiz-selectpicker" name="no_of_unmarried" id="no_of_unmarried" data-live-search="true" data-selected="{{ $sel_unmarried }}">
                        @for($i=0; $i<=20; $i++)
                            <option value="{{ $i }}" {{ (string)$sel_unmarried === (string)$i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('no_of_unmarried')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label for="family_value">{{translate('Family Value')}}</label>
                    @php
                        $sel_fam_val = $member->families->family_value ?? "";
                    @endphp
                    <select class="form-control aiz-selectpicker" name="family_value" id="family_value">
                        <option value="">{{translate('Select One')}}</option>
                        <option value="Liberal" {{ $sel_fam_val == 'Liberal' ? 'selected' : '' }}>{{translate('Liberal')}}</option>
                        <option value="Moderate" {{ $sel_fam_val == 'Moderate' ? 'selected' : '' }}>{{translate('Moderate')}}</option>
                        <option value="Traditional" {{ $sel_fam_val == 'Traditional' ? 'selected' : '' }}>{{translate('Traditional')}}</option>
                    </select>
                    @error('family_value')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label for="family_status">{{translate('Family Status')}}</label>
                    @php
                        $sel_fam_status = $member->families->family_status ?? "";
                    @endphp
                    <select class="form-control aiz-selectpicker" name="family_status" id="family_status">
                        <option value="">{{translate('Select One')}}</option>
                        <option value="Middle" {{ $sel_fam_status == 'Middle' ? 'selected' : '' }}>{{translate('Middle')}}</option>
                        <option value="Upper Middle" {{ $sel_fam_status == 'Upper Middle' ? 'selected' : '' }}>{{translate('Upper Middle')}}</option>
                        <option value="Affluent" {{ $sel_fam_status == 'Affluent' ? 'selected' : '' }}>{{translate('Affluent')}}</option>
                    </select>
                    @error('family_status')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label for="no_of_brothers">{{translate('No. of Brothers')}}</label>
                    @php
                        $sel_brothers = isset($member->families->no_of_brothers) && $member->families->no_of_brothers !== '' ? $member->families->no_of_brothers : 0;
                    @endphp
                    <select class="form-control aiz-selectpicker" name="no_of_brothers" id="no_of_brothers" onchange="totalSibling()" data-live-search="true" data-selected="{{ $sel_brothers }}" required>
                        @for($i=0; $i<=20; $i++)
                            <option value="{{ $i }}" {{ (string)$sel_brothers === (string)$i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('no_of_brothers')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label for="no_of_sisters">{{translate('No. of Sister')}}</label>
                    @php
                        $sel_sisters = isset($member->families->no_of_sisters) && $member->families->no_of_sisters !== '' ? $member->families->no_of_sisters : 0;
                    @endphp
                    <select class="form-control aiz-selectpicker" name="no_of_sisters" id="no_of_sisters" onchange="totalSibling()" data-live-search="true" data-selected="{{ $sel_sisters }}" required>
                        @for($i=0; $i<=20; $i++)
                            <option value="{{ $i }}" {{ (string)$sel_sisters === (string)$i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('no_of_sisters')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
    
                {{-- About parents --}}
                <div class="col-md-12 mt-3">
                    <label for="mother">{{translate('About Parents')}}</label>
                    <textarea type="text" name="about_parents" value="{{ $member->families->about_parents ?? "" }}" rows="4" placeholder="{{ translate('About Parents') }}" class="form-control">{{ $member->families->about_parents ?? "" }}</textarea>
                    @error('about_parents')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
    
                {{-- About Siblings --}}
                <div class="col-md-12 mt-3">
                    <label for="mother">{{translate('About Siblings')}}</label>
                    <textarea type="text" name="about_siblings" value="{{ $member->families->about_siblings ?? "" }}" rows="4" placeholder="{{ translate('About Siblings') }}" class="form-control">{{ $member->families->about_siblings ?? "" }}</textarea>
                    @error('about_siblings')
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
