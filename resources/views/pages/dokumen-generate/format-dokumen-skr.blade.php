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
                    <img src="{{ 'images/karawangkab_logo.png' }}" style="margin-top:0px;" height=100 alt="Foto">
                </td>
                <td style="text-align:center;">
                    <span style="font-size:18px;"> PEMERINTAH KABUPATEN KARAWANG  </span> <br/>
                    <b style="font-size:22px; padding:0px; text-indent: 20px;"> DINAS KESEHATAN  </b> <br/>
                    <b style="font-size:22px;"> UPTD LABORATORIUM KESEHATAN </b> <br/>
                    <div style="font-size:11pt">
                        Jl. Dr. Taruno No. Adiarsa Barat Telp (0267) 401768 Karawang 41313
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <hr style="height:3px;background-color:#000; margin-top:0px;"/>

    <table border="1" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td width="20%" style="padding: 5px; font-size:12pt; text-align: center;"><b>PEMERINTAH KABUPATEN KARAWANG</b></td>
            <td style="padding: 5px; font-size:14pt; text-align: center;"><b>SURAT KETETAPAN RETRIBUSI <br> (SKR)</b></td>
            <td width="20%" style="padding: 5px; font-size:12pt; text-align: center;"><b>NOMOR SKR</b> <br> SKR / {{$data_permohonan['tahun']}} / {{$data_permohonan['nomor']}}</td>
        </tr>
        <tr>
            <td width="20%" style="padding: 5px; font-size:11pt;">Tahun</td>
            <td colspan="2" style="padding: 5px; font-size:11pt; "><b>{{$data_permohonan['tahun']}}</b> </td>
        </tr>
        <tr>
            <td width="20%" style="padding: 5px; font-size:11pt;">Nama</td>
            <td colspan="2" style="padding: 5px; font-size:11pt; "><b>{{$data_permohonan['nama_customer']}}</b></td>
        </tr>
        <tr>
            <td width="20%" style="padding: 5px; font-size:11pt;">Alamat</td>
            <td colspan="2" style="padding: 5px; font-size:11pt; height: 50px;"> {{$data_permohonan['alamat_customer']}}</td>
        </tr>
    </table>

    <br><br>
    
    <table border="1" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td width="40%" style="padding: 5px; font-size:12pt; text-align: center;">
                @php
                    // use Illuminate\Support\Facades\Storage;
                    // $qrImageContent = file_get_contents(url('/dev/view/qr-code/'.$qr_filename));
                    // $qrImageBase64 = base64_encode($qrImageContent);
                    // http://localhost:8000/dev/view/qr-code/qr-8ed588e9-4c16-43c1-9c8d-ad811e7291a6-1701060858.png
                @endphp

                <img src="{{ $file_qr }}" style="margin-top:0px;" height=150 alt="Foto">
                {{-- {{ url('/dev/view/qr-code/'.$qr_filename) }} --}}
            </td>
            <td style="padding: 5px; font-size:14pt; text-align: center;"><b>KODE TRANSAKSI </b> <br><br><br> <b style="font-size:20pt;">{{$qr_generate}}</b></td>
        </tr>
    </table>

    <br>

    <b style="font-size:11pt;">Keterangan :</b> <br/>
    <table border="0" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td width="5%" style="padding: 2px; font-size:10pt; text-align: center;">-</td>
            <td style="padding: 2px; font-size:10pt; text-align: justify;">Penyetoran non tunai dilakukan pada Bank Jabar Banten (BJB ) MKIOS Retribusi Kabupaten Karawang </td>
        </tr>
        <tr>
            <td width="5%" style="padding: 2px; font-size:10pt; text-align: center;">-</td>
            <td style="padding: 2px; font-size:10pt; text-align: justify;">Bukti setoran digunakan sebagai syarat pengambilan laporan hasil</td>
        </tr>
        <tr>
            <td width="5%" style="padding: 2px; font-size:10pt; text-align: center;">-</td>
            <td style="padding: 2px; font-size:10pt; text-align: justify;">Harga tersebut diatas sesuai Peraturan Daerah Kabupaten Karawang Nomor 2 Tahun 2021 dan tidak dikenakan pajak</td>
        </tr>
    </table>

  </body>
</html>