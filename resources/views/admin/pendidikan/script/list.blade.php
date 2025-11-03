<script>
function load_pendidikan() {
    $.fn.dataTable.ext.errMode = 'none';
    const table = $('#pendidikanTable').DataTable({
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
            url: '{{ route('admin.pendidikan.list') }}', //  route untuk ambil data pendidikan
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
                data: 'institusi',
                name: 'institusi'
            },
            {
                data: 'jurusan',
                name: 'jurusan'
            },
            {
                data: 'tahun_masuk',
                name: 'tahun_masuk'
            },
            {
                data: 'tahun_lulus',
                name: 'tahun_lulus'
            },
            {
                data: 'jenis_nilai',
                name: 'jenis_nilai'
            },
            {
                data: 'sks',
                name: 'sks'
            },
            {
                data: 'sumber_biaya',
                name: 'sumber_biaya'
            },
            {
                data: 'nama_person',
                name: 'nama_person'
            },
        ],
    });

    // Optimized search (delay biar gak nge-spam request)
    const performOptimizedSearch = _.debounce(function (query) {
        try {
            if (query.length >= 3 || query.length === 0) {
                table.search(query).draw();
            }
        } catch (error) {
            console.error('Error during search:', error);
        }
    }, 800);

    // Target input filter DataTable
    $('#pendidikanTable_filter input').unbind().on('input', function () {
        performOptimizedSearch($(this).val());
    });
}

// 🔄 Panggil fungsi pas halaman siap
$(document).ready(function () {
    load_pendidikan();
});
</script>
