    // Open the menu modal with dynamically populated report button
    function openMenu() {
        const modal = document.getElementById("menuModal");
        const overlay = document.getElementById("overlay");
        modal.style.display = "block";
        overlay.style.display = "block";
    }
    function report() {
        const currentPageUrl = window.location.href;
        const filename = currentPageUrl.substring(currentPageUrl.lastIndexOf("/") + 1);
        const pageNumber = filename.replace(".php", "");
        const reportPageUrl = `report${pageNumber}.php`;
        window.location.href = reportPageUrl;
    }

    function goBack() {
        window.location.href = 'index.php';
    }

    function closeModal() {
        const modal = document.getElementById("menuModal");
        const overlay = document.getElementById("overlay");
        modal.style.display = "none";
        overlay.style.display = "none";
    }

    // Close the modal and overlay if user clicks outside the modal
    window.onclick = function (event) {
        const modal = document.getElementById("menuModal");
        const overlay = document.getElementById("overlay");
        if (event.target === overlay) {
            modal.style.display = "none";
            overlay.style.display = "none";
        }
    }