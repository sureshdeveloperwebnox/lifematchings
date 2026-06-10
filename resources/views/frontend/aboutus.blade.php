@extends('frontend.layouts.app')
@section('content')
<!-- --------------------------------------------------- -->

<div class="position-relative text-center text-white">
    <div class="bg-image mt-10" style="background: url('/public/assets/img/about-banner.jpg') center/cover no-repeat; height: 60vh;">
        <div class="d-flex h-100 w-100 align-items-center justify-content-center bg-dark bg-opacity-50">
            <div>
                <h1 class="fw-bold">About Us</h1>
                <p class="lead">Discover our journey, values, and vision for the future.</p>
            </div>
        </div>
    </div>
</div>

<!-- ------------------------------------------------------------------ -->
<div class="container py-5">
    <div class="row align-items-center">
        
        <!-- Left Side: Images -->
        <div class="col-lg-6 col-md-12 text-center mb-4 mb-lg-0">
            <div class="position-relative">
                <img src="/public/assets/img/about-1.jpg" class="img-fluid rounded shadow w-70 d-block mx-auto" alt="Wedding Image">
            </div>
        </div>

        <!-- Right Side: Text Content -->
        <div class="col-lg-6 col-md-12 text-center text-md-start">
            <h1 class="fw-bold text-dark">Welcome to <br> <span style="color: #BD099D;">Life Matchings Matrimony</span></h1>
            <p class="text-muted">
                Life Matchings is a revolutionary matrimonial platform designed to bring together 
                individuals who are searching for meaningful and lasting relationships. Founded by 
                Mr. Shanker Narrayan and Zarina Begum Abdul Hameed, Life Matchings blends 
                tradition with modern technology to offer a seamless, secure, and personalized 
                matchmaking experience.
            </p>
            <p><a href="#" class="text-decoration-none fw-bold text-danger">Click here</a> to start your matrimony service now.</p>
            
            <hr>

            <p class="text-muted">
                At Life Matchings, we believe that marriage is more than just a union—it is a lifelong 
                journey built on trust, understanding, and compatibility. Our goal is to simplify the 
                matchmaking process while maintaining the essence of cultural and personal 
                preferences, ensuring that every individual finds a partner who truly complements 
                them.
            </p>

            <!-- Contact Information -->
            <div class="d-flex flex-column flex-sm-row gap-3 mt-4 justify-content-center justify-content-md-start">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-dark text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                        📞
                    </div>
                    <div class="ms-2">
                        <small class="text-muted">Enquiry</small>
                        <h6 class="mb-0">+01 2242 3366</h6>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-dark text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                        ✉️
                    </div>
                    <div class="ms-2">
                        <small class="text-muted">Get Support</small>
                        <h6 class="mb-0">info@example.com</h6>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ---------------------- -->

<section class="container text-center pt-5">
    <h2 class="fw-bold">WHY CHOOSE US</h2>
    <p class="text-muted">Prepare for the future project expenses and get everything needed.</p>

    <div class="row g-4 mt-4">
        <div class="col-md-4">
            <div class="border p-4 rounded shadow-lg h-100">
                <h5 class="fw-bold">Authentic & Verified Profiles</h5>
                <p class="text-muted">We prioritize trust and transparency by ensuring
                that all profiles are genuine and verified.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border p-4 rounded shadow-lg h-100">
                <h5 class="fw-bold">Personalized Matchmaking</h5>
                <p class="text-muted">Our intelligent matching system considers various
                compatibility factors to suggest the best potential partners.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border p-4 rounded shadow-lg h-100">
                <h5 class="fw-bold">Privacy & Security</h5>
                <p class="text-muted">Your information is safe with us. We maintain strict
                confidentiality while helping you connect with the right match.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border p-4 rounded shadow-lg h-100">
                <h5 class="fw-bold">Expert Guidance</h5>
                <p class="text-muted">Our team of experienced relationship experts is here to assist
                you in finding your perfect life partner.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border p-4 rounded shadow-lg h-100">
                <h5 class="fw-bold">Diverse & Inclusive</h5>
                <p class="text-muted">Whether you’re looking for a traditional or modern approach
                to marriage, we cater to diverse preferences and communities.</p>
            </div>
        </div>
    </div>
</section>


<!-- --------------------------------------- -->

<div class="container text-center py-5">
    <h2 class="fw-bold">How Does It Works?</h2>

    <div class="row g-4 mt-4">
        <!-- Point 1 -->
        <div class="col-md-6 d-flex align-items-center">
            <div class="p-3 border rounded w-100">
                <!-- <h5 class="fw-bold text-primary">Creative Points 01</h5> -->
                <p class="text-muted">Sign Up & Create a Profile – Register and share details about yourself, your interests, and your preferences.
</p>
            </div>
            <div class="ms-3 border p-3 bg-primary text-white fw-bold fs-3">1</div>
        </div>

        <!-- Point 2 -->
        <div class="col-md-6 d-flex align-items-center flex-row-reverse">
            <div class="p-3 border rounded w-100">
                <!-- <h5 class="fw-bold text-warning">Creative Points 02</h5> -->
                <p class="text-muted">Find Compatible Matches – Our advanced algorithm suggests suitable profiles based on compatibility</p>
            </div>
            <div class="me-3 border p-3 bg-warning text-white fw-bold fs-3">2</div>
        </div>

        <!-- Point 3 -->
        <div class="col-md-6 d-flex align-items-center">
            <div class="p-3 border rounded w-100">
                <!-- <h5 class="fw-bold text-info">Creative Points 03</h5> -->
                <p class="text-muted">Connect & Communicate – Engage in meaningful conversations with potential matches</p>
            </div>
            <div class="ms-3 border p-3 bg-info text-white fw-bold fs-3">3</div>
        </div>

        <!-- Point 4 -->
        <div class="col-md-6 d-flex align-items-center flex-row-reverse">
            <div class="p-3 border rounded w-100">
                <!-- <h5 class="fw-bold text-danger">Creative Points 04</h5> -->
                <p class="text-muted">Take the Next Step – When you find the right one, move forward with confidence towards a lifelong journey together.</p>
            </div>
            <div class="me-3 border p-3 bg-danger text-white fw-bold fs-3">4</div>
        </div>
    </div>
</div>

<!-- ---------------------------------------- -->
<div class="position-relative text-center">
    <!-- Background Image -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('/public/assets/img/about-2.jpg') center/cover; filter: brightness(50%);"></div>

    <!-- Content -->
    <div class="container position-relative py-5">
        <div class="row justify-content-start">
            <div class="col-md-6 bg-white py-5 rounded shadow">
                <h3 class="fw-bold">Join Life Matchings Today!</h3>
                <hr class="border-2 border-warning w-25">
                <p class="text-muted">
                Whether you’re looking for love, companionship, or a life partner, Life Matchings is
                here to make your journey smooth and fulfilling. Let us help you find the one who
                truly completes you.
                </p>
            </div>
        </div>
    </div>
</div>


<!-- ----------------------------------- -->

<div class="container text-center pt-6 pb-2">
    <h2 class="fw-bold">Start Your Matchmaking Journey Now!</h2>
    <p class="fst-italic text-muted">"Love doesn't make the world go around. Love is what makes the ride worthwhile."</p>
    <!-- <div class="d-flex justify-content-center">
        <img src="/public/assets/img/about-3.jpg" alt="Decoration" class="img-fluid" width="50">
    </div> -->
</div>

<div class="container py-4">
    <div class="row align-items-center">
        <!-- Image Section -->
        <div class="col-md-6 text-center">
            <img src="/public/assets/img/about-3.jpg" class="img-fluid rounded" alt="Love Story" style="width: 60%;">
        </div>
        <!-- Text Section -->
        <div class="col-md-6">
            <h3 class="fw-bold mt-3">Trusted by Millions</h3>
            <hr class="border-2 border-warning w-25">
            <p class="text-muted">
            At Life Matchings, we believe that every love story deserves a perfect beginning. With
            millions of active users worldwide, we have been a trusted platform for individuals
            seeking meaningful and lasting relationships. Our commitment to authenticity,
            personalized matchmaking, and a seamless experience ensures that you find a
            partner who truly complements you.
            Join a community where hearts connect, bonds are built, and love finds its way. Let
            us help you discover your perfect match and make your journey of love worthwhile.
            </p>
        </div>
    </div>
</div>

<!-- ---------------------------------------- -->

<style>
        @media (max-width: 768px) {
            .tab-img {
                display: inline-block;
            }
        }
</style>

<div class="container text-center py-5">
    <h2 class="fw-bold" style="color: #BD099D;">Meet the Founders</h2>
    
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs justify-content-center mt-4" id="founderTabs">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#founder1">
                <img src="/public/assets/img/Shanker Narrayan.png" class="rounded-circle" width="50" height="50" alt="Founder 1"> Mr. Shanker Narrayan
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#founder2">
                <img src="/public/assets/img/Zarina.jpeg" class="rounded-circle" width="50" height="50" alt="Founder 2"> Zarina Begum Abdul Hameed
            </button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content mt-4" style="overflow: auto;">
        <!-- Founder 1 -->
        <div class="tab-pane fade show active" id="founder1">
            <div class="card p-4 border" style="background: url('/public/assets/img/bg-10.jpg') center/cover; height: 100vh; z-index: 0;">
            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-4 text-center text-md-start tab-img z-index: 999;">
              <img src="/public/assets/img/Shanker Narrayan.png" class="img-fluid rounded mb-3" width="150" height="150" alt="Mr. Shanker Narrayan">
              <div>
                  <h4 class="fw-bold">Mr. Shanker Narrayan</h4>
                  <p class="text-muted"><b>Renowned Astrologer with 17+ Years of Experience</b></p>
              </div>
          
                </div>
                <p style="text-align: justify; font-weight: 500; fomnt-size: 20px; padding: 30px;">Mr. Shanker Narrayan is a highly esteemed astrologer with vast experience in providing worldwide consultation services. With over 17 years of dedicated practice,
                 he has guided countless clients through his insightful astrological predictions and
                 remedies.
                 His expertise extends beyond astrology to numerology, gemology, Vaastu,
                 fortune-telling, and hidden energy studies. Passionate about this field from a young
                 age, he began his astrology practice at the age of 23 and has since helped numerous
                 individuals navigate their life's journey with accurate predictions and personalized
                 guidance.
                </p>
                <ul class="list-unstyled text-start" style="font-weight: 500; fomnt-size: 20px; padding:0 30px;">
                    <li>✔ Accurate Predictions – Expertise in horoscope analysis and future forecasting.</li>
                    <li>✔ Comprehensive Guidance – Specializes in astrology, numerology, gemology, Vaastu, and more.</li>
                    <li>✔ Personalized Remedies – Offers customized solutions for life challenges and Vaastu corrections.</li>
                    <li>✔ Global Consultation Services – Trusted by clients worldwide.</li>
                    <li>✔ Television Presence – Featured on Headlines TV, providing monthly zodiac predictions.</li>
                </ul>
                <p style=" font-weight: 500; fomnt-size: 20px; padding: 30px;">By meticulously analyzing celestial positions based on your Rasi/Zodiac Sign, Mr. Shanker
                 Narrayan provides practical and effective remedies to help you overcome obstacles
                 and achieve success.
                 For personalized consultation, connect with him today!</p>
            </div>
        </div>

        <!-- Founder 2 -->
        <div class="tab-pane fade" id="founder2">
            <div class="card p-4 border" style="background: url('/public/assets/img/bg-10.jpg') center/cover; height: 100vh;">
            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-4 text-center text-md-start">
                <img src="/public/assets/img/Zarina.jpeg" class="img-fluid rounded mb-3" width="150" height="150" alt="Zarina Begum Abdul Hameed">
                <div>
                    <h4 class="fw-bold">Zarina Begum Abdul Hameed</h4>
                    <p class="text-muted"><b>25+ Years in Business Development & Management</b></p>
                </div>
                </div>
                <p  style="text-align: justify; font-weight: 500; fomnt-size: 20px; padding: 30px;">TZarina
                Begum Abdul Hameed is a visionary leader and entrepreneur. She has played a
                pivotal role in multiple organizations, driving strategic growth and operational
                excellence. As the Managing Director of Life Remedies, Director & Head of
                Operations at Iscistech Business Solutions Pvt Ltd, and Business Relationship
                Manager at Uniprotech Solutions Pvt Ltd, Zarina has consistently demonstrated her
                ability to build and sustain successful business ventures.
                Beyond her corporate roles, she is deeply passionate about creating meaningful
                solutions that enhance people's lives. This passion has led her to co-found Life
                Matchings, a matrimonial platform designed to help individuals find compatible life
                partners with trust and transparency.
                Bringing a wealth of expertise and a keen understanding of human relationships, Mr.
                Shanker Narrayan joins Zarina in founding Life Matchings. With a strong background
                in business and matchmaking services, he aims to bridge the gap between tradition
                and modernity in matrimonial services, ensuring a seamless and personalized
                experience for individuals seeking lifelong companionship.
                Together, Zarina Begum Abdul Hameed and Shanker Narrayan are on a mission to
                redefine matchmaking with Life Matchings, a platform built on integrity,
                compatibility, and a deep commitment to helping people find their perfect match.
                </p>
            </div>
        </div>
    </div>
</div>


<!-- <style>
        .founder-img {
            width: 150px; /* Ensures proper image sizing */
            height: 150px;
            object-fit: cover;
        }
        @media (max-width: 768px) {
            .founder-info {
                flex-direction: column;
                text-align: center;
            }
        }
</style> -->



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection