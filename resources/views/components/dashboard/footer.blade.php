<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sidebarmenu.js') }}"></script>
<script src="{{ asset('js/app.min.js') }}"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="{{ asset('js/sheet.js') }}"></script>
<script src="{{ asset('js/jspdf.umd.min.js') }}"></script>
<script src="{{ asset('js/jspdf.plugin.autotable.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="//cdn.ckeditor.com/4.25.0/full/ckeditor.js"></script>
{{ $page ?? $page = '' }}

@if ($page === "dashboard")

<script src="{{ $chart->cdn() }}"></script>
{!! $chart->script() !!}

@endif
<script>
    var konten = document.getElementById("konten");
    CKEDITOR.replace(konten, {
        language: 'en-gb'
    });
    var konten2 = document.getElementById("konten2");
    CKEDITOR.replace(konten2, {
        language: 'en-gb'
    });
    CKEDITOR.config.allowedContent = true;

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


    @if(session() -> has('success') || session() -> has('error'))
    Toast.fire({
        icon: "{{ session()->has('success') ? 'success' : 'error' }}",
        title: "{{ session()->has('success') ? session('success') : session('error') }}"
    });
    @endif

    function exportData(type, idtable) {
        const table = document.getElementById(idtable)
        const fileName = `SPMB-SMAN 1 Sindangkasih${idtable}.xlsx`;
        const wb = XLSX.utils.table_to_book(table)
        XLSX.writeFile(wb, fileName)
    }

    $(document).ready(function() {
    $('#data_pendaftar').DataTable({
        "bLengthChange": false,
        "pageLength": 5,
        "order": [[0, "asc"]], // Pastikan ada pengaturan sorting
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
});

        $('#data_pendaftar').DataTable(options);
        $('#data_acc').DataTable(options);
        $('#data_sekolah').DataTable(options);

        $('#data_kategori').DataTable({
            "bLengthChange": false,
            "pageLength": 5
        });

        @if($page === 'kontak_admin')
        $('#data_sekolah').DataTable({
            "bLengthChange": false,
            "pageLength": 5
        });
        @endif

    });
</script>
<script type="text/javascript">
    $(function() {
        @if($page === 'jurusan')
        @foreach($data as $info)
        $(document).on('click', '#hapus_jurusan{{ $info->id ?? '
            ' }}',
            function(e) {
                e.preventDefault();
                let form = $('#hapus_jurusan{{ $info->id ?? '
                    ' }}').closest("form");
                Swal.fire({
                    title: 'Apa kamu yakin ingin menghapus jurusan ini?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: 'No',
                    customClass: {
                        actions: 'my-actions',
                        cancelButton: 'order-1 right-gap',
                        confirmButton: 'order-2',
                        denyButton: 'order-3',
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        @endforeach
        @endif

        @if($page === 'informasi_sekolah')
        @foreach($data as $info)
        $(document).on('click', '#hapus_informasi{{ $info->id ?? '
            ' }}',
            function(e) {
                e.preventDefault();
                let form = $('#hapus_informasi{{ $info->id ?? '
                    ' }}').closest("form");
                Swal.fire({
                    title: 'Apa kamu yakin ingin menghapus informasi ini?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: 'No',
                    customClass: {
                        actions: 'my-actions',
                        cancelButton: 'order-1 right-gap',
                        confirmButton: 'order-2',
                        denyButton: 'order-3',
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        @endforeach
        @endif

        @if($page === 'category_manager')
        @foreach($data as $info)
        $(document).on('click', '#hapus_kategori{{ $info->id ?? '
            ' }}',
            function(e) {
                e.preventDefault();
                let form = $('#hapus_kategori{{ $info->id ?? '
                    ' }}').closest("form");
                Swal.fire({
                    title: 'Apa kamu yakin ingin menghapus kategori ini?',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: 'No',
                    customClass: {
                        actions: 'my-actions',
                        cancelButton: 'order-1 right-gap',
                        confirmButton: 'order-2',
                        denyButton: 'order-3',
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        @endforeach
        @endif

    });

    document.addEventListener('DOMContentLoaded', function() {
        let checkbox1 = document.querySelector('#opt1');
        let checkbox2 = document.querySelector('#opt2');

        checkbox1.addEventListener('change', function() {
            if (checkbox1.checked) {
                // do this
                console.log('Checked A');
            } else {
                // do that
                console.log('Not checked A');
            }
        });

        checkbox2.addEventListener('change', function() {
            if (checkbox2.checked) {
                // do this
                console.log('Checked B');
            } else {
                // do that
                console.log('Not checked B');
            }
        });
    });

    const kategori = document.querySelector('#kategori');
    const slug = document.querySelector('#slug_kategori');

    kategori.addEventListener('keyup', function() {
        let preslug = kategori.value;
        preslug = preslug.replace(/ /g, "-");
        slug.value = preslug.toLowerCase();
    });
</script>
@if ($page === 'daftar_admin')
<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        (function(){
            const schoolLat = -7.308688088643808;
            const schoolLng = 108.24370675150715;
            let map, homeMarker, schoolMarker, connectorLine;
            let geocodeRequest;

            function toRad(x){return x * Math.PI / 180}
            function haversineKm(lat1, lon1, lat2, lon2){
                var R=6371; var dLat=toRad(lat2-lat1); var dLon=toRad(lon2-lon1);
                var a=Math.sin(dLat/2)*Math.sin(dLat/2)+Math.cos(toRad(lat1))*Math.cos(toRad(lat2))*Math.sin(dLon/2)*Math.sin(dLon/2);
                return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            }

            $(document).on('click', '#pick-on-map', function(){
                var mapModal = new bootstrap.Modal(document.getElementById('mapModal'));
                mapModal.show();
                setTimeout(function(){
                    if(!map){
                        map = L.map('map').setView([schoolLat, schoolLng], 14);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19}).addTo(map);
                        schoolMarker = L.marker([schoolLat, schoolLng],{draggable:false}).addTo(map).bindPopup('<strong>SMAN 1 Sindangkasih</strong>');
                        const prevLat = parseFloat($('#latitude').val());
                        const prevLng = parseFloat($('#longitude').val());
                        if(prevLat && prevLng){
                            homeMarker = L.marker([prevLat, prevLng],{draggable:true}).addTo(map);
                            homeMarker.on('dragend', updateFromMarker);
                            updateFromMarker();
                        }
                        map.on('click', function(e){
                            const latlng = e.latlng;
                            if(!homeMarker){
                                homeMarker = L.marker(latlng,{draggable:true}).addTo(map);
                                homeMarker.on('dragend', updateFromMarker);
                            } else { homeMarker.setLatLng(latlng); }
                            updateFromMarker();
                        });
                    } else { map.invalidateSize(); }
                },300);
            });

            $(document).on('click','#confirm-location', function(){ if(!homeMarker) return; updateFromMarker(); });

            function updateFromMarker(){
                const latlng = homeMarker.getLatLng();
                $('#latitude').val(latlng.lat);
                $('#longitude').val(latlng.lng);
                updateConnectorAndDistance();
                reverseGeocode(latlng.lat, latlng.lng);
            }

            async function reverseGeocode(lat, lng){
                if(geocodeRequest) geocodeRequest.abort();
                geocodeRequest = new AbortController();
                const addressField = $('textarea[name="alamat"]');
                addressField.val('Mencari alamat...');

                try {
                    const response = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lng)}&zoom=18&addressdetails=1&accept-language=id`,
                        {signal: geocodeRequest.signal}
                    );
                    if(!response.ok) throw new Error('Reverse geocoding failed');
                    const data = await response.json();
                    if(data.display_name) addressField.val(data.display_name);
                } catch(error) {
                    if(error.name !== 'AbortError') addressField.val('');
                }
            }

            function updateConnectorAndDistance(){
                if(!homeMarker || !schoolMarker) return;
                const a = homeMarker.getLatLng(); const b = schoolMarker.getLatLng();
                if(connectorLine) map.removeLayer(connectorLine);
                connectorLine = L.polyline([[a.lat,a.lng],[b.lat,b.lng]],{color:'blue'}).addTo(map);
                const dist = haversineKm(a.lat,a.lng,b.lat,b.lng);
                const rounded = (Math.round(dist * 100) / 100).toFixed(2);
                $('input[name="jarak_km"]').val(rounded);
            }
        })();
    </script>
@endif
</body>

</html>