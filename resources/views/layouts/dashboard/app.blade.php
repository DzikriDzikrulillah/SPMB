@include('components.dashboard.header')
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    @include('components.dashboard.sidebar')
        <div class="body-wrapper">
            @include('components.dashboard.headbar')
            <div class="container-fluid">
            @include('components.dashboard.modal')
                @yield('content')
            </div>
        </div>
    </div>
@include('components.dashboard.footer')
@section('scripts')
<script>
    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];

            fetch_data(page);
        });

        function fetch_data(page) {
            $.ajax({
                url: "{{ route('pendaftar') }}?page=" + page,
                success: function(data) {
                    $('#table_data').html(data.html);
                }
            });
        }
    });
</script>
@endsection

