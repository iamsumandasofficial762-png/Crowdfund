<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Supporter Report Submitted</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222; line-height: 1.5;">
    <h2>New Supporter Report Submitted</h2>

    <p>A new supporter report has been submitted.</p>

    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; border-color: #ddd;">
        <tr><th align="left">Fundraiser Post</th><td>{{ $report->fundraiserPost?->title ?: 'N/A' }}</td></tr>
        <tr><th align="left">Name</th><td>{{ $report->name ?: 'N/A' }}</td></tr>
        <tr><th align="left">Email</th><td>{{ $report->email ?: 'N/A' }}</td></tr>
        <tr><th align="left">Phone</th><td>{{ trim(($report->country_code ?? '').' '.($report->phone ?? '')) ?: 'N/A' }}</td></tr>
        <tr><th align="left">Message</th><td>{{ $report->message ?: 'N/A' }}</td></tr>
        <tr><th align="left">Supporting Document</th><td>{{ $report->supporting_document ?: 'N/A' }}</td></tr>
        <tr><th align="left">Submitted At</th><td>{{ optional($report->created_at)->format('d M Y, h:i A') ?: now()->format('d M Y, h:i A') }}</td></tr>
        <tr><th align="left">Source Page</th><td>{{ $sourcePage ?: 'N/A' }}</td></tr>
    </table>
</body>
</html>
