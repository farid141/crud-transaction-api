<!DOCTYPE html>
<html>

<head>
    <title>Transaction Details</title>
</head>

<body>
    <h1>Transaction Notification</h1>
    <p><strong>Type:</strong> {{ $transaction->type }}</p>
    <p><strong>Customer Name:</strong> {{ $transaction->customer_name }}</p>
    <p><strong>Customer Email:</strong> {{ $transaction->customer_email }}</p>
    <p><strong>Total Amount:</strong> {{ number_format($transaction->total_amount, 2) }}</p>
    <p><strong>Supplier Name:</strong> {{ $transaction->supplier_name }}</p>
    <p><strong>Notes:</strong> {{ $transaction->notes }}</p>

    <h2>Items:</h2>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Version</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->transaction_items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->total_amount, 2) }}</td>
                <td>{{ $item->version }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>