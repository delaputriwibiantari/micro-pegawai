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
                    titleAttr: 'Csv',
                    action: newexportaction,
                    className: 'btn btn-sm btn-dark rounded-2'
                },
                {
                    extend: 'excel',
                    titleAttr: 'Excel',
                    action: newexportaction,
                    className: 'btn btn-sm btn-dark rounded-2'
                }
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,
            ajax: {
                url: '{{ route('admin.absensi.izin.list') }}',
                cache: false
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
                    data: 'izin_id',
                    name: 'izin_id'
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap'
                },
                {
                    data: 'jenis_izin',
                    name: 'jenis_izin'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'waktu_izin',
                    name: 'waktu_izin'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data) {
                        if (!data) return '-';

                        let badgeClass = 'badge bg-secondary';

                        switch (data) {
                            case 'PENGAJUAN':
                                badgeClass = 'badge bg-warning text-dark';
                                break;
                            case 'DISETUJUI':
                                badgeClass = 'badge bg-success';
                                break;
                            case 'DITOLAK':
                                badgeClass = 'badge bg-danger';
                                break;
                        }

                        return `<span class="${badgeClass}">${data}</span>`;
                    }
                }
            ]
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

        $('#example_filter input')
            .unbind()
            .on('input', function () {
                performOptimizedSearch($(this).val());
            });
    }

    load_data();
</script>
