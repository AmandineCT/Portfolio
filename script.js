//navbar

const navbar = document.querySelector('#navigation');
window.addEventListener('scroll', () => {
  if (window.scrollY > 50) {
    navbar.classList.add('scroll');
  } else {
    navbar.classList.remove('scroll');
  }
});
