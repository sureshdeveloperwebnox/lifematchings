@extends('frontend.layouts.member_panel')
@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Add New Image to Gallery') }}</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('gallery-image.store') }}" method="POST" enctype="multipart/form-data" id="galleryImageForm">
                @csrf
                <div class="form-group row">
                    <label class="col-md-2 col-form-label" for="signinSrEmail">{{translate('Image')}} <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <div class="input-group" data-toggle="aizuploader" data-type="image">
                            <div class="input-group-prepend">
                                <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                            </div>
                            <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                            <input type="hidden" name="gallery_image" class="selected-files" id="galleryImageInput" required>
                        </div>
                        <div class="file-preview box sm">
                        </div>
                        <div class="invalid-feedback" id="imageError" style="display: none;">
                            {{ translate('Please select an image to upload.') }}
                        </div>
                    </div>
                </div>
                <div class="form-group row text-right">
                    <div class="col-md-11">
                        <button type="submit" class="btn btn-primary" id="submitBtn">{{translate('Confirm')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('galleryImageForm');
            const imageInput = document.getElementById('galleryImageInput');
            const imageError = document.getElementById('imageError');
            const submitBtn = document.getElementById('submitBtn');

            // Form submission validation
            form.addEventListener('submit', function(e) {
                if (!imageInput.value || imageInput.value.trim() === '') {
                    e.preventDefault();
                    imageError.style.display = 'block';
                    imageInput.classList.add('is-invalid');
                    return false;
                } else {
                    imageError.style.display = 'none';
                    imageInput.classList.remove('is-invalid');
                }
            });

            // Real-time validation when file is selected
            const fileAmount = document.querySelector('.file-amount');
            const filePreview = document.querySelector('.file-preview');
            
            // Monitor for changes in the file preview area
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        // Check if files are actually selected
                        if (filePreview.children.length > 0) {
                            imageError.style.display = 'none';
                            imageInput.classList.remove('is-invalid');
                        } else {
                            imageError.style.display = 'block';
                            imageInput.classList.add('is-invalid');
                        }
                    }
                });
            });

            observer.observe(filePreview, {
                childList: true,
                subtree: true
            });

            // Also check on input change
            imageInput.addEventListener('change', function() {
                if (this.value && this.value.trim() !== '') {
                    imageError.style.display = 'none';
                    this.classList.remove('is-invalid');
                } else {
                    imageError.style.display = 'block';
                    this.classList.add('is-invalid');
                }
            });
        });
    </script>
@endsection
