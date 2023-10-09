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
})

// For the popu logout
const logoutBtn = document.getElementById('logoutBtn');
const confirmationDialog = document.getElementById('confirmationDialog');
const confirmLogout = document.getElementById('confirmLogout');
const cancelLogout = document.getElementById('cancelLogout');

logoutBtn.addEventListener('click', (e) => {
    e.preventDefault();
    confirmationDialog.classList.add('show');
});

confirmLogout.addEventListener('click', (e) => {
    e.preventDefault();
    window.location.href = 'PageNotFound.html';
});

cancelLogout.addEventListener('click', (e) => {
    e.preventDefault();
    confirmationDialog.classList.add('hide');
    setTimeout(() => {
        confirmationDialog.classList.remove('show');
        confirmationDialog.classList.remove('hide');
    }, 300);
});

const toggler = document.querySelector('.btn');

toggler.addEventListener('click', function(){
    document.querySelector('#sidebar').classList.toggle('collapsed');
})