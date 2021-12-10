//navbar

const navbar = document.querySelector('#navigation');
window.addEventListener('scroll', () => {
    if(window.scrollY > 50) {
        navbar.classList.add('scroll');
    } else {
        navbar.classList.remove('scroll');
    }
});

//popups
/*
const popupContainer = document.querySelector('#popup-container');
const popup = popupContainer.querySelector('#popup');
const titrePopup = popupContainer.querySelector("#popupTitle");
const popupParts =  popupContainer.querySelectorAll('.popupPart');
let closeTop = document.querySelector('#closeTop');
let closeBottom = document.querySelector('#closeBottom');

closeTop.addEventListener('click', () => {
    popupContainer.classList.remove('active');
});

closeBottom.addEventListener('click', () => {
    popupContainer.classList.remove('active');
});
*/
