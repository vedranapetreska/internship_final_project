<!DOCTYPE html>
<html>
<head>
    <title>Reservation Denied</title>
</head>
<body>
    <h1>Reservation Denied</h1>
    <p>Dear {{ $reservation->user->name }},</p>
    <p>We regret to inform you that your reservation on {{ $reservation->date }} from {{ $reservation->start_time }} to {{ $reservation->end_time }} on court number {{ $reservation->court->court_number }} has been denied.</p>
    <p>Please contact us if you have any questions.</p>
    <p>Best regards,<br>TKPrilep</p>
</body>
</html>
