function loadData() {

    // const form = document.getElementById('meuFormulario');
    const formData = new FormData();
    formData.append('funcao', 'listarProdutoFilial');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../php/functions.php", true);
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
                botao.type = 'button';
                let idProdutoA = dadosProduto[x].id_produto;
                botao.onclick = function () {
                    desvincularFilialProduto(idProdutoA);
                };
                acoes.appendChild(botao);
                linha.appendChild(acoes);

                tabela.appendChild(linha);
            }
        }
    }
    xhr.send(formData);
}

loadData();

function pesquisarProduto(input) {

    let busca = input.value;
    let dropdown = document.getElementById("dropdown");

    if (busca === "") {
        dropdown.style.display = "none";
        return;
    }

    // const form = document.getElementById('meuFormulario');
    const formData = new FormData();
    formData.append('funcao', 'pesquisarProdutoFilial');
    formData.append('busca', busca);


    let xhr = new XMLHttpRequest();
    xhr.open("POST", `../../php/functions.php`, true);
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
                    botaoAdicionar.onclick = function () {
                        vincularFilialProduto(produto.id_produto);
                    }
                });
            } else {
                dropdown.style.display = "none";
            }
        }
    };
    xhr.send(formData);
}

function vincularFilialProduto(idProduto) {

    const formData = new FormData();
    formData.append('funcao', 'vincularFilialProduto');
    formData.append('vincularIdProduto', idProduto);
    formData.append('vincularIdFilial', 1);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", '../../php/functions.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            window.location.href = 'lista.html';
        }
    }
    xhr.send(formData);
}

function desvincularFilialProduto(idProduto) {
    const formData = new FormData();
    formData.append('funcao', 'desvincularFilialProduto');
    formData.append('desvincularIdProduto', idProduto);
    formData.append('desvincularIdFilial', 1);
    console.log(idProduto);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", '../../php/functions.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            window.location.href = 'lista.html';
        }
    }
    xhr.send(formData);
}