const sidebar = document.querySelector('aside');
const menuBtn = document.getElementById('menu-btn');
const closeBtn = document.getElementById('close-btn');
const darkMode = document.querySelector('.dark-mode');
const toggler = document.querySelector('.btn');

// Check if dark mode preference is already stored in local storage
const darkModePreference = localStorage.getItem('darkMode');

// Set dark mode based on the stored preference
if (darkModePreference === 'true') {
  document.body.classList.add('dark-mode-variables');
  darkMode.querySelector('span:nth-child(1)').classList.toggle('active');
  darkMode.querySelector('span:nth-child(2)').classList.toggle('active');
}

// Event listener for the dark mode toggle button
darkMode.addEventListener('click', () => {
  // Toggle dark mode class on the body element
  document.body.classList.toggle('dark-mode-variables');
  darkMode.querySelector('span:nth-child(1)').classList.toggle('active');
  darkMode.querySelector('span:nth-child(2)').classList.toggle('active');

  // Update the dark mode preference in local storage
  const isDarkMode = document.body.classList.contains('dark-mode-variables');
  localStorage.setItem('darkMode', isDarkMode.toString());
});

// Event listener for the toggler button
toggler.addEventListener('click', () => {
  document.querySelector('#sidebar').classList.toggle('collapsed');
});