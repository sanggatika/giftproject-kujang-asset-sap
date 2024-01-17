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
            <th colspan="11" style="text-align: center; font-weight: bold; font-size: 18px;">
                <p>DAFTAR TRANSAKSI PENJUALAN</p>
            </th>
        </tr>
        <tr>
            <th colspan="11" style="text-align: center; font-weight: bold; font-size: 18px;">
                <p>GIFTPROJECT.ID</p>
            </th>
        </tr>
        <tr>
            <th colspan="11" style="text-align: center; font-weight: bold; font-size: 14px;">
                <p>TAHUN 2024</p>
            </th>
        </tr>
        <tr>
            <th colspan="13" style="text-align: center;">
                
            </th>
        </tr>
        <tr>
            <th></th>
            <th style="font-weight: bold;">Tanggal Update</th>
            <th colspan="9" style="font-weight: bold;">: {{ $formattedDate }}</th>
        </tr>
        <tr>
            <th></th>
            <th style="font-weight: bold;">Jumlah Transaksi </th>
            <th colspan="9" style="font-weight: bold;">: {{ $model['transaksi_penjualan']->count(); }}</th>
        </tr>
        <tr>
            <th colspan="11" style="text-align: center;">
                
            </th>
        </tr>
        <tr>
            <th colspan="11" style="text-align: center;">
                
            </th>
        </tr>
        <tr>
            <th style="width: 50px; text-align: center; font-weight: bold;">NO</th>
            <th style="width: 300px; text-align: center; font-weight: bold;">Data Penjualan</th>
            <th style="width: 150px; text-align: center; font-weight: bold;">Tanggal</th>
            <th style="width: 300px; text-align: center; font-weight: bold;">Customer Nama</th>
            <th style="width: 300px; text-align: center; font-weight: bold;">Customer Kontak</th>
            <th style="width: 300px; text-align: center; font-weight: bold;">Barang</th>
            <th style="width: 50px; text-align: center; font-weight: bold;">Jumlah</th>
            <th style="width: 120px; text-align: center; font-weight: bold;">Harga</th>
            <th style="width: 120px; text-align: center; font-weight: bold;">Sub-Total</th>
            <th style="width: 50px; text-align: center; font-weight: bold;">TAX</th>
            <th style="width: 80px; text-align: center; font-weight: bold;">Discount</th>
            <th style="width: 120px; text-align: center; font-weight: bold;">Shipping</th>
            <th style="width: 120px; text-align: center; font-weight: bold;">Total</th>            
        </tr>
    </thead>
    <tbody>
        
        @php
            $no_loop = 1;
            $total_penjualan = 0;     
        @endphp

        @foreach($model['transaksi_penjualan'] as $penjualan)
            @php
                $tr_penjualan = null;
            @endphp
            @foreach($penjualan->trPenjualanDetail as $penjualan_detail)
            <tr>
                @if ( $tr_penjualan != $penjualan->kode)
                    <td rowspan="{{ $penjualan->trPenjualanDetail->count() }}" style="text-align: center; font-weight: bold;" valign="top">
                        {{ $no_loop }}
                    </td>
                    <td rowspan="{{ $penjualan->trPenjualanDetail->count() }}" style="font-weight: bold;" valign="top">
                        {{ $penjualan->invoice_nomor }}
                    </td>
                    <td rowspan="{{ $penjualan->trPenjualanDetail->count() }}" valign="top">
                        {{ Carbon::parse($penjualan->invoice_tanggal)->locale('id')->isoFormat('D MMMM Y') }}
                    </td>
                    <td rowspan="{{ $penjualan->trPenjualanDetail->count() }}" valign="top">
                        {{ $penjualan->mCustomer->nama }}
                    </td>
                    <td rowspan="{{ $penjualan->trPenjualanDetail->count() }}" valign="top">
                        {{ $penjualan->mCustomer->email }}
                    </td>
                @endif

                <td style="font-weight: bold;" valign="top">
                    {{ $penjualan_detail->barang_nama }}
                </td>
                <td style="font-weight: bold; text-align: center;" valign="top">
                    {{ $penjualan_detail->qty }}
                </td>
                <td style="font-weight: bold; text-align: right;" valign="top">
                    {{ number_format($penjualan_detail->harga,0,',','.') }}
                </td>
                <td style="font-weight: bold; text-align: right;" valign="top">
                    {{ number_format($penjualan_detail->total,0,',','.') }}
                </td>

                @if ( $tr_penjualan != $penjualan->kode)
                    <td rowspan="{{ $penjualan->trPenjualanDetail->count() }}" style="font-weight: bold; text-align: center;" valign="top">
                        @if ($penjualan->tax)
                        {{ $penjualan->tax }} %
                        @else
                        0
                        @endif                        
                    </td>
                    <td rowspan="{{ $penjualan->trPenjualanDetail->count() }}" style="font-weight: bold; text-align: center;" valign="top">
                        @if ($penjualan->discount)
                        {{ $penjualan->discount }} %
                        @else
                        0
                        @endif 
                    </td>
                    <td rowspan="{{ $penjualan->trPenjualanDetail->count() }}" style="font-weight: bold; text-align: right;" valign="top">
                        {{ number_format($penjualan->shipping,0,',','.') }},00
                    </td>
                    <td rowspan="{{ $penjualan->trPenjualanDetail->count() }}" style="font-weight: bold; text-align: right;" valign="top">
                        {{ number_format($penjualan->total,0,',','.') }},00
                    </td>
                @endif
            </tr>

            @php
                $tr_penjualan = $penjualan->kode;
            @endphp

            @endforeach 
            
            @php
                $no_loop = $no_loop + 1;    
                $total_penjualan = $total_penjualan + $penjualan->total;
            @endphp
        @endforeach

        <tr>
            <td colspan="13">
                
            </td>
        </tr>

        <tr>
            <td colspan="11"  style="font-weight: bold; text-align: center;" valign="top">
                Total Transaksi Penjualan
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                Rp.
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                {{ number_format($total_penjualan,0,',','.') }},00
            </td>
        </tr>

        <tr>
            <td colspan="13">
                
            </td>
        </tr>

        <tr>
            <td colspan="13" style="height: 50px;" valign="top">
                <i>CATATAN : </i> &nbsp;&nbsp; Data Transaksi Sesuai Dengan Filter Data <br>
            </td>
        </tr>
    
    </tbody>
</table>