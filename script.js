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

document.addEventListener('DOMContentLoaded', function() {
    // Get references to the form and the message div
    const contactForm = document.getElementById('contactForm');
    const formMessage = document.getElementById('formMessage');

    // Check if the form and message div exist on the page
    if (contactForm && formMessage) {

        // Add an event listener for the form's submit event
        contactForm.addEventListener('submit', function(event) {
            // Prevent the default browser form submission
            event.preventDefault();

            // Clear previous messages and hide the message div
            formMessage.textContent = '';
            formMessage.style.display = 'none';
            formMessage.style.borderColor = '#ccc'; // Reset border color
            formMessage.style.color = '#333'; // Reset text color


            // Collect form data using FormData object
            const formData = new FormData(contactForm);

            // --- Send data using the Fetch API ---
            fetch(contactForm.action, { // Use the action attribute from the form
                method: contactForm.method, // Use the method attribute from the form
                body: formData // The collected form data
            })
            .then(response => {
                // Check if the HTTP response was ok (status in the range 200-299)
                if (!response.ok) {
                    // If the server responded with an error status (e.g., 404, 500)
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                // Parse the response body as JSON
                return response.json();
            })
            .then(data => {
                // This 'data' is the JSON object returned by your PHP script

                // Display the message based on the 'status' from the PHP response
                formMessage.textContent = data.message; // Display the message from PHP
                formMessage.style.display = 'block'; // Make the message div visible

                if (data.status === 'success') {
                    // Style the message div for success
                    formMessage.style.borderColor = '#4CAF50'; // Green border
                    formMessage.style.color = '#4CAF50';       // Green text
                    contactForm.reset(); // Clear the form fields on successful submission
                } else {
                    // Style the message div for errors
                    formMessage.style.borderColor = '#f44336'; // Red border
                    formMessage.style.color = '#f44336';       // Red text
                }
            })
            .catch(error => {
                // This catch block handles network errors or errors thrown in the .then blocks
                console.error('Fetch Error:', error); // Log the error to the browser console
                formMessage.textContent = 'An error occurred while submitting the form. Please try again.';
                formMessage.style.borderColor = '#f44336';
                formMessage.style.color = '#f44336';
                formMessage.style.display = 'block'; // Make the message div visible
            });
            // --- End of Fetch API ---
        });
    }
});
document.addEventListener('click', (event) => {
  if (!event.target.closest('.options-menu')) {
    optionsMenu.style.display = 'none';
  }
});
