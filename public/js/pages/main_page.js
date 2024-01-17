"use strict";

const loadingEl = document.createElement("div");
    document.body.prepend(loadingEl);
    loadingEl.classList.add("page-loader");
    loadingEl.classList.add("flex-column");
    loadingEl.classList.add("bg-dark");
    loadingEl.classList.add("bg-opacity-25");
    loadingEl.innerHTML = `
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    `;

function decryptAES256CBC(data_encrpty)
{
    // Created using Crypt::encryptString('Hello world.') on Laravel.
    // If Crypt::encrypt is used the value is PHP serialized so you'll 
    // need to "unserialize" it in JS at the end.
    var tmp_dataencrpty = data_encrpty;
    var slice_first = tmp_dataencrpty.slice(3);
    var slice_last = slice_first.slice(0, -6);

    var encrypted = slice_last;

    // The APP_KEY in .env file. Note that it is base64 encoded binary
    var keyencodedString = $('meta[name="csrf-key"]').attr('content');
    // Remove the "base64:" prefix
    var key = keyencodedString.replace(/^base64:/, '');

    try {
        // Laravel creates a JSON to store iv, value and a mac and base64 encodes it.
        // So let's base64 decode the string to get them.
        encrypted = atob(encrypted);
        encrypted = JSON.parse(encrypted);

        // IV is base64 encoded in Laravel, expected as word array in cryptojs
        const iv = CryptoJS.enc.Base64.parse(encrypted.iv);

        // Value (chipher text) is also base64 encoded in Laravel, same in cryptojs
        const value = encrypted.value;

        // Key is base64 encoded in Laravel, word array expected in cryptojs
        key = CryptoJS.enc.Base64.parse(key);

        // Decrypt the value, providing the IV. 
        var decrypted = CryptoJS.AES.decrypt(value, key, {
            iv: iv
        });

        // CryptoJS returns a word array which can be 
        // converted to string like this
        decrypted = decrypted.toString(CryptoJS.enc.Utf8);
    }catch(err) {
        var decrypted = null;
    }

    return decrypted;
}

function blockLoadingOverlay()
{
    KTApp.showPageLoading();
}