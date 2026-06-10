<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Site Report Submitted</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222; line-height: 1.5;">
    <h2>New Site Report Submitted</h2>

    <p>A new site report has been submitted.</p>

    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; border-color: #ddd;">
        <tr><th align="left">Name</th><td>{{ $siteReport->name ?: 'N/A' }}</td></tr>
        <tr><th align="left">Email</th><td>{{ $siteReport->email ?: 'N/A' }}</td></tr>
        <tr><th align="left">Phone</th><td>{{ $siteReport->phone ?: 'N/A' }}</td></tr>
        <tr><th align="left">Page URL</th><td>{{ $siteReport->page_url ?: 'N/A' }}</td></tr>
        <tr><th align="left">Subject</th><td>{{ $siteReport->subject ?: 'N/A' }}</td></tr>
        <tr><th align="left">Message</th><td>{{ $siteReport->message }}</td></tr>
        <tr><th align="left">Supporting Document</th><td>{{ $siteReport->supporting_document ?: 'N/A' }}</td></tr>
        <tr><th align="left">Submitted At</th><td>{{ optional($siteReport->created_at)->format('d M Y, h:i A') ?: now()->format('d M Y, h:i A') }}</td></tr>
        <tr><th align="left">Source Page</th><td>{{ $sourcePage ?: 'N/A' }}</td></tr>
    </table>
</body>
</html>
