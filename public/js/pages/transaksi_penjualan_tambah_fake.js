"use strict";
var data_decrpty = null;

$("#form_penjualan_tanggalpembelian").flatpickr();

function reset_cardSupplier()
{
    $('#card_customer_email').html(": ");
    $('#card_customer_hp').html(": ");
    $('#card_customer_alamat').html(": ");
}

form_penjualan_customer.onchange = evt => {
    reset_cardSupplier();

    let form_penjualan_customer = $("#form_penjualan_customer").val();

    if(form_penjualan_customer != "-" && form_penjualan_customer != -1)
    {
        let data_id = form_penjualan_customer;

        $.ajax({
            url: BaseURL + "/masterdata/customer/act_detail",
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
                    $('#card_customer_email').html(": "+data.data.email);
                    $('#card_customer_hp').html(": "+data.data.handphone);
                    $('#card_customer_alamat').html(": "+data.data.alamat+", "+data.data.alamat_kabupaten_nama);
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

function btnTambahListBarang()
{
    let form_penjualan_masterbarang = $("#form_penjualan_masterbarang").val();
    
    if(form_penjualan_masterbarang == '-')
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

    let data_id = form_penjualan_masterbarang;

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
                console.log(data);
                // return false;

                var dataPurchasesProduk = [];

                var kode_list_barang = generateRandomString(8)+"-"+generateRandomNumber(100000, 999999);

                var tmpPurchasesProduk = {
                    'kode_list' : kode_list_barang,
                    'barang_uuid' : data.data.uuid,
                    'barang_kode' : data.data.kode,
                    'barang_nama' : data.data.barang_nama,
                    'jenis_barang_uuid' : data.data.m_barang_jenis.uuid,
                    'jenis_barang_nama' : data.data.m_barang_jenis.nama,
                    'satuan_uuid' : data.data.m_satuan.uuid,
                    'satuan_nama' : data.data.m_satuan.nama,
                    'kondisi' : data.data.kondisi,
                    'set_harga' : data.data.harga_jual,
                    'set_jumlah' : data.data.qty,
                    'jual_harga' : data.data.harga_jual,
                    'jual_jumlah' : 1,
                    'diskon' : 0,
                    'sub_total' : data.data.harga_jual,
                };

                if(localStorage.getItem(storageKey) == null)
                {
                    // dataLayanan.push(tmpDataLayanan);
                    localStorage.setItem(storageKey, JSON.stringify(dataPurchasesProduk));
                }

                // get data dari local storage
                var storagePurchasesProduk = JSON.parse(localStorage.getItem(storageKey));

                var cekDataListBarang = storagePurchasesProduk.filter(function(itm){
                    return itm.barang_uuid == form_penjualan_masterbarang;
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
                $("#form_penjualan_masterbarang").select2("val", "-");
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

function tabelListBarang(storageKey)
{
    let form_penjualan_pajak = $("#form_penjualan_pajak").val();
    let form_penjualan_diskon = $("#form_penjualan_diskon").val();
    let form_penjualan_shipping = $("#form_penjualan_shipping").val();
    let form_penjualan_nominalpembayaran = $("#form_penjualan_nominalpembayaran").val();

    var storagePenjualanProduk = JSON.parse(localStorage.getItem(storageKey));
    console.log(storagePenjualanProduk);

    $("#card_penjualan_subtotal").html(0);
    $("#card_penjualan_pajak").html(0);
    $("#card_penjualan_diskon").html(0);
    $("#card_penjualan_shipping").html(0);
    $("#card_penjualan_grandtotal").html(0);

    var penjualan_sub_total = 0;
    var penjualan_pajak = 0;
    var penjualan_diskon = 0;
    var penjualan_shipping = 0;
    var penjualan_grandtotal = 0;

    // Clear existing rows
    table.clear();

    if(storagePenjualanProduk != null && storagePenjualanProduk.length != 0)
    {
        let no_tabel = 0;

        for (let i = 0; i < storagePenjualanProduk.length; i++)
        {
            ++no_tabel;

            // var tmp_sub_total =  (parseInt(storagePenjualanProduk[i].jual_harga)*parseInt(storagePenjualanProduk[i].jual_jumlah));
            // var tmp_diskon = (storagePenjualanProduk[i].diskon / 100) * tmp_sub_total;
            // var set_sub_tota = tmp_sub_total - tmp_diskon;

            // Add row to DataTable
            table.row.add([
                '<button type="button" class="btn btn-danger py-2" onclick=act_hapusListBarang("'+storageKey+'","'+storagePenjualanProduk[i].barang_uuid+'","'+storagePenjualanProduk[i].kode_list+'")><span class="indicator-label"><i class="bi bi-clipboard-x fs-4 me-2"></i> Hapus</span></button>',
                '<div class="position-relative py-2"><div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div><a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">&nbsp; '+no_tabel+' &nbsp;&nbsp;</a></div>',
                '<div class="d-flex justify-content-start flex-column"><a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'+storagePenjualanProduk[i].barang_nama+'</a><small>'+storagePenjualanProduk[i].barang_kode+'</small><hr><small class="fw-bold">'+storagePenjualanProduk[i].jenis_barang_nama+'</small></div>',
                '<span class="form-label fw-bold text-dark">'+storagePenjualanProduk[i].kondisi+'</span>',
                '<input type="number" name="form_penjualan_masterbarang_harga" id="form_penjualan_masterbarang_harga" class="form-control" value="'+storagePenjualanProduk[i].jual_harga+'" data-barang="'+storagePenjualanProduk[i].barang_uuid+'" data-kodelist="'+storagePenjualanProduk[i].kode_list+'" onchange="act_hargaUnitListBarang(this);"/>',
                '<input type="number" name="form_penjualan_masterbarang_jumlah" id="form_penjualan_masterbarang_jumlah" class="form-control" value="'+storagePenjualanProduk[i].jual_jumlah+'" data-barang="'+storagePenjualanProduk[i].barang_uuid+'" data-kodelist="'+storagePenjualanProduk[i].kode_list+'" onchange="act_jumlahUnitListBarang(this);" style="width:100px;" />',
                '<input type="number" name="form_penjualan_masterbarang_diskon" id="form_penjualan_masterbarang_diskon" class="form-control" value="'+storagePenjualanProduk[i].diskon+'" data-barang="'+storagePenjualanProduk[i].barang_uuid+'" data-kodelist="'+storagePenjualanProduk[i].kode_list+'" onchange="act_diskonUnitListBarang(this);" style="width:100px;" />',
                '<div class="w-100 text-end"><a href="#" class="mb-1 me-2 text-dark text-hover-primary fw-bolder">'+new Intl.NumberFormat().format(storagePenjualanProduk[i].sub_total)+'</a></div>',
            ]).draw();

            penjualan_sub_total = penjualan_sub_total + parseInt(storagePenjualanProduk[i].sub_total);
        }

        $("#card_penjualan_subtotal").html(new Intl.NumberFormat().format(penjualan_sub_total));

        if(form_penjualan_pajak)
        {
            penjualan_pajak = (form_penjualan_pajak / 100) * (parseInt(penjualan_sub_total));
            $("#card_penjualan_pajak").html(new Intl.NumberFormat().format(penjualan_pajak));
        }

        if(form_penjualan_diskon)
        {
            penjualan_diskon = (form_penjualan_diskon / 100) * (parseInt(penjualan_sub_total));
            $("#card_penjualan_diskon").html(new Intl.NumberFormat().format(penjualan_diskon));
        }

        if(form_penjualan_shipping)
        {
            penjualan_shipping = form_penjualan_shipping;
            $("#card_penjualan_shipping").html(new Intl.NumberFormat().format(penjualan_shipping));
        }

        penjualan_grandtotal = parseInt(penjualan_sub_total) + parseInt(penjualan_pajak);
        penjualan_grandtotal = parseInt(penjualan_grandtotal) - parseInt(penjualan_diskon);
        penjualan_grandtotal = parseInt(penjualan_grandtotal) + parseInt(penjualan_shipping);

        $("#card_penjualan_grandtotal").html(new Intl.NumberFormat().format(penjualan_grandtotal));
        $("#form_penjualan_nominalpembayaran").val(penjualan_grandtotal);

    }else{
        table.row.add([
            '<span class="form-label fw-bold text-dark"> </span>',
            '<span class="form-label fw-bold text-dark"> </span>',
            '<span class="form-label fw-bold text-dark"> </span>',
            '<span class="form-label fw-bold text-dark"> </span>',
            '<span class="form-label fw-bold text-dark"> </span>',
            '<span class="form-label fw-bold text-dark"> </span>',
            '<span class="form-label fw-bold text-dark"> </span>',
            '<span class="form-label fw-bold text-dark"> </span>',
        ]).draw();
    }
}

function act_hapusListBarang(storageKey, barangUUID, listKode)
{
    var storagePurchasesProduk = JSON.parse(localStorage.getItem(storageKey));

    let new_storagePurchasesProduk = storagePurchasesProduk.filter(item => !(item.kode_list == listKode && item.barang_uuid == barangUUID));

    localStorage.setItem(storageKey, JSON.stringify(new_storagePurchasesProduk));

    Swal.fire({
        text: "Anda Berhasil Mengahpus Barang Dari List",
        icon: "success",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
            confirmButton: "btn btn-primary"
        }
    });

    tabelListBarang(storageKey);
    $("#form_penjualan_masterbarang").select2("val", "-");
    return false;
}

function act_hargaUnitListBarang(dataForm)
{
    let dataUUID = $(dataForm).data("barang");
    let dataListKode = $(dataForm).data("kodelist");
    let dataValue = $(dataForm).val();
    
    var storagePurchasesProduk = JSON.parse(localStorage.getItem(storageKey));

    for (var i in storagePurchasesProduk) {
        if (storagePurchasesProduk[i].barang_uuid == dataUUID && storagePurchasesProduk[i].kode_list == dataListKode) {
            // changeValue
            storagePurchasesProduk[i].jual_harga = dataValue;            
            storagePurchasesProduk[i].sub_total = dataValue * parseInt(storagePurchasesProduk[i].jual_jumlah);

            var diskon = (storagePurchasesProduk[i].diskon / 100) * parseInt(storagePurchasesProduk[i].sub_total);
            storagePurchasesProduk[i].sub_total = parseInt(storagePurchasesProduk[i].sub_total) - diskon;

            break; //Stop this loop, we found it!
        }
    }

    localStorage.setItem(storageKey, JSON.stringify(storagePurchasesProduk));

    tabelListBarang(storageKey);
    $("#form_penjualan_masterbarang").select2("val", "-");
    return false;
}

function act_jumlahUnitListBarang(dataForm)
{
    let dataUUID = $(dataForm).data("barang");
    let dataListKode = $(dataForm).data("kodelist");
    let dataValue = $(dataForm).val();
    
    if(dataValue < 1)
    {
        Swal.fire({
            text: "Jumlah Barang Tidak Boleh Kurang Dari Satu",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        tabelListBarang(storageKey);
        return false;
    }

    var storagePurchasesProduk = JSON.parse(localStorage.getItem(storageKey));

    for (var i in storagePurchasesProduk) {
        if (storagePurchasesProduk[i].barang_uuid == dataUUID && storagePurchasesProduk[i].kode_list == dataListKode) {
            // console.log(dataValue);
            // console.log(storagePurchasesProduk[i].set_jumlah);
            if(parseInt(dataValue) > parseInt(storagePurchasesProduk[i].set_jumlah))
            {
                Swal.fire({
                    text: "Jumlah Barang Melebihi Stok Asset",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
                tabelListBarang(storageKey);
                return false;
            }

            // changeValue
            storagePurchasesProduk[i].jual_jumlah = dataValue;
            storagePurchasesProduk[i].sub_total = dataValue * parseInt(storagePurchasesProduk[i].jual_harga);

            var diskon = (storagePurchasesProduk[i].diskon / 100) * parseInt(storagePurchasesProduk[i].sub_total);
            storagePurchasesProduk[i].sub_total = parseInt(storagePurchasesProduk[i].sub_total) - diskon;
            break; //Stop this loop, we found it!
        }
    }

    localStorage.setItem(storageKey, JSON.stringify(storagePurchasesProduk));

    tabelListBarang(storageKey);
    $("#form_penjualan_masterbarang").select2("val", "-");
    return false;
}

function act_diskonUnitListBarang(dataForm)
{
    let dataUUID = $(dataForm).data("barang");
    let dataListKode = $(dataForm).data("kodelist");
    let dataValue = $(dataForm).val();
    
    var storagePurchasesProduk = JSON.parse(localStorage.getItem(storageKey));

    for (var i in storagePurchasesProduk) {
        if (storagePurchasesProduk[i].barang_uuid == dataUUID && storagePurchasesProduk[i].kode_list == dataListKode) {
            // changeValue
            storagePurchasesProduk[i].diskon = dataValue;
            var diskon = (dataValue / 100) * (parseInt(storagePurchasesProduk[i].jual_harga)*parseInt(storagePurchasesProduk[i].jual_jumlah));

            storagePurchasesProduk[i].sub_total = (parseInt(storagePurchasesProduk[i].jual_harga)*parseInt(storagePurchasesProduk[i].jual_jumlah)) - diskon;
            break; //Stop this loop, we found it!
        }
    }

    localStorage.setItem(storageKey, JSON.stringify(storagePurchasesProduk));

    tabelListBarang(storageKey);
    $("#form_penjualan_masterbarang").select2("val", "-");
    return false;
}

form_penjualan_pajak.onchange = evt => {
    tabelListBarang(storageKey);
}

form_penjualan_diskon.onchange = evt => {
    tabelListBarang(storageKey);
}

form_penjualan_shipping.onchange = evt => {
    tabelListBarang(storageKey);
}

function act_submitTambahData()
{
    let form_penjualan_customer = $("#form_penjualan_customer").val();
    let form_penjualan_nomorpembelian = $("#form_penjualan_nomorpembelian").val();
    let form_penjualan_tanggalpembelian = $("#form_penjualan_tanggalpembelian").val();
    let form_penjualan_pajak = $("#form_penjualan_pajak").val();
    let form_penjualan_diskon = $("#form_penjualan_diskon").val();
    let form_penjualan_shipping = $("#form_penjualan_shipping").val();
    let form_penjualan_status = $("#form_penjualan_status").val();
    let form_penjualan_jenispembayaran = $("#form_penjualan_jenispembayaran").val();
    let form_penjualan_nominalpembayaran = $("#form_penjualan_nominalpembayaran").val();
    let form_penjualan_catatan = $("#form_penjualan_catatan").val();

    var storage_penjualan_produk = JSON.parse(localStorage.getItem(storageKey));

    Swal.fire({
        title: 'Tambah Data ?',
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
                url: BaseURL + "/transaksi/penjualan/fake/act_tambah",
                data: {
                    form_penjualan_customer,
                    form_penjualan_nomorpembelian,
                    form_penjualan_tanggalpembelian,
                    form_penjualan_pajak,
                    form_penjualan_diskon,
                    form_penjualan_shipping,
                    form_penjualan_status,
                    form_penjualan_jenispembayaran,
                    form_penjualan_nominalpembayaran,
                    form_penjualan_catatan,
                    storage_penjualan_produk
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
                                // location.reload();
                                window.location.replace(BaseURL + "/transaksi/penjualan/fake/detail/" + data.data.uuid);
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
    tabelListBarang(storageKey);    
});