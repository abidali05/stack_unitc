document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".team-option").forEach(item => {
        item.addEventListener("click", function (e) {
            e.preventDefault();

            let teamId = this.getAttribute("data-team-id");
            let teamName = this.getAttribute("data-team-name");

            document.getElementById("selectedTeam").innerText = teamName;
            document.getElementById("displayTeam").innerText = teamName;

            fetch(`/get-minisite-records/${teamId}`)
                .then(response => response.json())
                .then(data => {
                    let recordList = document.getElementById("recordList");
                    recordList.innerHTML = "";

                    if (data.length > 0) {
                        data.forEach(record => {
                            //console.log(record);
                            let listItem = document.createElement("li");
                            listItem.innerHTML = `<strong>${capitalizeWords(record.page_title)}</strong>`;
                            listItem.style.padding = "5px 0";
                            listItem.style.cursor = "pointer";
                            listItem.style.transition = "background 0.3s ease";
                            listItem.setAttribute("data-page-id", record.id);
                            listItem.onmouseover = function () {
                                listItem.style.backgroundColor = "#0C5097";
                                listItem.style.borderRadius = "5px";
                                listItem.style.color = "white";
                                listItem.style.padding = "5px 5px";
                            };
                            listItem.onmouseout = function () {
                                listItem.style.backgroundColor = "transparent";
                                listItem.style.color = "black";
                                listItem.style.padding = "5px 0px";
                            };
                            recordList.appendChild(listItem);
                        });
                    } else {
                        recordList.innerHTML = '<li style="color: gray;">No records found</li>';
                    }
                })
                .catch(error => {
                    console.error("Error fetching minisite records:", error);
                    document.getElementById("recordList").innerHTML = '<li style="color: red;">Failed to load records</li>';
                });
        });
    });

    function capitalizeWords(str) {
        return str.replace(/\b\w/g, char => char.toUpperCase());
    }

    document.getElementById("recordList").addEventListener("click", function (e) {
        let listItem = e.target.closest("li"); // Ensure we get the LI even if clicking on <strong>

        if (listItem && listItem.hasAttribute("data-page-id")) {
            let pageId = listItem.getAttribute("data-page-id");
            //console.log(pageId);
            document.querySelector(".welcome").style.display = "none";

            fetch(`/get-page-records/${pageId}`)
                .then(response => response.json())
                .then(data => {
                    let page = data[0];

                    let pageDetails = document.getElementById("pageDetails");
                    pageDetails.style.display = "block";
                    document.getElementById("pageTitle").innerText = capitalizeWords(page.page_title);
                    document.getElementById("pageRecords").innerHTML = `
                        <div>
                            <img src="/${page.image}" alt="${page.page_title}" class="page-image" style="width:10%">
                        </div>
                        <div class="page-description">
                            <p>${page.page_description}</p>
                        </div>
                        <div class="page-actions mt-3">
                            <button class="btn btn-edit" onclick="editPage(${page.id})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-delete" onclick="confirmDelete(${page.id})">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </div>
                    `;

                })
                .catch(error => {
                    console.error("Error fetching page details:", error);
                });
        }
    });

});

function editPage(pageId) {
    fetch(`/get-page-record/${pageId}`)
        .then(response => response.json())
        .then(page => {
            //console.log(page);
            let editPageId = document.getElementById("editPageId");
            let editPageTitle = document.getElementById("editPageTitle");
            let editPageDescription = document.getElementById("editPageDescription");
            let currentPageImage = document.getElementById("currentPageImage");

            if (!editPageId || !editPageTitle || !editPageDescription || !currentPageImage) {
                console.error("Edit page modal elements not found.");
                Swal.fire("Error", "Edit modal not properly loaded!", "error");
                return;
            }

            editPageId.value = page.id;
            editPageTitle.value = page.page_title;
            editPageDescription.value = page.page_description;

            // Display current image
            currentPageImage.src = page.page_logo ? `${page.page_logo}` : "";

            let editModal = new bootstrap.Modal(document.getElementById("editPageModal"));
            editModal.show();
        })
        .catch(error => {
            Swal.fire("Error", "Failed to fetch page details", "error");
            console.error("Error fetching page details for edit:", error);
        });
}


function updatePage() {
    let pageId = document.getElementById("editPageId").value;
    let title = document.getElementById("editPageTitle").value;
    let description = document.getElementById("editPageDescription").value;
    let pageImage = document.getElementById("editPageImage").files[0];

    let formData = new FormData();
    formData.append("page_title", title);
    formData.append("page_description", description);
    if (pageImage) {
        formData.append("page_logo", pageImage);
    }

    fetch(`/update-page/${pageId}`, {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": csrfToken
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: "Success!",
                    text: "Page updated successfully.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire("Error", "Failed to update page.", "error");
            }
        })
        .catch(error => console.error("Error updating page:", error));
}

function confirmDelete(pageId) {
    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/delete-page/${pageId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "The page has been deleted.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire("Error", "Failed to delete page.", "error");
                    }
                })
                .catch(error => {
                    Swal.fire("Error", "Something went wrong!", "error");
                    console.error("Error deleting page:", error);
                });
        }
    });
}

document.getElementById('activity').addEventListener('click', function () {
    let content = document.getElementById('activityContent');
    let container = document.getElementById('teamActivityContainer');

    if (content.style.height === '0px' || content.style.height === '') {
        content.style.height = '200px'; // Smoothly expand
        container.style.bottom = '200px'; // Move up smoothly
    } else {
        content.style.height = '0px';
        container.style.bottom = '0';
    }
});

