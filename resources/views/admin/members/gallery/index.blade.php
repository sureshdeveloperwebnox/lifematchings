<div class="card-header bg-dark text-white">
    <h5 class="mb-0 h6">{{ translate('Gallery Images') }}</h5>
</div>
<div class="card-body">

    {{-- Upload Form --}}
    <form action="{{ route('admin.member.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ $member->id }}">
        <div class="form-group">
            <label>{{ translate('Upload New Gallery Image') }}</label>
            <div class="input-group" data-toggle="aizuploader" data-type="image">
                <div class="input-group-prepend">
                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                </div>
                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                <input type="hidden" name="gallery_image" class="selected-files">
            </div>
            <div class="file-preview box sm"></div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="las la-upload mr-1"></i> {{ translate('Upload Image') }}
        </button>
    </form>

    <hr class="my-4">

    {{-- Existing Gallery Images --}}
    @php
        $gallery_images = \App\Models\GalleryImage::where('user_id', $member->id)->latest()->get();
    @endphp

    @if($gallery_images->count() > 0)
        <div class="row gutters-10">
            @foreach($gallery_images as $gallery_image)
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="card shadow-sm position-relative overflow-hidden">
                        <div style="height: 200px; overflow: hidden; background: #f5f6fa;">
                            <img src="{{ uploaded_asset($gallery_image->image) }}"
                                 alt="{{ translate('Gallery Image') }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <div class="card-footer p-2 d-flex justify-content-between align-items-center bg-white">
                            <a href="{{ uploaded_asset($gallery_image->image) }}" target="_blank"
                               class="btn btn-soft-primary btn-sm btn-block mr-1">
                                <i class="las la-eye mr-1"></i>{{ translate('View') }}
                            </a>
                            <a href="{{ route('admin.member.gallery.destroy', $gallery_image->id) }}"
                               class="btn btn-soft-danger btn-sm btn-block ml-1 mt-0 confirm-delete"
                               data-href="{{ route('admin.member.gallery.destroy', $gallery_image->id) }}">
                                <i class="las la-trash-alt mr-1"></i>{{ translate('Delete') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            {{ translate('No gallery images uploaded yet.') }}
        </div>
    @endif
</div>
