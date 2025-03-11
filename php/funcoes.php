<?php

require_once 'conexao.php';

// Funções para para/com o servidor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $funcao = $_POST['funcao'];
    switch ($funcao) {
        case 'exibirPanfleto':
            $exibirPanfleto = new ExibirPanfleto($conexao);
            $exibirPanfleto->exibirPanfleto("CP", "PR");
            break;
        case 'cadastrarProduto':
            $cadastrarProduto = new CadastrarProduto($conexao);
            $cadastrarProduto->cadastrarProduto();
            break;
        case 'listarProdutoFilial':
            $listarProdutoFilial = new ListarProdutoFilial($conexao);
            $listarProdutoFilial->listarProdutoFilial();
            break;
        case 'pesquisarProdutoFilial':
            $pesquisarProdutoFilial = new PesquisarProdutoFilial($conexao);
            $pesquisarProdutoFilial->pesquisarProdutoFilial();
            break;
        case 'vincularFilialProduto':
            $vinculoFilialProduto = new VinculoFilialProduto($conexao);
            $vinculoFilialProduto->vincularFilialProduto();
            break;
        case 'desvincularFilialProduto':
            $vinculoFilialProduto = new VinculoFilialProduto($conexao);
            $vinculoFilialProduto->desvincularFilialProduto();
            break;
        default:
            break;
    }
}

class ExibirPanfleto
{
    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function exibirPanfleto($filial, $uf)
    {

        $sql = "SELECT p.cod_produto, p.desc_produto, p.tipo_produto, pr.tipo_venda, pr.valor, pr.quantidade
                FROM tb_filial f
                JOIN filial_produto pf ON f.id_filial = pf.fk_filial
                JOIN tb_produto p ON p.id_produto = pf.fk_produto
                JOIN tb_preco pr ON p.id_produto = pr.fk_produto
                WHERE f.filial = ?
                AND f.uf = ?
                AND pr.uf = f.uf
                AND p.status = 1
                AND pr.status = 1
                AND pf.status = 1
                ORDER BY p.desc_produto ASC, pr.quantidade ASC
                ;";

        $statement = $this->conexao->prepare($sql);

        if (!$statement) {
            throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
        }

        $statement->bind_param("ss", $filial, $uf);

        if (!$statement->execute()) {
            throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
        }

        $result = $statement->get_result();

        if (!$result) {
            throw new Exception("Erro ao obter os resultados da consulta: " . $this->conexao->error);
        }

        $dados = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($dados);
    }
}

class CadastrarProduto
{

    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function cadastrarProduto()
    {
        $codigoProduto = $_POST['codigoProduto'];
        $descricaoProduto = $_POST['descricaoProduto'];
        $tipoProduto = $_POST['tipoProduto'];

        $sql = "INSERT INTO `tb_produto` (
                `cod_produto`,
                `desc_produto`,
                `tipo_produto`
                )VALUES(
                ?,
                ?,
                ?
                );";

        $statement = $this->conexao->prepare($sql);

        if (!$statement) {
            throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
        }

        $statement->bind_param("ssi", $codigoProduto, $descricaoProduto, $tipoProduto);

        if (!$statement->execute()) {
            throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
        }

        $idProduto = $this->conexao->insert_id;

        if ($_POST['tipoVenda'] == 1) {
            if (isset($_POST['valorUnitarioPr'])) {
                $valor = $_POST['valorUnitarioPr'];

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

                $statement = $this->conexao->prepare($sql);

                if (!$statement) {
                    throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
                }

                $statement->bind_param("di", $valor, $idProduto);

                if (!$statement->execute()) {
                    throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
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

                $statement = $this->conexao->prepare($sql);

                if (!$statement) {
                    throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
                }

                $statement->bind_param("di", $valor, $idProduto);

                if (!$statement->execute()) {
                    throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
                }
            }
        }

        if ($_POST['tipoVenda'] == 2) {
            if (isset($_POST['valorProduto1pr'])) {
                $valor = $_POST['valorProduto1pr'];
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

                $statement = $this->conexao->prepare($sql);

                if (!$statement) {
                    throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
                }

                $statement->bind_param("dii", $valor, $quantidade, $idProduto);

                if (!$statement->execute()) {
                    throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
                }
            }
            if (isset($_POST['valorProduto1ms'])) {
                $valor = $_POST['valorProduto1ms'];
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

                $statement = $this->conexao->prepare($sql);

                if (!$statement) {
                    throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
                }

                $statement->bind_param("dii", $valor, $quantidade, $idProduto);

                if (!$statement->execute()) {
                    throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
                }
            }
            if (isset($_POST['valorProduto2pr'])) {
                $valor = $_POST['valorProduto2pr'];
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

                $statement = $this->conexao->prepare($sql);

                if (!$statement) {
                    throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
                }

                $statement->bind_param("dii", $valor, $quantidade, $idProduto);

                if (!$statement->execute()) {
                    throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
                }
            }
            if (isset($_POST['valorProduto2ms'])) {
                $valor = $_POST['valorProduto2ms'];
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

                $statement = $this->conexao->prepare($sql);

                if (!$statement) {
                    throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
                }

                $statement->bind_param("dii", $valor, $quantidade, $idProduto);

                if (!$statement->execute()) {
                    throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
                }
            }
            if (isset($_POST['valorProduto3pr'])) {
                $valor = $_POST['valorProduto3pr'];
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

                $statement = $this->conexao->prepare($sql);

                if (!$statement) {
                    throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
                }

                $statement->bind_param("dii", $valor, $quantidade, $idProduto);

                if (!$statement->execute()) {
                    throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
                }
            }
            if (isset($_POST['valorProduto3ms'])) {
                $valor = $_POST['valorProduto3ms'];
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

                $statement = $this->conexao->prepare($sql);

                if (!$statement) {
                    throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
                }

                $statement->bind_param("dii", $valor, $quantidade, $idProduto);

                if (!$statement->execute()) {
                    throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
                }
            }
        }

        header("Location: ../pages/cadastrar.html");
    }
}

class ListarProdutoFilial
{

    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function listarProdutoFilial()
    {
        $sql = "SELECT p.id_produto, p.cod_produto, p.desc_produto
                FROM tb_filial f
                JOIN filial_produto pf ON f.id_filial = pf.fk_filial
                JOIN tb_produto p ON p.id_produto = pf.fk_produto
                WHERE f.filial = 'CP'
                AND f.uf = 'PR'
                AND p.status = 1
                AND pf.status = 1
                ORDER BY p.desc_produto ASC
                ;";

        $statement = $this->conexao->prepare($sql);

        if (!$statement) {
            throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
        }

        if (!$statement->execute()) {
            throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
        }

        $result = $statement->get_result();

        if (!$result) {
            throw new Exception("Erro ao obter os resultados da consulta: " . $this->conexao->error);
        }

        $dados = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($dados);
    }
}

class PesquisarProdutoFilial
{

    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    function pesquisarProdutoFilial()
    {
        $busca = "%" . $_POST['busca'] . "%";
        $sql = "SELECT p.id_produto, p.cod_produto, p.desc_produto
                FROM tb_produto p
                WHERE NOT EXISTS
                (
                SELECT 1 
                FROM filial_produto pf 
                WHERE pf.fk_produto = p.id_produto 
                AND pf.fk_filial = 1
                )
                AND
                (
                p.cod_produto LIKE ?
                OR
                p.desc_produto LIKE ?
                )
                ;";

        $statement = $this->conexao->prepare($sql);

        if (!$statement) {
            throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
        }

        $statement->bind_param("ss", $busca, $busca);

        if (!$statement->execute()) {
            throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
        }

        $result = $statement->get_result();

        if (!$result) {
            throw new Exception("Erro ao obter os resultados da consulta: " . $this->conexao->error);
        }

        $dados = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode($dados);
    }
}

class VinculoFilialProduto
{

    private $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    function vincularFilialProduto()
    {
        $idProduto = null;
        $idFilial = null;

        // ==================================================================================================================
        // Conferir se esse código funciona sem esses ifs
        // ==================================================================================================================

        if (isset($_POST['vincularIdProduto'])) {
            $idProduto = $_POST['vincularIdProduto'];
        }
        if (isset($_POST['vincularIdFilial'])) {
            $idFilial = $_POST['vincularIdFilial'];
        }
        $sql = "INSERT INTO `filial_produto` (
                `fk_produto`, 
                `fk_filial`
                )VALUES(
                ?, 
                ?
                );";

        $statement = $this->conexao->prepare($sql);

        if (!$statement) {
            throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
        }

        $statement->bind_param("ss", $idProduto, $idFilial);

        if (!$statement->execute()) {
            throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
        }
    }

    function desvincularFilialProduto()
    {
        $idProduto = null;
        $idFilial = null;
        if (isset($_POST['desvincularIdProduto'])) {
            $idProduto = $_POST['desvincularIdProduto'];
        }
        if (isset($_POST['desvincularIdFilial'])) {
            $idFilial = $_POST['desvincularIdFilial'];
        }
        $sql = "DELETE FROM filial_produto
                WHERE fk_produto = ? 
                AND fk_filial = ?
                ;";

        $statement = $this->conexao->prepare($sql);

        if (!$statement) {
            throw new Exception("Erro na preparação da consulta: " . $this->conexao->error);
        }

        $statement->bind_param("ss", $idProduto, $idFilial);

        if (!$statement->execute()) {
            throw new Exception("Erro na execução da consulta: " . $this->conexao->error);
        }
    }
}
