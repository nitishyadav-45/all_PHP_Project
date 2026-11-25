
// Sidebar Toggle
document.getElementById("menu-toggle").addEventListener("click", function (e) {
    e.preventDefault();
    document.getElementById("sidebar").classList.toggle("active");
});

document.addEventListener("click", function (event) {
    var sidebar = document.getElementById("sidebar");
    var menuToggle = document.getElementById("menu-toggle");

    if (window.innerWidth <= 992 && sidebar.classList.contains("active")) {
        if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
            sidebar.classList.remove("active");
        }
    }
});
