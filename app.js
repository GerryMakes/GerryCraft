const menu = document.querySelector('#mobile-menu')
const menuLinks = document.querySelector('.navbar__menu')

menu.addEventListener('click', function() {
    menu.classList.toggle('is-active');
    menuLinks.classList.toggle('active');
});

var storedItem = localStorage.getItem("storedItem");

function save() {
    var Item = document.getElementById("input").value;
    localStorage.setItem("storedItem", Item);
    document.getElementByIda("savedText").innerHTML = Item + "SAVED";
}

function get() {
    localStorage.getItem("storedItem");
    document.getElementById("openedText").innerHTML = storedItem + "OPENED";
}