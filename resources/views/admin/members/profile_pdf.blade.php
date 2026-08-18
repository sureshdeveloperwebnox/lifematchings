<!DOCTYPE html>
<html>
<head>
    <title>Member Profile - {{ $member->first_name }} {{ $member->last_name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        * { font-family: Arial, sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { font-size: 13px; color: #333; background: #fff; }

        /* Header */
        .pdf-header {
            background: linear-gradient(135deg, #bd099d, #8a006f);
            color: #fff;
            padding: 18px 25px;
            text-align: center;
            margin-bottom: 20px;
        }
        .pdf-header .site-name { font-size: 22px; font-weight: bold; letter-spacing: 1px; }
        .pdf-header .site-tagline { font-size: 11px; opacity: 0.85; margin-top: 3px; }
        .pdf-header .profile-title { font-size: 14px; margin-top: 8px; background: rgba(255,255,255,0.15); display: inline-block; padding: 3px 14px; border-radius: 12px; }

        /* Profile top card */
        .profile-card {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border: 1px solid #e0d0e8;
            border-radius: 6px;
            background: #fdf5fb;
            padding: 15px;
        }
        .profile-photo-cell {
            display: table-cell;
            width: 110px;
            vertical-align: top;
            padding-right: 18px;
        }
        .profile-photo-cell img {
            width: 100px;
            height: 120px;
            object-fit: cover;
            object-position: top center;
            border: 2px solid #bd099d;
            border-radius: 5px;
        }
        .profile-info-cell {
            display: table-cell;
            vertical-align: top;
        }
        .member-name { font-size: 20px; font-weight: bold; color: #bd099d; margin-bottom: 4px; }
        .member-code { font-size: 12px; color: #888; margin-bottom: 10px; }
        .badge-row { margin-top: 6px; }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            margin-right: 6px;
        }
        .badge-gender { background: #e8f4fd; color: #0070c0; border: 1px solid #b3d7f5; }
        .badge-membership { background: #fef3e2; color: #b06000; border: 1px solid #f5d89a; }
        .badge-dob { background: #f0fef4; color: #1a7a3c; border: 1px solid #a8dbb8; }

        /* Section */
        .section {
            margin-bottom: 16px;
            page-break-inside: avoid;
        }
        .section-title {
            background: #bd099d;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 3px 3px 0 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .section-body {
            border: 1px solid #e0d0e8;
            border-top: none;
            border-radius: 0 0 4px 4px;
            padding: 0;
        }
        table.info-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.info-table tr:nth-child(odd) { background: #fdf5fb; }
        table.info-table tr:nth-child(even) { background: #fff; }
        table.info-table th {
            width: 25%;
            padding: 6px 10px;
            font-size: 12px;
            color: #7a007a;
            font-weight: bold;
            text-align: left;
            border-right: 1px solid #e8d8f0;
            white-space: nowrap;
        }
        table.info-table td {
            width: 25%;
            padding: 6px 10px;
            font-size: 12px;
            color: #333;
            border-right: 1px solid #f0e0f5;
        }
        table.info-table td:last-child, table.info-table th:last-child { border-right: none; }

        /* Footer */
        .pdf-footer {
            margin-top: 25px;
            border-top: 1px solid #e0d0e8;
            padding-top: 10px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        .pdf-footer strong { color: #bd099d; }

        /* Confidential watermark for shared version */
        .confidential-notice {
            background: #fff8e1;
            border: 1px solid #ffcc02;
            border-radius: 4px;
            padding: 8px 14px;
            font-size: 11px;
            color: #7a5f00;
            margin-bottom: 16px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="pdf-header">
        <div class="site-name">Life Matchings</div>
        <div class="site-tagline">L M Royal Matrimony Services Private Limited</div>
        <div class="profile-title">
            @if($showContact)
                Full Profile — Confidential
            @else
                Biodata Profile
            @endif
        </div>
    </div>

    @if(!$showContact)
    <div class="confidential-notice">
        &#9432; Contact details (phone, email, address) have been excluded from this profile copy.
    </div>
    @endif

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-photo-cell">
            @if($member->photo && uploaded_asset($member->photo))
                <img src="{{ public_path(parse_url(uploaded_asset($member->photo), PHP_URL_PATH)) }}" alt="Photo">
            @else
                @php $avatar = (optional($member->member)->gender == 2) ? 'female-avatar-place.png' : 'avatar-place.png'; @endphp
                <img src="{{ public_path('assets/img/' . $avatar) }}" alt="Photo">
            @endif
        </div>
        <div class="profile-info-cell">
            <div class="member-name">{{ $member->first_name }} {{ $member->last_name }}</div>
            <div class="member-code">Member ID: {{ $member->code }}</div>
            <div class="badge-row">
                <span class="badge badge-gender">
                    @if(optional($member->member)->gender == 1) Male
                    @elseif(optional($member->member)->gender == 2) Female
                    @else N/A @endif
                </span>
                @if(!empty($member->member->birthday))
                    <span class="badge badge-dob">
                        Age: {{ \Carbon\Carbon::parse($member->member->birthday)->age }} yrs
                    </span>
                    <span class="badge badge-dob">
                        DOB: {{ date('d-m-Y', strtotime($member->member->birthday)) }}
                    </span>
                @endif
                <span class="badge badge-membership">
                    {{ $member->membership == 2 ? 'Premium Member' : 'Free Member' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="section">
        <div class="section-title">Basic Information</div>
        <div class="section-body">
            <table class="info-table">
                <tr>
                    <th>Marital Status</th>
                    <td>{{ optional($member->member->marital_status)->name ?? '—' }}</td>
                    <th>On Behalf</th>
                    <td>{{ optional($member->member->on_behalves)->name ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Children</th>
                    <td>{{ $member->member->children ?? '—' }}</td>
                    <th>Mother Tongue</th>
                    <td>{{ optional($member->member->mothereTongue)->name ?? '—' }}</td>
                </tr>
                @if($showContact)
                <tr>
                    <th>Email</th>
                    <td>{{ $member->email ?? '—' }}</td>
                    <th>Phone</th>
                    <td>{{ $member->phone ?? '—' }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    <!-- Spiritual & Social Background -->
    @if(optional($member->spiritual_backgrounds)->religion || optional($member->spiritual_backgrounds)->caste)
    <div class="section">
        <div class="section-title">Spiritual &amp; Social Background</div>
        <div class="section-body">
            <table class="info-table">
                <tr>
                    <th>Religion</th>
                    <td>{{ optional(optional($member->spiritual_backgrounds)->religion)->name ?? '—' }}</td>
                    <th>Caste</th>
                    <td>{{ optional(optional($member->spiritual_backgrounds)->caste)->name ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Sub Caste</th>
                    <td>{{ optional(optional($member->spiritual_backgrounds)->sub_caste)->name ?? '—' }}</td>
                    <th>Gothram</th>
                    <td>{{ $member->spiritual_backgrounds->gothram ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Diet</th>
                    <td>{{ $member->spiritual_backgrounds->diet ?? '—' }}</td>
                    <th>Nationality</th>
                    <td>{{ $member->spiritual_backgrounds->nationality ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Living In</th>
                    <td>{{ $member->spiritual_backgrounds->living_in ?? '—' }}</td>
                    <th>Mother Tongue</th>
                    <td>{{ $member->spiritual_backgrounds->mother_tongue ?? '—' }}</td>
                </tr>
            </table>
        </div>
    </div>
    @endif

    <!-- Physical Attributes -->
    @if($member->physical_attributes)
    <div class="section">
        <div class="section-title">Physical Attributes</div>
        <div class="section-body">
            <table class="info-table">
                <tr>
                    <th>Height</th>
                    <td>{{ $member->physical_attributes->height ?? '—' }}</td>
                    <th>Weight</th>
                    <td>{{ $member->physical_attributes->weight ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Complexion</th>
                    <td>{{ $member->physical_attributes->complexion ?? '—' }}</td>
                    <th>Body Type</th>
                    <td>{{ $member->physical_attributes->body_type ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Disability</th>
                    <td colspan="3">{{ $member->physical_attributes->disability ?? '—' }}</td>
                </tr>
            </table>
        </div>
    </div>
    @endif

    <!-- Education -->
    @if($educations && $educations->count())
    <div class="section">
        <div class="section-title">Education</div>
        <div class="section-body">
            <table class="info-table">
                <tr>
                    <th style="width:50%">Degree</th>
                    <th style="width:50%">Institution</th>
                </tr>
                @foreach($educations as $edu)
                <tr>
                    <td>{{ $edu->degree ?? '—' }}</td>
                    <td>{{ $edu->institution ?? '—' }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endif

    <!-- Career -->
    @if($careers && $careers->count())
    <div class="section">
        <div class="section-title">Career</div>
        <div class="section-body">
            <table class="info-table">
                <tr>
                    <th>Designation</th>
                    <th>Company</th>
                    <th>Annual Income</th>
                    <th>Additional Income</th>
                </tr>
                @foreach($careers as $career)
                <tr>
                    <td>{{ $career->designation ?? '—' }}</td>
                    <td>{{ $career->company ?? '—' }}</td>
                    <td>{{ $career->annual_income ?? '—' }}</td>
                    <td>{{ $career->additional_income ?? '—' }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endif

    <!-- Present Address -->
    @if($showContact && $present_address)
    <div class="section">
        <div class="section-title">Present Address</div>
        <div class="section-body">
            <table class="info-table">
                <tr>
                    <th>City</th>
                    <td>{{ optional($present_address->city)->name ?? '—' }}</td>
                    <th>State</th>
                    <td>{{ optional($present_address->state)->name ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{ optional($present_address->country)->name ?? '—' }}</td>
                    <th>Postal Code</th>
                    <td>{{ $present_address->postal_code ?? '—' }}</td>
                </tr>
                @if($present_address->address)
                <tr>
                    <th>Address</th>
                    <td colspan="3">{{ $present_address->address }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>
    @endif

    <!-- Astronomical Information -->
    @if($member->astrologies)
    <div class="section">
        <div class="section-title">Astronomical Information</div>
        <div class="section-body">
            <table class="info-table">
                <tr>
                    <th>Rasi / Zodiac Sign</th>
                    <td>
                        @php
                            $sun = '';
                            if($member->astrologies->sun_sign) {
                                $sun = is_numeric($member->astrologies->sun_sign)
                                    ? (optional(\App\Models\SunSign::find($member->astrologies->sun_sign))->name ?? $member->astrologies->sun_sign)
                                    : $member->astrologies->sun_sign;
                            }
                        @endphp
                        {{ $sun ?: '—' }}
                    </td>
                    <th>Star / Nakshatra</th>
                    <td>
                        @php
                            $moon = '';
                            if($member->astrologies->moon_sign) {
                                $moon = is_numeric($member->astrologies->moon_sign)
                                    ? (optional(\App\Models\MoonSign::find($member->astrologies->moon_sign))->name ?? $member->astrologies->moon_sign)
                                    : $member->astrologies->moon_sign;
                            }
                        @endphp
                        {{ $moon ?: '—' }}
                    </td>
                </tr>
                <tr>
                    <th>Lagnam / Lagna</th>
                    <td>
                        @php
                            $lagnam = '';
                            if($member->astrologies->lagnam) {
                                $lagnam = is_numeric($member->astrologies->lagnam)
                                    ? (optional(\App\Models\SunSign::find($member->astrologies->lagnam))->name ?? $member->astrologies->lagnam)
                                    : $member->astrologies->lagnam;
                            }
                        @endphp
                        {{ $lagnam ?: '—' }}
                    </td>
                    <th>Manglik</th>
                    <td>{{ $member->astrologies->manglik ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Time of Birth</th>
                    <td>{{ $member->astrologies->time_of_birth ?? '—' }}</td>
                    <th>City of Birth</th>
                    <td>{{ $member->astrologies->city_of_birth ?? '—' }}</td>
                </tr>
            </table>
        </div>
    </div>
    @endif

    <!-- Life Style -->
    @if($member->lifestyles)
    <div class="section">
        <div class="section-title">Life Style</div>
        <div class="section-body">
            <table class="info-table">
                <tr>
                    <th>Diet</th>
                    <td>{{ $member->lifestyles->diet ?? '—' }}</td>
                    <th>Social Drinker</th>
                    <td>{{ strtoupper($member->lifestyles->drink ?? '—') }}</td>
                </tr>
                <tr>
                    <th>Social Smoker</th>
                    <td>{{ strtoupper($member->lifestyles->smoke ?? '—') }}</td>
                    <th>Living With</th>
                    <td>{{ $member->lifestyles->living_with ?? '—' }}</td>
                </tr>
            </table>
        </div>
    </div>
    @endif

    <!-- Partner Expectations -->
    @if($member->partner_expectations)
    <div class="section">
        <div class="section-title">Partner Expectations</div>
        <div class="section-body">
            <table class="info-table">
                <tr>
                    <th>Age Range</th>
                    <td>{{ ($member->partner_expectations->age_from ?? '') ? $member->partner_expectations->age_from . ' - ' . $member->partner_expectations->age_to . ' yrs' : '—' }}</td>
                    <th>Height Range</th>
                    <td>{{ ($member->partner_expectations->height_from ?? '') ? $member->partner_expectations->height_from . ' - ' . $member->partner_expectations->height_to : '—' }}</td>
                </tr>
                <tr>
                    <th>Marital Status</th>
                    <td>{{ $member->partner_expectations->marital_status ?? '—' }}</td>
                    <th>Religion</th>
                    <td>{{ $member->partner_expectations->religion ?? '—' }}</td>
                </tr>
            </table>
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="pdf-footer">
        <strong>Life Matchings</strong> — L M Royal Matrimony Services Private Limited<br>
        www.lifematchings.com &nbsp;|&nbsp; info@lifematchings.com &nbsp;|&nbsp; +91 9384814536<br>
        Generated on {{ date('d-m-Y H:i') }}
        @if(!$showContact)
            &nbsp;&nbsp;|&nbsp;&nbsp; <em>Contact details removed — Biodata copy</em>
        @endif
    </div>

</body>
</html>
