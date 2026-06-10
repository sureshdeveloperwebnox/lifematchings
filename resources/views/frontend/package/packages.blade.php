
@extends('frontend.layouts.app')
@section('content')

<style>
    .carousel-box {
/* Make all carousel cards equal height */
.aiz-carousel .carousel-box {
    display: flex;
    align-items: stretch;
    height: 100%;
}

.aiz-carousel .carousel-box > div {
    display: flex;
    flex-direction: column;
    flex: 1;
}

/* Ensure card body fills full height */
.aiz-carousel .card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    flex: 1;
}

/* Push price & button section to the bottom */
.aiz-carousel .card-body .mb-5.text-dark.text-center,
.aiz-carousel .card-body .text-center:last-child {
    margin-top: auto;
}

</style>


<div class="position-relative text-center text-white">
        <div class="bg-image" style="background: url('/public/assets/img/beautiful-woman-long-red-dress-walks-around-city-with-her-husband.jpg') center/cover no-repeat; height: 60vh;">
            <div class="d-flex h-100 w-100 align-items-center justify-content-center bg-dark bg-opacity-50">
                <div>
                    <h1 class="fw-bold">Select Your Package</h1>
                    <!-- <p class="lead">Discover our journey, values, and vision for the future.</p> -->
                </div>
            </div>
        </div>
    </div>

<!-- 
<section class="pt-6 pb-4 bg-white text-center">
    <div class="container">
        <h1 class="mb-0 fw-600 text-dark">{{ translate('Select Your Package') }}</h1>
    </div>
</section> -->

<section class="py-5 bg-white">
    <div class="container">
        <div class="aiz-carousel" data-items="4" data-xl-items="3" data-md-items="2" data-sm-items="1" data-dots='true' data-infinite='true' data-autoplay='true'>
            @foreach ($packages as $key => $package)
                <div class="carousel-box">
                    <div class="overflow-hidden shadow-none border-right">
                        <div class="card-body">
                            <div class="text-center mb-4 mt-3">
                                <img class="mw-100 mx-auto mb-4" src="{{ uploaded_asset($package->image) }}" height="130">
                                <h5 class="mb-3 h5 fw-600">{{$package->name}}</h5>
                            </div>


<ul class="list-group list-group-raw mb-5" style="font-size:13px;">

    {{-- ✅ Extra Content for Each Package --}}
    @if($package->name == 'Free Package' || $package->name == 'Default')
        <li class="list-group-item py-2">
            <i class="las la-heart text-success mr-2"></i> <b>15</b> {{ translate('Express Interests') }}
        </li>
        <li class="list-group-item py-2">
            <i class="las la-image text-success mr-2"></i> <b>2</b> {{ translate('Gallery Image Uploads') }}
        </li>
        <li class="list-group-item py-2 text-muted">
            <i class="las la-times text-danger mr-2"></i> {{ translate('No Contact Info View') }}
        </li>
        <li class="list-group-item py-2 mb-5 text-muted">
            <i class="las la-times text-danger mr-2"></i> {{ translate('No Profile Viewer View') }}
        </li>
    @endif

    @if($package->name == 'Elite')
        <li class="list-group-item py-2">
            <i class="las la-user-tie text-success mr-2"></i> Relationship Manager
        </li>
        <li class="list-group-item py-2">
            <i class="las la-phone text-success mr-2"></i> Connect with your preferred matches, View <b>15 Verified Numbers</b>
        </li>
        <li class="list-group-item py-2">
            <i class="las la-microphone text-success mr-2"></i> Get Personal Marriage Recorded Voice Clip - 1
        </li>
        <li class="list-group-item py-2 mb-5">
            <i class="las la-database text-success mr-2"></i> Get Marriage Matching Recorded Voice Clip Across Others Matrimony Data - 3
        </li>
    @endif

    @if($package->name == 'Elite Super')
        <li class="list-group-item py-2">
            <i class="las la-user-tie text-success mr-2"></i> Relationship Manager
        </li>
        <li class="list-group-item py-2">
            <i class="las la-phone text-success mr-2"></i> Connect with your preferred matches, View <b>25 Verified Numbers</b>
        </li>
        <li class="list-group-item py-2">
            <i class="las la-microphone text-success mr-2"></i> Get Personal Marriage Recorded Voice Clip - 1
        </li>
        <li class="list-group-item py-2 mb-5">
            <i class="las la-database text-success mr-2"></i> Get Marriage Matching Recorded Voice Clip Across Others Matrimony Data - 5
        </li>
    @endif

    @if($package->name == 'Elite Plus')
        <li class="list-group-item py-2">
            <i class="las la-user-tie text-success mr-2"></i> Relationship Manager
        </li>
        <li class="list-group-item py-2">
            <i class="las la-phone text-success mr-2"></i> Connect with your preferred matches, View <b>35 Verified Numbers</b>
        </li>
        <li class="list-group-item py-2">
            <i class="las la-microphone text-success mr-2"></i> Get Personal Marriage Recorded Voice Clip - 1
        </li>
        <li class="list-group-item py-2 mb-5">
            <i class="las la-database text-success mr-2"></i> Get Marriage Matching Recorded Voice Clip Across Others Matrimony Data - 7
        </li>
    @endif

    @if($package->name == 'VIP')
        <li class="list-group-item py-2">
            <i class="las la-star text-success mr-2"></i> Personal Relationship Only
        </li>
        <li class="list-group-item py-2">
            <i class="las la-user-tie text-success mr-2"></i> Assistance from Astrologer Shanker Narrayan / Senior Relationship Manager for 6 Months
        </li>
        <li class="list-group-item py-2">
            <i class="las la-check text-success mr-2"></i> Senior Relationship Manager will share matching profiles periodically
        </li>
        <li class="list-group-item py-2">
            <i class="las la-envelope text-success mr-2"></i> All communications handled by Senior Relationship Manager
        </li>
        <li class="list-group-item ">
            <i class="las la-moon text-success mr-2"></i> Sending of Star/Horoscope matching profiles as and when available
        </li>
    @endif
</ul>






                            <div class="mb-5 text-dark text-center">
                                @if ($package->id == 1)
                                    <span class="display-4 fw-600 lh-1 mb-0">{{ translate('Free') }}</span>
                                @else
                                    <span class="display-4 fw-600 lh-1 mb-0">{{single_price($package->price)}}</span>
                                @endif
                                <span class="text-secondary d-block">{{$package->validity}} {{translate('Days')}}</span>
                            </div>
                            <div class="text-center">
                                @if ($package->id != 1)
                                    @if(Auth::check())
                                        <a href="{{ route('package_payment_methods', encrypt($package->id)) }}" type="submit" class="btn btn-primary" >{{translate('Purchase This Package')}}</a>
                                    @else
                                        <button type="submit" onclick="loginModal()" class="btn btn-primary" >{{translate('Purchase This Package')}}</button>
                                    @endif
                                @else
                                    <a href="javascript:void(0);" class="btn btn-light" ><del>{{translate('Purchase This Package')}}</del></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@section('modal')
    @include('modals.login_modal')
    @include('modals.package_update_alert_modal')
@endsection

@section('script')
<script type="text/javascript">

	// Login alert
    function loginModal(){
        $('#LoginModal').modal();
    }

    // Package update alert
    function package_update_alert(){
      $('.package_update_alert_modal').modal('show');
    }

</script>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>