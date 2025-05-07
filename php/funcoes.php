<?php

require_once 'conexao.php';

// Funções para para/com o servidor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $funcao = $_POST['funcao'];
    switch ($funcao) {
        case 'exibirPanfleto':
            exibirPanfleto();
            break;
        case 'cadastrarProduto':
            cadastrarProduto();
            break;
        case 'listarProdutoFilial':
            listarProdutoFilial();
            break;
        case 'pesquisarProdutoFilial':
            pesquisarProdutoFilial();
            break;
        case 'vincularFilialProduto':
            vincularFilialProduto();
            break;
        case 'desvincularFilialProduto':
            desvincularFilialProduto();
            break;
        case 'selecaoFilial':
            selecaoFilial();
            break;
        case 'seletorFilial':
            seletorFilial();
            break;
        default:
            break;
    }
}

function exibirPanfleto()
{
    global $conexao;

    if (!isset($_SESSION)) {
        session_start();
    }

    $sessao = $_SESSION['id_filial'];

    $sql = "SELECT p.cod_produto, p.desc_produto, p.tipo_produto, pr.tipo_venda, pr.valor, pr.quantidade
                FROM tb_filial f
                JOIN filial_produto pf ON f.id_filial = pf.fk_filial
                JOIN tb_produto p ON p.id_produto = pf.fk_produto
                JOIN tb_preco pr ON p.id_produto = pr.fk_produto
                WHERE f.id_filial = ?
                AND pr.uf = f.uf
                AND p.status = 1
                AND pr.status = 1
                AND pf.status = 1
                ORDER BY p.desc_produto ASC, pr.quantidade ASC
                ;";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    $statement->bind_param("i", $sessao);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }

    $result = $statement->get_result();

    if (!$result) {
        throw new Exception("Erro ao obter os resultados da consulta: " . $conexao->error);
    }

    $dados = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($dados);
}

function cadastrarProduto()
{
    global $conexao;

    // Adiciona as informações descritivas do produto
    $statusProduto = 0;
    if (isset($_POST['statusProduto']) && $_POST['statusProduto'] == "on") {
        $statusProduto = 1;
    }
    $codigoProduto = $_POST['codigoProduto'];
    $descricaoProduto = $_POST['descricaoProduto'];
    $tipoProduto = $_POST['tipoProduto'];

    $sql = "INSERT INTO `tb_produto` (
                `status`,
                `cod_produto`,
                `desc_produto`,
                `tipo_produto`
                )VALUES(
                ?,
                ?,
                ?,
                ?
                );";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    $statement->bind_param("issi", $statusProduto, $codigoProduto, $descricaoProduto, $tipoProduto);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }

    // Captura o id do produto adicionado
    $idProduto = $conexao->insert_id;

    // Adiciona o valor do produto caso seja vendido unitário
    if ($_POST['tipoVenda'] == 1) {
        if (isset($_POST['valorUnitarioPr'])) {
            $valor = str_replace(",", ".", $_POST['valorUnitarioPr']);

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '1',
                        ?,
                        '1',
                        'PR',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("di", $valor, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
        if (isset($_POST['valorUnitarioMs'])) {
            $valor = $_POST['valorUnitarioMs'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '1',
                        ?,
                        '1',
                        'MS',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("di", $valor, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
    }

    // Adiciona o valor do produto caso seja vendido em quantidade
    if ($_POST['tipoVenda'] == 2) {
        if (isset($_POST['valorProduto1pr'])) {
            $valor = str_replace(",", ".", $_POST['valorProduto1pr']);
            $quantidade = $_POST['quantidadeProduto1'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '2',
                        ?,
                        ?,
                        'PR',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
        if (isset($_POST['valorProduto1ms'])) {
            $valor = str_replace(",", ".", $_POST['valorProduto1ms']);
            $quantidade = $_POST['quantidadeProduto1'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '2',
                        ?,
                        ?,
                        'MS',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
        if (isset($_POST['valorProduto2pr'])) {
            $valor = str_replace(",", ".", $_POST['valorProduto2pr']);
            $quantidade = $_POST['quantidadeProduto2'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '2',
                        ?,
                        ?,
                        'PR',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
        if (isset($_POST['valorProduto2ms'])) {
            $valor = str_replace(",", ".", $_POST['valorProduto2ms']);
            $quantidade = $_POST['quantidadeProduto2'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '2',
                        ?,
                        ?,
                        'MS',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
        if (isset($_POST['valorProduto3pr'])) {
            $valor = str_replace(",", ".", $_POST['valorProduto3pr']);
            $quantidade = $_POST['quantidadeProduto3'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '2',
                        ?,
                        ?,
                        'PR',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
        if (isset($_POST['valorProduto3ms'])) {
            $valor = str_replace(",", ".", $_POST['valorProduto3ms']);
            $quantidade = $_POST['quantidadeProduto3'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '2',
                        ?,
                        ?,
                        'MS',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
    }

    header("Location: ../pages/cadastrar.html");
}

function listarProdutoFilial()
{
    global $conexao;

    if (!isset($_SESSION)) {
        session_start();
    }

    $sessao = $_SESSION['id_filial'];

    $sql = "SELECT p.id_produto, p.cod_produto, p.desc_produto
                FROM tb_filial f
                JOIN filial_produto pf ON f.id_filial = pf.fk_filial
                JOIN tb_produto p ON p.id_produto = pf.fk_produto
                WHERE f.id_filial = ?
                AND p.status = 1
                AND pf.status = 1
                ORDER BY p.desc_produto ASC
                ;";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    $statement->bind_param("i", $sessao);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }

    $result = $statement->get_result();

    if (!$result) {
        throw new Exception("Erro ao obter os resultados da consulta: " . $conexao->error);
    }

    $dados = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($dados);
}

function pesquisarProdutoFilial()
{
    global $conexao;

    if (!isset($_SESSION)) {
        session_start();
    }

    $sessao = $_SESSION['id_filial'];

    $busca = "%" . $_POST['busca'] . "%";
    $sql = "SELECT p.id_produto, p.cod_produto, p.desc_produto
                FROM tb_produto p
                WHERE NOT EXISTS
                (
                SELECT 1 
                FROM filial_produto pf 
                WHERE pf.fk_produto = p.id_produto 
                AND pf.fk_filial = ?
                )
                AND
                (
                p.cod_produto LIKE ?
                OR
                p.desc_produto LIKE ?
                )
                AND
                p.status = 1
                ;";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    $statement->bind_param("iss", $sessao, $busca, $busca);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }

    $result = $statement->get_result();

    if (!$result) {
        throw new Exception("Erro ao obter os resultados da consulta: " . $conexao->error);
    }

    $dados = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($dados);
}

function vincularFilialProduto()
{
    global $conexao;

    if (!isset($_SESSION)) {
        session_start();
    }

    $idProduto = $_POST['vincularIdProduto'];
    $sessao = $_SESSION['id_filial'];


    $sql = "INSERT INTO `filial_produto` (
            `fk_produto`,
            `fk_filial`
            )VALUES(
            ?,
            ?
            );";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    $statement->bind_param("ss", $idProduto, $sessao);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }
}

function desvincularFilialProduto()
{
    global $conexao;

    if (!isset($_SESSION)) {
        session_start();
    }

    $idProduto = $_POST['desvincularIdProduto'];
    $sessao = $_SESSION['id_filial'];

    $sql = "DELETE FROM filial_produto
            WHERE fk_produto = ? 
            AND fk_filial = ?
            ;";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    $statement->bind_param("ss", $idProduto, $sessao);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }
}

function selecaoFilial()
{
    if (!isset($_SESSION)) {
        session_start();
    }

    $_SESSION['id_filial'] = $_POST['selecaoFilial'];
}

function seletorFilial()
{
    global $conexao;
    if (!isset($_SESSION)) {
        session_start();
    }

    $sessao = $_SESSION['id_filial'];

    $sql = "SELECT f.id_filial, f.filial
    FROM tb_filial f
    WHERE f.status = 1;";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }

    $result = $statement->get_result();

    if (!$result) {
        throw new Exception("Erro ao obter os resultados da consulta: " . $conexao->error);
    }

    $dados = [
        'sessao' => $sessao,
        'filiais' => $result->fetch_all(MYSQLI_ASSOC)
    ];

    echo json_encode($dados);
}
