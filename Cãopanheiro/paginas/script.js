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

    function criarFormulario() {
        var formContainer = document.getElementById('conteudo');
        formContainer.innerHTML = ''; // Limpa o conteúdo anterior
        
        var form = document.createElement('form');
        form.id = 'form';
        
        var nomeLabel = document.createElement('label');
        nomeLabel.setAttribute('for', 'nome');
        nomeLabel.textContent = 'Nome:';
        form.appendChild(nomeLabel);
        
        var nomeInput = document.createElement('input');
        nomeInput.setAttribute('type', 'text');
        nomeInput.setAttribute('id', 'nome');
        nomeInput.setAttribute('name', 'nome');
        nomeInput.setAttribute('required', '');
        form.appendChild(nomeInput);
        
        var emailLabel = document.createElement('label');
        emailLabel.setAttribute('for', 'email');
        emailLabel.textContent = 'Email:';
        form.appendChild(emailLabel);
        
        var emailInput = document.createElement('input');
        emailInput.setAttribute('type', 'text');
        emailInput.setAttribute('id', 'email');
        emailInput.setAttribute('name', 'email');
        emailInput.setAttribute('required', '');
        form.appendChild(emailInput);
        
        var mensagemLabel = document.createElement('label');
        mensagemLabel.setAttribute('for', 'mensagem');
        mensagemLabel.textContent = 'Mensagem:';
        form.appendChild(mensagemLabel);
        
        var mensagemTextarea = document.createElement('textarea');
        mensagemTextarea.setAttribute('id', 'mensagem');
        mensagemTextarea.setAttribute('name', 'mensagem');
        mensagemTextarea.setAttribute('rows', '4');
        mensagemTextarea.setAttribute('required', '');
        form.appendChild(mensagemTextarea);
        
        var submitButton = document.createElement('input');
        submitButton.setAttribute('type', 'submit');
        submitButton.setAttribute('value', 'Enviar');
        form.appendChild(submitButton);
        
        formContainer.appendChild(form);
      }