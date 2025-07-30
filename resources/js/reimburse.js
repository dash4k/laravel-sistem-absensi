document.addEventListener('DOMContentLoaded', () => {
    const type = document.getElementById('formType');
    const bensinForm = document.getElementById('bensinForm');
    const makanForm = document.getElementById('makanForm');
    const barangForm = document.getElementById('barangForm');

    if (!type || !bensinForm || !makanForm || !barangForm) {
        return;
    }

    function toggleForms() {
        const value = type.value;

        bensinForm.classList.toggle('hidden', value !== 'bensin');
        makanForm.classList.toggle('hidden', value !== 'makan');
        barangForm.classList.toggle('hidden', value !== 'barang');
    }

    toggleForms();

    type.addEventListener('change', toggleForms);
});

const notaBensin = document.getElementById('notaBensin');
const notaMakan = document.getElementById('notaMakan');
const notaBarang = document.getElementById('notaBarang');
const buktiMakan = document.getElementById('buktiMakan');
const buktiBarang = document.getElementById('buktiBarang');
const notaBensinPreview = document.getElementById('notaBensinPreview');
const notaMakanPreview = document.getElementById('notaMakanPreview');
const notaBarangPreview = document.getElementById('notaBarangPreview');
const buktiMakanPreview = document.getElementById('buktiMakanPreview');
const buktiBarangPreview = document.getElementById('buktiBarangPreview');

document.addEventListener('DOMContentLoaded', function () {
    // Setup bensin preview
    if (notaBensin && notaBensinPreview) {
        notaBensin.addEventListener('change', function (event) {
            const file = event.target.files[0];
            notaBensinPreview.innerHTML = '';
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Preview";
                    img.className = "max-w-xs rounded-lg shadow-md";
                    notaBensinPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
                notaBensinPreview.classList.remove('hidden');
            } else {
                notaBensinPreview.innerHTML = '<p class="text-red-500">File bukan gambar yang valid.</p>';
            }
        });
    }

    // Setup makan preview
    if (notaMakan && notaMakanPreview) {
        notaMakan.addEventListener('change', function (event) {
            const file = event.target.files[0];
            notaMakanPreview.innerHTML = '';
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Preview";
                    img.className = "max-w-xs rounded-lg shadow-md";
                    notaMakanPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
                notaMakanPreview.classList.remove('hidden');
            } else {
                notaMakanPreview.innerHTML = '<p class="text-red-500">File bukan gambar yang valid.</p>';
            }
        });
    }

    if (buktiMakan && buktiMakanPreview) {
        buktiMakan.addEventListener('change', function (event) {
            const file = event.target.files[0];
            buktiMakanPreview.innerHTML = '';
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Preview";
                    img.className = "max-w-xs rounded-lg shadow-md";
                    buktiMakanPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
                buktiMakanPreview.classList.remove('hidden');
            } else {
                buktiMakanPreview.innerHTML = '<p class="text-red-500">File bukan gambar yang valid.</p>';
            }
        });
    }

    // Setup barang preview
    if (notaBarang && notaBarangPreview) {
        notaBarang.addEventListener('change', function (event) {
            const file = event.target.files[0];
            notaBarangPreview.innerHTML = '';
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Preview";
                    img.className = "max-w-xs rounded-lg shadow-md";
                    notaBarangPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
                notaBarangPreview.classList.remove('hidden');
            } else {
                notaBarangPreview.innerHTML = '<p class="text-red-500">File bukan gambar yang valid.</p>';
            }
        });
    }

    if (buktiBarang && buktiBarangPreview) {
        buktiBarang.addEventListener('change', function (event) {
            const file = event.target.files[0];
            buktiBarangPreview.innerHTML = '';
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Preview";
                    img.className = "max-w-xs rounded-lg shadow-md";
                    buktiBarangPreview.appendChild(img);
                };
                reader.readAsDataURL(file);
                buktiBarangPreview.classList.remove('hidden');
            } else {
                buktiBarangPreview.innerHTML = '<p class="text-red-500">File bukan gambar yang valid.</p>';
            }
        });
    }
});
