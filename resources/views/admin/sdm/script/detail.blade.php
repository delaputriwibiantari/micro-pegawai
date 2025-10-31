<script defer>
$('#form_detail_sdm').on('show.bs.modal', function(e) {
    const button = $(e.relatedTarget);
    const id = button.data('id'); // ambil ID dari tombol
    const detailUrl = '{{ route('admin.sdm.show', [':id']) }}'.replace(':id', id);

    DataManager.fetchData(detailUrl).then(response => {
        if (response.success) {
            const data = response.data;

            // Data Person
            $('#detail_nik').text(data.nik ?? '-');
            $('#detail_nama_lengkap').text(data.nama_lengkap ?? '-');
            $('#detail_tempat_lahir').text(data.tempat_lahir ?? '-');
            $('#detail_tanggal_lahir').text(data.tanggal_lahir ?? '-');
            $('#detail_alamat').text(data.alamat ?? '-');

            // Data SDM
            $('#detail_nip').text(data.nip ?? '-');
            $('#detail_status_pegawai').text(data.status_pegawai ?? '-');
            $('#detail_tipe_pegawai').text(data.tipe_pegawai ?? '-');
            $('#detail_tanggal_masuk').text(data.tanggal_masuk ?? '-');

            // Foto
            if (data.foto) {
                const photoUrl = '{{ route('admin.view-file', ['person', ':filename']) }}'
                    .replace(':filename', data.foto);
                $('#detail_foto').attr('src', photoUrl);
            } else {
                $('#detail_foto').attr('src', '{{ asset('assets/default-profile.png') }}');
            }

        } else {
            Swal.fire('Warning', response.message, 'warning');
        }
    }).catch(err => ErrorHandler.handleError(err));
});
</script>
