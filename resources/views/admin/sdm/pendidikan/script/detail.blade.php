<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.sdm.pendidikan.show', [':id']) }}';


        DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                    $('#detail_id_jenjang_pendidikan').text(response.data.id_jenjang_pendidikan);
                    $('#detail_institusi').text(response.data.institusi);
                    $('#detail_jurusan').text(response.data.jurusan);
                    $('#detail_tahun_masuk').text(response.data.tahun_masuk);
                    $('#detail_tahun_lulus').text(response.data.tahun_lulus);
                    $('#detail_sks').text(response.data.sks);
                    $('#detail_jenis_nilai').text(response.data.jenis_nilai === 'IPK' ? 'IPK' : (response.data.jenis_nilai === 'NILAI' ? 'NILAI' : response.data.jenis_nilai));
                    $('#detail_sumber_biaya').text(response.data.sumber_biaya === 'BEASISWA' ? 'BEASISWA' : (response.data.sumber_biaya === 'MANDIRI' ? 'MANDIRI' : response.data.sumber_biaya));

                if (data.file_ijazah) {
                        $('#detail_file_ijazah_name').text(data.file_ijazah);
                        const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                            .replace(':folder', 'pendidikan')
                            .replace(':filename', data.file_ijazah);
                        $('#detail_file_ijazah_link').attr('href', fileUrl);
                        $('#detail_file_ijazah_section').show();
                        $('#no_file_ijazah_section').hide();
                    } else {
                        $('#detail_file_ijazah_section').hide();
                        $('#no_file_ijazah_section').show();
                    }
                    if (data.file_transkip) {
                        $('#detail_file_transkip_name').text(data.file_transkip);
                        const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                            .replace(':folder', 'pendidikan')
                            .replace(':filename', data.file_transkip);
                        $('#detail_file_transkip_link').attr('href', fileUrl);
                        $('#detail_file_transkip_section').show();
                        $('#no_file_transkip_section').hide();
                    } else {
                        $('#detail_file_transkip_section').hide();
                        $('#no_file_transkip_section').show();
                    }
                } else {
                    Swal.fire("Warning", response.message, "warning");
                }
            })
            .catch(function (error) {
            ErrorHandler.handleError(error);
        });
    });
</script>

