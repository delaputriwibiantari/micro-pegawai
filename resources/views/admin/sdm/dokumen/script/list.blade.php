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
                url: '{{ route('admin.sdm.dokumen.list', $id) }}',
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
                    data: 'jenis_dokumen',
                    name: 'jenis_dokumen',
                    render: function (data) {
                        return data;
                    }
                },
                {
                    data: 'nama_dokumen',
                    name: 'nama_dokumen',
                    render: function (data) {
                        return data;
                    }
                },

                 {
                    data: 'file_dokumen',
                    name: 'file_dokumen',
                    render: function (data, type, row) {
                        if (data) {
                            const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                                .replace(':folder', 'dokumen')
                                .replace(':filename', data);
                            return `<a href="${fileUrl}" target="_blank" class="btn btn-sm btn-light-primary">Lihat</a>`;
                        }
                        return '-';
                    }
                },
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
