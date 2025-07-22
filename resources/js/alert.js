import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', () => {
    if (window.laravelErrors && Array.isArray(window.laravelErrors)) {
        const errorMessages = window.laravelErrors.join('<br>');

        Swal.fire({
            title: 'Whoops...',
            html: errorMessages,
            icon: 'error',
            confirmButtonText: '  OK  ',
            confirmButtonColor: '#2176ff',
        });
    }
    
    if (window.laravelSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: window.laravelSuccess,
        });
    }
});

document.querySelectorAll('.deleteButton').forEach(button => {
    button.addEventListener('click', (e) => {
        const form = button.closest('form');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Tindakan ini tidak bisa dibatalkan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});