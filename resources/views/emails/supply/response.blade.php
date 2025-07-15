<!DOCTYPE html>
<html>
<head>
    <title>Supply Requisition Response</title>
    <style>
        /* Basic email styling */
        body { font-family: sans-serif; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .status-Provided { color: green; font-weight: bold; }
        .status-Purchase { color: orange; font-weight: bold; }
        .status-Unavailable { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Requisition Report for {{ $supplyRequest->user->name }}</h2>
    <p>High Command has processed your recent supply request. Please find the detailed status report below.</p>

    <table>
        <thead>
            <tr>
                <th>Weapon</th>
                <th>Quantity Requested</th>
                <th>Status</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplyRequest->items as $item)
                <tr>
                    <td>{{ $item->weapon->name }}</td>
                    <td>{{ $item->quantity_requested }}</td>
                    <td class="status-{{ str_replace(' ', '', $item->status) }}">{{ $item->status }}</td>
                    <td>{{ $item->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr style="margin: 20px 0;">

    <p>For a permanent record of this transaction, please scan the QR code below or visit the link provided.</p>

    {!! $qrCode !!}

    <p><a href="{{ route('supply.receipt.show', $supplyRequest) }}">View Transaction Details Online</a></p>

    <p>For the Fatherland!</p>
</body>
</html>
