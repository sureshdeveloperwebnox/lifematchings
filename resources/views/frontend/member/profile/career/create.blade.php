<form action="{{ route('career.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title h6">{{translate('Add New Career Info')}}</h5>
        <button type="button" class="close" data-dismiss="modal">
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="user_id" value="{{ $member_id }}">
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Designation')}}</label>
            <div class="col-md-9">
                <input type="text" name="designation" class="form-control" placeholder="{{translate('designation')}}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Company')}}</label>
            <div class="col-md-9">
                <input type="text" name="company"  placeholder="{{ translate('company') }}" class="form-control" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Annual Income')}}</label>
            <div class="col-md-9">
                <select class="form-control aiz-selectpicker" name="annual_income" data-live-search="true" required>
                    <option value="">{{translate('Select Annual Income')}}</option>
                    @if(isset($annual_salary_ranges) && count($annual_salary_ranges) > 0)
                        @foreach ($annual_salary_ranges as $annual_salary_range)
                            @php
                                $range_val = single_price($annual_salary_range->min_salary).' - '.single_price($annual_salary_range->max_salary);
                            @endphp
                            <option value="{{ $range_val }}">{{ $range_val }}</option>
                        @endforeach
                    @endif
                    <option value="Below 1 Lakh">{{translate('Below 1 Lakh')}}</option>
                    <option value="1 - 2 Lakhs">{{translate('1 - 2 Lakhs')}}</option>
                    <option value="2 - 3 Lakhs">{{translate('2 - 3 Lakhs')}}</option>
                    <option value="3 - 5 Lakhs">{{translate('3 - 5 Lakhs')}}</option>
                    <option value="5 - 7 Lakhs">{{translate('5 - 7 Lakhs')}}</option>
                    <option value="7 - 10 Lakhs">{{translate('7 - 10 Lakhs')}}</option>
                    <option value="10 - 15 Lakhs">{{translate('10 - 15 Lakhs')}}</option>
                    <option value="15 - 20 Lakhs">{{translate('15 - 20 Lakhs')}}</option>
                    <option value="20 - 30 Lakhs">{{translate('20 - 30 Lakhs')}}</option>
                    <option value="30 - 50 Lakhs">{{translate('30 - 50 Lakhs')}}</option>
                    <option value="50 Lakhs - 1 Crore">{{translate('50 Lakhs - 1 Crore')}}</option>
                    <option value="Above 1 Crore">{{translate('Above 1 Crore')}}</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{translate('Additional Income')}}</label>
            <div class="col-md-9">
                <select class="form-control aiz-selectpicker" name="additional_income" data-live-search="true" required>
                    <option value="">{{translate('Select Additional Income')}}</option>
                    <option value="Nil">{{translate('Nil')}}</option>
                    @if(isset($annual_salary_ranges) && count($annual_salary_ranges) > 0)
                        @foreach ($annual_salary_ranges as $annual_salary_range)
                            @php
                                $range_val = single_price($annual_salary_range->min_salary).' - '.single_price($annual_salary_range->max_salary);
                            @endphp
                            <option value="{{ $range_val }}">{{ $range_val }}</option>
                        @endforeach
                    @endif
                    <option value="Below 1 Lakh">{{translate('Below 1 Lakh')}}</option>
                    <option value="1 - 2 Lakhs">{{translate('1 - 2 Lakhs')}}</option>
                    <option value="2 - 3 Lakhs">{{translate('2 - 3 Lakhs')}}</option>
                    <option value="3 - 5 Lakhs">{{translate('3 - 5 Lakhs')}}</option>
                    <option value="5 - 7 Lakhs">{{translate('5 - 7 Lakhs')}}</option>
                    <option value="7 - 10 Lakhs">{{translate('7 - 10 Lakhs')}}</option>
                    <option value="10 - 15 Lakhs">{{translate('10 - 15 Lakhs')}}</option>
                    <option value="15 - 20 Lakhs">{{translate('15 - 20 Lakhs')}}</option>
                    <option value="20 - 30 Lakhs">{{translate('20 - 30 Lakhs')}}</option>
                    <option value="30 - 50 Lakhs">{{translate('30 - 50 Lakhs')}}</option>
                    <option value="Above 50 Lakhs">{{translate('Above 50 Lakhs')}}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Close')}}</button>
        <button type="submit" class="btn btn-primary">{{translate('Add New Career Info')}}</button>
    </div>
</form>
<script>
    AIZ.plugins.bootstrapSelect();
</script>
