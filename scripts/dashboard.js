const sidebar = document.querySelector('aside');
const menuBtn = document.getElementById('menu-btn');
const closeBtn = document.getElementById('close-btn');

const darkMode = document.querySelector('.dark-mode');

menuBtn.addEventListener('click', () => {
    sidebar.style.display = 'block';
});

closeBtn.addEventListener('click', () => {
    sidebar.style.display = 'none';
});

darkMode.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode-variables');
    darkMode.querySelector('span:nth-child(1)').classList.toggle('active');
    darkMode.querySelector('span:nth-child(2)').classList.toggle('active');
});


const toggler = document.querySelector('.btn');

toggler.addEventListener('click', function(){
    document.querySelector('#sidebar').classList.toggle('collapsed');
});