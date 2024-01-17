"use strict";
var data_decrpty = null;

function act_resetFilter()
{
    location.reload();
    return false;
}

form_filter_barang.onchange = evt => {
    serverSideDatatables();
}

form_filter_jenisbarang.onchange = evt => {
    serverSideDatatables();
}

form_filter_supplier.onchange = evt => {
    serverSideDatatables();
}

form_filter_status.onchange = evt => {
    serverSideDatatables();
}

function serverSideDatatables()
{
    let form_filter_barang = $("#form_filter_barang").val();
    let form_filter_jenisbarang = $("#form_filter_jenisbarang").val();
    let form_filter_supplier = $("#form_filter_supplier").val();
    let form_filter_status = $("#form_filter_status").val();

    $('#tabel_master_data').dataTable().fnDestroy();

    $('#tabel_master_data').DataTable({
        processing: true,
        serverSide: true,
        searching:true,        
        pageLength: 10,
        ajax: {
            url: BaseURL + "/transaksi/inventory/data/get_datatable",
            type: "POST",
            data: {
                form_filter_barang:form_filter_barang,
                form_filter_jenisbarang:form_filter_jenisbarang,
                form_filter_supplier:form_filter_supplier,
                form_filter_status:form_filter_status
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                // setting a timeout
                KTApp.showPageLoading();
            },
            dataSrc: function (data) {
                // console.log(data);
                KTApp.hidePageLoading();
                loadingEl.remove(); 

                return data.data;
            },
            error: function ()
            {
                KTApp.hidePageLoading();
                loadingEl.remove(); 

                Swal.fire({
                    title: 'Informasi !',
                    text: ' Harap Hubungi Petugas, Data Tidak Bisa Di Load',
                    icon: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', class:'text-center'},
            {data: 'fild_img', name: 'fild_img'},
            {data: 'fild_nama', name: 'fild_nama'},
            {data: 'fild_supplier', name: 'fild_supplier'},
            {data: 'fild_kondisi', name: 'fild_kondisi'},
            {data: 'fild_limit', name: 'fild_limit'},
            {data: 'fild_harga_purchases', name: 'fild_harga_purchases'},
            {data: 'fild_harga_jual', name: 'fild_harga_jual'},
            {data: 'fild_status', name: 'fild_status'},
            {data: 'action', name: 'action'}            
        ]
    });
}

function datatabelesreload()
{
	$('#tabel_master_data').DataTable().ajax.reload(null, false); //Reload Tanpa Reset Page Datatable
}

function btnDetailMasterdata(data)
{
    $('#form_barcode_inventory_kode').val('');
    $('#form_barcode_inventory_jumlah').val('');

    let data_id = $(data).attr('data-id');

    $.ajax({
        url: BaseURL + "/transaksi/inventory/data/act_detail",
        async:false,
        data: {
            data_id,
        },
        method: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if(data.status == true)
            {   
                console.log(data.data);
                if(data.data.m_barang.logo != null)
                {
                    // console.log(BaseURL + "/storage/dokumen-club/logo/" + data.data.logo);
                    $("#img_masterdata_barang").attr("src", BaseURL + "/storage/masterdata/barang/" + data.data.m_barang.logo);
                }

                $("#img_assetinventory_barcode").attr("src", BaseURL + "/dev/view/barcode/" + data.data.kode);
                $('#card_assetinventory_barcode').html(data.data.kode);
                
                $('#form_barcode_inventory_kode').val(data.data.uuid);

                $('#card_assetinventory_namabarang').html(data.data.m_barang.nama);
                $('#card_assetinventory_kodebarang').html(data.data.m_barang.kode);

                $('#card_assetinventory_supplier_nama').html(data.data.tr_purchases.m_supplier.nama);
                $('#card_assetinventory_supplier_email').html(data.data.tr_purchases.m_supplier.email);
                $('#card_assetinventory_supplier_phone').html(data.data.tr_purchases.m_supplier.handphone);
                $('#card_assetinventory_supplier_alamat').html(data.data.tr_purchases.m_supplier.alamat);

                $('#card_assetinventory_supplier_nomorpembelian').html(data.data.tr_purchases.invoice_nomor);

                var tanggalAwal = data.data.tr_purchases.invoice_tanggal;

                // Buat objek Date dari tanggal awal
                var tanggalObjek = new Date(tanggalAwal);

                // Daftar nama bulan dalam Bahasa Indonesia
                var namaBulan = [
                "Januari", "Februari", "Maret",
                "April", "Mei", "Juni",
                "Juli", "Agustus", "September",
                "Oktober", "November", "Desember"
                ];

                // Dapatkan komponen tanggal, bulan, dan tahun dari objek Date
                var tanggal = tanggalObjek.getDate();
                var bulan = namaBulan[tanggalObjek.getMonth()];
                var tahun = tanggalObjek.getFullYear();

                $('#card_assetinventory_supplier_tanggalpembelian').html(tanggal + " " + bulan + " " + tahun);

                $('#card_assetinventory_kondisi').html(data.data.kondisi);
                $('#card_assetinventory_jumlah').html(data.data.qty);
                $('#card_assetinventory_harga_pembelian').html(new Intl.NumberFormat().format(data.data.harga_purchases));
                $('#card_assetinventory_harga_penjualan').html(new Intl.NumberFormat().format(data.data.harga_jual));

                $('#modal-masterdata-jenisbarang').modal('show');
            }else{                
                Swal.fire({
                    text: data.message,
                    icon: "warning",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                return false;
            }
        },
        error: function () {
            Swal.fire({
                text: "Data Tidak Terkirim, Hubungi Administrator !!",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            return false;
        }
    });
}

function btnCetakBarcodePDF()
{
    let form_barcode_inventory_kode = $("#form_barcode_inventory_kode").val();
    let form_barcode_inventory_jumlah = $("#form_barcode_inventory_jumlah").val();

    if(form_barcode_inventory_jumlah <= 3)
    {
        Swal.fire({
            text: "Cetakan Barcode Asset Inventory Minimal Lebih Dari 3 Penyesuaian Cetakan",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    var win = window.open(BaseURL + "/dev/generate/barcode/inventory/" + form_barcode_inventory_kode + "/" + form_barcode_inventory_jumlah, '_blank');

    win.focus();
}

function act_btnDonloadExcell()
{
    let form_filter_barang = $("#form_filter_barang").val();
    let form_filter_jenisbarang = $("#form_filter_jenisbarang").val();
    let form_filter_supplier = $("#form_filter_supplier").val();
    let form_filter_status = $("#form_filter_status").val();

    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        url: BaseURL + "/dev/export/excell/transaksi/inventory",
        data: {
            form_filter_barang,
            form_filter_jenisbarang,
            form_filter_supplier,
            form_filter_status
        },
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (result, status, xhr) {
            var disposition = xhr.getResponseHeader('content-disposition');
            var matches = /"([^"]*)"/.exec(disposition);

            const data_datetime = new Date();
            let data_time = data_datetime.getTime();
            var filename = (matches != null && matches[1] ? matches[1] : 'data-transaksi-inventory-'+data_time+'.xlsx');

            // The actual download
            var blob = new Blob([result], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;

            document.body.appendChild(link);

            link.click();
            document.body.removeChild(link);
        },
        error: function () {
            Swal.fire({
                text: "Data Tidak Terkirim, Hubungi Administrator !!",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
            return false;
        }
    });
}

$(document).ready(function() {
    serverSideDatatables();    
});