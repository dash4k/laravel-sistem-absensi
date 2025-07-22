document.addEventListener('DOMContentLoaded', () => {
    const addButton = document.getElementById('addButton');
    const cancelButton = document.getElementById('cancelButton');

    const formContainer = document.getElementById('formContainer');
    const pegawaiForm = document.getElementById('pegawaiForm');
    
    function toggleForm(show = true) {
        pegawaiForm.classList.toggle('hidden', !show);
        formContainer.classList.toggle('opacity-0', !show);
        formContainer.classList.toggle('pointer-events-none', !show);
        formContainer.classList.toggle('opacity-100', show);
    }

    addButton.addEventListener('click', () => {
        pegawaiForm.reset();
        toggleForm(true);
    });

    cancelButton.addEventListener('click', () => toggleForm(false));

    formContainer.addEventListener('click', (e) => {
        if (e.target === formContainer) {
            toggleForm(false);
        }
    });
});