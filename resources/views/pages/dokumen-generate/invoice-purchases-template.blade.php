<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <style>
        body {
            color:black;
            font-size:12pt;
            -webkit-print-color-adjust:exact;
            font-family:Arial
        }

        #header-table{
            font-family:Arial;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
            font-family:Arial;
        }

        .table, td, th {
            text-align: left;
            font-family:Arial;
            vertical-align: text-top;
        }

        ul, ol, li {
            margin-top: 0.83em;
            margin-bottom: 0.83em;
        }

        @page {
            footer: page-footer;    
        }

    </style>

</head>
  <body>

    <htmlpagefooter name="page-footer">
        <img src="{{ 'images/pdf-footer-2.png' }}" style="margin-top:0px; margin-right:-50px; margin-bottom:-20px;" alt="Foto">
    </htmlpagefooter>

    <div class="header">
        <img src="{{ 'images/pdf-header-2.png' }}" style="margin-top: -50px; margin-right:-50px;  float: right;" height=150 alt="Foto">
        <img src="{{ 'images/logo_giftproject_landscape_4.png' }}" style="margin-top:0px;" height=90 alt="Foto">
    </div>

    <table border="0" width="100%" id="header-table">
        <tbody>
            <tr>
                <td style="text-align:center;">
                    {{-- <b style="font-size:22px; padding:0px; text-indent: 20px;"> INVOICE PURCHASES  </b> <br/> --}}
                    <b style="font-size:22px;"> CV. GIFT PROJECT </b> <br/>
                    <div style="font-size:11pt">
                        Jl. Darussalam Johar Timur, Karawang Timur, Karawang, Jawa Barat 41314.<br/> Tlp. (0267) 641 614 Mobile. +62 8124 9999 109
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <hr style="height:3px;background-color:#000; margin-top:0px;"/>    

    <table border="0" width="100%" id="header-table" style="font-size: 12px; vertical-align: top;">
        <tbody>
            <tr>
                <td style="width: 20% padding-bottom:10px;">
                    Data Supplier
                </td>
                <td style="width: 3% padding-bottom:10px;">
                    :
                </td>
                <td style="padding-bottom:10px;">
                    <b> {{ $data_transaksi->mSupplier->nama }} </b>
                </td>
                <td style="padding-bottom:10px;">
                    Invoice : <b> {{ Carbon\Carbon::parse($data_transaksi->invoice_tanggal)->locale('id')->isoFormat('D MMMM Y') }}</b>
                </td>
            </tr>
            <tr>
                <td style="width: 20% padding-bottom:10px;">
                    Email Supplier
                </td>
                <td style="width: 3% padding-bottom:10px;">
                    : 
                </td>
                <td style="padding-bottom:10px;">
                    <b> {{ $data_transaksi->mSupplier->email }} </b>
                </td>
                <td style="padding-bottom:10px;">
                    <b style="font-size: 14px;"> {{ $data_transaksi->invoice_nomor }} </b>
                </td>
            </tr>
            <tr>
                <td style="width: 20% padding-bottom:10px;">
                    handphone Supplier
                </td>
                <td style="width: 3% padding-bottom:10px;">
                    : 
                </td>
                <td style="padding-bottom:10px;" colspan="2">
                    <b> {{ $data_transaksi->mSupplier->handphone }} </b>
                </td>
            </tr>
            <tr>
                <td style="width: 20% padding-bottom:10px;">
                    Alamat Supplier
                </td>
                <td style="width: 3% padding-bottom:10px;">
                    : 
                </td>
                <td style="padding-bottom:10px;" colspan="2">
                    <b> {{ $data_transaksi->mSupplier->alamat }} - {{ $data_transaksi->mSupplier->alamat_kabupaten_nama }} </b>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table border="1" style="width: 100%; font-size: 12px; border-collapse: collapse;">
        <tr>
            <td style="padding:10px; text-align: center; background-color: #00a89f; color: white;">
                <b>No.</b>
            </td>
            <td style="padding:10px; text-align: center; background-color: #036cb6;">
                <b>Produk</b>
            </td>
            <td style="padding:10px; text-align: center; background-color: #00a89f; color: white;">
                <b>Harga Unit</b>
            </td>
            <td style="padding:10px; text-align: center; background-color: #036cb6;">
                <b>QTY</b>
            </td>
            <td style="padding:10px; text-align: center; background-color: #00a89f; color: white;">
                <b>Diskon</b>
            </td>
            <td style="padding:10px; text-align: center; background-color: #036cb6;">
                <b>Sub Total</b>
            </td>
        </tr>
        @php
            $purchases_sub_total = 0;
            $purchases_pajak = 0;
            $purchases_diskon = 0;
            $purchases_shipping = 0;
            $purchases_grandtotal = 0;
        @endphp

        @foreach ($data_transaksi->trPurchasesDetail as $barang)
        <tr>
            <td style="padding:10px; text-align: center;">
                {{ $loop->iteration }}
            </td>
            <td style="padding:10px;">
                <b>{{ $barang->barang_nama }}</b><br>
                <small>{{ $barang->barang_kode }}</small>
                <hr style="height:1px;background-color:#000; margin-top:0px;"/> 
                <small>{{ $barang->jenis_barang_nama }} - <b>{{ $barang->kondisi }}</b></small>
            </td>
            <td style="padding:10px; text-align: right;">
                <b>{{ number_format($barang->harga,0,',','.') }}</b><br>
            </td>
            <td style="padding:10px; text-align: center;">
                <b>{{ number_format($barang->qty,0,',','.') }}</b><br>
            </td>
            <td style="padding:10px; text-align: center;">
                <b>{{ number_format($barang->discount,0,',','.') }}</b><br>
            </td>
            <td style="padding:10px; text-align: right;">
                <b>{{ number_format($barang->total,0,',','.') }}</b><br>
            </td>
        </tr>
        @php
            $purchases_sub_total = (int)$purchases_sub_total + (int)$barang->total;
        @endphp
        @endforeach        
    </table>
    <br>
    @php
        $purchases_pajak = ($data_transaksi->tax / 100) * ($purchases_sub_total);
        $purchases_diskon = ($data_transaksi->discount / 100) * ($purchases_sub_total);
        $purchases_shipping = $data_transaksi->shipping;

        // Perhitungan Grand Total
        $purchases_grandtotal = $purchases_sub_total + $purchases_pajak;
        $purchases_grandtotal = $purchases_grandtotal - $purchases_diskon;
        $purchases_grandtotal = $purchases_grandtotal + $purchases_shipping;
    @endphp
    
    <table border="0" width="100%" id="header-table" style="font-size: 12px; vertical-align: top;">
        <tbody>
            <tr>
                <td style="padding:5px; " rowspan="5">
                    <img src="{{ $file_qr }}" style="margin-top:0px;" height=150 alt="Foto">
                </td>
                <td style="padding:5px;">
                    <b>Sub-Total</b>
                </td>
                <td style="padding:5px;">
                    <b>: Rp. </b>
                </td>
                <td style="padding:5px; text-align: right;">
                    <b>{{ number_format($purchases_sub_total,0,',','.') }}</b>
                </td>
            </tr>
            <tr>
                <td style="padding:5px;">
                    <b>Pajak</b>
                </td>
                <td style="padding:5px;">
                    <b>: Rp. </b>
                </td>
                <td style="padding:5px; text-align: right;">
                    <b>{{ number_format($purchases_pajak,0,',','.') }}</b>
                </td>
            </tr>
            <tr>
                <td style="padding:5px;">
                    <b>Diskon</b>
                </td>
                <td style="padding:5px;">
                    <b>: Rp. </b>
                </td>
                <td style="padding:5px; text-align: right;">
                    <b>{{ number_format($purchases_diskon,0,',','.') }}</b>
                </td>
            </tr>
            <tr>
                <td style="padding:5px;">
                    <b>Shipping</b>
                </td>
                <td style="padding:5px;">
                    <b>: Rp. </b>
                </td>
                <td style="padding:5px; text-align: right;">
                    <b>{{ number_format($purchases_shipping,0,',','.') }}</b>
                    <hr style="height:2px;background-color:#000; margin-top:0px;"/> 
                </td>
            </tr>
            <tr>
                <td style="padding:5px; background-color: #036cb6;">
                    <b>Grand Total</b>
                </td>
                <td style="padding:5px; background-color: #036cb6;">
                    <b>: Rp. </b>
                </td>
                <td style="padding:5px; text-align: right; background-color: #036cb6;">
                    <b>{{ number_format($purchases_grandtotal,0,',','.') }}</b>
                </td>
            </tr>
        </tbody>
    </table>

    <br>
    <b style="font-size:11pt;">Keterangan / Catatan :</b> <br/>
    <table border="0" style="width: 100%; border-collapse: collapse;">
        @if ($data_transaksi->catatan)
        <tr>
            <td width="5%" style="padding: 2px; font-size:10pt; text-align: center;">-</td>
            <td style="padding: 2px; font-size:10pt; text-align: justify;">{{ $data_transaksi->catatan }} </td>
        </tr>
        @endif        
        <tr>
            <td width="5%" style="padding: 2px; font-size:10pt; text-align: center;">-</td>
            <td style="padding: 2px; font-size:10pt; text-align: justify;">Data QR-Code Digunakan Untuk Trancking Transaksi Purchases</td>
        </tr>
    </table>

    <br>
    <br>
    <table border="0" width="100%" id="body-tte" style="font-size:11pt;">
        <tbody>
            <tr>
                <td style="text-align:left; vertical-align: top; width: 50%;">
                </td>
                <td style="text-align:left; vertical-align: top; width: 50%;">
                    Ditetapkan di &nbsp;: &nbsp;&nbsp; Karawang <br>
                    Pada tanggal &nbsp;: &nbsp;&nbsp; 12 Januari 2024
                    <hr>
                </td>
            </tr>
            <tr>
                <td style="text-align:left; vertical-align: top; width: 50%;">
                </td>
                <td style="text-align:center; vertical-align: top; width: 50%;">
                    <b>D I R E K T U R</b> <br>
                    <img src="{{ 'images/logo_giftproject_landscape_4.png' }}" style="margin-top:0px;" height=100 alt="Foto"> <br><br>
                    <b>GIRI SANGGATIKA</b>
                </td>
            </tr>
        </tbody>
    </table>

  </body>
</html>