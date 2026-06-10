<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Donation Payment Details Submitted</title>
</head>
<body style="font-family: Arial, sans-serif; color: #222; line-height: 1.5;">
    <h2>New Donation Payment Details Submitted</h2>

    <p>A donor has submitted payment details for acknowledgement.</p>

    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; border-color: #ddd;">
        <tr><th align="left">Campaign</th><td>{{ $donation->fundraiserPost?->title ?: 'N/A' }}</td></tr>
        <tr><th align="left">Payment Mode</th><td>{{ ucfirst(str_replace('_', ' ', $donation->payment_method ?: 'N/A')) }}</td></tr>
        <tr><th align="left">Transaction ID</th><td>{{ $donation->transaction_id ?: 'N/A' }}</td></tr>
        <tr><th align="left">Donation Amount</th><td>Rs. {{ number_format((float) $donation->amount, 0) }}</td></tr>
        <tr><th align="left">Status</th><td>{{ ucfirst($donation->status) }}</td></tr>
        <tr><th align="left">Submitted At</th><td>{{ optional($donation->created_at)->format('d M Y, h:i A') ?: now()->format('d M Y, h:i A') }}</td></tr>
        <tr><th align="left">Source Page</th><td>{{ $sourcePage ?: 'N/A' }}</td></tr>
    </table>
</body>
</html>
