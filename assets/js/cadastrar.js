
// Obtém o elemento select e o parágrafo para exibir o resultado
const tipoVendaSelect = document.getElementById('tipoVenda');
const resultado = document.getElementById('resultado');

// Função para verificar o valor selecionado
function verificarTipoVenda() {
    const tipoVenda = tipoVendaSelect.value;

    if (tipoVenda === '1') {
        document.getElementById('telaValorUnitario').style.display = 'block';
        document.getElementById('telaValorQuantidade').style.display = 'none';
    } else if (tipoVenda === '2') {
        document.getElementById('telaValorQuantidade').style.display = 'block';
        document.getElementById('telaValorUnitario').style.display = 'none';
    }
}

// Adiciona o evento change ao select
tipoVendaSelect.addEventListener('change', verificarTipoVenda);

// Chama a função inicialmente para garantir que a mensagem padrão seja exibida
verificarTipoVenda();

