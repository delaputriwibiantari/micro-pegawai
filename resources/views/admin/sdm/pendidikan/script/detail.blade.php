<script defer>
    $('#form_detail_pendidikan').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.pendidikan.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_institusi').text(response.data.institusi);
                    $('#detail_jurusan').text(response.data.jurusan);
                    $('#detail_tahun_masuk').text(response.data.tahun_masuk);
                    $('#detail_tahun_lulus').text(formatter.formatDate(response.data.tahun_lulus));
                    $('#detail_sks').text(response.data.sks);
                    $('#detail_jenis_nilai').text(response.data.jenis_nilai === 'IPK' ? 'IPK' : (response.data.jenis_nilai === 'NILAI' ? 'NILAI' : response.data.jenis_nilai));
                    $('#detail_sumber_biaya').text(response.data.sumber_biaya === 'BEASISWA' ? 'BEASISWA' : (response.data.sumber_biaya === 'MANDIRI' ? 'MANDIRI' : response.data.sumber_biaya));

                } else {
                    Swal.fire('Peringatan', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });
    });
</script>

