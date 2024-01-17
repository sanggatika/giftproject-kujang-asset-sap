"use strict";
var data_decrpty = null;

function serverSideDatatables()
{
    $('#tabel_masterdata_satuan').dataTable().fnDestroy();

    $("#tabel_masterdata_satuan").DataTable({
        pageLength: 10,
        "language": {
            "lengthMenu": "Show _MENU_",
        },
        "dom":
            "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +
    
            "<'table-responsive'tr>" +
    
            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
    });
}

function datatabelesreload()
{
	$('#tabel_masterdata_satuan').DataTable().ajax.reload(null, false); //Reload Tanpa Reset Page Datatable
}

function btnTambahListBarang()
{
    let form_purchases_masterbarang = $("#form_purchases_masterbarang").val();
    
    if(form_purchases_masterbarang == '-')
    {
        Swal.fire({
            text: "Tidak Ada Barang Yang Dipilih Untuk Ditambahkan",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return false;
    }

    let data_id = form_purchases_masterbarang;

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
                // console.log(data);
                var dataPurchasesProduk = [];

                var kode_list_barang = generateRandomString(8)+"-"+generateRandomNumber(100000, 999999);

                var tmpPurchasesProduk = {
                    'kode_list' : kode_list_barang,
                    'uuid_asset' : data.data.uuid,
                    'kode_asset' : data.data.kode,
                    'invoice_number' : data.data.tr_purchases.invoice_nomor,
                    'invoice_tanggal' : data.data.tr_purchases.invoice_tanggal,
                    'barang_nama' : data.data.barang_nama,
                    'kondisi' : data.data.kondisi,
                    'jumlah' : data.data.qty,
                    'harga_purchases' : data.data.harga_purchases,
                    'harga_jual' : data.data.harga_jual,
                };

                console.log(data.data);
                console.log(tmpPurchasesProduk);

                if(localStorage.getItem(storageKey) == null)
                {
                    // dataLayanan.push(tmpDataLayanan);
                    localStorage.setItem(storageKey, JSON.stringify(dataPurchasesProduk));
                }

                // get data dari local storage
                var storagePurchasesProduk = JSON.parse(localStorage.getItem(storageKey));

                var cekDataListBarang = storagePurchasesProduk.filter(function(itm){
                    return itm.uuid_asset == form_purchases_masterbarang;
                });

                if(cekDataListBarang.length >= 1)
                {
                    Swal.fire({
                        text: "Data Layanan Sudah Ada Dalam List, Silahkan Cek Kembali",
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    return false;
                }

                storagePurchasesProduk.push(tmpPurchasesProduk);
                localStorage.setItem(storageKey, JSON.stringify(storagePurchasesProduk));

                Swal.fire({
                    text: "Anda Berhasil Menambahkan Layanan Kedalam List",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });

                tabelListBarang(storageKey);
                $("#form_purchases_masterbarang").select2("val", "-");
                return false;
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

var table = $("#tabel_masterdata_satuan").DataTable({
    pageLength: 10,
    "language": {
        "lengthMenu": "Show _MENU_",
    },
    "dom":
        "<'row'" +
        "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
        "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
        ">" +

        "<'table-responsive'tr>" +

        "<'row'" +
        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        ">"
});

function tabelListBarang(storageKey)
{
    var storagePurchasesProduk = JSON.parse(localStorage.getItem(storageKey));

    // Clear existing rows
    table.clear();
    
    if(storagePurchasesProduk != null && storagePurchasesProduk.length != 0)
    {
        let no_tabel = 0;
        for (let i = 0; i < storagePurchasesProduk.length; i++)
        {
            ++no_tabel;

            // Buat objek Date dari tanggal awal
            var tanggalObjek = new Date(storagePurchasesProduk[i].invoice_tanggal);

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

            // Add row to DataTable
            table.row.add([
                '<div class="position-relative py-2"><div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div><a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">&nbsp; '+no_tabel+' &nbsp;&nbsp;</a></div>',
                '<div class="d-flex justify-content-start flex-column"><span class="form-label fw-bold text-dark fs-5">'+storagePurchasesProduk[i].invoice_number+'</span><small>'+tanggal+' '+ bulan +' '+tahun+'</small><hr></div>',
                '<div class="d-flex justify-content-start flex-column"><span class="form-label fw-bold text-dark fs-5">'+storagePurchasesProduk[i].barang_nama+'</span><small>'+storagePurchasesProduk[i].kode_asset+'</small><hr><input type="hidden" class="form-control" name="form_inventory_adjustments_uuid" value="'+storagePurchasesProduk[i].uuid_asset+'" aria-describedby="basic-addon1"/></div>',
                '<span class="form-label fw-bold text-dark">'+storagePurchasesProduk[i].kondisi+'</span>',
                '<input type="number" name="form_inventory_adjustments_jumlah" class="form-control" value="'+storagePurchasesProduk[i].jumlah+'" style="width:80px;">',
                '<span class="form-label fw-bold text-dark">'+new Intl.NumberFormat().format(storagePurchasesProduk[i].harga_purchases)+'</span>',
                '<div class="input-group mb-2"><span class="input-group-text fw-bold text-dark fs-5" id="basic-addon1">Rp.</span><input type="number" class="form-control" name="form_inventory_adjustments_hargajual" placeholder="Set Harga Jual Barang" aria-label="Set Harga Jual Barang" value="'+storagePurchasesProduk[i].harga_jual+'" aria-describedby="basic-addon1" /></div>'
            ]).draw();
        }
    }
}

function act_submitAdjustmentsData()
{
    let form_inventory_adjustments_data = table.$('input, select').serializeArray();
    let form_inventory_adjustments_catatan = $("#form_inventory_adjustments_catatan").val();
   
    Swal.fire({
        title: 'Update Data ?',
        text: "Pastikan Anda Sudah Mengecek Kembali Data akan di kirim?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Submit!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {

            $.ajax({
                url: BaseURL + "/transaksi/inventory/adjustments/act_update",
                data: {
                    form_inventory_adjustments_data,
                    form_inventory_adjustments_catatan
                },
                method: "POST",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {    
                    KTApp.showPageLoading();                       
                },
                success: function (data) {
                    KTApp.hidePageLoading();
                    loadingEl.remove();

                    if(data.status == true)
                    {
                        Swal.fire({
                            title: 'Update Success !',
                            text: data.message,
                            icon: "success",
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Oke',
                            allowOutsideClick: false,
                            closeOnClickOutside: false,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                window.location.replace(BaseURL + "/transaksi/inventory/data");
                                return false;
                            }                    
                        })
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
                    KTApp.hidePageLoading();
                    loadingEl.remove();
                    
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
            
        }else{
            Swal.fire({
                text: "Pastikan Anda Sudah Mengisi Form Required.. !!",
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

function generateRandomString(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        result += characters.charAt(randomIndex);
    }
    return result;
}

function generateRandomNumber(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

$(document).ready(function() {
    // serverSideDatatables();
    tabelListBarang(storageKey);   
});