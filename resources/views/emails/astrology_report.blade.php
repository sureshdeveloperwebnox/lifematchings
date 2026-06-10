@php
    $memberName = $member->first_name ?? $member->name ?? 'Member';
    $lifeId = $report->life_id ?? ($member->code ?? 'N/A');
@endphp

<p style="margin:0 0 16px;font-family:Arial,sans-serif;">Dear {{ $memberName }},</p>

<p style="margin:0 0 16px;font-family:Arial,sans-serif;">
    Thank you for trusting Life Matchings with your astrology analysis. Your personalised report is ready and has been attached as a PDF file for your convenience.
</p>

<p style="margin:0 0 16px;font-family:Arial,sans-serif;">
    <strong>Life Matchings ID:</strong> {{ $lifeId }}<br>
    <strong>Generated on:</strong> {{ now()->format('d-m-Y') }}
</p>

<p style="margin:0 0 16px;font-family:Arial,sans-serif;">
    We recommend saving this report for future reference. If you have any questions, require clarifications, or would like to schedule a consultation, simply reply to this email or reach us using the contact information below.
</p>

<p style="margin:0 0 16px;font-family:Arial,sans-serif;">
    Warm regards,<br>
    <strong>Life Matchings Support Team</strong><br>
    <a href="mailto:info@lifematchings.com">info@lifematchings.com</a> · <a href="tel:+919384814536">+91 93848 14536</a><br>
    <a href="https://www.lifematchings.com">www.lifematchings.com</a>
</p>

