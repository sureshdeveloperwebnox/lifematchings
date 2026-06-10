
@extends('frontend.layouts.app')
@section('content')


<div class="position-relative text-center text-white">
        <div class="bg-image" style="background: url('/public/assets/img/indian-wedding-photography-groom-bride-hands.jpg') center/cover no-repeat; height: 60vh;">
            <div class="d-flex h-100 w-100 align-items-center justify-content-center bg-dark bg-opacity-50">
                <div>
                    <h1 class="fw-bold">Our Services</h1>
                    <!-- <p class="lead">Discover our journey, values, and vision for the future.</p> -->
                </div>
            </div>
        </div>
    </div>
<!-- ----------------------------------------------------------------------------- -->

<style>
    body {
        background-color: #fdfbf5;
    }
    .service-title {
        text-align: center;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .service-description {
        text-align: center;
        color: #6c757d;
        max-width: 700px;
        margin: 0 auto 30px;
    }
    .service-card {
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s;
        height: 250px;
    }
    .service-card:hover {
        transform: scale(1.05);
    }
    .service-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }
    .service-label {
        color: #fff;
        font-size: 18px;
        padding: 10px;
        font-weight: 700;
        text-align: center;
        border-radius: 10px;
        margin-top: -80px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        width: 80%;
        margin-left: auto;
        margin-right: auto;
    }
    .btn-global{
        background-size: 100% 100%;
        background-position: 0px 0px;
        background-image: linear-gradient(90deg, #FD00D1 0%, #71C4FFFF 100%);
        color: #fff;
    }
</style>

<section class="py-5">
<div class="container text-center">

    <div class="row g-4">
        <div class="col-md-4">
            <div class="service-card">
                <img src="/public/assets/img/marriage-2.jpg" alt="Wedding Bouquet" class="service-img">
                <div class="service-label">Marriage Matching Compatibility</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service-card">
                <img src="/public/assets/img/horo-2.jpg" alt="Wedding Invitation" class="service-img">
                <div class="service-label">Marriage Horoscope Audio Clip</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service-card">
                <img src="/public/assets/img/senior-2.jpg" alt="Wedding Location" class="service-img">
                <div class="service-label">Senior Life Matchings</div>
            </div>
        </div>
    </div>
</div>
</section>

<!------------------------------------------------------>

<!-- 
<style>
    @media (max-width: 768px) {
    .row.align-items-center {
        flex-direction: column-reverse; /* Ensures the image appears below text on smaller screens */
    }
    
    .col-md-7, .col-md-5 {
        width: 100%; /* Makes both sections full width on small screens */
        text-align: center; /* Centers text for better readability */
    }

    ul {
        text-align: left; /* Keeps list items aligned left even in center text */
        padding-left: 0;
    }

    .btn-global {
        display: block;
        margin: 20px auto; /* Centers button */
    }
}
</style> -->

<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h2 class="fw-bold text-dark">Marriage Matching Compatibility</h2>
                <p class="lead text-secondary"> - Voice Clip Script</p>
                <p class="text-dark">
                    Marriage is a significant milestone, and finding a compatible life partner is essential for happiness and stability. Horoscope Matching plays a crucial role in ensuring harmony by analyzing the horoscopes of the bride and groom based on 10 key Poruthams:
                </p>

                <ul class="list-unstyled text-dark" style="font-size: 18px;">
                    <li ><strong><img src="/public/assets/img/heart1.png" width="20" alt="Heart Icon"> - Dina & Rasi/Zodiac Sign Porutham</strong> – Ensures health, emotional, and mental compatibility.</li>
                    <li class="mt-2"><strong><img src="/public/assets/img/heart1.png" width="20" alt="Heart Icon"> - Gana & Yoni Porutham</strong> – Assesses temperament and physical compatibility.</li>
                    <li class="mt-2"><strong><img src="/public/assets/img/heart1.png" width="20" alt="Heart Icon"> - Mahendra & Stree Dirgha Porutham</strong> – Predicts prosperity and well-being.</li>
                    <li class="mt-2"><strong><img src="/public/assets/img/heart1.png" width="20" alt="Heart Icon"> - Vashya & Rajju Porutham</strong> – Determines mutual attraction and marital stability.</li>
                    <li class="mt-2"><strong><img src="/public/assets/img/heart1.png" width="20" alt="Heart Icon"> - Rashyadhipati & Vedha Porutham</strong> – Evaluates understanding and potential obstacles.</li>
                    <li class="mt-2"><strong><img src="/public/assets/img/heart1.png" width="20" alt="Heart Icon"> - Nadi Porutham</strong> – Ensures genetic and health compatibility for future generations.</li>
                </ul>

                <p class="mt-4 text-dark">
                    Astrologers analyze these factors to provide guidance, ensuring a successful and blissful marriage. Let astrology help you find your perfect match! 💫
                </p>

                <a href="https://lifehoroscope.in/marriage-horoscope-recorded-audio-clip" class="btn btn-global my-3">Get Your Horoscope</a>
            </div>

            
            <div class="col-md-5 text-center">
                <img src="/public/assets/img/marriage-1.jpg" alt="Marriage Compatibility" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>


<!-- ---------------------------------------------------------- -->
 
<!-- .row.align-items-center {
            flex-direction: column-reverse; /* Ensures text appears below image on mobile */
            text-align: center;
        } -->

<style>
    @media (max-width: 768px) {
        .col-md-5, .col-md-7 {
            width: 100%;
        }
    
        ul {
            text-align: left; /* Keeps bullet points aligned properly */
            padding-left: 0;
            display: inline-block; /* Helps maintain alignment */
        }
    
        .btn-global {
            display: block;
            margin: 20px auto; /* Centers button */
        }
    }

</style>

<section class="bg-light py-5" style="background: linear-gradient(to right, #6a0572, #9b1578);">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Side Image -->
            <div class="col-md-5 text-center">
                <img src="/public/assets/img/horo-1.jpg" alt="Marriage Horoscope" class="img-fluid rounded">
            </div>

            <!-- Right Side Content -->
            <div class="col-md-7">
                <h2 class="fw-bold text-white">Marriage Horoscope Audio Clip</h2>
                <p class="lead text-white">  - Unlock the Secrets of Your Married Life</p>
                <p class="text-white">
                    Marriage is a significant milestone, and finding a compatible life partner is essential for happiness and stability. Horoscope Matching plays a crucial role in ensuring harmony by analyzing the horoscopes of the bride and groom based on 10 key Poruthams.
                </p>

                <ul class="list-unstyled text-white " style="font-size: 18px;">
                    <li><strong><img src="/public/assets/img/heart.png" width="20" alt="Heart Icon"> - Your Personality & Its Influence on Marriage</strong></li>
                    <li class="mt-2"><strong><img src="/public/assets/img/heart.png" width="20" alt="Heart Icon"> - Characteristics of Your Ideal Partner</strong></li>
                    <li class="mt-2"><strong><img src="/public/assets/img/heart.png" width="20" alt="Heart Icon"> - Future Prospects of Your Married Life</strong></li>
                    <li class="mt-2"><strong><img src="/public/assets/img/heart.png" width="20" alt="Heart Icon"> - Possibilities Regarding Children & Family Life</strong></li>
                    <li class="mt-2"><strong><img src="/public/assets/img/heart.png" width="20" alt="Heart Icon"> - Astrological Remedies for a Happy Marriage</strong></li>
                </ul>
                <p class="mt-4 text-white ">
                    Marriage prediction is a detailed study of your astrological chart, offering valuable inputs about the timing of marriage, compatibility factors, and potential challenges. Discover the path to a joyful and harmonious marriage today!
                </p>

                <a href="https://lifehoroscope.in/marriage-horoscope-recorded-audio-clip" class="btn btn-global mt-3 mb-4">Get Your Horoscope</a>
            </div>
        </div>
    </div>
</section>

<!-- ------------------------------------------------------------------------------------------------------------------- -->
<!-- .row.align-items-center {
           flex-direction: column-reverse; /* Image moves above text on small screens */
           text-align: center;
       } -->

<style>
    @media (max-width: 768px) {
       .col-md-6 {
           width: 100%;
       }

       .row.g-4 {
           gap: 20px 0; /* Adds spacing between stacked cards */
       }

       .card {
           padding: 20px;
       }

       .w-75 {
           width: 90% !important; /* Ensures text fits well on smaller screens */
       }
    }

</style>

<!-- <style>
    @media (max-width: 768px){
        .col-md-6 {
           width: 100%;
       }
    }
</style> -->

<section class="bg-light pt-5 my-3">
    <div class="container text-center">
        <h2 class="fw-bold"> Senior Life Matchings</h2>
        <h3 class="fs-4">– A Special Service for Meaningful Companionship</h3>
        <p class="text-secondary w-75 mx-auto pb-3">
            At Life Matchings, we understand that love and companionship have no age limit.
            That’s why we offer a dedicated Senior Life Matchings service, specially designed for
            individuals seeking a compatible partner later in life.
        </p>
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Side - 2x2 Grid -->
                <div class="col-md-6 mt-5">
                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <div class="card border-0 shadow p-4 text-center h-100">
                                <div class="fs-4 text-danger pb-3"><img src="/public/assets/img/heart1.png" width="50" alt="Heart Icon"></div>
                                <h5 class="fw-bold">Exclusive Matching for Seniors</h5>
                                <p class="text-secondary">Tailored matchmaking for women aged 40+ and men aged 45+.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card border-0 shadow p-4 text-center h-100">
                                <div class="fs-4 text-danger pb-3"><img src="/public/assets/img/heart1.png" width="50" alt="Heart Icon"></div>
                                <h5 class="fw-bold">Personalized Assistance</h5>
                                <p class="text-secondary">Expert guidance to find a partner who shares your values and life goals.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card border-0 shadow p-4 text-center h-100">
                                <div class="fs-4 text-danger pb-3"><img src="/public/assets/img/heart1.png" width="50" alt="Heart Icon"></div>
                                <h5 class="fw-bold">Extra Services & Packages</h5>
                                <p class="text-secondary">Premium matchmaking options for a more refined experience.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card border-0 shadow p-4 text-center h-100">
                                <div class="fs-4 text-danger "><img src="/public/assets/img/heart1.png" width="50" alt="Heart Icon"></div>
                                <h5 class="fw-bold">Privacy & Security</h5>
                                <p class="text-secondary">A trusted and discreet platform to ensure safe and meaningful connections.</p>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Right Side - Image -->
                <div class="col-md-6 text-center mt-5">
                    <img src="/public/assets/img/senior-1.png" alt="Matchmaking Services" class="img-fluid rounded">
                </div>
            </div>
        </div>
        <p class="mt-4 text-secondary">
            Whether you're looking for love, companionship, or a fresh start, Senior Life
            Matchings helps you find the right person for a fulfilling future. Start your journey
            today! 💖
        </p>
    </div>
</section>

<!-- ------------------------------------------------------- -->


<div class="text-center pt-3 pb-5">
    <button type="button" class="btn btn-global" data-bs-toggle="modal" data-bs-target="#popupForm">
        Register the Form
    </button>
</div>

<!-- The Modal -->
<div class="modal fade" id="popupForm" tabindex="-1" aria-labelledby="popupFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupFormLabel">User Details Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" placeholder="Enter your full name">
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob">
                    </div>
                    <div class="mb-3">
                        <label class="form-label d-block">Gender</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                            <label class="form-check-label" for="other">Other</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" rows="2" placeholder="Enter your address"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection



<!-- -------------------------------------------------------------------------------------------------------------------- -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>