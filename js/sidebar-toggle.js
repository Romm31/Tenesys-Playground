document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggleSidebar");
    const sidebar = document.querySelector(".dash-side-nav");
    const container = document.querySelector(".dash-container");

    toggleBtn.addEventListener("click", function () {
        const isCollapsed = sidebar.classList.toggle("collapsed");
        container.classList.toggle("sidebar-hidden", isCollapsed);
    });
});
