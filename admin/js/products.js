// /admin/js/products.js

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Modal Logic
    const modal = document.getElementById('productModal');
    const closeBtn = document.querySelector('.close-modal');

    window.openProductModal = function() {
        modal.style.display = 'block';
    };

    closeBtn.onclick = function() {
        modal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };

    // 2. Select All Checkbox Logic
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');

    if(selectAll) {
        selectAll.addEventListener('change', (e) => {
            checkboxes.forEach(cb => cb.checked = e.target.checked);
        });
    }

    // 3. Image Drag & Drop (Frontend Visuals)
    const dropZone = document.getElementById('imageDropZone');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        // Logic to preview images goes here
        console.log('Files dropped:', files);
        dropZone.innerHTML = `<p>${files.length} images selected</p>`;
    }
});