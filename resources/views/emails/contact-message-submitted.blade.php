<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Contact Form Submitted</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222; line-height: 1.5;">
    <h2>New Contact Form Submitted</h2>

    <p>A new contact message has been submitted.</p>

    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; border-color: #ddd;">
        <tr><th align="left">Name</th><td>{{ $contactMessage->name }}</td></tr>
        <tr><th align="left">Email</th><td>{{ $contactMessage->email }}</td></tr>
        <tr><th align="left">Phone</th><td>{{ $contactMessage->phone ?: 'N/A' }}</td></tr>
        <tr><th align="left">Message</th><td>{{ $contactMessage->message ?: 'N/A' }}</td></tr>
        <tr><th align="left">Submitted At</th><td>{{ optional($contactMessage->created_at)->format('d M Y, h:i A') ?: now()->format('d M Y, h:i A') }}</td></tr>
        <tr><th align="left">Source Page</th><td>{{ $sourcePage ?: 'N/A' }}</td></tr>
    </table>
</body>
</html>
