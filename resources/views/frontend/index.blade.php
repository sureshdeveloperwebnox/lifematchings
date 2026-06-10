<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
       html, body {
        overflow-x: hidden;
        width: 100%;
       }
    
    .home-slider-area {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        margin-top: 80px;
        z-index: 1;
    }
    .home-slider-area::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4); 
    z-index: 1;
   }

    .text-center-1 {
        position: relative;
        z-index: 2;
    }
    .text-center-1 h1, 
    .text-center-1 p {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8); 
    }
 
    .aiz-carousel img {
        width: 100%;
        height: 100vh;
        object-fit: cover;
    }
    
    .search-box {
        background:rgba(56, 54, 56, 0.67) !important; 
        border-radius: 8px;
        gap: 20px;
        position: relative;
        z-index: 2; 
    }
    
    .search-box select,
    .search-box button {
        height: 45px;
        border-radius: 6px;
        padding: 10px;
    }
    
    /* Make headings bold and stylish */
     .h-light h1 {
         font-family: 'Poppins', sans-serif; /* Use a modern, premium font */
         font-size: 3rem; /* Increase size for emphasis */
         font-weight: 800; /* Extra bold for better impact */
         letter-spacing: 1px; /* Adds elegance */
         text-transform: uppercase; /* Gives a luxury branding feel */
         text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.3); /* Adds depth */
     }
     
     /* Make "Perfect Match" more eye-catching */
     .h-light .h-light-1 {
         font-size: 3.2rem; /* Slightly bigger */
         font-weight: 900; /* Extra bold */
         background: linear-gradient(to right, #bd099d, #2a57d8); /* Gradient effect */
         -webkit-background-clip: text;
         -webkit-text-fill-color: transparent; /* Makes gradient visible */
         text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.36);
     }
     
     /* Improve paragraph styling */
     .h-light-2 {
         font-family: 'Montserrat', sans-serif;
         font-size: 1.2rem;
         font-weight: 600;
         letter-spacing: 0.5px;
         color: #fff !important;
     }
      
    @media (max-width: 992px) {
        .home-slider-area {
            min-height: auto; 
            padding: 20px;
        }
    
        .aiz-carousel img {
            height: auto; 
            object-fit: cover;
        }
    
        .search-box {
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding: 15px;
        }
    
        .search-box select,
        .search-box button {
            flex: 1 1 calc(50% - 10px);
        }
        .text-center-1 h1 {
        font-size: 2.5rem;
      }
      .text-center-1 p {
        font-size: 1rem;
    }
    }

     @media (max-width: 1200px) {
    .home-slider-area {
        min-height: 80vh;
    }
    .aiz-carousel img {
        height: 80vh;
    }
    }

    @media (max-width: 992px) { 
        .home-slider-area {
            min-height: auto;
            padding: 20px;
        }
        .aiz-carousel img {
            height: auto;
        }
        .search-box {
            flex-wrap: wrap;
            gap: 10px;
            padding: 15px;
        }
        .search-box select,
        .search-box button {
            flex: 1 1 45%;
        }
    }

    @media (max-width: 768px) {
        .home-slider-area {
            min-height: 100vh;
            padding: 15px;
        }
        .aiz-carousel img {
            height: 100vh;
        }
        .search-box {
            flex-direction: column;
            align-items: center;
            gap: 12px;
            padding: 10px;
        }
        .search-box select,
        .search-box button {
            width: 100%;
        }
        .text-center h1 {
            font-size: 22px;
        }
        .text-light {
            font-size: 14px;
        }
        .hide {
            display: none;
        }
        .text-center-1 h1 {
        font-size: 2rem;
       }
       .text-center-1 p {
        font-size: 0.9rem;
       }
    }

    @media (max-width: 576px) {
    .text-center-1 h1 {
        font-size: 1.8rem;
    }
    .text-center-1 p {
        font-size: 0.8rem;
    }
}

.home-slider-area .rounded-top {
    position: relative;
    /* z-index: 10; */
    /* border-radius: 20px; */
    background-color: transparent; /* Transparent white */
    /* backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px); For Safari */
    box-shadow: none;
    /* border: 1px solid rgba(255, 255, 255, 0.2); */
    z-index: 10;
}
.home-slider-area {
            overflow: visible !important;
        }
.absolute-full {
    z-index: 1;
}
.form-group .form-label{
  color: white; 
  text-transform: capitalize; 
  font-size: 18px;
  font-weight: 700;
  margin-bottom: 15px;
  /* background-color: 	#4F4F4F; */
  padding: 0px 20px;
  border-radius: 12px;
}

.hero-text {
  font-family: 'Arial', sans-serif;
  color: white;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
  margin-bottom: 20px;
}

.hero-text h1 {
  font-size: 36px;
  font-weight: 700;
  margin: 0;
}

.hero-text .highlight {
  color:rgb(255, 76, 255); /* pinkish highlight */
}

.hero-text .subtext {
  font-size: 16px;
  color: #dcdcdc; /* light gray for subtext */
  margin-top: 10px;
}

</style>


@extends('frontend.layouts.app')
@section('content')

    <!-- Homepage Slider Section -->
    @if (get_setting('show_homepage_slider') == 'on' && get_setting('home_slider_images') != null)
        <section class="position-relative overflow-hidden min-vh-100 d-flex home-slider-area">
            @php 
                $slider_images = json_decode(get_setting('home_slider_images'), true);  
                $slider_images_small = json_decode(get_setting('home_slider_images_small'), true);  
            @endphp
            <div class="absolute-full">
                <div class="aiz-carousel aiz-carousel-full h-100 d-none {{ get_setting('home_slider_images_small') != null ? 'd-md-block' : 'd-block' }}" data-fade='true' data-infinite='true' data-autoplay='true'>
                    @foreach ($slider_images as $key => $slider_image)
                        <img class="img-fit" src="{{ uploaded_asset($slider_image) }}">
                    @endforeach
                </div>
                @if (get_setting('home_slider_images_small') != null)
                    <div class="aiz-carousel aiz-carousel-full h-100 d-md-none" data-fade='true' data-infinite='true' data-autoplay='true'>
                        @foreach ($slider_images_small as $key => $slider_image)
                            <img class="img-fit" src="{{ uploaded_asset($slider_image) }}">
                        @endforeach
                    </div>
                @endif
                <div class="absolute-full bg-white opacity-0 d-md-none"></div>
            </div>  
            @if (Auth::check() && Auth::user()->user_type == 'member')
                    <div class="p-4 rounded-top ">
                    <div class="hero-text">
                      <h1>Find your<br><span class="highlight">Perfect Match here</span></h1>
                    </div>
                        <div class="row">
                            <div class="col-xl-10 mx-auto">
                                <form action="{{ route('member.listing') }}" method="get">
                                    <div class="row gutters-5">
                                        <div class="col-lg">
                                            <div class="form-group mb-3">
                                                <label class="form-label"
                                                    for="name">{{ translate('Age From') }}</label>
                                                <input type="number" name="age_from" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="name">{{ translate('To') }}</label>
                                                <input type="number" name="age_to" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <div class="form-group mb-3">
                                                <label class="form-label"
                                                    for="name">{{ translate('Religion') }}</label>
                                                @php $religions = \App\Models\Religion::all(); @endphp
                                                <select name="religion_id" id="religion_id"
                                                    class="form-control aiz-selectpicker" data-live-search="true"
                                                    data-container="body">
                                                    <option value="">{{ translate('Choose One') }}</option>
                                                    @foreach ($religions as $religion)
                                                        <option value="{{ $religion->id }}"> {{ $religion->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <div class="form-group mb-3">
                                                <label class="form-label"
                                                    for="name">{{ translate('Mother Tongue') }}</label>
                                                @php $mother_tongues = \App\Models\MemberLanguage::all(); @endphp
                                                <select name="mother_tongue" class="form-control aiz-selectpicker"
                                                    data-live-search="true" data-container="body">
                                                    <option value="">{{ translate('Select One') }}</option>
                                                    @foreach ($mother_tongues as $mother_tongue_select)
                                                        <option value="{{ $mother_tongue_select->id }}">
                                                            {{ $mother_tongue_select->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg" style="margin-top: 20px;">
                                            <button type="submit"
                                                class="btn btn-block btn-primary mt-4">{{ translate('Search') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
       
            
        </section>
  
<!-------------------------------------------------------------------------------------  -->
                <!-- search  -->
         

            </div>
        </section>
    @endif

<!-- -------------------------------------------------------------------------------- -->

    <!-- premium member Section
    @if (get_setting('show_premium_member_section') == 'on')
        <section class="pt-7 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3 text-dark">{{ get_setting('premium_member_section_title') }}</h2>
                            <p class="fw-400 fs-16 opacity-60">{{ get_setting('premium_member_section_sub_title') }}</p>
                        </div>
                    </div>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="5" data-xl-items="4" data-lg-items="4"
                    data-md-items="3" data-sm-items="2" data-xs-items="1" data-dots='true' data-infinite='true'>
                    @foreach ($premium_members as $key => $member)
                        <div class="carousel-box">
                            @include('frontend.inc.member_box_1',['member'=>$member])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
 -->
<!-------------------------------------Why Choose Life Matching---------------------------------------------------- -->
<style>
        /* Background Gradient */
        .choose-section {
            background-image: url('/public/assets/img/bg-10 (2).jpg');
            background-repeat: no-repeat;
            color: 	#686868;
            background-size: cover; /* Ensures full width & height coverage */
            background-position: center center; /* Centers the image */
            width: 100%; 
            padding: 60px 0px 40px  0px;
        }
        /* Title Styling */
        .choose-section h2 {
            font-size: 45px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .choose-section h2 span {
            color: #fc00d0;
        }
        /* Card Styling */
        .choose-card {
            background: white;
            color: black;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.18);
            transition: transform 0.3s ease-in-out;
            height: 260px;
            width: 200px;
        }
        .choose-card:hover {
            transform: translateY(-10px);
        }
        .choose-card img {
            width: 90px;
            margin-bottom: 30px;
        }
        .choose-card p{
          font-size: 15px;
        }
        
        @media (max-width: 768px) {
              .choose-section h2{
                font-size: 30px;
        }
              .choose-card{
                  margin-top: 20px;
                  width: 100%;
      }
    }

    

    

</style>
    
<div class="choose-section text-center">
        <div class="container">
            <h2>Why <span>Choose</span> Life Matchings</h2>
            <p class="pb-2 fs-16">Choose us for superior quality matchmaking, AI-driven suggestions, horoscope matching, and verified profiles.</p>
            <div class="row mt-4 mx-auto" style="display: flex; justify-content: center; gap: 30px;">
                <!-- Card 1 -->
                <div class="col-md-2 col-lg-2  mb-3" data-aos="fade-right" data-aos-delay="600">
                    <div class="choose-card">
                        <img src="/public/assets/img/wedding-invitation.png" alt="Community Matches">
                        <p>Get Matches from your Community</p>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-md-2 col-lg-2 mb-3 even-card" data-aos="fade-up-right" data-aos-delay="600">
                    <div class="choose-card">
                        <img src="/public/assets/img/searching.png" alt="Search Barrier">
                        <p>Enable your search without any barrier</p>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-md-2 col-lg-2 mb-3" data-aos="fade-up" data-aos-delay="600">
                    <div class="choose-card">
                        <img src="/public/assets/img/horo.png" alt="Horoscope Matching">
                        <p>Get horoscope matching reports</p>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="col-md-2 col-lg-2 mb-3 even-card" data-aos="fade-up-left" data-aos-delay="600">
                    <div class="choose-card">
                        <img src="/public/assets/img/ai-art.png" alt="AI Matchmaking">
                        <p>AI-driven match recommendations</p>
                    </div>
                </div>
                <!-- Card 5 -->
                <!-- <div class="col-md-2 col-lg-2 mb-3" data-aos="fade-left" data-aos-delay="600">
                    <div class="choose-card">
                        <img src="/public/assets/img/verified.png" alt="Verified Profiles">
                        <p>Profiles with govt ID verified</p>
                    </div>
                </div> -->
            </div>
        </div>
</div>
<!-- --------------------------------------------Benifits of matrimony------------------------------------------------------ -->
<style>
        /* Section Styling */
    .benefits-section {
      background: #ffffff;
      padding-bottom: 60px;
      padding-top: 20px;
    }
    .benefits-section h2 {
      font-weight: bold;
    }
    .benefits-section h2 span {
      color: #9b1578;
    }

    /* Benefit Items */
    .benefit-item {
      display: flex;
      align-items: center;
      gap: 22px;
      margin-bottom: 40px;
      transition: all 0.3s ease-in-out;
    }

  .benifit-item:hover {
    background: #BD099D;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    box-shadow: 3px 3px 5px rgba(54, 51, 51, 0.2);
  }
    .benefit-item img {
      width: 45px;
    }
    .benefit-item p {
      margin: 0;
      font-size: 17px;
    }
   
    /* .highlighted {
      background: #d30047;
      color: white;
      padding: 10px 15px;
      border-radius: 5px;
      box-shadow: 3px 3px 5px rgba(54, 51, 51, 0.2);
    } */

    /* Alternating Left & Right Alignment */
    .left-align {
      flex-direction: row;
      text-align: left;
    }
    .right-align {
      flex-direction: row;
      text-align: right;
    }

    /* .right-img{
      background-image: url("/public/assets/img/Artboard 1.jpg");
    } */

        /* Video Section */
        .video-container {
            position: relative;
            text-align: center;
            border-radius: 10px;
            overflow: hidden;
           
        }
        .video-container img {
            max-width: 100%;
            border-radius: 10px;
        }
        .play-button {
            width: 100px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
           
            padding: 20px;
            border-radius: 50%;
        }
        .sub-title{
          font-size: 18px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .benefit-item {
                flex-direction: row;
            }
            .benefits-section{
              padding-top: 0;
            }
        }
   </style>

<section class="benefits-section">
    <div class="container">
        <div class="row align-items-center">
            
       <!-- Left Side: Benefits List -->
       <div class="col-lg-6">
           <h2><strong>Benefits of the <span>Matrimony</span></strong></h2>
           <p class="sub-title mb-5">Choose us for superior quality services, convenient online ordering, and exceptional customer support.</p>

                   
      <div class="row">
        <!-- Left Column -->
        <div class="col-md-6">
          <div class="benefit-item left-align" data-aos="fade-up" data-aos-delay="200">
            <img src="/public/assets/img/privacy.png" alt="Privacy">
            <p>Complete Privacy</p>
          </div>
          <div class="benefit-item left-align" data-aos="fade-up" data-aos-delay="400">
            <img src="/public/assets/img/notification.png" alt="Notification">
            <p>Notification On Matches</p>
          </div>
          <div class="benefit-item left-align" data-aos="fade-up" data-aos-delay="600">
            <img src="/public/assets/img/verify.png" alt="Verification">
            <p>Verification by personal visits</p>
          </div>
          <div class="benefit-item left-align" data-aos="fade-up" data-aos-delay="800">
            <img src="/public/assets/img/90.png" alt="Additional Services">
            <p>90+ varieties of additional services to book</p>
          </div>
        </div>
        <!-- Right Column -->
        <div class="col-md-6">
          <div class="benefit-item right-align" data-aos="fade-up" data-aos-delay="1000">
            <img src="/public/assets/img/video.png" alt="Video Profile">
            <p>Video Profile Intro</p>
          </div>
          <div class="benefit-item right-align" data-aos="fade-up" data-aos-delay="1200">
            <img src="/public/assets/img/service.png" alt="Manager Services">
            <p>Services of Manager</p>
          </div>
          <div class="benefit-item right-align" data-aos="fade-up" data-aos-delay="1400">
            <img src="/public/assets/img/advanced.png" alt="Filters">
            <p>Advanced filters</p>
          </div>
        </div>
      </div>
        </div>

         <!-- Right Side: Video Preview -->
         <div class="col-lg-6 right-img" data-aos="fade-up" data-aos-delay="200">
            <div class="video-container">
                <img src="/public/assets/img/bg-1.jpg" alt="Wedding Video">
                <div class="play-button">
                    <img src="/public/assets/img/play.png" alt="Play">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ---------------------------------------------Simple Steps Find your Partner---------------------------------------------------------- -->

<!-- <style>
    /* Section Container */
    .steps-section {
      background: #fff;
      padding: 60px 0;
    }

    .steps-section h2 {
      font-weight: bold;
      font-size: 45px;
    }

    /* Optional color highlight for a key word in the heading */
    .steps-section h2 span {
      color: #9b1578;
    }

    .steps-section p.subtitle {
      max-width: 600px;
      font-size: 17px;
      margin: 0 auto 40px auto;
      color: #666;
    }

    /* Step Items */
    .step-item {
      position: relative;
      text-align: center;
      margin-bottom: 30px;
    }

    /* Circle Container */
    .step-circle {
      width: 250px;
      height: 250px;
      background-color: #BD099D; /* Circle color */
      border-radius: 50%;
      margin: 0 auto 15px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* Circle Icon */
    .step-circle img {

      width: 60px; /* Adjust as needed */
      filter: brightness(0) invert(1);
      position: absolute;
      margin-bottom: 50px;
       /* Make icon white if it's dark */
      
    }

    /* Step Title */
    .step-item h4 {
      font-size: 15px;
      font-weight: 500;
      margin-top: 50px;
      color: #fff;
    }

    /* Step Description */
    .step-item p {
      color: #666;
      margin: 0;
      font-size: 0.95rem;
      line-height: 1.4;
    }

    /* Horizontal Connector (Optional) on large screens */
    @media (min-width: 992px) {
      .steps-row {
        position: relative;
      }
      .step-item:not(:last-child)::after {
        content: "";
        position: absolute;
        top: 50%;
        right: -50%;
        width: 100%;
        height: 2px;
        background: #9b1578;
        transform: translateY(-50%);
        z-index: -1;
      }
    }
  </style> -->

<!-- <section class="steps-section">
  <div class="container">
   
    <h2 class="text-center">Simple Steps <span>Find Your Partner</span></h2>
    <p class="subtitle text-center">
      Lorem Ipsum is simply dummy text of the printing and typesetting industry.
      Lorem Ipsum is simply dummy text of the printing and typesetting industry.
    </p>

    
    <div class="row steps-row justify-content-center">
      
      <div class="col-lg-3 col-md-6 step-item">
        <div class="step-circle">
          <img src="/public/assets/img/Gro up.png" alt="Step 1 Icon" />
          <h4>Create Your Profile</h4>
        </div>
        <p>
          Just fill basic details & access the huge database of Brides/Grooms
        </p>
      </div>

      
      <div class="col-lg-3 col-md-6 step-item">
        <div class="step-circle">
          <img src="/public/assets/img/Grohup.png" alt="Step 2 Icon" />
          <h4>Set Partner Preference</h4>
        </div>
        <p>
          Set your partner preference & let us match your requirement with others
        </p>
      </div>

      
      <div class="col-lg-3 col-md-6 step-item">
        <div class="step-circle">
          <img src="/public/assets/img/gVector.png" alt="Step 3 Icon" />
          <h4>Receive Matching Profiles</h4>
        </div>
        <p>
          Receive matching profiles daily as per your set partner preference
        </p>
      </div>


      <div class="col-lg-3 col-md-6 step-item">
        <div class="step-circle">
          <img src="/public/assets/img/Grogup.png" alt="Step 4 Icon" />
          <h4>Send/Receive interest & Calls</h4>
        </div>
        <p>
          Send/receive interest to suitable profiles and connect instantly
        </p>
      </div>
    </div>
  </div>
</section> -->

<style>
  .steps-section {
    padding: 50px 0;
    background: #f9f9f9;
  }
  .steps-section h2 {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 10px;
  }
  .steps-section .subtitle {
    font-size: 16px;
    color: #666;
    margin-bottom: 30px;
  }
  .step-item {
    text-align: center;
    margin-bottom: 30px;
  }

  /* Step Circle Wrapper */
  .step-circle {
    width: 250px;
    height: 250px;
    position: relative;
    perspective: 1000px;
    margin: 0 auto 15px;
  }

  /* Front & Back Faces */
  .step-front, .step-back {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    position: absolute;
    top: 0;
    left: 0;
    backface-visibility: hidden;
    transition: transform 0.6s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Front Side */
  .step-front {
    background-size: cover;
    background-position: center;
    transform: rotateY(0deg);
  }

  .step-front img {
    width: 50px;
    height: 50px;
  }

  /* Back Side with Black Background */
  .step-back {
    background:rgba(190, 56, 168, 0.89);
    transform: rotateY(180deg);
  }

  .step-back img {
    width: 80px; /* Adjust size as needed */
    height: 80px;
  }

  /* Hover Effect */
  .step-circle:hover .step-front {
    transform: rotateY(180deg);
  }

  .step-circle:hover .step-back {
    transform: rotateY(0deg);
  }

  .step-item h4 {
    padding: 12px;
    font-size: 16px;
    font-weight: 500;
    color: #ffff;
  }
  .step-item p {
    font-size: 15px;
    color: #555;
    margin-top: 20px;
  }
  .step-back img{
    color: #ffff;
  }
</style>

<section class="steps-section">
  <div class="container">
    <h2 class="text-center">Simple Steps <span>Find Your Partner</span></h2>
    <p class="subtitle text-center mb-5">
    Discover a seamless and personalized matchmaking experience designed <br>
    to help you find your ideal life partner with ease.
    </p>

    <div class="row steps-row justify-content-center">
      <!-- Step 1 -->
      <div class="col-lg-3 col-md-6 step-item">
        <div class="step-circle">
          <div class="step-front" style="background-image: url('/public/assets/img/marriage-1.png');">
          <h4>Create Your Profile</h4>
          </div>
          <div class="step-back">
          <img src="/public/assets/img/Gro up.png" alt="">
          </div>
        </div>
        <p>Complete your profile with essential details and become part of a vast community of like-minded individuals.</p>
      </div>

      <!-- Step 2 -->
      <div class="col-lg-3 col-md-6 step-item"> 
        <div class="step-circle">
          <div class="step-front" style="background-image: url('/public/assets/img/marriage-2.png');">
          <h4>Set Partner Preference</h4>
          </div>
          <div class="step-back">
            <img src="/public/assets/img/Grohup.png" alt="">
          </div>
        </div>
        <p>Define your ideal match criteria, and let our advanced system find the best potential matches for you.</p>
      </div>

      <!-- Step 3 -->
      <div class="col-lg-3 col-md-6 step-item">
        <div class="step-circle">
          <div class="step-front" style="background-image: url('/public/assets/img/marriage-3.png');">
          <h4>Receive Matching Profiles</h4>
          </div>
          <div class="step-back">
            <img src="/public/assets/img/gVector.png" alt="">
          </div>
        </div>
        <p>Get daily recommendations based on your preferences, ensuring the best compatibility for a successful relationship.</p>
      </div>

      <!-- Step 4 -->
      <div class="col-lg-3 col-md-6 step-item">
        <div class="step-circle">
          <div class="step-front" style="background-image: url('/public/assets/img/marriage-4.png');">
          <h4>Send/Receive interest & Calls</h4>
          </div>
          <div class="step-back">
            <img src="/public/assets/img/Grogup.png" alt="">
          </div>
        </div>
        <p>Express your interest, communicate with potential matches, and take the next step towards a lifelong connection.</p>
      </div>
    </div>
  </div>
</section>



<!-- --------------------------------------------Life Partner------------------------------------------------------------ -->

<style>
     .app-download-section{
         color: #fff;
         width: 100%;
         background-repeat: no-repeat;
         background-position: center;
         background-size: cover;
    }
    .app-download-section .info-text {
      padding: 60px 90px;

    }
    .app-download-section .info-text h1 {
      font-weight: 700;
      font-size: 2rem;
    }
    .app-download-section .info-text span {
      color: #ffd700; /* Highlight color */
    }
    .app-download-section .info-text p {
      margin: 20px 0;
      max-width: 800px;
    }
    /* Store badges styling (adjust width as needed) */
    .store-badges img {
      width: 150px;
      height: 50px;
    }
    /* Right side (phone image) styling */
    .phone-mockup {
      /* background: #fff;  */
      text-align: center;
      padding: 60px 30px;
    }
    .phone-mockup img {
      max-width: 100%;
      height: auto;
    }
    .info-text{
      font-size: 16px;
    }
    .img-fluid{
      width: 300px;
  
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .app-download-section .info-text,
      .phone-mockup {
        padding: 30px;
      }
      .app-download-section img{
        margin-left: -20px;
      }
    }
    
  </style>

<section class="app-download-section" style="background-image: url('/public/assets/img/bg-11.jpg');">    
  <div class="container-fluid">
    <div class="row">
      <!-- Left: Text & Store Badges -->
      <div class="col-lg-8 info-text d-flex flex-column justify-content-center">
        <h1>Life Partner, Download Our App <span>Today!</span></h1>
        <p class="mb-0">
        Discover seamless matchmaking with Life Matchings. Our app connects you with compatible partners through advanced matchmaking algorithms, secure communication, and personalized recommendations. 
        </p>
        <p class="mt-2">
        Find your life partner effortlessly with our intuitive and easy-to-use platform. Join thousands of happy users who have found meaningful connections!
        </p>
        <div class="store-badges d-flex flex-wrap gap-3">
          <!-- Replace with your actual store badge images/links -->
          <a href="#" style="margin-left: 20px;">
            <img src="/public/assets/img/play_store.png" alt="Get it on Google Play" />
          </a>
          <a href="#" style="margin-left: 20px;">
            <img src="/public/assets/img/app_store.png" alt="Download on the App Store" />
          </a>
        </div>
      </div>

      <!-- Right: Phone Mockup -->
      <div class="col-lg-4 phone-mockup d-flex align-items-center justify-content-center">
        <!-- Replace with your actual phone mockup image -->
        <img
          src="/public/assets/img/mobile.jpg"
          alt="Life Matchings App Mockup"
          class="img-fluid"
        />
      </div>
    </div>
  </div>
</section>

<!-- ------------------------------------------Hear What our satisfied----------------------------------------------------------- -->

<style>
    /* Section Styling */
    .testimonial-section {
      background-color: #fff;
      padding-top: 60px;
    }

    .testimonial-section h2 {
      font-weight: bold;
      margin-bottom: 20px;
      color: #333;
    }
    .testimonial-section h2 span {
      color: #9b1578; /* Optional highlight color */
    }

    /* Quote & Author */
    blockquote {
      font-size: 1.1rem;
      line-height: 1.6;
      color: #555;
      position: relative;
      padding-left: 1rem;
      margin-left: 0;
      border-left: 4px solid #9b1578; /* Decorative left border */
    }
    .blockquote-footer {
      margin-top: 15px;
      color: #666;
      font-size: 0.9rem;
    }

    /* World Map & Pins */
    .map-container {
      position: relative;
      text-align: center;
    }
    .map-container img {
      width: 100%;
      height: auto;
      border-radius: 5px;
    }
    .map-pin {
      position: absolute;
      transform: translate(-50%, -50%);
      border: 3px solid #fff;
      border-radius: 50%;
      overflow: hidden;
      width: 50px;
      height: 50px;
    }
    .map-pin img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Adjust pin positions as needed */
    .pin-1 {
      top: 30%;
      left: 35%;
    }
    .pin-2 {
      top: 50%;
      left: 70%;
    }
    footer img{
      width: 50px;
      height: 45px;
      padding-right: 20px;
      border-radius: 10px;
    }
    /* Add more pins if desired */

    /* Responsive Tweaks */
    @media (max-width: 768px) {
      blockquote {
        margin-top: 20px;
        border-left: 4px solid #9b1578;
      }
    }
  </style>

<section class="testimonial-section">
  <div class="container">
    <div class="row align-items-center">
      <!-- Left Column: Headline & Testimonial -->
      <div class="col-md-6 mb-4 mb-md-0">
        <h2>
          Hear What Our Satisfied <span>Customers</span> Have to Say!
        </h2>
        <blockquote class="blockquote">
          <p>
            <!--"I couldn't be happier with my purchase from Life Matchings.-->
            <!--The quality and craftsmanship of the furniture are truly-->
            <!--outstanding. Every time I walk into my living room, I'm reminded-->
            <!--of the great decision I made."-->
            "Life Matchings exceeded my expectations!
            The quality, attention to detail, and elegance of the product completely transformed my space.
            Every guest that walks in compliments my choice — it truly feels like a reflection of me."
          </p>
          <!--<footer class="blockquote-footer d-flex">-->
          <!--<img src="/public/assets/img/avatar-place.png" alt="">-->
          <!-- <div>-->
          <!--  <strong>Cornelia Carter</strong><br />-->
          <!--  <span>Senior Marketing Manager</span>-->
          <!-- </div>-->
          <!--</footer>-->
        </blockquote>
      </div>

      <!-- Right Column: World Map with Pins -->
      <div class="col-md-6 map-container">
        <!-- Replace with your own world map image -->
        <img
          src="/public/assets/img/map.png"
          alt="World Map"
          class="img-fluid"
        />
        <!-- Example pins (replace images & positions) -->
        <!-- <div class="map-pin pin-1">
          <img
            src="user1.jpg"
            alt="User Photo"
          />
        </div>
        <div class="map-pin pin-2">
          <img
            src="user2.jpg"
            alt="User Photo"
          />
        </div> -->
      </div>
    </div>
  </div>
</section>

<!-- -----------------------------------------Packages--------------------------------------------------------- -->


<!-- <style>
   /* Background Gradient */
  .pricing-section {
     /* background: linear-gradient(90deg, hsla(341, 94%, 49%, 1) 0%, hsla(16, 90%, 77%, 1) 100%); */
     background: url('/public/assets/img/copy-space-engagement-rings.jpg') no-repeat center center;
     background-size: cover;
     padding: 60px 0;
     /* margin-bottom: 80px; */
     overflow: hidden;
 }
 
 /* Title Styling */
 .pricing-section h2, 
 .pricing-section h3 {
    font-weight: bold;
    text-align: center;
 }
 
 .pricing-section h3 {
     font-size: 22px;
 }
 
 /* Button Styling */
 .btn-outline-light {
     border: 2px solid #BD099D;
     color: #BD099D;
     font-size: 16px;
     border-radius: 25px;
     padding: 10px 20px;
 }
 
 .btn-outline-light:hover {
     background: white;
     color: #b31217;
     border: 2px solid #b31217;
 }
 
 /* Pricing Cards */
 .pricing-card {
     text-align: center;
     background: white;
     border-radius: 15px;
    overflow: visible;
     box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
     transition: transform 0.3s ease-in-out;
     /* margin-bottom: 20px; */
    margin-bottom: 20px;
     /* display: flex;
     justify-content: center; */
 
 }
 
 /* .pricing-card:hover {
     transform: translateY(-5px);
 } */
 
.pricing-header {
    z-index: 2;
    min-width: 180px;
    max-width: 260px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    background: #d9d9d9;
    font-size: 18px;
    font-weight: 800;
    position: absolute;
    top: -40px;
    padding: 12px 24px;
    border-radius: 12px;
    left: 50%;
    transform: translateX(-50%);
    color: #000000;
}
 
 .pricing-body {
     color: white;
     padding: 70px 0;
     font-size: 22px;
     font-weight: bold;
     border-radius: 0 0 15px 15px;
 }
 
 .btn-package {
     background: #ff0080;
     color: #fff;
     border: none;
     font-size: 12px;
     padding: 12px 20px;
     transition: 0.3s;
     border-radius:12px;
 }
 
 .gold {
     background: linear-gradient(to bottom, #ffcc00, #ff9900);
 }
 
 .diamond {
     background: linear-gradient(to bottom, #e52d27, #b31217);
 }
 
 .platinum {
     background: linear-gradient(to bottom, #a200ff, #7700cc);
 }
 
 .vip {
     background: linear-gradient(to bottom, #5a008a, #3a0061);
 }

/* Horizontal scroller for pricing */
.pricing-scroller {
    display: flex;
    gap: 24px;
    overflow-x: auto;
    padding: 24px 4px 12px 4px;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
}
.pricing-scroller::-webkit-scrollbar { height: 8px; }
.pricing-scroller::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.15); border-radius: 4px; }
.pricing-item { flex: 0 0 360px; scroll-snap-align: start; position: relative; }
.pricing-card { position: relative; }
.pricing-body h2 { font-size: 36px; margin-bottom: 6px; font-weight: 900; }
.pricing-body p { margin-bottom: 16px; font-weight: 700; opacity: 0.95; }

 @media (max-width: 768px) {
     .pricing-card{
         display: inline;
      }
     .s-package{
         margin-top: 100px;
      } 
      .s-padding{
         padding: 0px;
      }
   }
  
   @media (max-width: 576px) {
      .pricing-card{
         display: inline;
      }
      .s-package{
         margin-top: 100px;
      } 
      .s-padding{
         padding: 0px;
      }
   }    

</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var scroller = document.querySelector('.pricing-scroller');
    if (!scroller) return;

    var isHovering = false;
    var speed = 0.6; // pixels per frame
    var rafId;

    function step() {
      if (!isHovering) {
        scroller.scrollLeft += speed;
        // loop seamlessly
        if (scroller.scrollLeft + scroller.clientWidth >= scroller.scrollWidth - 1) {
          scroller.scrollLeft = 0;
        }
      }
      rafId = requestAnimationFrame(step);
    }

    scroller.addEventListener('mouseenter', function(){ isHovering = true; });
    scroller.addEventListener('mouseleave', function(){ isHovering = false; });
    scroller.addEventListener('touchstart', function(){ isHovering = true; }, {passive:true});
    scroller.addEventListener('touchend', function(){ isHovering = false; }, {passive:true});

    step();
  });
</script>

@if (get_setting('show_homapege_package_section') == 'on')
<section class="pb-6 pricing-section">
    <div class="container text-center">
        <h2 class="fw-bold fs-16 text" >Curated Pricing Packages to</h2>
        <h1 class="text-dark">Choose based on your needs</h1>
        <a href="https://lifematchings.com/packages" class="btn btn-outline-light mt-3 px-4 py-2 rounded-pill">View More Details</a>

        <div class="pricing-scroller mt-5 pt-6 pb-6 s-padding">
            @foreach (\App\Models\Package::where('active', '1')->get() as $key => $package)
                <div class="pricing-item s-package" data-aos="fade-up" 
                data-aos-delay="{{ $loop->index * 200 }}">
                    <div class="pricing-card">
                        <div class="pricing-header">{{ $package->name }}</div>
                        <div class="pricing-body vip">
                            @if ($package->id == 1)
                                <h2>{{ translate('Free') }}</h2>
                            @else
                                <h2>{{ single_price($package->price) }}</h2>
                            @endif
                            <p>For {{ $package->validity }} Days</p>
                            @if (Auth::check())
                                <a href="{{ route('package_payment_methods', encrypt($package->id)) }}"
                                    class="btn btn-package w-60">Purchase This Package</a>
                            @else
                                <button type="button" onclick="loginModal()" class=" btn-package w-4">
                                    Purchase This Package
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif -->




<!-- ------------------------------------------------------------------------------>

    <!-- @if (get_setting('show_homapege_package_section') == 'on')
        <section class="py-7 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center pb-6">
                            <h2 class="fw-600 text-dark">{{ get_setting('homepage_package_section_title') }}</h2>
                            <div class="fs-16 fw-400">{{ get_setting('homepage_package_section_sub_title') }}</div>
                        </div>
                    </div>
                </div>
                <div class="aiz-carousel" data-items="4" data-xl-items="3" data-md-items="2" data-sm-items="1"
                    data-dots='true' data-infinite='true' data-autoplay='true'>
                    @foreach (\App\Models\Package::where('active', '1')->get() as $key => $package)
                        <div class="carousel-box">
                            <div class="overflow-hidden shadow-none mb-3 border-right">
                                <div class="card-body">
                                    <div class="text-center mb-4 mt-3">
                                        <img class="mw-100 mx-auto mb-4" src="{{ uploaded_asset($package->image) }}"
                                            height="130">
                                        <h5 class="mb-3 h5 fw-600">{{ $package->name }}</h5>
                                    </div>
                                    <div class="mb-5 text-dark text-center">
                                        @if ($package->id == 1)
                                            <span class="display-4 fw-600 lh-1 mb-0">{{ translate('Free') }}</span>
                                        @else
                                            <span
                                                class="display-4 fw-600 lh-1 mb-0">{{ single_price($package->price) }}</span>
                                        @endif
                                        <span class="text-secondary d-block">{{ $package->validity }}
                                            {{ translate('Months') }}</span>
                                    </div>
                                    <div class="text-center mb-3">
                                        @if (Auth::check())
                                            <a href="{{ route('package_payment_methods', encrypt($package->id)) }}"
                                                type="submit"
                                                class="btn btn-primary">{{ translate('Purchase This Package') }}</a>
                                        @else
                                            <button type="submit" onclick="loginModal()"
                                                class="btn btn-primary">{{ translate('Purchase This Package') }}</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif -->


    <style>
/* Background Section */
.pricing-section {
  background: url('/public/assets/img/copy-space-engagement-rings.jpg') no-repeat center center;
  background-size: cover;
  padding: 60px 0;
  overflow: hidden;
}

/* Section Title */
.pricing-section h2, 
.pricing-section h1 {
  font-weight: bold;
  text-align: center;
}

/* Pricing Card */
.pricing-card {
  text-align: center;
  background: white;
  border-radius: 15px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
  transition: transform 0.3s ease-in-out;
  margin-bottom: 20px;
  position: relative;
}

.pricing-header {
  z-index: 2;
  min-width: 220px;
  min-height: 80px;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #d9d9d9;
  font-size: 18px;
  font-weight: 800;
  position: absolute;
  top: -20px;
  padding: 12px 24px;
  border-radius:12px 12px 0px 0px;
  left: 50%;
  transform: translateX(-50%);
  color: #000;
}

.pricing-body {
  color: white;
  padding: 70px 0;
  font-size: 22px;
  font-weight: bold;
  border-radius: 0 0 15px 15px;
}

.pricing-body h2 { 
  font-size: 36px; 
  margin-bottom: 6px; 
  font-weight: 900; 
}
.pricing-body p { 
  margin-bottom: 16px; 
  font-weight: 700; 
  opacity: 0.95; 
}

.btn-package {
  background: #ff0080;
  color: #fff;
  border: none;
  font-size: 14px;
  padding: 12px 20px;
  border-radius: 12px;
  transition: 0.3s;
}
.btn-package:hover { background: #d60067; }

/* Gradient Backgrounds */
.gold { background: linear-gradient(to bottom, #ffcc00, #ff9900); }
.diamond { background: linear-gradient(to bottom, #e52d27, #b31217); }
.platinum { background: linear-gradient(to bottom, #0072ff, #0041a8); }
.vip { background: linear-gradient(to bottom, #5a008a, #3a0061); }

/* Horizontal Scroll */
.pricing-scroller {
  display: flex;
  gap: 24px;
  overflow-x: auto;
  padding: 24px 4px 12px 4px;
  /* scroll-snap-type: x mandatory; */
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
  cursor: grab;    
}
.pricing-scroller:active {
  cursor: grabbing;
}
.pricing-scroller::-webkit-scrollbar { height: 8px; }
.pricing-scroller::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.15); border-radius: 4px; }
.pricing-item { flex: 0 0 360px; scroll-snap-align: start; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var scroller = document.querySelector('.pricing-scroller');
  if (!scroller) return;

  var isHovering = false;
  var speed = 0.8;
  var rafId;

  function step() {
    if (!isHovering) {
      scroller.scrollLeft += speed;
      if (scroller.scrollLeft + scroller.clientWidth >= scroller.scrollWidth - 1) {
        scroller.scrollLeft = 0;
      }
    }
    rafId = requestAnimationFrame(step);
  }

  scroller.addEventListener('mouseenter', () => isHovering = true);
  scroller.addEventListener('mouseleave', () => isHovering = false);
  scroller.addEventListener('touchstart', () => isHovering = true, {passive:true});
  scroller.addEventListener('touchend', () => isHovering = false, {passive:true});

  step();
});
</script>

@if (get_setting('show_homapege_package_section') == 'on')
<section class="pb-6 pricing-section">
  <div class="container text-center">
    <h2>Curated Pricing Packages to</h2>
    <h1 class="text-dark">Choose based on your needs</h1>
    <a href="https://lifematchings.com/packages" class="btn btn-outline-light mt-3">View More Details</a>

    <div class="pricing-scroller mt-5">
      @foreach (\App\Models\Package::where('active', '1')->get() as $key => $package)
        <div class="pricing-item">
          <div class="pricing-card">
            <div class="pricing-header">{{ $package->name }}</div>
            <div class="pricing-body 
              {{ $loop->index % 4 == 0 ? 'gold' : ($loop->index % 4 == 1 ? 'diamond' : ($loop->index % 4 == 2 ? 'platinum' : 'vip')) }}">
              @if ($package->id == 1)
                <h2>{{ translate('Free') }}</h2>
              @else
                <h2>{{ single_price($package->price) }}</h2>
              @endif
              <p>For {{ $package->validity }} Days</p>
                @if (Auth::check())
                  <a href="{{ route('package_payment_methods', encrypt($package->id)) }}" class="btn btn-package">
                    Purchase This Package
                  </a>
                @else
                  <button type="button" onclick="loginModal()" class="btn btn-package">
                    Purchase This Package
                  </button>
                @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- ----------------------------------------Premium Service to------------------------------------------------------------------- -->

<style>
    .premium-banner {
      padding: 60px 20px;
      color: #fff;
      text-align: center;
      position: relative;
      height: 350px;
      background-position: center center;
    }
    .premium-banner h1 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 10px;
    }
    .premium-banner p {
      max-width: 600px;
      margin: 0 auto;
      font-size: 1rem;
    }

    /* Card Wrapper - to overlap the banner */
    .card-wrapper {
      position: relative;
      margin-top: -100px; /* Pull the card up over the banner */
      z-index: 2;        /* Ensure it appears above the banner */
    }

    /* Tabs Card */
    .tabs-card {
      border-radius: 10px;
      overflow: hidden;
    }
    .tabs-card .nav-tabs {
      background-color: #BD099D;
      border: none;
      border-radius: 0;
      justify-content: center;
      padding: 20px;
    }
    .tabs-card .nav-tabs .nav-link {
      background-color: #BD099D;
      color: #fff;
      border: none;
      border-radius: 0;
      padding: 15px 20px;
      font-size:16px;
      font-weight: 600;
     
    }
    .tabs-card .nav-tabs .nav-link.active {
      background-color: #fff;
      color: #BD099D;
    }
    /* Content inside the card */
    .tab-content {
      background-color: #fff;
      padding: 30px;
    }
    .tab-content h3 {
      color: #BD099D;
      margin-bottom: 15px;
      font-weight: 700;
    }
    .tab-content p {
      color: #555;
      font-size: 0.95rem;
      line-height: 1.5;
      margin-bottom: 20px;
    }
    .tab-content img {
      max-width: 100%;
      border-radius: 5px;
    }
    .buy-now-btn {
      background-color: #BD099D;
      color: #fff;
      border: none;
      border-radius: 25px;
      padding: 10px 30px;
    }
    .buy-now-btn:hover {
      background-color: #6a0572;
    }
    .tab-columns img{
      width: 400px;
      height: 300px;
    }

    @media (min-width: 768px) {
     .tab-columns img{
      width: 400px;
      height: 300px;
    }
  }  
               
  @media (max-width: 576px) {
     .card-wrapper{
        margin-top: -30px;
     }
     .tab-columns img{
      width: 400px;
      height: 250px;
    }
    .tabs-card{
      margin-top: 30px;
    }
    .tabs-card .nav-tabs .nav-link{
      font-size: 13px;
    }
  }    
</style>


<section class="premium-banner"  style="background-image: url('/public/assets/img/bg-3.jpg');">
  <div class="container">
    <h1>Premium Services to Find Your Partner at ease</h1>
    <p>
    Experience a hassle-free and personalized matchmaking journey with our exclusive services. We bring you verified profiles, smart compatibility checks, and expert guidance to help you find your ideal life partner.
    </p>
  </div>
</section>
 
<!-- Tabs Card Section -->
<div class="card-wrapper pb-5">
  <div class="container">
    <div class="card shadow tabs-card">
      <!-- Tabs (Nav) -->
      <ul class="nav nav-tabs nav-fill" id="serviceTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button
            class="nav-link active"
            id="wedding-date-tab"
            data-bs-toggle="tab"
            data-bs-target="#wedding-date"
            type="button"
            role="tab"
            aria-controls="wedding-date"
            aria-selected="true"
          >
            Wedding Date
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            id="match-senior-tab"
            data-bs-toggle="tab"
            data-bs-target="#match-senior"
            type="button"
            role="tab"
            aria-controls="match-senior"
            aria-selected="false"
          >
            Match for Senior
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            id="pre-wedding-tab"
            data-bs-toggle="tab"
            data-bs-target="#pre-wedding"
            type="button"
            role="tab"
            aria-controls="pre-wedding"
            aria-selected="false"
          >
            Pre Wedding
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link"
            id="post-wedding-tab"
            data-bs-toggle="tab"
            data-bs-target="#post-wedding"
            type="button"
            role="tab"
            aria-controls="post-wedding"
            aria-selected="false"
          >
            Post Wedding
          </button>
        </li>
      </ul>

      <!-- Tabs Content -->
      <div class="tab-content" id="serviceTabsContent">
        <!-- Wedding Date Content -->
        <div
          class="tab-pane fade show active tab-columns"
          id="wedding-date"
          role="tabpanel"
          aria-labelledby="wedding-date-tab"
        >
          <div class="row align-items-center">
            <div class="col-md-4 mb-3 mb-md-0">
              <!-- Replace with your own image -->
              <img
                src="/public/assets/img/wedding-date.jpg"
                alt="Wedding Date Book"
              />
            </div>
            <div class="col-md-8">
              <h3>Wedding Date Book</h3>
              <p>
              Mark the most special day of your life with ease! Our Wedding Date Booking service helps you find the perfect date based on astrology, availability, and cultural preferences, ensuring a beautiful and harmonious beginning to your journey together.
              <br>
              <br>
              📅 Plan your dream wedding with confidence!
              </p>
              <a href="https://lifematchings.com/packages" class="buy-now-btn btn-global text-white">Buy Now</a>
            </div>
          </div>
        </div>

        <!-- Match for Senior Content -->
        <div
          class="tab-pane fade tab-columns"
          id="match-senior"
          role="tabpanel"
          aria-labelledby="match-senior-tab"
        >
        <div class="row align-items-center">
            <div class="col-md-4 mb-3 mb-md-0">
              <!-- Replace with your own image -->
              <img
                src="/public/assets/img/match-of-senior.jpg"
                alt="Wedding Date Book"
              />
            </div>
            <div class="col-md-8">
              <h3>Match for Senior</h3>
              <p>
              Love has no age! Our Senior Matchmaking service is dedicated to helping mature individuals find companionship, love, and meaningful relationships. Whether you're looking for friendship or a life partner, we make the journey simple and fulfilling.
              <br>
              <br>
              💖 Rediscover love and companionship today!
              </p>
              <a href="https://lifematchings.com/packages" class="buy-now-btn btn-global text-white">Buy Now</a>
            </div>
          </div>
        </div>

        <!-- Pre Wedding Content -->
        <div
          class="tab-pane fade tab-columns"
          id="pre-wedding"
          role="tabpanel"
          aria-labelledby="pre-wedding-tab"
        >
        <div class="row align-items-center">
            <div class="col-md-4 mb-3 mb-md-0">
              <!-- Replace with your own image -->
              <img
                src="/public/assets/img/prewedding.jpg"
                alt="Wedding Date Book"
              />
            </div>
            <div class="col-md-8">
              <h3>Pre Wedding</h3>
              <p>
              Begin your forever with moments you'll never forget. Our Pre-Wedding Services offer elegant photoshoots, personalized engagement planning, seamless event coordination, and unforgettable experiences designed to capture your love story.
              <br>
              <br>
              📸 Let us help you tell your love story—beautifully, authentically, and timelessly.
              </p>
              <a href="https://lifematchings.com/packages" class="buy-now-btn btn-global text-white">Buy Now</a>
            </div>
          </div>
        </div>

        <!-- Post Wedding Content -->
        <div
          class="tab-pane fade tab-columns"
          id="post-wedding"
          role="tabpanel"
          aria-labelledby="post-wedding-tab"
        >
        <div class="row align-items-center">
            <div class="col-md-4 mb-3 mb-md-0">
              <!-- Replace with your own image -->
              <img
                src="/public/assets/img/postwedding.jpg"
                alt="Wedding Date Book"
              />
            </div>
            <div class="col-md-8">
              <h3>Post Wedding</h3>
              <p>
              Step into your new journey with confidence and joy. Our Post-Wedding Services are here to support you with honeymoon planning, name change guidance, financial planning, and smooth family integration—everything you need for a seamless start to married life.
              <br>
              <br>
              💑 Begin your forever with peace of mind and a heart full of happiness.
              </p>
              <a href="https://lifematchings.com/packages" class="buy-now-btn btn-global text-white">Buy Now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.js"></script>

<!-- ----------------------------------------------Need to Assistance-------------------------------------------------------------- -->

<style>
    /* Minimal CSS for background */
    .assistance-bg {
      /* If you have a mandala or pattern image, use it below */
      background: url("/public/assets/img/bg-4.png") center center / cover no-repeat;
      /* Fallback color if image fails to load */
    }
    .btn-global{
        background-size: 100% 100%;
        background-position: 0px 0px;
        background-image: linear-gradient(90deg, #FD00D1 0%, #71C4FFFF 100%);
        color: #fff;
    }
    
  </style>

<section class="assistance-bg py-5">
  <div class="container">
    <h2 class="text-center fw-bold mb-4">Need Assistance in <span class="text-primary">Making Payment</span></h2>
    <div class="row g-4">
      
      <!-- Left Column: Call-Back Form -->
      <div class="col-md-6">
        <div class="card border-0 shadow h-100">
          <div class="card-body text-center">
            <!-- Icon (replace with your own) -->
            <div class="mb-3">
              <img
                src="/public/assets/img/mail.png"
                alt="Mail Icon"
                class="img-fluid"
                style="max-width: 80px;"
              />
            </div>
            <p class="fw-semibold fs-16">
              Enter your contact number here, we will call you back
            </p>
            <!-- Input Group for Phone Number -->
            <div class="input-group my-3 w-75 mx-auto">
              <input
                type="tel"
                class="form-control"
                placeholder="+91 XXXXX XXXXX"
                aria-label="Phone Number"
              />
              <button class="btn btn-global" type="button">Submit</button>
            </div>
            <small class="text-muted fs-14">
              Mention STD code for landline number
            </small>
          </div>
        </div>
      </div>
      
      <!-- Right Column: Call Us Info -->
      <div class="col-md-6">
        <div class="card border-0 shadow h-100">
          <div class="card-body text-center">
            <!-- Icon (replace with your own) -->
            <div class="mb-3">
              <img
                src="/public/assets/img/call.png"
                alt="Phone Icon"
                class="img-fluid"
                style="max-width: 80px;"
              />
            </div>
            <p class="fw-semibold fs-16">
              Call Us at <br />
              <span class="fw-bold fs-5">+91 99411 61613</span>
            </p>
            <small class="text-muted d-block mb-3 fs-14">24/7 Payment Assistance</small>
             <a href="https://lifematchings.com/packages" class="buy-now-btn btn-global text-white">Buy Now</a>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</section>

<!-- --------------------------------------------------------------------------------------------------------------- -->
/* 
<style>

        .category{
            background: url('/public/assets/img/couple-love-kissing-holding-hands-together-sunset-sky.jpg') no-repeat center center;
            background-size: cover;
            padding: 50px;
        }
        .custom-box {
          
            padding: 60px;
            color: #ffff;
            text-align: center;
            border: 1px solid #ffff;
            background-color:rgba(73, 73, 73, 0.46);
            
        }
        .category p{
          font-size: 15px;
        }
        .category h4{
          color: #BD099D;
          margin-bottom: 10px;
        }
</style> */
<style>
    .category {
        background: url('/public/assets/img/couple-love-kissing-holding-hands-together-sunset-sky.jpg') no-repeat top center;
        background-size: cover; /* Ensures the image covers the section */
        background-attachment: fixed; /* Keeps background stable while scrolling (optional) */
        padding: 50px;
        width: 100%; /* Ensures full width */
        height: auto; /* Adjusts height dynamically */
    }

    .custom-box {
        padding: 60px;
        color: #ffffff;
        text-align: center;
        border: 1px solid #ffffff;
        background-color: rgba(73, 73, 73, 0.46);
    }

    /* Improve text readability */
    .category p {
        font-size: 16px;
        line-height: 1.5;
        color: #ffffff;
    }

    .category h4 {
        color: #BD099D;
        margin-bottom: 10px;
        font-weight: bold;
    }

    @media (max-width: 992px) {
        .category {
            background-size: contain; 
            background-attachment: scroll; 
        }
    }

    @media (max-width: 768px) {
        .category {
            padding: 30px;
            background-size: cover; 
        }
      
        .custom-box {
            padding: 40px;
        }
      
        .category p {
            font-size: 14px;
        }
    }

</style>


<!-- <style>
        body {
            background-color: #f9f9f9;
        }

        .feature-box {
            border: 1px solid #ddd;
            padding: 40px;
            text-align: center;
            background: white;
            transition: 0.3s ease-in-out;
        }

        .feature-box:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .feature-icon img {
            width: 80px; /* Adjust icon size */
            margin-bottom: 15px;
        }

        .feature-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .feature-subtitle {
            font-size: 14px;
            font-weight: 500;
            color: #c96;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .feature-text {
            font-size: 14px;
            color: #555;
        }
    </style>

<section class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="feature-box">
                <div class="feature-icon">
                    <img src="https://via.placeholder.com/80" alt="Icon">
                </div>
                <p class="feature-subtitle">Religion</p>
                <p class="feature-text">Hindu | Jain | Muslim |<br> Christian | Sikh | Parsi |<br> Buddhist | Jewish</p>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="feature-box">
                <div class="feature-icon">
                    <img src="https://via.placeholder.com/80" alt="Icon">
                </div>
                <p class="feature-subtitle">Caste</p>
                <p class="feature-text">Agarwal | Gupta | Arora | Baniya<br> Brahmin | Jat | Kayastha |<br> Khatri | Rajput | Sunni</p>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="feature-box">
                <div class="feature-icon">
                    <img src="https://via.placeholder.com/80" alt="Icon">
                </div>
                <p class="feature-subtitle">State</p>
                <p class="feature-text">Delhi | Chandigarh | Gujarat | Haryana <br> Karnataka | Maharashtra | Punjab |<br> Rajasthan | Uttar Pradesh | West Bengal <br> Telangana | Madhya Pradesh <br> Andhra Pradesh | Tamil Nadu | Kerala</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="feature-box">
                <div class="feature-icon">
                    <img src="https://via.placeholder.com/80" alt="Icon">
                </div>
                <p class="feature-subtitle">Regional</p>
                <p class="feature-text">Bengali | Gujarati | Hindi | Kannada |<br> Malayalam | Marathi | Punjabi |<br> Tamil | Telugu | Urdu</p>
            </div>
        </div>

    </div>

    </div>
</section> -->




<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
  AOS.init({
        // duration: 1000,
         once: true, 
         offset: 120, 
      });
</script>
<!-- -------------------------------------------------------------------------------------------------------------------- -->
    <!-- Banner section 1 -->
    <!-- @if (get_setting('show_home_banner1_section') == 'on' && get_setting('home_banner1_images') != null)
        <section class="pt-7 bg-white">
            <div class="container">
                <div class="row gutters-10">
                    @php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp
                    @foreach ($banner_1_imags as $key => $value)
                        <div class="col-xl col-md-6">
                            <div class="mb-3">
                                <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}"
                                    class="d-block text-reset">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset($banner_1_imags[$key]) }}"
                                        alt="{{ env('APP_NAME') }}" class="img-fluid lazyload w-100">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif -->

    <!-- How It Works Section -->
    <!-- @if (get_setting('show_how_it_works_section') == 'on' && get_setting('how_it_works_steps_titles') != null)
        <section class="py-7 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3">{{ get_setting('how_it_works_title') }}</h2>
                            <p class="fw-400 fs-16 opacity-60">{{ get_setting('how_it_works_sub_title') }}</p>
                        </div>
                    </div>
                </div>
                <div class="row gutters-10">
                    @php
                        $how_it_works_steps_titles = json_decode(get_setting('how_it_works_steps_titles'));
                        $step = 1;
                    @endphp
                    @foreach ($how_it_works_steps_titles as $key => $how_it_works_steps_title)
                        <div class="col-lg">
                            <div class="border p-3 mb-3">
                                <div class=" row align-items-center">
                                    <div class="col-7">
                                        <div class="text-primary fw-600 h1">{{ $step++ }}</div>
                                        <div class="text-secondary fs-20 mb-2 fw-600">{{ $how_it_works_steps_title }}
                                        </div>
                                        <div class="fs-15 opacity-60">
                                            {{ json_decode(get_setting('how_it_works_steps_sub_titles'), true)[$key] }}
                                        </div>
                                    </div>
                                    <div class="mt-3 col-5 text-right">
                                        <img src="{{ uploaded_asset(json_decode(get_setting('how_it_works_steps_icons'), true)[$key]) }}"
                                            class="img-fluid h-80px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif -->

    <!-- Trusted by Millions Section -->
    <!-- @if (get_setting('show_trusted_by_millions_section') == 'on')
        <section class="bg-center bg-cover min-vh-100 py-7 text-white d-flex align-items-center bg-fixed"
            style="background-image: url('{{ uploaded_asset(get_setting('trusted_by_millions_background_image')) }}')">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 mx-auto">
                        <div class="text-center pb-12">
                            <h2 class="fw-600">{{ get_setting('trusted_by_millions_title') }}</h2>
                            <div class="fs-16 fw-400">{{ get_setting('trusted_by_millions_sub_title') }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                        $homepage_best_features = json_decode(get_setting('homepage_best_features'));
                    @endphp
                    @if (!empty($homepage_best_features))
                        @foreach ($homepage_best_features as $key => $homepage_best_feature)
                            <div class="col-lg">
                                <div class="border rounded position-relative z-1 border-gray-600 overflow-hidden mt-4">
                                    <div class="absolute-full bg-dark opacity-60 z--1"></div>
                                    <div class="px-4 py-5 d-flex align-items-center justify-content-center">
                                        <img src="{{ uploaded_asset(json_decode(get_setting('homepage_best_features_icons'), true)[$key]) }}"
                                            class="img-fluid h-20px">
                                        <span class="fs-17 ml-2">{{ $homepage_best_feature }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
    @endif -->

    <!-- New Member Section -->
    <!-- @if (get_setting('show_new_member_section') == 'on')
        <section class="py-7 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3 text-dark">{{ get_setting('new_member_section_title') }}</h2>
                            <p class="fw-400 fs-16 opacity-60">{{ get_setting('new_member_section_sub_title') }}</p>
                        </div>
                    </div>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="5" data-xl-items="4" data-lg-items="4"
                    data-md-items="3" data-sm-items="2" data-xs-items="1" data-dots='true' data-infinite='true'>
                    @foreach ($new_members as $key => $member)
                        <div class="carousel-box">
                            @include('frontend.inc.member_box_1',['member'=>$member])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif -->
    <!-- happy Story Section -->
    <!-- @if (get_setting('show_happy_story_section') == 'on')
        <section class="py-7 bg-dark text-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3">Happy Stories</h2>
                        </div>
                    </div>
                </div>
                <div
                    class="card-columns column-gap-10 card-columns-xxl-4 card-columns-lg-3 card-columns-md-2 card-columns-1">
                    @php
                        $happy_stories = \App\Models\HappyStory::where('approved', '1')
                            ->latest()
                            ->limit(get_setting('max_happy_story_show_homepage'))
                            ->get();
                    @endphp
                    @foreach ($happy_stories as $key => $happy_story)
                        @php
                            $photo = explode(',', $happy_story->photos);
                        @endphp
                        <div class="card border-gray-800 overflow-hidden mb-2">
                            <a href="{{ route('story_details', $happy_story->id) }}"
                                class="text-reset d-block position-relative">
                                <img src="{{ uploaded_asset($photo[0]) }}" class="img-fluid">
                                <div class="absolute-bottom-left p-3">
                                    <div class="position-relative z-1 p-3">
                                        <div class="absolute-full z--1 bg-dark opacity-60"></div>
                                        <div class="text-primary text-truncate">
                                            {{ $happy_story->user->first_name . ' & ' . $happy_story->partner_name }}</div>
                                        <h2 class="h5 mb-0 fs-14 fw-400 lh-1-5 text-truncate-3">
                                            {{ $happy_story->title }}
                                        </h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('happy_stories') }}" class="btn btn-primary">{{ translate('View More') }}</a>
                </div>
            </div>
        </section>
    @endif -->


    <!-- ---------------------------------------------------------------------------------------------------- -->

                                    <!-- <ul class="list-group list-group-raw fs-15 mb-5">
                                        <li class="list-group-item py-2">
                                            <i class="las la-check text-success mr-2"></i>
                                            {{ $package->express_interest }} {{ translate('Express Interests') }}
                                        </li>
                                        <li class="list-group-item py-2">
                                            <i class="las la-check text-success mr-2"></i>
                                            {{ $package->photo_gallery }} {{ translate('Gallery Photo Upload') }}
                                        </li>
                                        <li class="list-group-item py-2">
                                            <i class="las la-check text-success mr-2"></i>
                                            {{ $package->contact }} {{ translate('Contact Info View') }}
                                        </li>
                                        <li class="list-group-item py-2 text-line-through">
                                            @if ($package->auto_profile_match == 0)
                                                <i class="las la-times text-danger mr-2"></i>
                                                <del
                                                    class="opacity-60">{{ translate('Show Auto Profile Match') }}</del>
                                            @else
                                                <i class="las la-check text-success mr-2"></i>
                                                {{ translate('Show Auto Profile Match') }}
                                            @endif
                                        </li>
                                    </ul> -->
                                   
    <!-- @if (get_setting('show_homepage_review_section') == 'on' && get_setting('homepage_reviews') != null)
        <section class="py-7 bg-cover bg-center text-white"
            style="background-image: url('{{ uploaded_asset(get_setting('homepage_review_section_background_image')) }}');">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-9 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3">{{ get_setting('homepage_review_section_title') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-10 mx-auto">
                        <div class="aiz-carousel large-arrow" data-items="1" data-arrows='true' data-infinite='true'
                            data-autoplay='true'>
                            @foreach (json_decode(get_setting('homepage_reviews')) as $key => $review)
                                <div class="carousel-box">
                                    <div class="text-center px-lg-9">
                                        <img src="{{ uploaded_asset(json_decode(get_setting('homepage_reviewers_images'), true)[$key]) }}"
                                            class="size-180px img-fit mx-auto rounded-circle border border-white border-width-5 shadow-lg mb-5">
                                        <div class="fs-18 fw-300 font-italic">{{ $review }}</div>
                                        <i class="las la-quote-right la-10x text-dark opacity-30"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif -->

    <!-- @if (get_setting('show_blog_section') == 'on')
        <section class="py-7 bg-white text-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3 text-dark">{{ get_setting('blog_section_title') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="aiz-carousel gutters-10" data-items="4" data-xl-items="3" data-md-items="2" data-sm-items="1"
                    data-arrows='true'>
                    @php
                        $blogs = \App\Models\Blog::query()
                            ->where('status', 1)
                            ->latest()
                            ->limit(get_setting('max_blog_show_homepage'))
                            ->get();
                    @endphp
                    @foreach ($blogs as $key => $blog)
                        <div class="caorusel-box p-1">
                            <div class="card mb-3 overflow-hidden shadow-sm text-dark">
                                <a href="{{ route('blog.details', $blog->slug) }}" class="text-reset d-block">
                                    <img src="{{ uploaded_asset($blog->banner) }}" alt="{{ $blog->title }}"
                                        class="h-200px img-fit">
                                </a>
                                <div class="p-4">
                                    <h2 class="fs-18 fw-600 mb-1">
                                        <a href="{{ route('blog.details', $blog->slug) }}" class="text-reset">
                                            {{ $blog->title }}
                                        </a>
                                    </h2>
                                    @if ($blog->category != null)
                                        <div class="mb-2 opacity-50">
                                            <i>{{ $blog->category->category_name }}</i>
                                        </div>
                                    @endif
                                    <p class="opacity-70 mb-4">{{ $blog->short_description }}</p>
                                    <a href="{{ route('blog.details', $blog->slug) }}"
                                        class="btn btn-soft-primary">{{ translate('View More') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('blog') }}" class="btn btn-primary">{{ translate('View More') }}</a>
                </div>
            </div>
        </section>
    @endif -->

@endsection

@section('modal')
    @include('modals.login_modal')
    @include('modals.package_update_alert_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function loginModal() {
            $('#LoginModal').modal();
        }

        function package_update_alert() {
            $('.package_update_alert_modal').modal('show');
        }
    </script>
    @if(get_setting('google_recaptcha_activation') == 1)
        @include('partials.recaptcha')
    @endif
    @if(addon_activation('otp_system'))
        @include('partials.emailOrPhone')
    @endif

    
@endsection


