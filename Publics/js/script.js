document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".menu-btn").addEventListener("click", function () {
        alert("Mở menu danh mục!");
    });

    document.querySelector(".location-btn").addEventListener("click", function () {
        alert("Chọn thành phố!");
    });

    document.querySelector(".search-btn").addEventListener("click", function () {
        alert("Tìm kiếm: " + document.querySelector(".search-box input").value);
    });

    document.querySelector(".login-btn").addEventListener("click", function () {
        alert("Mở trang đăng nhập!");
    });

    document.querySelectorAll(".nav-link").forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            alert("Chức năng chưa có!");
        });
    });
});
