document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const openBtn = document.getElementById("open-btn");
    const closeBtn = document.getElementById("close-btn");

    openBtn.addEventListener("click", function () {
        sidebar.classList.add("open"); // Show aside
    });

    closeBtn.addEventListener("click", function () {
        sidebar.classList.remove("open"); // Hide aside
    });
});
