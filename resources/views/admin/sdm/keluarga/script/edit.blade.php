<script defer>
    $('#form_edit').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.pendidikan.show', ':id') }}";


    DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                    $('#edit_id_hubungan_keluarga').val(data.id_hubungan_keluarga).trigger('change');
                    $('#edit_status_tanggungan').val(data.status_tanggungan).trigger('change');
                    $('#edit_pekerjaan').val(response.data.pekerjaan);
                    $('#edit_pendidikan_terakhir').val(response.data.pendidikan_terakhir);
                    $('#edit_penghasilan').val(response.data.penghasilan);

                fetchDataDropdown("{{ route('api.ref.hubungan_keluarga') }}", "#edit_id_hubungan_keluarga", "hubungan_keluarga", "hubungan_keluarga", function () {
                    $("#edit_id_hubungan_keluarga").val(data.id_hubungan_keluarga).trigger("change");
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
                    formData.append('id_hubungan_keluarga', $('#edit_id_hubungan_keluarga').val());
                    formData.append('status_tanggungan', $('#edit_status_tanggungan').val());
                    formData.append('pekerjaan', $('#edit_pekerjaan').val());
                    formData.append('pendidikan_terakhir', $('#edit_pendidikan_terakhir').val());
                    formData.append('penghasilan', $('#edit_penghasilan').val());

                    const updateUrl = "{{ route('admin.sdm.keluarga.update', ':id') }}";
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
