<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ticket Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .ticket {
            width: 100%;
            border: 1px solid #000;
            padding: 20px;
            margin: 20px 0;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <h1>Ticket Confirmation</h1>
        <p>Ticket ID: {{ $ticketId }}</p>
        <p>User Name: {{ $userName }}</p>
        <h2>Tour Details</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid #000; padding: 8px;">Tour Name</th>
                    <th style="border: 1px solid #000; padding: 8px;">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tourDetails as $item)
                    <tr>
                        <td style="border: 1px solid #000; padding: 8px;">{{ $item->tour->name }}</td>
                        <td style="border: 1px solid #000; padding: 8px;">{{ $item->qty }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Total Quantity: {{ $totalQuantity }}</p>

        @if (!isset($isPdf) || !$isPdf)
            <a href="{{ route('ticket.download', ['orderId' => $orderId]) }}" class="button">
                Download Ticket as PDF
            </a>
        @endif
    </div>
</body>

</html>
