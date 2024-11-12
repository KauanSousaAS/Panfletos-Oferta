function loadData() {

    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../../php/conexao.php?funcao=listarProdutoFilial", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            let dadosProduto = JSON.parse(xhr.responseText);
            let tabela = document.getElementById('tabelaProdutosFilial');

            for (let x = 0; x < dadosProduto.length; x++) {
                let linha = document.createElement('tr');
                let descricaoProduto = document.createElement('td');
                let acoes = document.createElement('td');
                let botao = document.createElement('button');

                descricaoProduto.innerHTML = dadosProduto[x].cod_produto + " - " + dadosProduto[x].desc_produto;
                linha.appendChild(descricaoProduto);

                botao.textContent = 'X';
                acoes.appendChild(botao);
                linha.appendChild(acoes);

                tabela.appendChild(linha);
            }
        }
    }
    xhr.send();
}

loadData();

function pesquisarProduto(input) {
    let busca = input.value;
    let dropdown = document.getElementById("dropdown");

    if (busca === "") {
        dropdown.style.display = "none";
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("GET", `../php/conexao.php?funcao=pesquisarProdutoFilial&busca=${encodeURIComponent(busca)}`, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let produtos = JSON.parse(xhr.responseText);

            dropdown.innerHTML = "";
            if (produtos.length > 0) {
                dropdown.style.display = "block";
                produtos.forEach(produto => {
                    let div = document.createElement("div");
                    div.textContent = produto.cod_produto + " - " + produto.desc_produto;
                    let botaoAdicionar = document.createElement('button');
                    botaoAdicionar.textContent = '+';
                    botaoAdicionar.type = 'button';
                    div.appendChild(botaoAdicionar);
                    dropdown.appendChild(div);
                    botaoAdicionar.onclick = function(){
                        vincularFilialProduto(produto.id_produto);
                    }
                });
            } else {
                dropdown.style.display = "none";
            }
        }
    };
    xhr.send();
}

function vincularFilialProduto(idProduto){
    let xhr = new XMLHttpRequest();

    const vincular = [idProduto, 1]; 

    xhr.open("GET", '../php/conexao.php?funcao=vincularFilialProduto&vincularIdProduto='+idProduto+'&vincularIdFilial=1', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            pesquisarProduto(document.getElementById('pesquisa'));
            window.location.href = 'lista.html';
        }
    }
    xhr.send();
}