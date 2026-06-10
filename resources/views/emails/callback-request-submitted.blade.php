<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Call Back Request</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222; line-height: 1.5;">
    <h2>New Call Back Request</h2>

    <p>A new call back request has been submitted.</p>

    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; border-color: #ddd;">
        <tr><th align="left">Name</th><td>{{ $contactMessage->name }}</td></tr>
        <tr><th align="left">Phone</th><td>{{ $contactMessage->phone }}</td></tr>
        <tr><th align="left">Alternate Phone</th><td>{{ $contactMessage->alternate_phone ?: 'N/A' }}</td></tr>
        <tr><th align="left">Reason</th><td>{{ $contactMessage->reason ?: 'N/A' }}</td></tr>
        <tr><th align="left">Estimated Cost</th><td>{{ $contactMessage->estimated_cost ?: 'N/A' }}</td></tr>
        <tr><th align="left">Preferred Language</th><td>{{ $contactMessage->preferred_language ?: 'N/A' }}</td></tr>
        <tr><th align="left">Description</th><td>{{ $contactMessage->description ?: 'N/A' }}</td></tr>
        <tr><th align="left">Submitted At</th><td>{{ optional($contactMessage->created_at)->format('d M Y, h:i A') ?: now()->format('d M Y, h:i A') }}</td></tr>
        <tr><th align="left">Source Page</th><td>{{ $sourcePage ?: 'N/A' }}</td></tr>
    </table>
</body>
</html>
