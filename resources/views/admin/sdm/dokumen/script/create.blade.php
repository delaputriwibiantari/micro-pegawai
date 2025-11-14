<script defer>
    $('#form_create').on('show.bs.modal', function (e) {
        fetchDataDropdown("{{ route('api.ref.jenis-dokumen') }}", '#id_jenis_dokumen', 'jenis_dokumen', 'jenis_dokumen');


      $('#bt_submit_create').off('submit').on('submit', function (e) {
            e.preventDefault();
            const fileDokumenInput = document.getElementById('file_dokumen');
            const fileDokumen = fileDokumenInput.files[0];
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

            if (fileDokumen) {

                const fileName = fileDokumen.name.toLowerCase();
                const fileSize = fileDokumen.size;


                const allowedExt = ['pdf', 'jpg', 'jpeg', 'png', 'docx', 'xlsx', 'pptx'];
                const ext = fileName.split('.').pop();

                if (fileName.split('.').length > 2) {
                    Swal.fire("Warning", "Nama file tidak boleh mengandung double extension.", "warning");
                    return;
                }

                const invisibleCharRegex = /[\u200B\u200C\u200D\uFEFF]/;
                if (invisibleCharRegex.test(fileName)) {
                    Swal.fire("Warning", "Nama file mengandung karakter tak terlihat. Silakan rename.", "warning");
                    return;
                }
                if (!allowedExt.includes(ext)) {
                    Swal.fire("Warning", "Tipe file tidak diizinkan. Hanya PDF, JPG, JPEG, PNG.", "warning");
                    return;
                }

                const allowedTypes = ["application/pdf", "image/jpeg", "image/png"];
                if (!allowedTypes.includes(fileDokumen.type)) {
                    Swal.fire("Warning", "Format file tidak valid / dicurigai dimodifikasi.", "warning");
                    return;
                }

                if (fileSize > 5 * 1024 * 1024) {
                    Swal.fire("Warning", "Ukuran file Dokumen tidak boleh lebih dari 5MB", "warning");
                    return;
                }

                if (['jpg', 'jpeg', 'png'].includes(ext)) {
                    const img = new Image();
                    img.src = URL.createObjectURL(fileDokumen);
                    img.onload = function () {
                        console.log("Preview aman.");
                    }
                }
            }

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
                    formData.append('uuid_person', '{{ $id }}');
                    formData.append('id_jenis_dokumen', $('#id_jenis_dokumen').val());
                    formData.append('nama_dokumen', $('#nama_dokumen').val());

                   if (fileDokumen) {
                        formData.append('file_dokumen', fileDokumen);
                    }
                    const action = "{{ route('admin.sdm.dokumen.store') }}";
                    DataManager.formData(action, formData).then(response => {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Warning', 'validasi bermasalah', 'warning');
                        }

                        if (!response.success && !response.errors) {
                            Swal.fire('Peringatan', response.message, 'warning');
                        }

                    }).catch(error => {
                        ErrorHandler.handleError(error);
                    });
                }
            })
        });
    }).on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
    });
</script>




