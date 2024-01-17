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
                <p>DAFTAR TRANSAKSI PURCHASES</p>
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
            <th colspan="9" style="font-weight: bold;">: {{ $model['transaksi_purchases']->count(); }}</th>
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
            <th style="width: 300px; text-align: center; font-weight: bold;">Data Purchases</th>
            <th style="width: 150px; text-align: center; font-weight: bold;">Tanggal</th>
            <th style="width: 300px; text-align: center; font-weight: bold;">Supplier Nama</th>
            <th style="width: 300px; text-align: center; font-weight: bold;">Supplier Kontak</th>
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
            $total_purchases = 0;     
        @endphp

        @foreach($model['transaksi_purchases'] as $purchases)
            @php
                $tr_purchases = null;
            @endphp
            @foreach($purchases->trPurchasesDetail as $purchases_detail)
            <tr>
                @if ( $tr_purchases != $purchases->kode)
                    <td rowspan="{{ $purchases->trPurchasesDetail->count() }}" style="text-align: center; font-weight: bold;" valign="top">
                        {{ $no_loop }}
                    </td>
                    <td rowspan="{{ $purchases->trPurchasesDetail->count() }}" style="font-weight: bold;" valign="top">
                        {{ $purchases->invoice_nomor }}
                    </td>
                    <td rowspan="{{ $purchases->trPurchasesDetail->count() }}" valign="top">
                        {{ Carbon::parse($purchases->invoice_tanggal)->locale('id')->isoFormat('D MMMM Y') }}
                    </td>
                    <td rowspan="{{ $purchases->trPurchasesDetail->count() }}" valign="top">
                        {{ $purchases->mSupplier->nama }}
                    </td>
                    <td rowspan="{{ $purchases->trPurchasesDetail->count() }}" valign="top">
                        {{ $purchases->mSupplier->email }}
                    </td>
                @endif

                <td style="font-weight: bold;" valign="top">
                    {{ $purchases_detail->barang_nama }}
                </td>
                <td style="font-weight: bold; text-align: center;" valign="top">
                    {{ $purchases_detail->qty }}
                </td>
                <td style="font-weight: bold; text-align: right;" valign="top">
                    {{ number_format($purchases_detail->harga,0,',','.') }}
                </td>
                <td style="font-weight: bold; text-align: right;" valign="top">
                    {{ number_format($purchases_detail->total,0,',','.') }}
                </td>

                @if ( $tr_purchases != $purchases->kode)
                    <td rowspan="{{ $purchases->trPurchasesDetail->count() }}" style="font-weight: bold; text-align: center;" valign="top">
                        @if ($purchases->tax)
                        {{ $purchases->tax }} %
                        @else
                        0
                        @endif                        
                    </td>
                    <td rowspan="{{ $purchases->trPurchasesDetail->count() }}" style="font-weight: bold; text-align: center;" valign="top">
                        @if ($purchases->discount)
                        {{ $purchases->discount }} %
                        @else
                        0
                        @endif 
                    </td>
                    <td rowspan="{{ $purchases->trPurchasesDetail->count() }}" style="font-weight: bold; text-align: right;" valign="top">
                        {{ number_format($purchases->shipping,0,',','.') }},00
                    </td>
                    <td rowspan="{{ $purchases->trPurchasesDetail->count() }}" style="font-weight: bold; text-align: right;" valign="top">
                        {{ number_format($purchases->total,0,',','.') }},00
                    </td>
                @endif
            </tr>

            @php
                $tr_purchases = $purchases->kode;
            @endphp

            @endforeach 
            
            @php
                $no_loop = $no_loop + 1;    
                $total_purchases = $total_purchases + $purchases->total;
            @endphp
        @endforeach

        <tr>
            <td colspan="13">
                
            </td>
        </tr>

        <tr>
            <td colspan="11"  style="font-weight: bold; text-align: center;" valign="top">
                Total Transaksi Purchases
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                Rp.
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                {{ number_format($total_purchases,0,',','.') }},00
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