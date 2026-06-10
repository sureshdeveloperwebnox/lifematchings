@php
    $memberName = $member->first_name ?? $member->name ?? 'Member';
    $lifeId = $report->life_id ?? ($member->code ?? 'N/A');
@endphp

Dear {{ $memberName }},

Your Life Matchings astrology report is ready. The PDF is attached.

Life Matchings ID: {{ $lifeId }}
Generated on: {{ now()->format('d-m-Y') }}

If you have questions or need assistance, reply to this email or contact:
info@lifematchings.com | +91 93848 14536 | www.lifematchings.com

Thank you for choosing Life Matchings.

