<html>
<head>
    <title>Laporan Orders</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2, h3, h4 { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        .info { margin-top: 10px; text-align: center; }
    </style>
</head>
<body>
    <h2>SECAPA AD</h2>
    <h4>Bandung, Jawa Barat</h4>

    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Nama Pemesan</th>
                <th>Tanggal Pemesanan</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->invoices }}</td>
                <td>{{ $order->nama_pemesan }}</td>
                <td>{{ $order->tanggal_pemesanan }}</td>
                <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td>{{ ucfirst($order->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>