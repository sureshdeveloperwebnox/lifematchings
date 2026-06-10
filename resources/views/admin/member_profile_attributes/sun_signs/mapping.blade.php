<form action="{{ route('sun-signs.update-mapping', $sun_sign->id) }}" method="POST" id="moon_sign_mapping_form">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title h6">{{translate('Map Star/Nakshatra to')}} {{ $sun_sign->name }}</h5>
        <button type="button" class="close" data-dismiss="modal">
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Star/Nakshatra')}}</label>
            <div class="col-md-9">
                <select name="moon_sign_ids[]" id="moon_sign_ids" class="form-control aiz-selectpicker" multiple data-live-search="true" data-selected-text-format="count" title="{{translate('Select Star/Nakshatra')}}">
                    @foreach($moon_signs as $moon_sign)
                        <option value="{{ $moon_sign->id }}" {{ in_array($moon_sign->id, $selected_moon_sign_ids) ? 'selected' : '' }}>
                            {{ $moon_sign->name }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">{{translate('Select multiple Star/Nakshatra that can be mapped to this Rasi/Zodiac Sign')}}</small>
                @error('moon_sign_ids')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">{{translate('Close')}}</button>
        <button type="submit" class="btn btn-sm btn-primary">{{translate('Update Mapping')}}</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Initialize selectpicker when modal is shown
        $('.create_edit_modal').on('shown.bs.modal', function() {
            if (typeof $.fn.selectpicker !== 'undefined') {
                $('#moon_sign_ids').selectpicker('refresh');
            }
        });
        
        // Initialize selectpicker if available
        if (typeof $.fn.selectpicker !== 'undefined') {
            $('#moon_sign_ids').selectpicker();
        }
    });
</script>

