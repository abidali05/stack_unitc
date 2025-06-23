document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('createSnap').addEventListener('click', function () {
        Swal.fire({
            title: 'Creating Snap...',
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false
        });
        Swal.close();

        html2canvas(document.body, {
            // useCORS: true,
            logging: false,
            foreignObjectRendering: true,
            scale: window.devicePixelRatio,
            onrendered: function(canvas) {
                Swal.fire({
                    icon: 'success',
                    title: 'Snap Created!',
                    text: 'Your screenshot has been downloaded successfully.',
                    confirmButtonText: 'OK'
                });
                var link = document.createElement('a');
                link.href = canvas.toDataURL('image/jpeg'); // Convert canvas to a JPG data URL
                link.download = 'screenshot.jpg'; // Filename to save
                link.click(); // Trigger the download
            }
        });
    });
});
