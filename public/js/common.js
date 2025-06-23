document.addEventListener("DOMContentLoaded", function () {
    const mediaBtn = document.getElementById('media-btn');
    const mediaSubmenu = document.getElementById('media-submenu');
    const mediaClose = document.getElementById('media-close');
    const backdrop = document.getElementById('backdrop');

    mediaBtn.addEventListener('click', function () {
        if (mediaSubmenu.style.display === "none" || mediaSubmenu.style.display === "") {
            mediaSubmenu.style.display = "block";
            backdrop.style.display = "block";
        } else {
            mediaSubmenu.style.display = "none";
            backdrop.style.display = "none";
        }
    });

    mediaSubmenu.addEventListener('click', function (event) {
        event.stopPropagation();
    });

    backdrop.addEventListener('click', function () {
        mediaSubmenu.style.display = "none";
        backdrop.style.display = "none";
    });

    mediaClose.addEventListener('click', function () {
        mediaSubmenu.style.display = "none";
        backdrop.style.display = "none";
    });
});

// login/register/reset form eye password
document.querySelectorAll('.password-toggle').forEach(toggleContainer => {
    const input = toggleContainer.querySelector('.full-width-input');
    const toggleButton = toggleContainer.querySelector('.toggle-password');
    const icon = toggleButton.querySelector('i');

    toggleButton.addEventListener('click', function () {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
});


//media code

function submitForm(event) {
    event.preventDefault();

    const form = document.getElementById('uploadForm');
    const loader = document.getElementById('loader');
    const successMessage = document.getElementById('successMessage');
    //const mediaContainer = document.getElementById('mediaContainer');

    loader.style.display = 'block';
    successMessage.style.display = 'none';

    let formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    })
        .then(response => response.json())
        .then(data => {
            loader.style.display = 'none';
            if (data.success) {
                //console.log(data);
                swal.fire('Success!', 'Media Uploaded Successfully', 'success');
                successMessage.style.display = 'block';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3000); // Hide message after 3 seconds

                //let mediaHTML = '';
                data.media.forEach(media => {
                    if (media.type === 'image') {
                     let mediaHTML = `
                            <div class="media-container" style="position: relative; width: 155px; height: 100px;">
                                <img src="${media.path}" class="image-fluid"
                                    style="object-fit: cover; width: 100%; height: 100%; border-radius: 6px;">
                                <button class="delete-media" data-id="${media.id}"
                                    style="position: absolute; bottom: 2px; right: 2px; background: red; color: white;
                                        border: none; padding: 2px; border-radius: 50%; cursor: pointer;">
                                    🗑️
                                </button>
                            </div>`;

                        document.getElementById('imageContainer').insertAdjacentHTML('afterbegin', mediaHTML);
                        let newButton = document.querySelector('.delete-media[data-id="' + media.id + '"]');
                        attachDeleteEvent(newButton);

                    } else if (media.type === 'video') {
                        let mediaHTML = `
                                    <div class="media-container" style="position: relative; width: 150px; height: 120px;">
                                        <video width="100%" height="100%" controls style="border-radius: 6px; object-fit: cover;">
                                            <source src="${media.path}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <button class="delete-media" data-id="${media.id}"
                                            style="position: absolute; top: 2px; right: 2px; background: red; color: white;
                                                border: none; padding: 1px; border-radius: 50%; cursor: pointer;">
                                            🗑️
                                        </button>
                                    </div>`;
                        document.getElementById('videoContainer').insertAdjacentHTML('afterbegin', mediaHTML);
                        let newButton = document.querySelector('.delete-media[data-id="' + media.id + '"]');
                        attachDeleteEvent(newButton);
                    } else if (media.type === 'audio') {
                        console.log(media);
                        let mediaHTML = `
                                    <div class="media-container" style="position: relative; display: inline-block;">
                                        <p style="font-size: 12px; font-weight: bold; color: gray; margin-bottom:3px">
                                            ${media.user?.name ?? 'Unknown'} |
                                            ${new Date(media.created_at).toLocaleString()}
                                        </p>
                                        <audio src="${media.path}" controls preload="metadata"
                                            style="width: 330px; border-radius: 6px;" controlslist="nodownload">
                                        </audio>
                                        <button class="delete-media" data-id="${media.id}"
                                            style="position:absolute; top:57px; right:0px; background: red; color: white; border: none; padding: 2px; border-radius: 50%; cursor: pointer;">
                                            🗑️
                                        </button>
                                    </div>`;
                        document.getElementById('audioContainer').insertAdjacentHTML('afterbegin', mediaHTML);
                        let newButton = document.querySelector('.delete-media[data-id="' + media.id + '"]');
                        attachDeleteEvent(newButton);
                    }
                });

                // let newMedia = document.createElement('div');
                // newMedia.innerHTML = mediaHTML;
                //mediaContainer.prepend(newMedia);
            }
        })
        .catch(error => {
            console.error('Upload failed:', error);
            loader.style.display = 'none';
        });
}

function toggleMedia(type) {
    document.getElementById('imageSection').style.display = 'none';
    document.getElementById('videoSection').style.display = 'none';
    document.getElementById('audioSection').style.display = 'none';

    document.getElementById('imageTab').style.borderBottom = '';
    document.getElementById('videoTab').style.borderBottom = '';
    document.getElementById('audioTab').style.borderBottom = '';

    if (type === 'image') {
        document.getElementById('imageSection').style.display = 'block';
        document.getElementById('imageTab').style.borderBottom = '4px solid #036AB2';
    } else if (type === 'video') {
        document.getElementById('videoSection').style.display = 'block';
        document.getElementById('videoTab').style.borderBottom = '4px solid #036AB2';
    } else if (type === 'audio') {
        document.getElementById('audioSection').style.display = 'block';
        document.getElementById('audioTab').style.borderBottom = '4px solid #036AB2';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    toggleMedia('image');
});

function attachDeleteEvent(button) {
    button.addEventListener("click", () => {
        const id = button.getAttribute("data-id");
        console.log("Deleting media with ID:", id);

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/media/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json"
                    }
                }).then(response => {
                    if (response.ok) {
                        button.closest(".media-container").remove();
                        Swal.fire("Deleted!", "Your item has been deleted.", "success");
                    } else {
                        Swal.fire("Error!", "Failed to delete the item.", "error");
                    }
                });
            }
        });
    });
}

// Run on initial page load
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".delete-media").forEach(button => {
        attachDeleteEvent(button);
    });
});
