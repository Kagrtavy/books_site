import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    function toggleFields(selectElement, conditionValue, fieldsToShow) {
        if (selectElement.value === conditionValue) {
            fieldsToShow.forEach(field => field.style.display = 'block');
        } else {
            fieldsToShow.forEach(field => field.style.display = 'none');
        }
    }

    // Для поля Type
    const typeSelect = document.getElementById('type');
    const sourceWrapper = document.getElementById('source-wrapper');
    typeSelect.addEventListener('change', function () {
        toggleFields(typeSelect, 'Based on', [sourceWrapper]);
    });
    toggleFields(typeSelect, 'Based on', [sourceWrapper]);

    // Для поля Authorship
    const authorshipSelect = document.getElementById('authorship');
    const authorWrapper = document.getElementById('author-wrapper');
    const workLinkWrapper = document.getElementById('work-link-wrapper');
    authorshipSelect.addEventListener('change', function () {
        toggleFields(authorshipSelect, 'Translation', [authorWrapper, workLinkWrapper]);
    });
    toggleFields(authorshipSelect, 'Translation', [authorWrapper, workLinkWrapper]);

    // Для нового джерела (New Source)
    const sourceSelect = document.getElementById('source_id');
    const newSourceWrapper = document.getElementById('new-source-wrapper');
    sourceSelect.addEventListener('change', function () {
        toggleFields(sourceSelect, 'new', [newSourceWrapper]);
    });
    toggleFields(sourceSelect, 'new', [newSourceWrapper]);
});

document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photo-preview-img');
    photoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                photoPreview.src = e.target.result;
                photoPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            photoPreview.src = '';
            photoPreview.style.display = 'none';
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const addChapterBtn = document.getElementById('add-chapter-btn');
    const chapterForm = document.getElementById('chapter-form');

    addChapterBtn.addEventListener('click', function () {
        chapterForm.classList.toggle('hidden');
    });
});
