<!DOCTYPE html>
<html>

<head>
    <title>Faktur Pembayaran</title>
    <style>
        #tabel {
            font-size: 15px;
            border-collapse: collapse;
        }

        #tabel td {
            padding-left: 5px;
            border: 1px solid black;
        }
    </style>
</head>

<body style='font-family: tahoma; font-size: 8pt;'>
    <center>
        <table style='width: 350px; font-size: 16pt; font-family: calibri; border-collapse: collapse;' border='0'>
            <tr>
                <td width='70%' align='CENTER' vertical-align:top>
                    <span style='color: black;'><b>SATE PERAWAN</b></span><br>
                    Jl. Raya Muchtar No. 18, Sawangan, Depok Depok<br>
                    <span style='font-size: 12pt'>No. : #{{ $order['id'] }},
                        {{ \Carbon\Carbon::parse($order['created_at'])->format('d-m-Y') }},(kasir:
                        {{ $order->user->nama }}),
                        {{ \Carbon\Carbon::parse($order['created_at'])->format('H:i') }}</span><br>

                </td>
            </tr>
            <hr style='border-style: inset; border-width: 1px; width: 350px;'>
        </table>

        <table cellspacing='0' cellpadding='0'
            style='width: 350px; font-size: 12pt; font-family: calibri; border-collapse: collapse;' border='0'>
            <tr align='center'>
                <td width='10%'>Item</td>
                <td width='13%'>Price</td>
                <td width='4%'>Qty</td>
                <td width='4%'>Ket</td>
                <td width='13%'>Total</td>
            </tr>
            <tr>
                <td colspan='5'>
                    <hr>
                </td>
            </tr>
            @foreach ($items as $item)
                <tr>
                    <td style='vertical-align: top; font-size: 10pt;'>{{ $item->menu->nama }}</td>
                    <td style='vertical-align: top; text-align: right; padding-right: 10px; font-size: 10pt;'>
                        Rp {{ number_format($item->menu->harga, 0, ',', '.') }}</td>
                    <td style='vertical-align: top; text-align: right; padding-right: 10px; font-size: 10pt;'>
                        {{ $item['jumlah'] }}</td>
                    <td style='text-align: right; vertical-align: top; font-size: 10pt;'>{{ $item['keterangan'] }}
                    </td>
                    <td style='text-align: right; vertical-align: top; font-size: 10pt;'>
                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td colspan='5'>
                        <hr>
                    </td>
                </tr>
            @endforeach





            @if ($order['metode_pembayaran'] == 'cash')
                <tr>
                    <td colspan='4'>
                        <div style='text-align: right; color: black'>Pembayaran :</div>
                    </td>
                    <td style='text-align: right; font-size: 12pt; color: black'>
                        {{ $order['metode_pembayaran'] }}</td>
                </tr>
                <tr>
                    <td colspan='4'>
                        <div style='text-align: right; color: black'>Total :</div>
                    </td>
                    <td style='text-align: right; font-size: 12pt; color: black'>
                        Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan='4'>
                        <div style='text-align: right; color: black'>Dibayarkan :</div>
                    </td>
                    <td style='text-align: right; font-size: 12pt; color: black'>
                        Rp {{ number_format($order['dibayarkan'], 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan='4'>
                        <div style='text-align: right; color: black'>Kembalian :</div>
                    </td>
                    <td style='text-align: right; font-size: 12pt; color: black'>
                        Rp {{ number_format($order['kembalian'], 0, ',', '.') }}</td>
                </tr>
            @else
                <tr>
                    <td colspan='4'>
                        <div style='text-align: right; color: black'>Pembayaran :</div>
                    </td>
                    <td style='text-align: right; font-size: 12pt; color: black'>
                        {{ $order['metode_pembayaran'] }} {{ $order->pembayaran->bank }}</td>
                </tr>
                <tr>
                    <td colspan='4'>
                        <div style='text-align: right; color: black'>Total :</div>
                    </td>
                    <td style='text-align: right; font-size: 12pt; color: black'>
                        Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                </tr>
            @endif




        </table>
        <table style='width: 350px; font-size: 12pt;' cellspacing='2'>
            <tr>
                <td align='center'>****** TERIMAKASIH ******</td>
            </tr>
        </table>
    </center>
</body>

</html>
