<script defer>
    function load_data_penggajian() {
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
                    collectionTitle: 'Column visibility control',
                    className: 'btn btn-sm btn-dark rounded-2',
                    columns: ':not(.noVis)'
                },
                {
                    extend: 'csv',
                    titleAttr: 'CSV',
                    action: newexportaction,
                    className: 'btn btn-sm btn-dark rounded-2',
                },
                {
                    extend: 'excel',
                    titleAttr: 'Excel',
                    action: newexportaction,
                    className: 'btn btn-sm btn-dark rounded-2',
                }
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,

            ajax: {
                url: '{{ route('admin.gaji.list') }}',
                cache: false,
                error: function(xhr) {
                    console.error("Ajax Error:", xhr.responseText);
                }
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
                    data: 'nama_pegawai',
                    name: 'nama_pegawai'
                },
                {
                    data: 'jabatan',
                    name: 'jabatan'
                },
                {
                    data: 'unit_kerja',
                    name: 'unit_kerja'
                },
                {
                    data: 'take_home_pay',
                    name: 'take_home_pay',
                    render: function(data) {
                        return data ? `Rp ${Number(data).toLocaleString('id-ID')}` : '-';
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                     render: function (data) {
                        return data === 'DRAFT' ? 'DRAFT' : (data === 'FINAL' ? 'FINAL' :)(data === 'CLOSED' ? 'CLOSED' : data);
                    }
                },
                {
                    data: 'bulan',
                    name: 'bulan',
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                }
            ],
        });

        // Search optimize
        const performOptimizedSearch = _.debounce(function (query) {
            try {
                if (query.length >= 3 || query.length === 0) {
                    table.search(query).draw();
                }
            } catch (error) {
                console.error('Error during search:', error);
            }
        }, 1000);

        $('#example_filter input').unbind().on('input', function () {
            performOptimizedSearch($(this).val());
        });
    }

    load_data_penggajian();
</script>
