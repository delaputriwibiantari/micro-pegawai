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
                url: '{{ route('admin.sdm.pendidikan.list', $id) }}',
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
                    data: 'jenjang_pendidikan',
                    name: 'jenjang_pendidikan',
                    render: function (data) {
                        return data;
                    }
                },
                {
                    data: 'institusi',
                    name: 'institusi',
                    render: function (data) {
                        return data;
                    }
                },
                 {
                    data: 'jurusan',
                    name: 'jurusan',
                    render: function (data) {
                        return data;
                    }
                },
                 {
                    data: 'tahun_masuk',
                    name: 'tahun_masuk',
                    render: function (data) {
                        return data;
                    }
                },
                 {
                    data: 'tahun_lulus',
                    name: 'tahun_lulus',
                    render: function (data) {
                        return data;
                    }
                },
                {
                    data: 'jenis_nilai',
                    name: 'jenis_nilai',
                    render: function (data) {
                        return data === 'IPK' ? 'IPK' : (data === 'NILAI' ? 'NILAI' : data);
                    }
                },
                {
                    data: 'sks',
                    name: 'sks',
                    render: function (data) {
                        return data;
                    }
                },
                {
                    data: 'sumber_biaya',
                    name: 'sumber_biaya',
                    render: function (data) {
                        return data === 'BEASISWA' ? 'BEASISWA' : (data === 'MANDIRI' ? 'MANDIRI' : data);
                    }
                },
                 {
                    data: 'file_ijazah',
                    name: 'file_ijazah',
                    render: function (data, type, row) {
                        if (data) {
                            const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                                .replace(':folder', 'pendidikan')
                                .replace(':filename', data);
                            return `<a href="${fileUrl}" target="_blank" class="btn btn-sm btn-light-primary">Lihat</a>`;
                        }
                        return '-';
                    }
                },
                {
                    data: 'file_transkip',
                    name: 'file_transkip',
                    render: function (data, type, row) {
                        if (data) {
                            const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                                .replace(':folder', 'pendidikan')
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
