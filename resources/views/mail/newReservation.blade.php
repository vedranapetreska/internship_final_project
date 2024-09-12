<!DOCTYPE html>
<html>
<head>
    <title>New Reservation Alert</title>
</head>
<body>
    <h1>New Reservation Alert</h1>
    <p>Dear Admin,</p>
    <p>A new reservation has been made by {{ $reservation->user->name }}.</p>
    <p><strong>Reservation Details:</strong></p>
    <ul>
        <li><strong>Date:</strong> {{ $reservation->date }}</li>
        <li><strong>Start Time:</strong> {{ $reservation->start_time }}</li>
        <li><strong>End Time:</strong> {{ $reservation->end_time }}</li>
        <li><strong>Court:</strong> {{ $reservation->court->court_number }}</li>
    </ul>
    <p>Please review the reservation in the admin panel.</p>
    <p>Thank you!</p>
</body>
</html>
