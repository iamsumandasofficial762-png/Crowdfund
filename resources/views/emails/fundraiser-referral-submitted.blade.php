<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Refer Us Request</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222; line-height: 1.5;">
    <h2>New Refer Us Request</h2>

    <p>A new refer us request has been submitted.</p>

    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; border-color: #ddd;">
        <tr><th align="left">Name</th><td>{{ $referral->name }}</td></tr>
        <tr><th align="left">Phone</th><td>{{ trim(($referral->country_code ?? '').' '.($referral->phone ?? '')) }}</td></tr>
        <tr><th align="left">Alternate Phone</th><td>{{ trim(($referral->alternate_country_code ?? '').' '.($referral->alternate_phone ?? '')) ?: 'N/A' }}</td></tr>
        <tr><th align="left">Reason</th><td>{{ $referral->reason ?: 'N/A' }}</td></tr>
        <tr><th align="left">Estimated Cost</th><td>{{ $referral->estimated_cost ?: 'N/A' }}</td></tr>
        <tr><th align="left">Preferred Language</th><td>{{ $referral->preferred_language ?: 'N/A' }}</td></tr>
        <tr><th align="left">Fundraiser Post</th><td>{{ $referral->fundraiserPost?->title ?: 'N/A' }}</td></tr>
        <tr><th align="left">Submitted At</th><td>{{ optional($referral->created_at)->format('d M Y, h:i A') ?: now()->format('d M Y, h:i A') }}</td></tr>
        <tr><th align="left">Source Page</th><td>{{ $sourcePage ?: 'N/A' }}</td></tr>
    </table>
</body>
</html>
