$(document).ready(function () {
    $(document).on("click", ".download-link", function (e) {
        e.preventDefault(); // Prevent default anchor behavior
        var link = $(this);
        var url = link.attr("href");

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    // File exists, initiate download
                    var downloadUrl = url.replace("/downloader", "/download");
                    var tempLink = document.createElement('a');
                    tempLink.href = downloadUrl;
                    tempLink.setAttribute('download', ''); // Optional: Set the download attribute to suggest a filename
                    tempLink.style.display = 'none';
                    document.body.appendChild(tempLink);
                    tempLink.click();
                    document.body.removeChild(tempLink);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: data.message,
                        confirmButtonColor: "#5D87FF",
                        iconColor: "#FA896B",
                        customClass: {
                            title: "title" // Apply custom class to title
                        }
                    });
                }
            },
            error: function () {
                // Handle AJAX error if needed
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Failed to check file existence.",
                    confirmButtonColor: "#5D87FF",
                    iconColor: "#FA896B",
                    customClass: {
                        title: "title" // Apply custom class to title
                    }
                });
            }
        });
    });
});