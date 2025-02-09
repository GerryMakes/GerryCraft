document.addEventListener("DOMContentLoaded", function () {
    const aside = document.getElementById("aside");
    const container = document.querySelector(".container");
    const openBtn = document.getElementById("open-btn");
    const closeBtn = document.getElementById("close-btn");

    openBtn.addEventListener("click", function () {
        aside.classList.add("open");
        container.classList.add("aside-open");
    });

    closeBtn.addEventListener("click", function () {
        aside.classList.remove("open");
        container.classList.remove("aside-open");
    });
});

function math(num1, num2) {
    let sum = Number(num1) + Number(num2);
    document.getElementById("Sum").innerHTML = sum;
}