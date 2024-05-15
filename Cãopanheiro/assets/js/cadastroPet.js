
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
