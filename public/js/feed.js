
//show news detail on click
function displayNewsDetails(article) {
    const newsDetailsContainer = document.getElementById('news-details');

    const content = `
        <div style="display: flex;">
            <div style="display: flex; align-items: center; border: 1px solid lightgray; border-radius: 5px; padding: 5px; background: lightgray;">
                <img src="${article.urlToImage || '/images/default-news.webp'}"
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 20px;" alt="News Image">
            </div>
            <div style="padding-left: 15px; width: 50%;">
                <p style="font-size: 12px; margin-bottom: 3px; color: #A2A2A2;">${article.publishedAt || 'Date not available'}</p>
                <p style="font-size: 14px; font-weight: 500; margin-bottom: 0px;">${article.title}</p>
                
            </div>
        </div>
        <div style="width: 85%; padding: 14px 0px;">
            <p style="font-size: 14px; margin-bottom: 0px;">${article.description || 'No description available.'}</p>
        </div>
        <div style="width: 85%; padding: 14px 0px;">
            <p style="font-size: 14px; margin-bottom: 0px;">${article.content || 'No content available.'}</p>
            
        </div>
    `;

    newsDetailsContainer.innerHTML = content;
}

//filter news
function filterNews() {
    const query = document.getElementById('searchInput').value;
    fetch(`/search-news?query=${encodeURIComponent(query)}`, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
        .then(response => response.json())
        .then(data => {
            const newsFeed = document.getElementById('newsFeed');
            newsFeed.innerHTML = '';

            if (data.length === 0) {
                newsFeed.innerHTML = '<p>No records found.</p>';
                return;
            }

            data.forEach(article => {
                const articleDiv = document.createElement('div');
                articleDiv.classList.add('article-container');
                articleDiv.style.display = 'flex';
                articleDiv.style.marginBottom = '20px';
                articleDiv.style.cursor = 'pointer';

                const isUserNews = article.user_id !== undefined;

                articleDiv.innerHTML = `
                <div style="display: flex; align-items: center; border: 1px solid lightgray; border-radius: 5px; padding: 10px; background: lightgray;">
                    <img src="${article.urlToImage || 'images/default-news.webp'}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 20px;" alt="News Image">
                </div>
                <div style="padding-left: 5px;">
                    <p style="font-size: 12px; margin-bottom: 3px; color: #A2A2A2;">${article.publishedAt}</p>
                    <p style="font-size: 13px; margin-bottom: 0;">${article.title}</p>
                    <a href="${article.url}" target="_blank" style="font-size: 12px; color: #007BFF;">Read more</a>
                </div>

                ${isUserNews ? `
                    <div class="article-actions">
                        <a href="javascript:void(0)" style="text-decoration: none;" class="edit-icon"
                            title="Edit" data-bs-toggle="modal" data-bs-target="#editNewsModal"
                            data-id="${article.id}" data-title="${article.title}"
                            data-source="${article.source}" data-content="${article.content}"
                            data-url="${article.url}" data-description="${article.description}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" class="delete-icon" title="Delete"
                            data-id="${article.id}">
                            <i class="fas fa-trash" style="color: red;"></i>
                        </a>
                    </div>` : ''}
            `;

                articleDiv.addEventListener('click', function () {
                    displayNewsDetails(article);
                });

                newsFeed.appendChild(articleDiv);
            });
        })
        .catch(error => console.error('Error fetching news:', error));
}
document.getElementById('searchInput').addEventListener('input', filterNews);

// edit news with assigning id to the edit form
document.addEventListener('click', function (e) {
    if (e.target.closest('.edit-icon')) {
        const editIcon = e.target.closest('.edit-icon');
        const newsId = editIcon.getAttribute('data-id');
        const newsTitle = editIcon.getAttribute('data-title');
        const newsSource = editIcon.getAttribute('data-source');
        const newsContent = editIcon.getAttribute('data-content');
        const newsUrl = editIcon.getAttribute('data-url');
        const newsDescription = editIcon.getAttribute('data-description');

        document.getElementById('newsId').value = newsId;
        document.getElementById('newsTitleInput').value = newsTitle;
        document.getElementById('newsSourceInput').value = newsSource;
        document.getElementById('newsContentInput').value = newsContent;
        document.getElementById('newsDescriptionInput').value = newsDescription;
        document.getElementById('newsUrlInput').value = newsUrl;

        const form = document.getElementById('editNewsForm');
        form.action = `/news-feed/${newsId}`;
    }
});

// delete news
document.addEventListener('click', function (e) {
    if (e.target.closest('.delete-icon')) {
        const newsId = e.target.closest('.delete-icon').getAttribute('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/news-feed/${newsId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', data.message, 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Something went wrong!', 'error');
                    });
            }
        });
    }
});

