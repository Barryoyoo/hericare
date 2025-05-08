const animatedSection = document.getElementById('my-animated-section');
const backgroundImages = ['backgroundmain1.jpg', 'backgroundmain2.jpg', 'backgroundmain3.jpg', 'backgroundmain4.jpg', 'backgroundmain5.jpg']; // Array of your image URLs
let currentIndex = 0; 
const animationDuration = 7000; // Time in milliseconds between image changes
const fadeDuration = 1000; // Duration of the fade effect

function changeBackgroundImage() {
  const nextIndex = (currentIndex + 1) % backgroundImages.length;
  const currentImage = backgroundImages[currentIndex];
  const nextImage = backgroundImages[nextIndex];

  // Create temporary image elements for smooth fading
  const currentBg = document.createElement('div');
  currentBg.style.position = 'absolute';
  currentBg.style.top = '0';
  currentBg.style.left = '0';
  currentBg.style.width = '100%';
  currentBg.style.height = '100%';
  currentBg.style.backgroundImage = `url('${currentImage}')`;
  currentBg.style.backgroundSize = 'cover';
  currentBg.style.backgroundPosition = 'center';
  currentBg.style.opacity = '1';
  currentBg.style.transition = `opacity ${fadeDuration / 1000}s ease-in-out`;
  animatedSection.appendChild(currentBg);

  const nextBg = document.createElement('div');
  nextBg.style.position = 'absolute';
  nextBg.style.top = '0';
  nextBg.style.left = '0';
  nextBg.style.width = '100%';
  nextBg.style.height = '100%';
  nextBg.style.backgroundImage = `url('${nextImage}')`;
  nextBg.style.backgroundSize = 'cover';
  nextBg.style.backgroundPosition = 'center';
  nextBg.style.opacity = '0';
  nextBg.style.transition = `opacity ${fadeDuration / 1000}s ease-in-out`;
  animatedSection.appendChild(nextBg);

  // Fade out the current image and remove it after the transition
  setTimeout(() => {
    currentBg.style.opacity = '0';
    setTimeout(() => {
      animatedSection.removeChild(currentBg);
    }, fadeDuration);
  }, 10); // Small delay to ensure the next image is added

  currentIndex = nextIndex;
}

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
