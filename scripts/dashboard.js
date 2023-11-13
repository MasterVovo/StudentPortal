const sidebar = document.querySelector('aside');
const menuBtn = document.getElementById('menu-btn');
const closeBtn = document.getElementById('close-btn');

menuBtn.addEventListener('click', () => { //Open sidebar
    sidebar.style.display = 'block';
    sidebar.style.animation = 'showMenu 0.5s ease-in-out forwards';
});

closeBtn.addEventListener('click', () => { //Close sidebar
    sidebar.style.animation = 'hideMenu 0.5s ease-in-out forwards';
    
    setTimeout(() => { // Hide sidebar after 300ms
        sidebar.style.display = 'none';
    }, 300);
});


const darkMode = document.querySelector('.dark-mode');
const toggler = document.querySelector('.btn');
const darkModePreference = localStorage.getItem('darkMode');// Store dark mode preference

if (darkModePreference === 'true') { // If dark mode preference is true
    document.body.classList.add('dark-mode-variables'); // Apply dark mode
    darkMode.querySelector('span:nth-child(1)').classList.toggle('active');
    darkMode.querySelector('span:nth-child(2)').classList.toggle('active');
}

darkMode.addEventListener('click', () => { // Toggle dark mode
    document.body.classList.toggle('dark-mode-variables');
    darkMode.querySelector('span:nth-child(1)').classList.toggle('active');
    darkMode.querySelector('span:nth-child(2)').classList.toggle('active');

    const isDarkMode = document.body.classList.contains('dark-mode-variables');
    localStorage.setItem('darkMode', isDarkMode.toString()); 
});

toggler.addEventListener('click', () => { // Toggle sidebar
    document.querySelector('#sidebar').classList.toggle('collapsed');
});