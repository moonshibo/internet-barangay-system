document.addEventListener("DOMContentLoaded", () => {

    /*
    ========================================
    SIDEBAR
    ========================================
    */

    const sidebar = document.getElementById("sidebar");
    const menuButton = document.getElementById("menuButton");

    if (menuButton && sidebar) {
        menuButton.addEventListener("click", () => {
            sidebar.classList.toggle("open");
        });
    }


    /*
    ========================================
    LOGOUT MODAL
    ========================================
    */

    const logoutButton = document.getElementById("logoutButton");
    const logoutModal = document.getElementById("logoutModal");

    const closeLogoutModal =
        document.getElementById("closeLogoutModal");

    const cancelLogout =
        document.getElementById("cancelLogout");


    function openLogoutModal() {
        if (logoutModal) {
            logoutModal.classList.add("show");
        }
    }


    function closeLogout() {
        if (logoutModal) {
            logoutModal.classList.remove("show");
        }
    }


    if (logoutButton) {
        logoutButton.addEventListener("click", openLogoutModal);
    }

    if (closeLogoutModal) {
        closeLogoutModal.addEventListener("click", closeLogout);
    }

    if (cancelLogout) {
        cancelLogout.addEventListener("click", closeLogout);
    }


    /*
    Close modal when clicking outside
    */

    if (logoutModal) {

        logoutModal.addEventListener("click", (event) => {

            if (event.target === logoutModal) {
                closeLogout();
            }

        });

    }

});