document.addEventListener("DOMContentLoaded", function() {
    const usernameElement = document.getElementById('username');
    const username = '<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : ""; ?>';
    usernameElement.textContent = username;

    const navToggle = document.querySelector('.nav-toggle');
    const nav = document.querySelector('nav');
    navToggle.addEventListener('click', function() {
        nav.classList.toggle('nav-collapsed');
    });
});
