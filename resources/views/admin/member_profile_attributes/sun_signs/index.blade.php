@extends('admin.layouts.app')
@section('content')
<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('Rasi/Zodiac Signs')}}</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="@if(auth()->user()->can('add_sun_signs')) col-lg-7 @else col-lg-12 @endif">
        <div class="card">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Rasi/Zodiac Signs') }}</h5>
                </div>
                <div class="col-md-4">
                    <form class="" id="sort_sun_signs" action="" method="GET">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{translate('Name')}}</th>
                            <th>{{translate('Mapped Star/Nakshatras')}}</th>
                            <th class="text-right" width="20%">{{translate('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sun_signs as $key => $sun_sign)
                            <tr>
                                <td>{{ ($key+1) + ($sun_signs->currentPage() - 1)*$sun_signs->perPage() }}</td>
                                <td>{{$sun_sign->name}}</td>
                                <td>
                                    @if(isset($sun_sign->mapped_moon_signs) && $sun_sign->mapped_moon_signs->count() > 0)
                                        @foreach($sun_sign->mapped_moon_signs as $moon_sign)
                                            <span class="badge badge-inline badge-info mr-1 mb-1">{{ $moon_sign->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">{{translate('No Star/Nakshatras mapped')}}</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @can('edit_sun_signs')
                                        <a href="javascript:void(0);" onclick="sun_sign_modal('{{ route('sun-signs.edit', encrypt($sun_sign->id)) }}')" class="btn btn-soft-info btn-icon btn-circle btn-sm" title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                        <a href="javascript:void(0);" onclick="moon_sign_mapping_modal('{{ route('sun-signs.mapping', encrypt($sun_sign->id)) }}')" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Map Star/Nakshatras') }}">
                                            <i class="las la-sitemap"></i>
                                        </a>
                                    @endcan
                                    @can('delete_sun_signs')
                                        <a href="javascript:void(0);" data-href="{{route('sun-signs.destroy', $sun_sign->id)}}" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $sun_signs->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
    @can('add_sun_signs')
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Add New Rasi/Zodiac Sign')}}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sun-signs.store') }}" method="POST" >
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">{{translate('Name')}}</label>
                        <input type="text" id="name" name="name" placeholder="{{ translate('Name') }}"
                               class="form-control" required>
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-3 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection
@section('modal')
    @include('modals.create_edit_modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script>
    function sort_sun_signs(el){
      $('#sort_sun_signs').submit();
    }
        function sun_sign_modal(url){
            $.get(url, function(data){
            $('.create_edit_modal_content').html(data);
                $('.create_edit_modal').modal('show');
        });
    }
    function moon_sign_mapping_modal(url){
        $.get(url, function(data){
                $('.create_edit_modal_content').html(data);
            $('.create_edit_modal').modal('show');
            });
        }
    </script>
@endsection

