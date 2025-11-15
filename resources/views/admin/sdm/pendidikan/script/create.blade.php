<script defer>
    $("#form_create_pendidikan").on("show.bs.modal", function (e) {
        fetchDataDropdown("{{ route('api.ref.jenjang-pendidikan') }}", '#id_jenjang_pendidikan', 'jenjang_pendidikan', 'jenjang_pendidikan');


        $("#bt_submit_create").on("submit", function (e) {
            e.preventDefault();
            const fileIjazahInput = document.getElementById('file_ijazah');
            const fileTranskipInput = document.getElementById('file_transkip');
            const fileIjazah = fileIjazahInput.files[0];
            const fileTranskip = fileTranskipInput.files[0];
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

            if (fileIjazah) {
                const fileName = fileIjazah.name.toLowerCase();
                const fileSize = fileIjazah.size;

                const allowedExt = ['pdf', 'jpg', 'jpeg', 'png', 'docx', 'xlsx', 'pptx', 'zip'];
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
                if (!allowedTypes.includes(fileIjazah.type)) {
                    Swal.fire("Warning", "Format file tidak valid / dicurigai dimodifikasi.", "warning");
                    return;
                }

                if (fileSize > 5 * 1024 * 1024) {
                    Swal.fire("Warning", "Ukuran file Ijazah tidak boleh lebih dari 5MB", "warning");
                    return;
                }

                if (['jpg', 'jpeg', 'png'].includes(ext)) {
                    const img = new Image();
                    img.src = URL.createObjectURL(fileIjazah);
                    img.onload = function () {
                        console.log("Preview aman.");
                    }
                }

            }

            if (fileTranskip) {
               const fileName = fileTranskip.name.toLowerCase();
                const fileSize = fileTranskip.size;

                const allowedExt = ['pdf', 'jpg', 'jpeg', 'png', 'docx', 'xlsx', 'pptx', 'zip'];
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
                if (!allowedTypes.includes(fileTranskip.type)) {
                    Swal.fire("Warning", "Format file tidak valid / dicurigai dimodifikasi.", "warning");
                    return;
                }

                if (fileSize > 5 * 1024 * 1024) {
                    Swal.fire("Warning", "Ukuran file Transkip tidak boleh lebih dari 5MB", "warning");
                    return;
                }

                if (['jpg', 'jpeg', 'png'].includes(ext)) {
                    const img = new Image();
                    img.src = URL.createObjectURL(fileTranskip);
                    img.onload = function () {
                        console.log("Preview aman.");
                    }
                }
            }

            Swal.fire({
                title: 'Kamu yakin?',
                text: "Apakah datanya benar dan apa yang anda inginkan?",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#dd3333',
                showCancelButton: true,
                allowOutsideClick: false, allowEscapeKey: false,
                confirmButtonText: 'Ya, Simpan', cancelButtonText: 'Batal', focusCancel: true,
            }).then(result => {
                if (result.value) {
                    DataManager.openLoading();

                    const formData = new FormData();
                    formData.append('uuid_person', '{{ $id }}');
                    formData.append('id_jenjang_pendidikan', $('#id_jenjang_pendidikan').val());
                    formData.append('institusi', $('#institusi').val());
                    formData.append('jurusan', $('#jurusan').val());
                    formData.append('tahun_masuk', $('#tahun_masuk').val());
                    formData.append('tahun_lulus', $('#tahun_lulus').val());
                    formData.append('jenis_nilai', $('#jenis_nilai').val());
                    formData.append('sks', $('#sks').val());
                    formData.append('sumber_biaya', $('#sumber_biaya').val());

                    if (fileIjazah) {
                        formData.append('file_ijazah', fileIjazah);
                    }
                    if (fileTranskip) {
                        formData.append('file_transkip', fileTranskip);
                    }
                    const createUrl = "{{ route('admin.sdm.pendidikan.store') }}";

                    DataManager.formData(createUrl, formData).then(response => {
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
