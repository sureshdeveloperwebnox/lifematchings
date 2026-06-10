<style>
    .initial-pay-card .btn-razorpay {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: #fff;
        border: 0;
        box-shadow: 0 8px 20px rgba(37, 117, 252, 0.25);
        transition: transform .08s ease, box-shadow .2s ease;
    }
    .initial-pay-card .btn-razorpay:hover { box-shadow: 0 10px 24px rgba(37, 117, 252, 0.35); transform: translateY(-1px); }
    .initial-pay-card .btn-razorpay:active { transform: translateY(0); }

    .initial-pay-card .btn-paypal {
        background: #003087; /* PayPal brand */
        color: #fff;
        border: 0;
        box-shadow: 0 8px 20px rgba(0, 48, 135, 0.25);
        transition: transform .08s ease, box-shadow .2s ease;
    }
    .initial-pay-card .btn-paypal:hover { box-shadow: 0 10px 24px rgba(0, 48, 135, 0.35); transform: translateY(-1px); }
    .initial-pay-card .btn-paypal:active { transform: translateY(0); }

    .initial-pay-card .btn {
        border-radius: 16px;
        padding: 14px 28px; /* more padding */
        font-weight: 700;
        letter-spacing: .2px;
        font-size: 1rem;
        line-height: 1.2;
        min-width: 230px; /* consistent width */
    }
    @media (max-width: 767.98px){
        .initial-pay-card .btn { width: 100%; }
    }
    .initial-pay-card .note { font-size: .85rem; }
</style>

<div class="card shadow-lg border-0 initial-pay-card">
    <div class="card-body p-5 text-center">
        <!--<div class="mb-4">-->
        <!--    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">-->
        <!--        <i class="las la-crown text-white" style="font-size: 2rem;"></i>-->
        <!--    </div>-->
        <!--    <h3 class="fw-bold text-dark mb-2">Premium Starter Package</h3>-->
        <!--    <p class="text-muted">Perfect for new users to experience premium features</p>-->
        <!--</div>-->
        <div style="text-align: center;">
             <img src="/public/assets/img/Sequence 01.00_00_41_03.png" alt="Scene from video" style="width: 320px; margin-bottom: 20px;">
        </div>
        <div class="alert alert-pink text-start fs-6" style="background-color: #ffe6f0; color: #333;">
            Based on Sankar Narayanan's astrology, we will identify your <strong>Rasi</strong> (Rasi/Zodiac Sign),
            <strong>Star/Nakshatra</strong> (birth star), and <strong>Lagna</strong> (ascendant), and recommend the most compatible
            Rasi, Star/Nakshatra, and Lagna for you. We will also let you know if you have any <strong>doshas</strong> (astrological flaws).
            All this detailed information will be provided within <strong>24 to 48 hours</strong>.
        </div>

        <div class="my-4">
            <div class="bg-light rounded p-4">
                <span class="display-4 fw-bold text-primary mb-0">999 INR</span>
                <span class="text-muted d-block">One-time payment</span>
            </div>
        </div>

        <div class="text-center">
            @if(Auth::check())
                <div class="d-grid gap-3 d-md-flex justify-content-center align-items-center">
                    <form action="{{ route('initial.payment.razorpay') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-razorpay btn-lg">
                            <i class="las la-bolt me-2"></i> Pay Now with Razorpay
                        </button>
                    </form>
                @php $memberCountry = \App\Utility\MemberUtility::member_country(Auth::id()); @endphp
                @if(!$memberCountry || strtolower($memberCountry) !== 'india')
                    <form action="{{ route('initial.payment.paypal') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-paypal btn-lg ms-md-2">
                            <i class="lab la-paypal me-2"></i> Pay with PayPal (International)
                        </button>
                    </form>
                @endif
                </div>
            @else
                <button type="button" onclick="loginModal()" class="btn btn-razorpay btn-lg">
                    <i class="las la-sign-in-alt me-2"></i> Login to Purchase
                </button>
            @endif
        </div>

        <div class="text-center mt-2">
            <small class="text-muted note">
                For Indian cards/UPI, use Razorpay. PayPal works for international cards or PayPal wallet.
            </small>
        </div>

        <div class="text-center mt-4">
            <small class="text-muted note">
                <i class="las la-shield-alt me-1"></i> Secure payment • 30-day money-back guarantee
            </small>
        </div>
    </div>
</div>
