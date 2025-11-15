<script defer>
    $('#form_edit').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.pendidikan.show', ':id') }}";


    DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                    $('#edit_id_jenjang_pendidikan').val(data.id_jenjang_pendidikan).trigger('change');
                    $('#edit_institusi').val(response.data.institusi);
                    $('#edit_jurusan').val(response.data.jurusan);
                    $('#edit_tahun_masuk').val(response.data.tahun_masuk);
                    $('#edit_tahun_lulus').val(response.data.tahun_lulus);
                    $('#edit_jenis_nilai').val(data.jenis_nilai).trigger('change');
                    $('#edit_sks').val(response.data.sks);
                    $('#edit_sumber_biaya').val(data.sumber_biaya).trigger('change');

                if (data.file_ijazah) {
                    $('#current_file_ijazah_name').text(data.file_ijazah);
                    const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                        .replace(':folder', 'pendidikan')
                        .replace(':filename', data.file_ijazah);
                    $('#current_file_ijazah_link').attr('href', fileUrl);
                    $('#current_file_ijazah_info').show();
                } else {
                    $('#current_file_ijazah_info').hide();
                }

                if (data.file_transkip) {
                    $('#current_file_transkip_name').text(data.file_transkip);
                    const fileUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                        .replace(':folder', 'pendidikan')
                        .replace(':filename', data.file_transkip);
                    $('#current_file_transkip_link').attr('href', fileUrl);
                    $('#current_file_transkip_info').show();
                } else {
                    $('#current_file_transkip_info').hide();
                }

                fetchDataDropdown("{{ route('api.ref.jenjang-pendidikan') }}", "#edit_id_jenjang_pendidikan", "jenjang_pendidikan", "jenjang_pendidikan", function () {
                    $("#edit_id_jenjang_pendidikan").val(data.id_jenjang_pendidikan).trigger("change");
                });
                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
            ErrorHandler.handleError(error);
        });


        $("#bt_submit_edit").on("submit", function (e) {
            e.preventDefault();
            const fileIjazahInput = document.getElementById('edit_file_ijazah');
            const fileTranskipInput = document.getElementById('edit_file_transkip');
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
                    formData.append('id_jenjang_pendidikan', $('#edit_id_jenjang_pendidikan').val());
                    formData.append('institusi', $('#edit_institusi').val());
                    formData.append('jurusan', $('#edit_jurusan').val());
                    formData.append('tahun_masuk', $('#edit_tahun_masuk').val());
                    formData.append('tahun_lulus', $('#edit_tahun_lulus').val());
                    formData.append('jenis_nilai', $('#edit_jenis_nilai').val());
                    formData.append('sks', $('#edit_sks').val());
                    formData.append('sumber_biaya', $('#edit_sumber_biaya').val());
                   if (fileIjazah) {
                        formData.append('file_ijazah', fileIjazah);
                    }
                    if (fileTranskip) {
                        formData.append('file_transkip', fileTranskip);
                    }
                    const updateUrl = "{{ route('admin.sdm.pendidikan.update', ':id') }}";
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
