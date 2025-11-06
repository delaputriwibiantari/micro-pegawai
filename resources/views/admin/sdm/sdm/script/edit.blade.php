<script defer>
    $("#form_edit").on("show.bs.modal", function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.sdm.show', ':id') }}";

        let edit_tanggal_masuk = $("#edit_tanggal_masuk").flatpickr({
            dateFormat: "Y-m-d",
            altFormat: "d/m/Y",
            allowInput: false,
            altInput: true,
        });


        DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                $("#edit_nip").text(data.nip);
                $("#edit_status_pegawai").text(data.status_pegawai);
                $("#edit_tipe_pegawai").text(data.tipe_pegawai);
                $("#edit_id_person").text(data.id_person);
                $("#edit_nama_lengkap").text(data.nama_lengkap);
                edit_tanggal_masuk.setDate(response.data.tanggal_masuk);
            } else {
                Swal.fire("Warning", response.message, "warning");
            }
        })
            .catch(error => {
                ErrorHandler.handleError(error);
            });

        $("#bt_submit_edit").on("submit", function (e) {
            e.preventDefault();
            const updateUrl = "{{ route('admin.sdm.sdm.update', ':id') }}".replace(":id", id);
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin memperbarui data ini?",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#dd3333',
                showCancelButton: true,
                allowOutsideClick: false, allowEscapeKey: false,
                confirmButtonText: 'Ya, Perbarui!',
                cancelButtonText: 'Batal',
            }).then(result => {
                if (result.value) {
                    DataManager.openLoading();
                    const input = {
                        "nip": $("#edit_nip").val(),
                        "status_pegawai": $("#edit_status_pegawai").val(),
                        "tipe_pegawai": $("#edit_tipe_pegawai").val(),
                        "tanggal_masuk": $("#edit_tanggal_masuk").val(),
                    };
                    DataManager.postData(updateUrl, input).then(response => {
                        if (response.success) {
                            Swal.fire('Berhasil', response.message, 'success');
                            setTimeout(() => location.reload(), 1000);
                        } else if (response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter("edit_");
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Peringatan', 'Isian Anda belum lengkap atau tidak valid.', 'warning');
                        } else {
                            Swal.fire("Warning", response.message, "warning");
                        }
                    })
                        .catch(error => {
                            ErrorHandler.handleError(error);
                        });
                }
            });
        });
    })
        .on("hidden.bs.modal", function () {
            const $m = $(this);
            $m.find('form').trigger('reset');
            $m.find('select, textarea').val('').trigger('change');
            $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
            $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
        });
</script>
