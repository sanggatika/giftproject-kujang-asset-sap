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
            <th colspan="8" style="text-align: center; font-weight: bold; font-size: 18px;">
                <p>DAFTAR TRANSAKSI ASSET INVENTORY</p>
            </th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center; font-weight: bold; font-size: 18px;">
                <p>GIFTPROJECT.ID</p>
            </th>
        </tr>
        <tr>
            <th colspan="8" style="text-align: center; font-weight: bold; font-size: 14px;">
                <p>TAHUN 2024</p>
            </th>
        </tr>
        <tr>
            <th colspan="10" style="text-align: center;">
                
            </th>
        </tr>
        <tr>
            <th></th>
            <th style="font-weight: bold;">Tanggal Update</th>
            <th colspan="8" style="font-weight: bold;">: {{ $formattedDate }}</th>
        </tr>
        <tr>
            <th></th>
            <th style="font-weight: bold;">Jumlah Transaksi </th>
            <th colspan="8" style="font-weight: bold;">: {{ $model['transaksi_inventory']->count(); }}</th>
        </tr>
        <tr>
            <th colspan="10" style="text-align: center;">
                
            </th>
        </tr>
        <tr>
            <th colspan="10" style="text-align: center;">
                
            </th>
        </tr>
        <tr>
            <th style="width: 50px; text-align: center; font-weight: bold;">NO</th>
            <th style="width: 300px; text-align: center; font-weight: bold;">Data Purchases</th>
            <th style="width: 150px; text-align: center; font-weight: bold;">Tanggal</th>
            <th style="width: 300px; text-align: center; font-weight: bold;">Supplier Nama</th>
            <th style="width: 300px; text-align: center; font-weight: bold;">Barang</th>            
            <th style="width: 200px; text-align: center; font-weight: bold;">Kondisi</th>
            <th style="width: 50px; text-align: center; font-weight: bold;">Jumlah</th>
            <th style="width: 120px; text-align: center; font-weight: bold;">Harga Purchases</th>
            <th style="width: 120px; text-align: center; font-weight: bold;">Harga Jual</th>   
            <th style="width: 120px; text-align: center; font-weight: bold;">Nilai Asset</th>         
        </tr>
    </thead>
    <tbody>
        
        @php
            $total_stok = 0;
            $total_harga_purchases = 0;
            $total_harga_jual = 0;
            $total_nilai_asset = 0;
        @endphp

        @foreach($model['transaksi_inventory'] as $inventory)
        <tr>
            @php
                $nilai_asset = $inventory->qty * $inventory->harga_jual;
            @endphp

            <td style="text-align: center; font-weight: bold;" valign="top">
                {{ $loop->iteration }}
            </td>
            <td style="font-weight: bold;" valign="top">
                {{ $inventory->trPurchases->invoice_nomor }}
            </td>
            <td valign="top">
                {{ Carbon::parse($inventory->trPurchases->invoice_tanggal)->locale('id')->isoFormat('D MMMM Y') }}
            </td>
            <td style="font-weight: bold;" valign="top">
                {{ $inventory->trPurchases->mSupplier->nama }}
            </td>
            <td style="font-weight: bold;" valign="top">
                {{ $inventory->barang_nama }}
            </td>
            <td style="font-weight: bold; text-align: center;" valign="top">
                {{ $inventory->kondisi }}
            </td>
            <td style="font-weight: bold; text-align: center;" valign="top">
                {{ $inventory->qty }}
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                {{ number_format($inventory->harga_purchases,0,',','.') }}
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                {{ number_format($inventory->harga_jual,0,',','.') }}
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                {{ number_format($nilai_asset,0,',','.') }}
            </td>
        </tr>

        @php
            $total_stok = $total_stok + $inventory->qty;
            $total_harga_purchases = $total_harga_purchases + $inventory->harga_purchases;
            $total_harga_jual = $total_harga_jual + $inventory->harga_jual;
            $total_nilai_asset = $total_nilai_asset + $nilai_asset;
        @endphp

        @endforeach

        <tr>
            <td colspan="10">
                
            </td>
        </tr>

        <tr>
            <td colspan="6"  style="font-weight: bold; text-align: center;" valign="top">
                Total Transaksi Asset Inventory
            </td>
            <td style="font-weight: bold; text-align: center;" valign="top">
                {{ number_format($total_stok,0,',','.') }}
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                {{ number_format($total_harga_purchases,0,',','.') }}
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                {{ number_format($total_harga_jual,0,',','.') }}
            </td>
            <td style="font-weight: bold; text-align: right;" valign="top">
                {{ number_format($total_nilai_asset,0,',','.') }}
            </td>
        </tr>

        <tr>
            <td colspan="10">
                
            </td>
        </tr>

        <tr>
            <td colspan="10" style="height: 50px;" valign="top">
                <i>CATATAN : </i> &nbsp;&nbsp; Data Transaksi Sesuai Dengan Filter Data <br>
            </td>
        </tr>
    
    </tbody>
</table>