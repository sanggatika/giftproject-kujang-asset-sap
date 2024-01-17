"use strict";
var data_decrpty = null;

$("#form_purchases_tanggalpembelian").flatpickr();

function reset_cardSupplier()
{
    $('#card_supplier_email').html(": ");
    $('#card_supplier_hp').html(": ");
    $('#card_supplier_alamat').html(": ");
}

form_purchases_supplier.onchange = evt => {
    reset_cardSupplier();

    let form_filter_supplier = $("#form_purchases_supplier").val();

    if(form_filter_supplier != "-" && form_filter_supplier != -1)
    {
        let data_id = form_filter_supplier;

        $.ajax({
            url: BaseURL + "/masterdata/supplier/act_detail",
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
                    $('#card_supplier_email').html(": "+data.data.email);
                    $('#card_supplier_hp').html(": "+data.data.handphone);
                    $('#card_supplier_alamat').html(": "+data.data.alamat+", "+data.data.alamat_kabupaten_nama);
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

function tabelListBarang(storageKey)
{
    let form_purchases_pajak = $("#form_purchases_pajak").val();
    let form_purchases_diskon = $("#form_purchases_diskon").val();
    let form_purchases_shipping = $("#form_purchases_shipping").val();
    let form_purchases_nominalpembayaran = $("#form_purchases_nominalpembayaran").val();

    var storagePurchasesProduk = JSON.parse(localStorage.getItem(storageKey));

    $("#tableListPurchasesProduk").html('');

    $("#card_purchases_subtotal").html(0);
    $("#card_purchases_pajak").html(0);
    $("#card_purchases_diskon").html(0);
    $("#card_purchases_shipping").html(0);
    $("#card_purchases_grandtotal").html(0);

    var purchases_sub_total = 0;
    var purchases_pajak = 0;
    var purchases_diskon = 0;
    var purchases_shipping = 0;
    var purchases_grandtotal = 0;

    if(storagePurchasesProduk != null && storagePurchasesProduk.length != 0)
    {
        let no_tabel = 0;        

        for (let i = 0; i < storagePurchasesProduk.length; i++) {
            ++no_tabel;

            $("#tableListPurchasesProduk").append('<tr><td class="text-center"><button type="button" class="btn btn-danger py-2" onclick=act_hapusListBarang("'+storageKey+'","'+storagePurchasesProduk[i].barang_uuid+'","'+storagePurchasesProduk[i].kode_list+'")><span class="indicator-label"><i class="bi bi-clipboard-x fs-4 me-2"></i> Hapus</span></button></td><td class="text-center"><div class="position-relative py-2"><div class="position-absolute start-0 top-0 w-4px h-100 rounded-2 bg-success"></div><a href="#" class="mb-1 text-dark text-hover-primary fw-bolder">'+no_tabel+'. </a></div></td><td class="text-start"><div class="d-flex justify-content-start flex-column"><a href="#" class="text-gray-800 text-hover-primary mb-1 fw-bolder fs-5">'+storagePurchasesProduk[i].barang_nama+'</a><small>'+storagePurchasesProduk[i].barang_kode+'</small><hr><small class="fw-bold">'+storagePurchasesProduk[i].jenis_barang_nama+'</small></div></td><td class="text-center"><select class="form-select" data-barang="'+storagePurchasesProduk[i].barang_uuid+'" data-kodelist="'+storagePurchasesProduk[i].kode_list+'" onchange="act_kondisiUnitListBarang(this);"><option value="SANGAT BAIK" '+ (storagePurchasesProduk[i].kondisi == "SANGAT BAIK" ? 'selected': '') +'>Sangat Baik</option><option value="BAIK" '+ (storagePurchasesProduk[i].kondisi == "BAIK" ? 'selected': '') +'>Baik</option><option value="KURANG" '+ (storagePurchasesProduk[i].kondisi == "KURANG" ? 'selected': '') +'>Kurang</option><option value="SANGAT KURANG" '+ (storagePurchasesProduk[i].kondisi == "SANGAT KURANG" ? 'selected': '') +'>Sangat Kurang</option></select></td><td class="text-center"> <input type="number" name="form_purchases_masterbarang_harga" id="form_purchases_masterbarang_harga" class="form-control" value="'+storagePurchasesProduk[i].harga+'" data-barang="'+storagePurchasesProduk[i].barang_uuid+'" data-kodelist="'+storagePurchasesProduk[i].kode_list+'" onchange="act_hargaUnitListBarang(this);"/> </td><td class="text-center"> <input type="number" name="form_purchases_masterbarang_jumlah" id="form_purchases_masterbarang_jumlah" class="form-control" value="'+storagePurchasesProduk[i].jumlah+'" data-barang="'+storagePurchasesProduk[i].barang_uuid+'" data-kodelist="'+storagePurchasesProduk[i].kode_list+'" onchange="act_jumlahUnitListBarang(this);" style="width:100px;" /> </td><td class="text-center"> <input type="number" name="form_purchases_masterbarang_diskon" id="form_purchases_masterbarang_diskon" class="form-control" value="'+storagePurchasesProduk[i].diskon+'" data-barang="'+storagePurchasesProduk[i].barang_uuid+'" data-kodelist="'+storagePurchasesProduk[i].kode_list+'" onchange="act_diskonUnitListBarang(this);" style="width:100px;" /> </td><td class="text-end"><a href="#" class="mb-1 me-2 text-dark text-hover-primary fw-bolder">'+new Intl.NumberFormat().format(storagePurchasesProduk[i].sub_total)+'</a></td></tr>');
        
            purchases_sub_total = purchases_sub_total + parseInt(storagePurchasesProduk[i].sub_total);            
        }

        $("#card_purchases_subtotal").html(new Intl.NumberFormat().format(purchases_sub_total));

        if(form_purchases_pajak)
        {
            purchases_pajak = (form_purchases_pajak / 100) * (parseInt(purchases_sub_total));
            $("#card_purchases_pajak").html(new Intl.NumberFormat().format(purchases_pajak));
        }

        if(form_purchases_diskon)
        {
            purchases_diskon = (form_purchases_diskon / 100) * (parseInt(purchases_sub_total));
            $("#card_purchases_diskon").html(new Intl.NumberFormat().format(purchases_diskon));
        }

        if(form_purchases_shipping)
        {
            purchases_shipping = form_purchases_shipping;
            $("#card_purchases_shipping").html(new Intl.NumberFormat().format(purchases_shipping));
        }

        purchases_grandtotal = parseInt(purchases_sub_total) + parseInt(purchases_pajak);
        purchases_grandtotal = parseInt(purchases_grandtotal) - parseInt(purchases_diskon);
        purchases_grandtotal = parseInt(purchases_grandtotal) + parseInt(purchases_shipping);

        $("#card_purchases_grandtotal").html(new Intl.NumberFormat().format(purchases_grandtotal));
        $("#form_purchases_nominalpembayaran").val(parseInt(purchases_grandtotal));

    }else{
        $("#tableListPurchasesProduk").append('<tr><td colspan="8" class="text-center fw-bold">Tidak Ada List Barang / Belum Ditambahkan</td></tr>');
    }
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
        url: BaseURL + "/masterdata/barang/act_detail",
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
                    'barang_uuid' : data.data.uuid,
                    'barang_kode' : data.data.kode,
                    'barang_nama' : data.data.nama,
                    'jenis_barang_uuid' : data.data.m_barang_jenis.uuid,
                    'jenis_barang_nama' : data.data.m_barang_jenis.nama,
                    'satuan_uuid' : data.data.m_satuan.uuid,
                    'satuan_nama' : data.data.m_satuan.nama,
                    'kondisi' : 'BAIK',
                    'harga' : 0,
                    'jumlah' : 1,
                    'diskon' : 0,
                    'sub_total' : 0,
                };

                if(localStorage.getItem(storageKey) == null)
                {
                    // dataLayanan.push(tmpDataLayanan);
                    localStorage.setItem(storageKey, JSON.stringify(dataPurchasesProduk));
                }

                // get data dari local storage
                var storagePurchasesProduk = JSON.parse(localStorage.getItem(storageKey));

                // var cekDataListBarang = storagePurchasesProduk.filter(function(itm){
                //     return itm.barang_uuid == form_purchases_masterbarang;
                // });

                // if(cekDataListBarang.length >= 1)
                // {
                //     Swal.fire({
                //         text: "Data Layanan Sudah Ada Dalam List, Silahkan Cek Kembali",
                //         icon: "warning",
                //         buttonsStyling: false,
                //         confirmButtonText: "Ok, got it!",
                //         customClass: {
                //             confirmButton: "btn btn-primary"
                //         }
                //     });
                //     return false;
                // }

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
    $("#form_purchases_masterbarang").select2("val", "-");
    return false;
}

function act_kondisiUnitListBarang(dataForm)
{
    let dataUUID = $(dataForm).data("barang");
    let dataListKode = $(dataForm).data("kodelist");
    let dataValue = $(dataForm).val();
    
    var storagePurchasesProduk = JSON.parse(localStorage.getItem(storageKey));

    for (var i in storagePurchasesProduk) {
        if (storagePurchasesProduk[i].barang_uuid == dataUUID && storagePurchasesProduk[i].kode_list == dataListKode) {
            // changeValue
            storagePurchasesProduk[i].kondisi = dataValue;
            break; //Stop this loop, we found it!
        }
    }

    localStorage.setItem(storageKey, JSON.stringify(storagePurchasesProduk));

    tabelListBarang(storageKey);
    $("#form_purchases_masterbarang").select2("val", "-");
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
            storagePurchasesProduk[i].harga = dataValue;            
            storagePurchasesProduk[i].sub_total = dataValue * parseInt(storagePurchasesProduk[i].jumlah);

            var diskon = (storagePurchasesProduk[i].diskon / 100) * parseInt(storagePurchasesProduk[i].sub_total);
            storagePurchasesProduk[i].sub_total = parseInt(storagePurchasesProduk[i].sub_total) - diskon;

            break; //Stop this loop, we found it!
        }
    }

    localStorage.setItem(storageKey, JSON.stringify(storagePurchasesProduk));

    tabelListBarang(storageKey);
    $("#form_purchases_masterbarang").select2("val", "-");
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
        return false;
    }

    var storagePurchasesProduk = JSON.parse(localStorage.getItem(storageKey));

    for (var i in storagePurchasesProduk) {
        if (storagePurchasesProduk[i].barang_uuid == dataUUID && storagePurchasesProduk[i].kode_list == dataListKode) {
            // changeValue
            storagePurchasesProduk[i].jumlah = dataValue;
            storagePurchasesProduk[i].sub_total = dataValue * parseInt(storagePurchasesProduk[i].harga);

            var diskon = (storagePurchasesProduk[i].diskon / 100) * parseInt(storagePurchasesProduk[i].sub_total);
            storagePurchasesProduk[i].sub_total = parseInt(storagePurchasesProduk[i].sub_total) - diskon;
            break; //Stop this loop, we found it!
        }
    }

    localStorage.setItem(storageKey, JSON.stringify(storagePurchasesProduk));

    tabelListBarang(storageKey);
    $("#form_purchases_masterbarang").select2("val", "-");
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
            var diskon = (dataValue / 100) * (parseInt(storagePurchasesProduk[i].harga)*parseInt(storagePurchasesProduk[i].jumlah));

            storagePurchasesProduk[i].sub_total = (parseInt(storagePurchasesProduk[i].harga)*parseInt(storagePurchasesProduk[i].jumlah)) - diskon;
            break; //Stop this loop, we found it!
        }
    }

    localStorage.setItem(storageKey, JSON.stringify(storagePurchasesProduk));

    tabelListBarang(storageKey);
    $("#form_purchases_masterbarang").select2("val", "-");
    return false;
}

form_purchases_pajak.onchange = evt => {
    tabelListBarang(storageKey);
}

form_purchases_diskon.onchange = evt => {
    tabelListBarang(storageKey);
}

form_purchases_shipping.onchange = evt => {
    tabelListBarang(storageKey);
}


function act_submitTambahData()
{
    let form_purchases_supplier = $("#form_purchases_supplier").val();
    let form_purchases_nomorpembelian = $("#form_purchases_nomorpembelian").val();
    let form_purchases_tanggalpembelian = $("#form_purchases_tanggalpembelian").val();
    let form_purchases_pajak = $("#form_purchases_pajak").val();
    let form_purchases_diskon = $("#form_purchases_diskon").val();
    let form_purchases_shipping = $("#form_purchases_shipping").val();
    let form_purchases_status = $("#form_purchases_status").val();
    let form_purchases_jenispembayaran = $("#form_purchases_jenispembayaran").val();
    let form_purchases_nominalpembayaran = $("#form_purchases_nominalpembayaran").val();
    let form_purchases_catatan = $("#form_purchases_catatan").val();

    var storage_purchases_produk = JSON.parse(localStorage.getItem(storageKey));

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
                url: BaseURL + "/transaksi/purchases/act_tambah",
                data: {
                    form_purchases_supplier,
                    form_purchases_nomorpembelian,
                    form_purchases_tanggalpembelian,
                    form_purchases_pajak,
                    form_purchases_diskon,
                    form_purchases_shipping,
                    form_purchases_status,
                    form_purchases_jenispembayaran,
                    form_purchases_nominalpembayaran,
                    form_purchases_catatan,
                    storage_purchases_produk
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
                                location.reload();
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