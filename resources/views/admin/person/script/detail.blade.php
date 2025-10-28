<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = '{{ route('admin.admin.person.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    $('#detail_nama_lengkap').text(response.data.nama_lengkap);
                    $('#detail_nama_panggilan').text(response.data.nama_panggilan);
                    $('#detail_tempat_lahir').text(response.data.tempat_lahir);
                    $('#detail_tanggal_lahir').text(formatter.formatDate(response.data.tanggal_lahir));
                    $('#detail_agama').text(response.data.agama);
                    $('#detail_kewarganegaraan').text(response.data.kewarganegaraan);
                    $('#detail_email').text(response.data.email);
                    $('#detail_no_hp').text(response.data.no_hp);
                    $('#detail_nik').text(response.data.nik);
                    $('#detail_kk').text(response.data.kk);
                    $('#detail_npwp').text(response.data.npwp);
                    $('#detail_alamat').text(response.data.alamat);
                    $('#detail_id_desa').text(response.data.desa);
                    $('#detail_jk').text(response.data.jk === 'L' ? 'Laki-laki' : (response.data.jk === 'P' ? 'Perempuan' : response.data.jk));
                    $('#detail_golongan_darah').text(response.data.golongan_darah === 'A'? 'A': (response.data.golongan_darah === 'B' ? 'B' : response.data.golongan_darah === 'AB' ? 'AB' : response.data.golongan_darah ===  'O' ? 'O' :response.data.golongan_darah));
                    $('#detail_rt').text(response.data.rt);
                    $('#detail_rw').text(response.data.rw);
                    $('#detail_provinsi').text(response.data.provinsi);
                    $('#detail_kabupaten').text(response.data.kabupaten);
                    $('#detail_kecamatan').text(response.data.kecamatan);

                    // Handle foto display
                    if (response.data.foto) {
                        const photoUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                            .replace(':folder', 'person')
                            .replace(':filename', response.data.foto);
                        $('#detail_foto_preview').attr('src', photoUrl);
                    } else {
                        $('#detail_foto_preview').attr('src', '');
                    }
                } else {
                    Swal.fire('Peringatan', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });
    });
</script>
