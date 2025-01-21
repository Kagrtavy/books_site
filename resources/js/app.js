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

    // for Type
    const typeSelect = document.getElementById('type');
    const sourceWrapper = document.getElementById('source-wrapper');
    typeSelect.addEventListener('change', function () {
        toggleFields(typeSelect, 'Based on', [sourceWrapper]);
    });
    toggleFields(typeSelect, 'Based on', [sourceWrapper]);

    // for Authorship
    const authorshipSelect = document.getElementById('authorship');
    const authorWrapper = document.getElementById('author-wrapper');
    const workLinkWrapper = document.getElementById('work-link-wrapper');
    authorshipSelect.addEventListener('change', function () {
        toggleFields(authorshipSelect, 'Translation', [authorWrapper, workLinkWrapper]);
    });
    toggleFields(authorshipSelect, 'Translation', [authorWrapper, workLinkWrapper]);

    // for New Source
    const sourceSelect = document.getElementById('source_id');
    const newSourceWrapper = document.getElementById('new-source-wrapper');
    sourceSelect.addEventListener('change', function () {
        toggleFields(sourceSelect, 'new', [newSourceWrapper]);
    });
    toggleFields(sourceSelect, 'new', [newSourceWrapper]);
});

// show photo
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

document.addEventListener('DOMContentLoaded', function () {
    const genreSearch = document.getElementById('genre-search');
    const genreList = document.getElementById('genre-list');
    const selectedGenresContainer = document.getElementById('selected-genres');
    const selectedGenreIdsInput = document.getElementById('selected-genre-ids');
    const updateSelectedGenres = () => {
        const selectedGenres = Array.from(selectedGenresContainer.querySelectorAll('.selected-genre')).map(
            (genreCard) => ({
                id: genreCard.dataset.id,
                name: genreCard.dataset.name,
            })
        );
        selectedGenreIdsInput.value = JSON.stringify(selectedGenres.map((genre) => genre.id));
    };
    genreSearch.addEventListener('input', () => {
        const searchValue = genreSearch.value.toLowerCase();
        Array.from(genreList.children).forEach((genreItem) => {
            const genreName = genreItem.dataset.name.toLowerCase();
            genreItem.style.display = genreName.includes(searchValue) ? 'block' : 'none';
        });
        genreList.classList.toggle('hidden', searchValue.trim() === '');
    });
    genreList.addEventListener('click', (event) => {
        const genreItem = event.target.closest('.genre-item');
        if (!genreItem) return;
        const genreId = genreItem.dataset.id;
        const genreName = genreItem.dataset.name;
        if (Array.from(selectedGenresContainer.children).some((el) => el.dataset.id === genreId)) return;
        const genreCard = document.createElement('div');
        genreCard.className = 'selected-genre flex items-center gap-2 bg-blue-100 dark:bg-blue-700 text-blue-900 dark:text-blue-200 px-2 py-1 rounded-md';
        genreCard.dataset.id = genreId;
        genreCard.dataset.name = genreName;
        genreCard.innerHTML = `
                <span>${genreName}</span>
                <button type="button" class="remove-genre text-red-500 hover:text-red-700">&times;</button>
            `;
        selectedGenresContainer.appendChild(genreCard);
        updateSelectedGenres();
    });
    selectedGenresContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-genre')) {
            event.target.closest('.selected-genre').remove();
            updateSelectedGenres();
        }
    });
});
