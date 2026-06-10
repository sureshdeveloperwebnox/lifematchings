@extends('frontend.layouts.app')
@section('content')

<div class="position-relative text-center text-white">
    <div class="bg-image" style="background: url('/public/assets/img/beautiful-woman-long-red-dress-walks-around-city-with-her-husband.jpg') center/cover no-repeat; height: 60vh; min-height: 300px;">
        <div class="d-flex h-100 w-100 align-items-center justify-content-center bg-dark bg-opacity-50">
            <div class="px-3">
                <h1 class="fw-bold fs-1 fs-md-2 fs-lg-1">Initial Payment Package</h1>
                <p class="lead fs-6 fs-md-5">Get started with our premium features</p>
            </div>
        </div>
    </div>
</div>

<section class="py-4 py-md-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6 col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-3 p-md-5">
                        <div class="text-center mb-4">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; width: 80px; height: 80px;">
                                <i class="las la-crown text-white" style="font-size: 1.5rem; font-size: 2rem;"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-2 fs-4 fs-md-3">Premium Starter Package</h3>
                            <p class="text-muted fs-6 fs-md-5">Perfect for new users to experience premium features</p>
                        </div>
                        <div class="text-center mb-4">
                            <img src="/public/assets/img/Sequence 01.00_00_41_03.png" alt="Sequence Image" class="img-fluid" style="max-width: 100%; height: auto;">
                        </div>
                        
                        <div style="background-color: #ffe6f0; padding: 15px; padding: 20px; border-radius: 10px; font-size: 14px; font-size: 16px; color: #333; margin-bottom: 30px;">
                         Based on Sankar Narayanan's astrology, we will identify your <strong>Rasi</strong> (Rasi/Zodiac Sign), 
                         <strong>Star/Nakshatra</strong> (birth star), and <strong>Lagna</strong> (ascendant), and recommend the most compatible 
                         Rasi, Star/Nakshatra, and Lagna for you. We will also let you know if you have any <strong>doshas</strong> 
                        (astrological flaws). All this detailed information will be provided within <strong>24 to 48 hours</strong>.
                        </div>
                        
                        <div class="text-center mb-4">
                            <div class="bg-light rounded p-3 p-4">
                                <span class="display-6 display-4 fw-bold text-primary mb-0">999 INR</span>
                                <span class="text-muted d-block fs-6">One-time payment</span>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            @if(Auth::check())
                                <form action="{{ route('initial.payment.razorpay') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg px-3 px-md-5 py-2 py-md-3 fw-bold w-100 w-md-auto">
                                        <i class="las la-credit-card me-2"></i>
                                        <span class="d-none d-md-inline">Pay Now with Razorpay</span>
                                        <span class="d-md-none">Pay Now</span>
                                    </button>
                                </form>
                                @php
                                    $memberCountry = \App\Utility\MemberUtility::member_country(Auth::id());
                                @endphp
                                @if(!$memberCountry || strtolower($memberCountry) !== 'india')
                                    <form action="{{ route('initial.payment.paypal') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary btn-lg px-3 px-md-5 py-2 py-md-3 fw-bold w-100 w-md-auto mt-2 mt-md-0 ms-md-2">
                                            <i class="lab la-paypal me-2"></i>
                                            <span class="d-none d-md-inline">Pay with PayPal (International)</span>
                                            <span class="d-md-none">PayPal (Intl)</span>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <button type="button" onclick="loginModal()" class="btn btn-primary btn-lg px-3 px-md-5 py-2 py-md-3 fw-bold w-100 w-md-auto">
                                    <i class="las la-sign-in-alt me-2"></i>
                                    <span class="d-none d-md-inline">Login to Purchase</span>
                                    <span class="d-md-none">Login to Purchase</span>
                                </button>
                            @endif
                        </div>
                        <div class="text-center mt-2">
                            <small class="text-muted fs-7 fs-6">
                                For Indian cards/UPI, use Razorpay. PayPal works for international cards or PayPal wallet.
                            </small>
                        </div>
                        
                        <div class="text-center mt-4">
                            <small class="text-muted fs-7 fs-6">
                                <i class="las la-shield-alt me-1"></i>
                                Secure payment • 30-day money-back guarantee
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

@endsection

@section('modal')
    @include('modals.login_modal')
@endsection

@section('script')
<script type="text/javascript">
    // Login alert
    function loginModal(){
        $('#LoginModal').modal();
    }
</script>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
