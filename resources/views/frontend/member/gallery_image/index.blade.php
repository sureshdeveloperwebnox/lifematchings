@extends('frontend.layouts.member_panel')
@section('panel_content')
    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Gallery Images') }}</h1>
        </div>
      </div>
    </div>
    <div class="row gutters-10">
        <div class="col-md-5 mx-auto mb-3" >
          <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
            <span class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                <i class="las la-image la-2x text-white"></i>
            </span>
            <div class="px-3 pt-3 pb-3">
                @php
                    $uploaded_photos_count = \App\Models\GalleryImage::where('user_id', Auth::user()->id)->count();
                    $remaining_from_package = get_remaining_package_value(Auth::user()->id,'remaining_photo_gallery');
                    $allowed_remaining = max(0, 3 - $uploaded_photos_count);
                    $total_remaining = max($allowed_remaining, $remaining_from_package);
                @endphp
                <div class="h4 fw-700 text-center">{{ $total_remaining }}</div>
                <div class="opacity-50 text-center">{{ translate('Remaining Gallery Image Upload') }}</div>
            </div>
          </div>
        </div>
        <div class="col-md-5 mx-auto mb-3" >
            <a href="{{ route('gallery-image.create')}}">
                <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                    <span class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                        <i class="las la-plus la-3x text-white"></i>
                    </span>
                    <div class="fs-18 text-primary">{{ translate('Add New Image') }}</div>
                </div>
            </a>
        </div>
    </div>
    <div class="row gutters-10">
        @foreach ($gallery_images as $key => $gallery_image)
          <div class="col-md-4 col-sm-6 mb-3">
              <div class="card shadow-sm hov-shadow-lg position-relative overflow-hidden">
                  <div class="card-file-thumb position-relative" style="height: 220px; overflow: hidden; background: #f5f6fa;">
                      <img src="{{ uploaded_asset($gallery_image->image) }}" class="img-fit" alt="{{ translate('Image') }}" style="width: 100%; height: 100%; object-fit: cover;">
                      <div class="position-absolute" style="top: 8px; right: 8px; z-index: 2;">
                          <button type="button" onclick="remove_shortlist('{{ route('gallery_image.destroy', $gallery_image->id) }}')" class="btn btn-danger btn-icon btn-circle btn-sm shadow" title="{{ translate('Delete Image') }}">
                              <i class="las la-trash-alt"></i>
                          </button>
                      </div>
                  </div>
                  <div class="card-footer p-2 text-center bg-white border-top-0 d-flex justify-content-between align-items-center">
                      <a target="_blank" href="{{ uploaded_asset($gallery_image->image) }}" class="btn btn-soft-primary btn-sm btn-block mr-1">
                          <i class="las la-search mr-1"></i>{{ translate('View') }}
                      </a>
                      <button type="button" onclick="remove_shortlist('{{ route('gallery_image.destroy', $gallery_image->id) }}')" class="btn btn-soft-danger btn-sm btn-block ml-1 mt-0">
                          <i class="las la-trash-alt mr-1"></i>{{ translate('Delete') }}
                      </button>
                  </div>
              </div>
          </div>
        @endforeach
    </div>
@endsection

@section('modal')

<div class="modal fade report_modal" id="image_delete_modal">
	<div class="modal-dialog modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6">{{translate('Confirm Delete')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1">{{translate('Are You Sure That You Want To Delete This Image?')}}</p>
                <small class="text-danger">{{ translate('**N.B. Deleting An Image Will Not Refund Your Remaining Gallery Capacity**') }}</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">{{ translate('Close') }}</button>
                <a id="delete_link" class="btn btn-primary">{{translate('Delete')}}</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    function remove_shortlist(url) {
        $("#image_delete_modal").modal("show");
        $("#delete_link").attr("href", url);
    }
</script>
@endsection
