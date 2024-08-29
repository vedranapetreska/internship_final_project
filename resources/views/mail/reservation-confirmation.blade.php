<!DOCTYPE html>
<html>
<head>
    <title>Reservation Confirmation</title>
</head>
<body>
    <h1>Reservation Confirmation</h1>
    <p>Dear {{ $reservation->user->name }},</p>
    <p>Your reservation on {{ $reservation->date }} from {{ $reservation->start_time }} to {{ $reservation->end_time }} on court number {{ $reservation->court->court_number }} has been approved.</p>
    <p>Best regards,<br>TKPrilep</p>
</body>
</html>
