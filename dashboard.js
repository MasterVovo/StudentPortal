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