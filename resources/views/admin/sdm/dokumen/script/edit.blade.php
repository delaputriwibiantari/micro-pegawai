<script defer>
    $('#form_edit').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.pendidikan.show', ':id') }}";

         let edit_tanggal_sk = $("#edit_tgl_terbit").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });
        let edit_tanggal_sk = $("#edit_tgl_berlaku").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });


    DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                    $('#edit_id_jenis_dokumen').val(data.id_jenis_dokumen).trigger('change');
                    $('#edit_nomor_dokumen').val(response.data.nomor_dokumen);
                     edit_tgl_terbit.setDate(data.tgl_terbit);
                     edit_tgl_berlaku.setDate(data.tgl_berlaku);


                fetchDataDropdown("{{ route('api.ref.jenis-dokumen') }}", "#edit_id_jenis_dokumen", "jenis_dokumen", "jenis_dokumen", function () {
                    $("#edit_id_jenis_dokumen").val(data.id_jenis_dokumen).trigger("change");
                });
                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });


        $("#bt_submit_edit").on("submit", function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Apakah datanya benar dan apa yang anda inginkan?',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false, allowEscapeKey: false,
                showCancelButton: true,
                cancelButtonColor: '#dd3333',
                confirmButtonText: 'Ya, Simpan', cancelButtonText: 'Batal', focusCancel: true,
            }).then((result) => {
                if (result.value) {
                    DataManager.openLoading();
                    const formData = new FormData();
                    formData.append('id_jenis_dokumen', $('#edit_id_jenis_dokumen').val());
                    formData.append('nomor_dokumen', $('#edit_nomor_dokumen').val());
                    formData.append('tgl_terbit', $('#edit_tgl_terbit').val());
                    formData.append('tgl_berlaku', $('#edit_tgl_berlaku').val());

                    const updateUrl = "{{ route('admin.sdm.dokumen.update', ':id') }}";
                    DataManager.formData(updateUrl.replace(":id", id), formData).then(response => {

                        if (response.success) {
                            Swal.fire("Success", response.message, "success");
                            setTimeout(() => location.reload(), 1000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire("Warning", "Validasi bermasalah", "warning");
                        }
                        if (!response.success && !response.errors) {
                            Swal.fire('Peringatan', response.message, 'warning');
                        }
                    }).catch(error => {
                        ErrorHandler.handleError(error);
                    });
                }
            });
        });
    }).on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
    });
</script>
