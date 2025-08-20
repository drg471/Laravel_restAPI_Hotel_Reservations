<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reserva Confirmada</title>
</head>
<body>
    <h1>Hola {{ $reservation->guestName }},</h1>

    <p>Tu reserva ha sido confirmada con éxito.</p>

    <ul>
        <li><strong>Entrada:</strong> {{ $reservation->checkInDate->format('Y-m-d H:i') }}</li>
        <li><strong>Salida:</strong> {{ $reservation->checkOutDate->format('Y-m-d H:i') }}</li>
        <li><strong>Tipo de habitación:</strong> {{ $reservation->roomType->value ?? 'No especificado' }}</li>
    </ul>

    <p>Comentarios: {{ $reservation->comments }}</p>

    <p>¡Gracias por reservar con nosotros!</p>
</body>
</html>
