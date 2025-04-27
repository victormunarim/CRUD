<?php
include "database.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>

<?php
class Itens
{
    public $conexao;

    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function SepararDadosEOptions()
    {
        $options = "";
        if ($dados = $this->conexao->query("SELECT * FROM etiquetas;")) {
            while ($linha = $dados->fetch_assoc()) {
                $nome = $linha['nome'];
                $options .= "<option value='$nome'>$nome</option>";
            }
            return $options;
        }
    }
}

$itens = new Itens($conexao);
?>

<header>
    <h1 class="titulo">CRUD para gestão de etiquetas</h1>
</header>

<main class="container">
    <div class="cadastro">
        <h2>Cadastro de produto</h2>
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
            <div>
                <div class="caixa">
                    <label for="nomeCadastrar">Nome:</label>
                    <input required type="text" name="nomeCadastrar">
                </div>
                <div class="caixa">
                    <label for="precoCadastrar">Preço:</label>
                    <input required step="0.01" type="number" name="precoCadastrar">
                </div>
            </div>

            <?php

            //validar se os dados a cadastrar existem
            if (!empty($_GET["nomeCadastrar"]) && !empty($_GET["precoCadastrar"])) {
                $nomeCadastrar = $_GET["nomeCadastrar"];
                $precoCadastrar = $_GET["precoCadastrar"];

                //inserir os dados na tabela
                if ($dados = $conexao->query("SELECT * FROM etiquetas WHERE nome = '$nomeCadastrar';")) {
                    if ($linha = $dados->fetch_assoc()) {
                        echo "<p>Produto $nomeCadastrar ja exite</p>";
                    } else {
                        if ($conexao->query(
                            "INSERT INTO etiquetas (preco, nome)
                    VALUES ($precoCadastrar, '$nomeCadastrar');"
                        )) {
                            echo "<p>Produto $nomeCadastrar registrado com sucesso</p>";
                        }
                    }
                }
            }
            ?>
            <input class="enviar" type="submit">
        </form>

    </div>
    <div class="leitura">

        <h2>Leitura de produto</h2>
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
            <select class="caixa" name="produtoLer">
                <option selected>Selecione</option>
                <?php
                echo $itens->SepararDadosEOptions();
                ?>
            </select>
            <?php
            //ver se o dados a ler existem
            if (!empty($_GET["produtoLer"])) {
                $produtoLer = $_GET["produtoLer"];

                //pegar somente o dado selecionado para leitura
                if ($dados = $conexao->query("SELECT * FROM etiquetas WHERE nome = '$produtoLer'")) {
                    $linha = $dados->fetch_assoc();
                    if (isset($linha)) {
                        echo "<p>ID: $linha[produtoID] - Nome: $linha[nome] - Preco: R$$linha[preco]</p>";
                    }
                }
            }

            ?>
            <input class="enviar" type="submit">
        </form>

    </div>
    <div class="atualizacao">

        <h2>Atualização de produto</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
            <div>
                <select class="caixa" name="nomeAtualizar">
                    <option selected>Selecione</option>
                    <?php
                    echo $itens->SepararDadosEOptions();
                    ?>
                </select>
                <div class="caixa">
                    <label for="precoAtualizar">Preço:</label>
                    <input required step="0.01" type="number" name="precoAtualizar">
                </div>

            </div>
            <?php

            //validar se os dados a atualizar existem
            if (!empty($_GET["precoAtualizar"]) && !empty($_GET["nomeAtualizar"]) && $_GET["nomeAtualizar"] !== "Selecione") {
                $precoAtualizar = $_GET["precoAtualizar"];
                $nomeAtualizar = $_GET["nomeAtualizar"];

                //atualizar os dados na tabela
                if ($conexao->query("UPDATE etiquetas SET preco = '$precoAtualizar' WHERE nome = '$nomeAtualizar'")) {
                    echo "<p>Produto $nomeAtualizar atualizado com sucesso</p>";
                }
            }
            ?>
            <input class="enviar" type="submit">
        </form>

    </div>
    <div class="deletar">

        <h2>Deletar produto</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
            <select class="caixa" name="nomeExcluir">
                <option selected>Selecione</option>
                <?php
                echo $itens->SepararDadosEOptions();
                ?>

            </select>
            <?php

            //validar se os dados a excluir existem
            if (!empty($_GET["nomeExcluir"]) && $_GET["nomeExcluir"] !== "Selecione") {
                $produtoExcluir = $_GET["nomeExcluir"];

                //excluir os dados da tabela
                if ($conexao->query("DELETE FROM etiquetas WHERE nome = '$produtoExcluir'")) {
                    echo "<p>Produto: $produtoExcluir excluido com sucesso</p>";
                }
            }
            ?>
            <input class="enviar" type="submit">
        </form>
    </div>
</main>

</body>

</html>