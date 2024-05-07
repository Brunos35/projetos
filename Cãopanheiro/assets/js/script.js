document.addEventListener("DOMContentLoaded", function () {
  /*const usernameElement = document.getElementById("username");
  const username =
    '<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : ""; ?>';
  usernameElement.textContent = username;*/

  const navToggle = document.querySelector(".nav-toggle");
  const nav = document.querySelector("nav");
  navToggle.addEventListener("click", function () {
    nav.classList.toggle("nav-collapsed");
  });
});

function criarFormulario() {
  var formContainer = document.getElementById("conteudo");
  formContainer.innerHTML = ""; // Limpa o conteúdo anterior

  var form = document.createElement("form");
  form.id = "form";

  var nomeLabel = document.createElement("label");
  nomeLabel.setAttribute("action", "cadastroPet.php");
  nomeLabel.setAttribute("for", "nome");
  nomeLabel.textContent = "Nome:";
  form.appendChild(nomeLabel);

  var nomeInput = document.createElement("input");
  nomeInput.setAttribute("type", "text");
  nomeInput.setAttribute("id", "nome");
  nomeInput.setAttribute("name", "nome");
  nomeInput.setAttribute("required", "");
  form.appendChild(nomeInput);

  var dataLabel = document.createElement("label");
  dataLabel.setAttribute("for", "data");
  dataLabel.textContent = "Data de Nascimento:";
  form.appendChild(dataLabel);

  var dataInput = document.createElement("input");
  dataInput.setAttribute("type", "date");
  dataInput.setAttribute("id", "data");
  dataInput.setAttribute("name", "data");
  dataInput.setAttribute("required", "");
  form.appendChild(dataInput);

  var descricaoLabel = document.createElement("label");
  descricaoLabel.setAttribute("for", "desc");
  descricaoLabel.textContent = "Descrição:";
  form.appendChild(descricaoLabel);

  var descricaoTextarea = document.createElement("textarea");
  descricaoTextarea.setAttribute("id", "desc");
  descricaoTextarea.setAttribute("name", "desc");
  descricaoTextarea.setAttribute("rows", "4");
  descricaoTextarea.setAttribute("required", "");
  form.appendChild(descricaoTextarea);

  var racaLabel = document.createElement("label");
  racaLabel.setAttribute("for", "raca");
  racaLabel.textContent = "Selecione a raça:";
  form.appendChild(racaLabel);

  var racaSelect = document.createElement("select");
  racaSelect.setAttribute("id", "raca");
  racaSelect.setAttribute("name", "raca");
  racaSelect.setAttribute("required", "");

  var optionDefault = document.createElement("option");
  optionDefault.setAttribute("value", "");
  optionDefault.textContent = "Selecione";
  racaSelect.appendChild(optionDefault);

  var option1 = document.createElement("option");
  option1.setAttribute("value", "golden");
  option1.textContent = "Golden Retriever";
  racaSelect.appendChild(option1);

  var option2 = document.createElement("option");
  option2.setAttribute("value", "labrador");
  option2.textContent = "Labrador";
  racaSelect.appendChild(option2);

  var option3 = document.createElement("option");
  option3.setAttribute("value", "pincher");
  option3.textContent = "Pincher";
  racaSelect.appendChild(option3);

  form.appendChild(racaSelect);

  var submitButton = document.createElement("input");
  submitButton.setAttribute("type", "submit");
  submitButton.setAttribute("value", "Enviar");
  form.appendChild(submitButton);

  formContainer.appendChild(form);
}

function criarCatalogo(){
        var catalogoContainer = document.getElementById("conteudo");
        catalogoContainer.innerHTML = ""; // Limpa o conteúdo anterior
        
        catalogo.forEach(function(item) {
          var card = document.createElement('div');
          card.classList.add('card');
          
          var titulo = document.createElement('h3');
          titulo.textContent = item.nome;
          titulo.textContent = 'Cachorro'
          titulo.style.color= black;
          card.appendChild(titulo);

          var descricao = document.createElement('p');
          descricao.textContent = item.descricao;
          descricao.innerText ="Olá"
          card.appendChild(descricao);
          
          catalogContainer.appendChild(card);
        });
}
