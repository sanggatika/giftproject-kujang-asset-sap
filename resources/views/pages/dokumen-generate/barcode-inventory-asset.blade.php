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

    <table border="0" width="100%" id="header-table">
        <tbody>
            <tr>
                <td style="text-align:center;margin-left:30px;" valign=middle>
                    <img src="{{ 'images/logo_giftproject_landscape_5.png' }}" style="margin-top:0px;" height=100 alt="Foto">
                </td>
                <td style="text-align:center;">
                    <b style="font-size:22px; padding:0px; text-indent: 20px;"> PRINT BARCODE ASSET  </b> <br/>
                    <b style="font-size:22px;"> CV. GIFT PROJECT </b> <br/>
                    <div style="font-size:11pt">
                        Jl. Darussalam Johar Timur, Karawang Timur, Karawang, Jawa Barat 41314.<br/> Tlp. (0267) 641 614 Mobile. +62 8124 9999 109
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <hr style="height:3px;background-color:#000; margin-top:0px;"/> 
    
    <table border="0" width="100%" id="data-barang" style="font-size: 12px; vertical-align: top;">
        <tbody>
            <tr>
                <td style="width: 20% padding-bottom:10px;">
                    Nama Barang
                </td>
                <td style="width: 3% padding-bottom:10px;">
                    :
                </td>
                <td style="padding-bottom:10px;">
                    <b> {{ $data_transaksi->mBarang->nama }} </b>
                </td>
                <td style="padding-bottom:10px;">
                    Invoice : <b> {{ Carbon\Carbon::parse($data_transaksi->trPurchases->created_at)->locale('id')->isoFormat('D MMMM Y') }}</b>
                </td>
            </tr>
            <tr>
                <td style="width: 20% padding-bottom:10px;">
                    Nama Supplier
                </td>
                <td style="width: 3% padding-bottom:10px;">
                    : 
                </td>
                <td style="padding-bottom:10px;">
                    <b> {{ $data_transaksi->trPurchases->mSupplier->nama }} </b>
                </td>
                <td style="padding-bottom:10px;">
                    <b style="font-size: 14px;"> {{ $data_transaksi->trPurchases->invoice_nomor }} </b>
                </td>
            </tr>
            <tr>
                <td style="width: 20% padding-bottom:10px;">
                    Harga
                </td>
                <td style="width: 3% padding-bottom:10px;">
                    : 
                </td>
                <td style="padding-bottom:10px;" colspan="2">
                    <b> Rp. {{  number_format($data_transaksi->harga_jual,0,',','.') }} </b>
                </td>
            </tr>
        </tbody>
    </table>
    
    <br>

    <table border="1">
        
        @php
            $jumlahdata = $jumlah_cetak; // Your data array
            $maxColumns = 3; // Maximum number of columns per row
            $rowCount = ceil($jumlahdata / $maxColumns); // Calculate the number of rows needed

            $file_barcode = strtolower($data_transaksi->kode).".png";
        @endphp

        @for ($i = 0; $i < $rowCount; $i++)
            <tr>
                @for ($j = 0; $j < $maxColumns; $j++)
                    @php
                        $index = $i * $maxColumns + $j;
                    @endphp

                    @if ($index < $jumlahdata)
                        <td style="padding:5px; text-align: center;">
                            <img src="{{ 'storage/barcodes/inventory/' }}{{ $file_barcode }}" style="margin-top:0px;" height=50 alt="Foto">
                            <b style="font-size:10pt">{{ $data_transaksi->kode }}</b>
                        </td>
                    @else
                        <td></td> {{-- Add an empty cell if no data available --}}
                    @endif
                @endfor
            </tr>
        @endfor

    </table>

  </body>
</html>