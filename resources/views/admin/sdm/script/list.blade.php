<script>
    function load_sdm() {
        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#example').DataTable({
            dom: 'lBfrtip',
            stateSave: true,
            stateDuration: -1,
            pageLength: 10,
            lengthMenu: [
                [10, 15, 20, 25],
                [10, 15, 20, 25]
            ],
            buttons: [
                {
                    extend: 'colvis',
                    collectionLayout: 'fixed columns',
                    collectionTitle: 'Pilih Kolom',
                    className: 'btn btn-sm btn-dark rounded-2',
                    columns: ':not(.noVis)'
                },
                {
                    extend: 'csv',
                    titleAttr: 'Export ke CSV',
                    className: 'btn btn-sm btn-dark rounded-2',
                },
                {
                    extend: 'excel',
                    titleAttr: 'Export ke Excel',
                    className: 'btn btn-sm btn-dark rounded-2',
                },
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,
            ajax: {
                url: '{{ route('admin.sdm.list') }}', // ambil data SDM dari controller
                cache: false,
            },
            order: [],
            ordering: true,
            columns: [
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nip',
                    name: 'nip'
                },
                {
                    data: 'status_pegawai',
                    name: 'status_pegawai'
                },
                {
                    data: 'tipe_pegawai',
                    name: 'tipe_pegawai'
                },
                {
                    data: 'tanggal_masuk',
                    name: 'tanggal_masuk',
                    render: function (data) {
                        return data ? new Date(data).toLocaleDateString('id-ID') : '-';
                    }
                },
                {
                    data: 'id_person',
                    name: 'id_person'
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap'
                },
            ],
        });

        // search optimized biar nggak berat
        const performOptimizedSearch = _.debounce(function (query) {
            try {
                if (query.length >= 3 || query.length === 0) {
                    table.search(query).draw();
                }
            } catch (error) {
                console.error('Error during search:', error);
            }
        }, 800);

        $('#example_filter input').unbind().on('input', function () {
            performOptimizedSearch($(this).val());
        });
    }

    // panggil fungsi saat halaman siap
    $(document).ready(function () {
        load_sdm();
    });
</script>
