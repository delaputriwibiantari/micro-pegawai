<script defer>
    function load_data() {
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
            buttons: [{
                extend: 'colvis',
                collectionLayout: 'fixed columns',
                collectionTitle: 'Column visibility control',
                className: 'btn btn-sm btn-dark rounded-2',
                columns: ':not(.noVis)'
            },
                {
                    extend: 'csv',
                    titleAttr: 'Csv',
                    action: newexportaction,
                    className: 'btn btn-sm btn-dark rounded-2',
                },
                {
                    extend: 'excel',
                    titleAttr: 'Excel',
                    action: newexportaction,
                    className: 'btn btn-sm btn-dark rounded-2',
                },
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,
            ajax: {
                url: '{{ route('admin.sdm.sdm.list') }}',
                cache: false,
            },
            order: [],
            ordering: true,
            columns: [{
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
                    name: 'status_pegawai',
                    render: function (data) {
                        return data === 'TETAP' ? 'TETAP' : (data === 'KONTRAK' ? 'KONTRAK' : data);
                    }
                },
                {
                    data: 'tipe_pegawai',
                    name: 'tipe_pegawai',
                    render: function (data) {
                        return data === 'FULL TIME' ? 'FULL TIME' : (data === 'PART TIME' ? 'PART TIME' : data);
                    }
                },
                {
                    data: 'tanggal_masuk',
                    name: 'tanggal_masuk',
                    render: function (data) {
                        return data == null ? '' : formatter.formatDate(data);
                    }
                },
                {
                    data: 'id_person',
                    name: 'id_person'
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap'
                }
            ],
        });
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

    load_data();
</script>
