// resources/js/app.js
import './main.js';
import './sidebarmenu.js';
import './app.min.js';
import './dashboard.js';
import './sheet.js';
import './jspdf.umd.min.js';
import './jspdf.plugin.autotable.js';

// ================================
// Import Library JS
// ================================
import $ from 'jquery';
window.$ = window.jQuery = $;

import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import Swal from 'sweetalert2';
window.Swal = Swal;

// DataTables
import 'datatables.net';
import 'datatables.net-bs5';
import 'datatables.net-buttons';
import 'datatables.net-buttons/js/buttons.html5.js';
import 'datatables.net-buttons/js/buttons.print.js';

// JSZip & pdfMake untuk DataTables export
import JSZip from 'jszip';
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
pdfMake.vfs = pdfFonts.pdfMake.vfs;

// CKEditor
import CKEDITOR from 'ckeditor4';

// ================================
// Import Library Lokal
// ================================
import '../lib/wow/wow.min.js';
import '../lib/easing/easing.min.js';
import '../lib/waypoints/waypoints.min.js';
import '../lib/owlcarousel/owl.carousel.min.js';
import '../lib/counterup/counterup.min.js';

// ================================
// Import Template / Custom JS
// ================================
import './main.js';
import './sidebarmenu.js';
import './app.min.js';
import './dashboard.js';
import './sheet.js';
import './jspdf.umd.min.js';
import './jspdf.plugin.autotable.js';

// ================================
// Inisialisasi ketika DOM siap
// ================================
document.addEventListener('DOMContentLoaded', function () {

    // Inisialisasi CKEditor
    const konten = document.getElementById("konten");
    if(konten) CKEDITOR.replace(konten, { language: 'en-gb' });

    const konten2 = document.getElementById("konten2");
    if(konten2) CKEDITOR.replace(konten2, { language: 'en-gb' });

    CKEDITOR.config.allowedContent = true;

    // SweetAlert Toast
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    if(window.sessionStorage.getItem('success') || window.sessionStorage.getItem('error')){
        Toast.fire({
            icon: window.sessionStorage.getItem('success') ? 'success' : 'error',
            title: window.sessionStorage.getItem('success') || window.sessionStorage.getItem('error')
        });
    }

    // DataTables
    $('#data_pendaftar').DataTable({
        "bLengthChange": false,
        "pageLength": 5,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                className: 'btn btn-success',
                init: function(api, node, config) {
                    $(node).removeClass('dt-button')
                }
            }
        ]
    });

    // Input search filter
    const searchInput = document.getElementById("searchInput");
    if(searchInput){
        searchInput.addEventListener("keyup", function () {
            let value = this.value.toLowerCase();
            document.querySelectorAll("#dataTable tbody tr").forEach(function (row) {
                row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
            });
        });
    }

    // Checkbox example
    const checkbox1 = document.querySelector('#opt1');
    const checkbox2 = document.querySelector('#opt2');
    if(checkbox1){
        checkbox1.addEventListener('change', function() {
            console.log(checkbox1.checked ? 'Checked A' : 'Not checked A');
        });
    }
    if(checkbox2){
        checkbox2.addEventListener('change', function() {
            console.log(checkbox2.checked ? 'Checked B' : 'Not checked B');
        });
    }

    // Slug generation
    const kategori = document.querySelector('#kategori');
    const slug = document.querySelector('#slug_kategori');
    if(kategori && slug){
        kategori.addEventListener('keyup', function() {
            let preslug = kategori.value.replace(/ /g, "-").toLowerCase();
            slug.value = preslug;
        });
    }

    // Modal otomatis untuk route 'daftar'
    if (window.location.pathname.includes('daftar')) {
        $(window).on('load', function () {
            $('#myModal').modal('show');
        });
    }

});
