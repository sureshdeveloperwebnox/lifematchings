<form action="{{ route('career.update', $career->id) }}" method="POST">
    <input name="_method" type="hidden" value="PATCH">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title h6">{{translate('Edit Career Info')}}</h5>
        <button type="button" class="close" data-dismiss="modal">
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Designation')}}</label>
            <div class="col-md-9">
                <input type="text" name="designation" value="{{$career->designation}}" class="form-control" placeholder="{{translate('designation')}}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Company')}}</label>
            <div class="col-md-9">
                <input type="text" name="company" value="{{$career->company}}"  placeholder="{{ translate('company') }}" class="form-control" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Annual Income')}}</label>
            <div class="col-md-9">
                @php
                    $annual_income_options = [
                        'Below 1 Lakh', '1 - 2 Lakhs', '2 - 3 Lakhs', '3 - 5 Lakhs',
                        '5 - 7 Lakhs', '7 - 10 Lakhs', '10 - 15 Lakhs', '15 - 20 Lakhs',
                        '20 - 30 Lakhs', '30 - 50 Lakhs', '50 Lakhs - 1 Crore', 'Above 1 Crore'
                    ];
                    $db_ranges = [];
                    if(isset($annual_salary_ranges) && count($annual_salary_ranges) > 0) {
                        foreach ($annual_salary_ranges as $range) {
                            $db_ranges[] = single_price($range->min_salary).' - '.single_price($range->max_salary);
                        }
                    }
                    $all_annual_options = array_unique(array_merge($db_ranges, $annual_income_options));
                @endphp
                <select class="form-control aiz-selectpicker" name="annual_income" data-live-search="true" required>
                    <option value="">{{translate('Select Annual Income')}}</option>
                    @if($career->annual_income && !in_array($career->annual_income, $all_annual_options))
                        <option value="{{ $career->annual_income }}" selected>{{ $career->annual_income }}</option>
                    @endif
                    @foreach ($all_annual_options as $opt)
                        <option value="{{ $opt }}" @if($career->annual_income == $opt) selected @endif>{{ translate($opt) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Additional Income')}}</label>
            <div class="col-md-9">
                @php
                    $additional_income_options = [
                        'Nil', 'Below 1 Lakh', '1 - 2 Lakhs', '2 - 3 Lakhs', '3 - 5 Lakhs',
                        '5 - 7 Lakhs', '7 - 10 Lakhs', '10 - 15 Lakhs', '15 - 20 Lakhs',
                        '20 - 30 Lakhs', 'Above 30 Lakhs'
                    ];
                    $all_additional_options = array_unique(array_merge($db_ranges, $additional_income_options));
                @endphp
                <select class="form-control aiz-selectpicker" name="additional_income" data-live-search="true" required>
                    <option value="">{{translate('Select Additional Income')}}</option>
                    @if($career->additional_income && !in_array($career->additional_income, $all_additional_options))
                        <option value="{{ $career->additional_income }}" selected>{{ $career->additional_income }}</option>
                    @endif
                    @foreach ($all_additional_options as $opt)
                        <option value="{{ $opt }}" @if($career->additional_income == $opt) selected @endif>{{ translate($opt) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
        <button type="submit" class="btn btn-primary">{{translate('Update Career Info')}}</button>
    </div>
</form>
<script>
    AIZ.plugins.bootstrapSelect();
</script>
