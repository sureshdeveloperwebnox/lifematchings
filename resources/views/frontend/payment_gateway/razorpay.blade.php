@extends('frontend.layouts.app')

@section('content')
    <div class="bg-white py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="las la-credit-card text-white" style="font-size: 2rem;"></i>
                                </div>
                                <h3 class="fw-bold text-dark mb-2">
                                    @if(Session::get('payment_type') == 'initial_payment')
                                        Initial Payment - Razorpay
                                    @else
                                        Payment - Razorpay
                                    @endif
                                </h3>
                                <p class="text-muted">
                                    @if(Session::get('payment_type') == 'initial_payment')
                                        Complete your initial payment to access premium features
                                    @else
                                        Complete your payment to continue
                                    @endif
                                </p>
                            </div>
                            
                            <div class="text-center mb-4">
                                <div class="bg-light rounded p-4">
                                    <span class="display-4 fw-bold text-primary mb-0">${{ Session::get('payment_data')['amount'] }}</span>
                                    <span class="text-muted d-block">One-time payment</span>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <small class="text-muted">
                                    <i class="las la-shield-alt mr-1"></i>
                                    Secure payment • 30-day money-back guarantee
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{!!route('payment.rozer')!!}" method="POST" id='rozer-pay' style="display: none;">
        <!-- Note that the amount is in paise = 50 INR -->
        <!--amount need to be in paisa-->
        <script src="https://checkout.razorpay.com/v1/checkout.js"
                data-key="{{ env('RAZORPAY_KEY') }}"
                data-amount={{Session::get('payment_data')['amount']*100}}
                data-buttontext=""
                data-name="{{ env('APP_NAME') }}"
                data-description="{{ Session::get('payment_type') == 'initial_payment' ? 'Initial Payment Package' : 'Package Payment' }}"
                data-image="{{ uploaded_asset(get_setting('header_logo')) }}"
                data-prefill.name= "{{ Auth::user()->first_name.' '.Auth::user()->last_name}}"
                data-prefill.email= "{{ Auth::user()->email}}"
                data-theme.color="#ff7529">
        </script>
        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
    </form>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#rozer-pay').submit()
        });
    </script>
@endsection
