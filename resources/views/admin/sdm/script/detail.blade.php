<script defer>
// Handle modal detail
document.addEventListener('DOMContentLoaded', function() {
    // Event listener untuk tombol detail
    document.addEventListener('click', function(e) {
        if (e.target.closest('.detail-button')) {
            const button = e.target.closest('.detail-button');
            const id = button.getAttribute('data-id');

            // Redirect ke halaman show dengan ID
            window.location.href = `/admin/sdm/show/${id}`;
        }
    });
});
</script>
