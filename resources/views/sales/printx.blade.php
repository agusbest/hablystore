<!DOCTYPE html>
<html>
<head>

    <title>Print Invoice</title>

    <style>

    body{

        font-family: 'Courier New', monospace;
        font-size: 12px;

        margin:0;
        padding:0;

        width: 190mm;

    }

    .wrapper{

        width: 185mm;

        padding-left:5mm;
        padding-right:5mm;

    }

    table{

        width:100%;
        border-collapse: collapse;

    }

    th, td{

        padding:3px;

        vertical-align: top;

    }

    .line{

        border-top:1px dashed #000;

        margin-top:5px;
        margin-bottom:5px;

    }

    .right{

        text-align:right;

    }

    .center{

        text-align:center;

    }

    .bold{

        font-weight:bold;

    }

    .mt-10{

        margin-top:10px;

    }

    .signature{

        height:70px;

    }

    @media print {

        @page {

            size: 21.5cm auto;

            margin: 5mm;

        }

        body{

            width:190mm;

        }

    }
    table tr{
    page-break-inside: avoid;
}

</style>

</head>
<body onload="window.print()">

    <div class="center">

        <h3>Hably Store</h3>

        <p>
            Penjualan HP & Accessories
        </p>

    </div>

    <hr>

    <table>

        <tr>
            <td width="150">Invoice</td>
            <td>: {{ $sale->invoice_number }}</td>
        </tr>

        <tr>
            <td>Tanggal</td>
            <td>: {{ $sale->sale_date }}</td>
        </tr>

        <tr>
            <td>Customer</td>
            <td>: {{ $sale->customer_name }}</td>
        </tr>

    </table>

    <hr>

 <table border="0">

  <thead>

<tr>

    <th width="30">
        No
    </th>

    <th>
        Nama Barang
    </th>

    <th width="100" class="right">
        Harga
    </th>

    <th width="80" class="right">
        Disc
    </th>

    <th width="120" class="right">
        Total
    </th>

</tr>

</thead>

    <tbody>

        @php
            $grandTotal = 0;
        @endphp

        @foreach($sale->details as $key => $detail)

        @php

            $harga   = $detail->sell_price;
            $diskon  = $detail->discount ?? 0;
            $total   = $harga - $diskon;

            $grandTotal += $total;

        @endphp

        <tr>

            <td align="center">

                {{ $key + 1 }}

            </td>

            <td>

                <strong>

                    {{ $detail->product->brand }}
                    {{ $detail->product->model }}

                </strong>

                <br>

                RAM :
                {{ $detail->product->ram }}

                |
                ROM :
                {{ $detail->product->rom }}

                |

                {{ $detail->product->color }}

                <br>

                IMEI :
                {{ $detail->imei1 }}

            </td>

            <td align="right">

                {{ number_format($harga) }}

            </td>

            <td align="right">

                {{ number_format($diskon) }}

            </td>

            <td align="right">

                {{ number_format($total) }}

            </td>

        </tr>

        @endforeach

    </tbody>

</table>
    <br>

   <table width="100%">

    <tr>

        <td align="right">

            <h3>

                GRAND TOTAL :
                Rp {{ number_format($grandTotal) }}

            </h3>

        </td>

    </tr>

</table>

    <br><br><br>

    <table width="100%">

        <tr>

            <td class="center">
                Pembeli
            </td>

            <td class="center">
                Admin
            </td>

        </tr>

        <tr>

            <td height="80"></td>
            <td></td>

        </tr>

        <tr>

            <td class="center">
                (_______________)
            </td>

            <td class="center">
                (_______________)
            </td>

        </tr>

    </table>

</body>
</html>