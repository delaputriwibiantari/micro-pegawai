<script>
    $(document).on('show.bs.modal', '#form_detail_pendidikan', function(e) {
    const button = $(e.relatedTarget);
    const id = button.data('id');
    const detailUrl = '{{ route("admin.pendidikan.show", [":id"]) }}'.replace(':id', id);

    console.log('🔍 Load detail pendidikan ID:', id);

    DataManager.fetchData(detailUrl)
        .then(response => {
            if (response.success && response.data) {
                const d = response.data;
                $('#detail_institusi').text(d.institusi || '-');
                $('#detail_jurusan').text(d.jurusan || '-');
                $('#detail_tahun_masuk').text(d.tahun_masuk || '-');
                $('#detail_tahun_lulus').text(d.tahun_lulus || '-');
                $('#detail_sks').text(d.sks || '-');
                $('#detail_jenis_nilai').text(d.jenis_nilai || '-');
                $('#detail_sumber_biaya').text(d.sumber_biaya || '-');
            } else {
                Swal.fire('Warning', response.message || 'Data tidak ditemukan', 'warning');
            }
        })
        .catch(error => {
            console.error('💥 Error ambil detail pendidikan:', error);
            ErrorHandler.handleError(error);
        });
});

</script>
