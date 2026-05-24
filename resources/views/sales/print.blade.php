<!DOCTYPE html>
<html>
<head>

    <title>Faktur Penjualan</title>

    <style>

        body{

            font-family: Arial, sans-serif;
            font-size: 12px;

            width: 210mm;

            margin:0;
            padding:10px;

            color:#000;
        }

        .wrapper{

            width: 100%;
        }

        table{

            width:100%;
            border-collapse: collapse;
        }

        td, th{

            padding:2px;
            vertical-align: top;
        }

        .text-center{
            text-align:center;
        }

        .text-right{
            text-align:right;
        }

        .border-top{
            border-top:1px solid #000;
        }

        .border-bottom{
            border-bottom:1px solid #000;
        }

        .small{
            font-size:11px;
        }

        .signature td{

            height:80px;
        }

        @media print {

            @page {

                size: 21.5cm 14cm;
                margin: 5mm;

            }

            body{

                margin:0;
                padding:5px;
            }

        }

    </style>

</head>

<body onload="window.print()">

<div class="wrapper">

    {{-- HEADER --}}
    <table>

        <tr>

            <td width="35%">

                <strong style="font-size:24px;">
                    HABLY STORE
                </strong>

                <br>

                Jl. Kebayoran Lama No.3
                <br>

                Rt.06 Rw.01 Sukabumi Utara
                <br>

                Jakarta Barat
                <br>

                85691617500
                <br>

                hablystore@gmail.com

            </td>

            <td
                width="30%"
                class="text-center"
            >

                <div class="small">

                    {{ $sale->invoice_number }}

                </div>

                <br>

                <strong style="font-size:22px;">

                    FAKTUR PENJUALAN

                </strong>

                <br>

                Nomor Faktur

                <br>

                <strong>

                    {{ $sale->invoice_number }}

                </strong>

            </td>

            <td
                width="35%"
                class="text-right"
            >

                Tanggal Penjualan

                <br>

                <strong>

                    {{ date('d M Y', strtotime($sale->sale_date)) }}

                </strong>

                <br><br>

                Customer

                <br>

                <strong>

                    {{ $sale->customer_name }}

                </strong>

            </td>

        </tr>

    </table>

    <br>

    Catatan Invoice :
    UNIT HP

    {{-- TABLE BARANG --}}
    <table>

        <thead>

            <tr class="border-top border-bottom">

                <th width="5%">
                    No.
                </th>

                <th width="50%">
                    Barang
                </th>

                <th width="15%">
                    Harga
                </th>

                <th width="15%">
                    Diskon
                </th>

                <th width="15%">
                    Subtotal
                </th>

            </tr>

        </thead>

        <tbody>

            @php

                $grandTotal = 0;

            @endphp

            @foreach($sale->details as $key => $detail)

            @php

                $subtotal =
                    $detail->sell_price
                    - ($detail->discount ?? 0);

                $grandTotal += $subtotal;

            @endphp

            <tr class="border-bottom">

                <td>

                    {{ $key + 1 }}.

                </td>

                <td>

                    {{ $detail->product->brand }}
                    {{ $detail->product->model }}

                    Ram
                    {{ $detail->product->ram }}

                    /
                    {{ $detail->product->rom }}

                    <br>

                    {{ $detail->product->color }}

                    <br>

                    IMEI:
                    {{ $detail->imei1 }}

                </td>

                <td class="text-right">

                    Rp.
                    {{ number_format($detail->sell_price,0,',','.') }}

                </td>

                <td class="text-right">

                    Rp.
                    {{ number_format($detail->discount ?? 0,0,',','.') }}

                </td>

                <td class="text-right">

                    Rp.
                    {{ number_format($subtotal,0,',','.') }}

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

    <br>

    {{-- TOTAL --}}
    <table>

        <tr>

            <td width="70%"></td>

            <td width="30%">

                <table>

                    <tr>

                        <td>
                            Discount
                        </td>

                        <td class="text-right">

                            0%

                        </td>

                    </tr>

                    <tr class="border-top">

                        <td>

                            <strong>
                                Grand Total
                            </strong>

                        </td>

                        <td class="text-right">

                            <strong>

                                Rp.
                                {{ number_format($grandTotal,0,',','.') }}

                            </strong>

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

    <br><br>

    {{-- TANDA TANGAN --}}
    <table class="signature">

        <tr class="text-center">

            <td>Dibuat oleh</td>
            <td>Diperiksa oleh</td>
            <td>Penerima</td>
            <td>Hormat kami</td>

        </tr>

        <tr>

            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>

        <tr class="text-center">

            <td>(______________)</td>
            <td>(______________)</td>
            <td>(______________)</td>
            <td>(______________)</td>

        </tr>

    </table>

</div>

</body>
</html>