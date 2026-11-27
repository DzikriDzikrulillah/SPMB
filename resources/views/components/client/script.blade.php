
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('lib/counterup/counterup.min.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


    <!-- Template Javascript -->
    <script src="{{asset('js/main.js')}}"></script>

    <script>
        $(document).ready( function () {
        $('#data_pendaftar').DataTable();
      
        });
      </script>

      @if(Route::is('daftar'))
      <script type="text/javascript">
        $(window).on('load', function() {
            $('#myModal').modal('show');
        });
    </script>

      @endif
      
      <script>
      // Map picker only on daftar route
      @if(Route::is('daftar') || Route::is('admin.daftar') )
      const schoolLat = -7.308688088643808;
      const schoolLng = 108.24370675150715;

      let map, homeMarker, schoolMarker, connectorLine;
      let geocodeRequest;

      function haversineKm(lat1, lon1, lat2, lon2) {
        function toRad(x) { return x * Math.PI / 180; }
        var R = 6371; // km
        var dLat = toRad(lat2 - lat1);
        var dLon = toRad(lon2 - lon1);
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * Math.sin(dLon/2) * Math.sin(dLon/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
      }

      // Initialize map when modal is shown
      $(document).on('shown.bs.modal', '#mapModal', function() {
        setTimeout(function() {
          if (!map) {
            map = L.map('map').setView([schoolLat, schoolLng], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
              maxZoom: 19,
            }).addTo(map);

            schoolMarker = L.marker([schoolLat, schoolLng], {draggable:false}).addTo(map).bindPopup('<strong>SMAN 1 Sindangkasih</strong><br>Koordinat: ' + schoolLat + ', ' + schoolLng).openPopup();

            // If previous home coords exist, show marker
            const prevLat = parseFloat($('#latitude').val());
            const prevLng = parseFloat($('#longitude').val());
            if (prevLat && prevLng) {
              homeMarker = L.marker([prevLat, prevLng], {draggable:true}).addTo(map).bindPopup('Lokasi Rumah');
              homeMarker.on('dragend', updateFromMarker);
              updateFromMarker();
            }

            map.on('click', function(e) {
              const latlng = e.latlng;
              if (!homeMarker) {
                homeMarker = L.marker(latlng, {draggable:true}).addTo(map).bindPopup('Lokasi Rumah');
                homeMarker.on('dragend', updateFromMarker);
              } else {
                homeMarker.setLatLng(latlng);
              }
              updateFromMarker();
            });
          } else {
            map.invalidateSize();
          }
        }, 300);
      });

      $(document).on('click', '#confirm-location', function() {
        if (!homeMarker) return;
        updateFromMarker();
      });

      function updateFromMarker() {
        const latlng = homeMarker.getLatLng();
        $('#latitude').val(latlng.lat);
        $('#longitude').val(latlng.lng);
        updateConnectorAndDistance();
        reverseGeocode(latlng.lat, latlng.lng);
      }

      async function reverseGeocode(lat, lng) {
        if (geocodeRequest) {
          geocodeRequest.abort();
        }
        geocodeRequest = new AbortController();
        const addressField = $('textarea[name="alamat"]');
        addressField.val('Mencari alamat...');

        try {
          const response = await fetch(
            `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lng)}&zoom=18&addressdetails=1&accept-language=id`,
            { signal: geocodeRequest.signal }
          );
          if (!response.ok) throw new Error('Reverse geocoding failed');
          const data = await response.json();
          if (data.display_name) addressField.val(data.display_name);
        } catch (error) {
          if (error.name !== 'AbortError') addressField.val('');
        }
      }

      function updateConnectorAndDistance() {
        if (!homeMarker || !schoolMarker) return;
        const a = homeMarker.getLatLng();
        const b = schoolMarker.getLatLng();
        if (connectorLine) {
          map.removeLayer(connectorLine);
        }
        connectorLine = L.polyline([[a.lat, a.lng], [b.lat, b.lng]], {color: 'blue'}).addTo(map);
        const dist = haversineKm(a.lat, a.lng, b.lat, b.lng);
        const rounded = (Math.round(dist * 100) / 100).toFixed(2);
        $('input[name="jarak_km"]').val(rounded);
      }
      @endif
      </script>
      