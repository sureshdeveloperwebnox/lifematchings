@extends('frontend.layouts.app')
@section('content')

<div class="position-relative text-center text-white mb-5">
    <div class="bg-image" style="background: url('/public/assets/img/young-couple-india-using-smartphone-app-plan-their-wedding.jpg') center/cover no-repeat; height: 45vh;">
        <div class="d-flex h-100 w-100 align-items-center justify-content-center bg-dark bg-opacity-60">
            <div>
                <h1 class="fw-bold display-4">{{ translate('Account Deletion & Data Safety') }}</h1>
                <p class="lead text-white-50">{{ translate('Request deletion of your account and personal data') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Data Safety Policy Details -->
        <div class="col-lg-6 pr-lg-5 mb-5 mb-lg-0">
            <h2 class="text-dark fw-bold mb-4">{{ translate('How to Delete Your Account') }}</h2>
            <p class="text-secondary mb-4">
                {{ translate('You can request to delete your account and associated personal data at any time. Depending on how you use our services, you can perform this action directly or submit a request below.') }}
            </p>

            <div class="card mb-4 border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h5 class="fw-bold text-primary mb-3"><i class="las la-mobile-alt mr-2"></i>{{ translate('Option 1: From the Mobile App / Website') }}</h5>
                    <ol class="text-secondary pl-3 mb-0">
                        <li>{{ translate('Log in to your account on the app or website.') }}</li>
                        <li>{{ translate('Go to your Member Panel / Dashboard.') }}</li>
                        <li>{{ translate('Click on Profile Settings / Account settings.') }}</li>
                        <li>{{ translate('Scroll down to "Delete Account" and confirm your choice.') }}</li>
                    </ol>
                </div>
            </div>

            <h3 class="text-dark fw-bold h4 mb-3">{{ translate('What Data is Deleted?') }}</h3>
            <p class="text-secondary mb-3">
                {{ translate('Upon confirming your account deletion request, the following information will be permanently deleted and purged from our systems:') }}
            </p>
            <ul class="text-secondary pl-3 mb-4">
                <li>{{ translate('Your complete profile details (Name, Age, Gender, Relatives, etc.)') }}</li>
                <li>{{ translate('All uploaded photos, documents, and astrology reports') }}</li>
                <li>{{ translate('Education, Career, and Financial information') }}</li>
                <li>{{ translate('Your partner expectations and matchmaking preferences') }}</li>
                <li>{{ translate('Your shortlisted, ignored, and blocked member lists') }}</li>
                <li>{{ translate('All direct chat history and messages') }}</li>
                <li>{{ translate('Active packages, membership level, and validity') }}</li>
            </ul>

            <h3 class="text-dark fw-bold h4 mb-3">{{ translate('What Data is Retained?') }}</h3>
            <p class="text-secondary">
                {{ translate('We only retain transaction records, invoices, and necessary security/audit logs for financial compliance, tax purposes, and auditing under local laws. We do not use this data for any marketing or profiling purposes, and it will not be shared with third parties.') }}
            </p>
        </div>

        <!-- Deletion Form -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-4 p-md-5">
                    <h2 class="text-dark fw-bold h3 mb-2">{{ translate('Submit Deletion Request') }}</h2>
                    <p class="text-secondary mb-4">{{ translate('If you cannot log in or have uninstalled the app, fill out this form to request manual account deletion. We will verify and process your request within 7-14 business days.') }}</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('delete_account.submit') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label fw-600 text-primary-grad">{{ translate('Full Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="{{ translate('Enter your full name') }}" required value="{{ old('name') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-600 text-primary-grad">{{ translate('Registered Email Address') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="{{ translate('Enter your registered email') }}" required value="{{ old('email') }}">
                            <small class="form-text text-muted">{{ translate('Enter the email address you used to register your account.') }}</small>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-600 text-primary-grad">{{ translate('Registered Phone Number') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" placeholder="{{ translate('Enter phone number with country code (e.g. +91...)') }}" required value="{{ old('phone') }}">
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label fw-600 text-primary-grad">{{ translate('Reason for Deletion (Optional)') }}</label>
                            <textarea class="form-control" rows="4" name="reason" placeholder="{{ translate('Please let us know why you wish to delete your account...') }}" style="resize: none;">{{ old('reason') }}</textarea>
                        </div>

                        @if(get_setting('google_recaptcha_activation') == 1)
                            <div class="form-group mb-4">
                                <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                @error('g-recaptcha-response')
                                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        <button type="submit" class="btn btn-block btn-primary py-2 fw-600">{{ translate('Submit Deletion Request') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    @if(get_setting('google_recaptcha_activation') == 1)
        @include('partials.recaptcha')
    @endif
@endsection
