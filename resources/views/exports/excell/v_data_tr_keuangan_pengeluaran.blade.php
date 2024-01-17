@php
    use Carbon\Carbon;
    Carbon::setLocale('id_ID');
    $formattedDate = Carbon::now()->translatedFormat('l, d F Y - H:i');
@endphp

<table>
    <thead>        
        <tr>
            <th rowspan="3" colspan="2" style="text-align: center;">
                
            </th>
            <th colspan="4" style="text-align: center; font-weight: bold; font-size: 18px;">
                <p>DATA LAPORAN KEUANGAN - PENGELUARAN</p>
            </th>
        </tr>
        <tr>
            <th colspan="4" style="text-align: center; font-weight: bold; font-size: 18px;">
                <p>GIFTPROJECT.ID</p>
            </th>
        </tr>
        <tr>
            <th colspan="4" style="text-align: center; font-weight: bold; font-size: 14px;">
                <p>TAHUN 2024</p>
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">
                
            </th>
        </tr>
        <tr>
            <th></th>
            <th style="font-weight: bold;">Tanggal Update</th>
            <th colspan="4" style="font-weight: bold;">: {{ $formattedDate }}</th>
        </tr>
        <tr>
            <th></th>
            <th style="font-weight: bold;">Jumlah Transaksi </th>
            <th colspan="4" style="font-weight: bold;">: {{ $model['transaksi_keuangan_pengeluaran']->count(); }}</th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">
                
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: center;">
                
            </th>
        </tr>
        <tr>
            <th style="width: 50px; text-align: center; font-weight: bold;">NO</th>
            <th style="width: 300px; text-align: center; font-weight: bold;">Kode</th>
            <th style="width: 150px; text-align: center; font-weight: bold;">Tanggal</th>
            <th style="width: 400px; text-align: center; font-weight: bold;">Pengeluaran</th>
            <th style="width: 300px; text-align: center; font-weight: bold;">Jenis</th>            
            <th style="width: 200px; text-align: center; font-weight: bold;">Nominal</th>       
        </tr>
    </thead>
    <tbody>
        
        @php
            $total_pengeluaran = 0;
        @endphp
        @foreach($model['transaksi_keuangan_pengeluaran'] as $pengeluaran)
        <tr>
            <td style="text-align: center; font-weight: bold;" valign="top">
                {{ $loop->iteration }}
            </td>
            <td style="font-weight: bold;" valign="top">
                {{ $pengeluaran->kode }}
            </td>
            <td valign="top">
                {{ Carbon::parse($pengeluaran->waktu)->locale('id')->isoFormat('D MMMM Y') }}
            </td>
            <td style="font-weight: bold;" valign="top">
                {{ $pengeluaran->judul }}
            </td>
            <td style="font-weight: bold;" valign="top">
                {{ strtoupper($pengeluaran->jenis) }}
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                {{ number_format($pengeluaran->nominal,0,',','.') }},00
            </td>
        </tr>    
        @php
            $total_pengeluaran = $total_pengeluaran + $pengeluaran->nominal;
        @endphp    
        @endforeach

        <tr>
            <td colspan="6">
                
            </td>
        </tr>

        <tr>
            <td colspan="4"  style="font-weight: bold; text-align: center;" valign="top">
                Total Laporan Keuangan - Pengeluaran
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                Rp.
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                {{ number_format($total_pengeluaran,0,',','.') }},00
            </td>
        </tr>

        <tr>
            <td colspan="6">
                
            </td>
        </tr>

        <tr>
            <td colspan="10" style="height: 50px;" valign="top">
                <i>CATATAN : </i> &nbsp;&nbsp; Data Transaksi Sesuai Dengan Filter Data <br>
            </td>
        </tr>
    
    </tbody>
</table>