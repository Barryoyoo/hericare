// Initial call and set interval for continuous animation
changeBackgroundImage();
setInterval(changeBackgroundImage, animationDuration);


const dotsMenu = document.querySelector('.dots');
const optionsMenu = document.querySelector('.options');

dotsMenu.addEventListener('click', () => {
  optionsMenu.style.display = optionsMenu.style.display === 'block' ? 'none' : 'block';
});

// Close the menu if the user clicks outside of it
document.addEventListener('click', (event) => {
  if (!event.target.closest('.options-menu')) {
    optionsMenu.style.display = 'none';
  }
});