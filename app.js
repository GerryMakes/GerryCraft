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

const signUpButton=document.getElementById('signUpButton');
const signInButton=document.getElementById('signInButton');
const signInForm=document.getElementById('signIn');
const signUpForm=document.getElementById('signup');

signUpButton.addEventListener('click',function(){
    signInForm.style.display="none";
    signUpForm.style.display="block";
})
signInButton.addEventListener('click', function(){
    signInForm.style.display="block";
    signUpForm.style.display="none";
})