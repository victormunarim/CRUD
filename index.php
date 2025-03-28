<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h1 class="titulo">CRUD para gestão de etiquetas</h1>
    </header>

    <?php

    ?>

    <main>

        <h2>Cadastro de produto</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
            <label for="nome_cadastro">Nome:</label>
            <input type="text" name="nome_cadastro">
            <label for="preco_cadastro">Preço:</label>
            <input type="number" name="preco_cadastro">
            <input type="submit">
        </form>

        <?php
        include("database.php");

        if (isset($_GET["nome_cadastro"]) && isset($_GET["preco_cadastro"])) {
            $nome = $_GET["nome_cadastro"];
            $preco = $_GET["preco_cadastro"];


            $sql_code = "INSERT INTO etiquetas (preco, nome)
                VALUES ($preco, '$nome');";

            if (mysqli_query($conexao, $sql_code)) {
                echo "<p>Registrado produto $nome</p>";
            } else {
                echo "<p>Produto não registrado</p>";
            }
        }


        ?>

        <h2>Leitura de produto</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
            <select name="produto_leitura">
                <option selected>Selecione</option>
                <?php
                include("database.php");

                $sql_code = "SELECT * FROM etiquetas";

                if (mysqli_query($conexao, $sql_code)) {
                    $dados = mysqli_query($conexao, $sql_code);
                    while ($linha = mysqli_fetch_assoc($dados)) {
                        echo "<option value='$linha[nome]'>$linha[nome]</option>";
                    }
                }

                ?>
            </select>
            <input type="submit">
        </form>

        <?php

        if (isset($_GET["produto_leitura"])) {
            $produtoEscolhido = $_GET["produto_leitura"];
            $sql_code = "SELECT * FROM etiquetas WHERE nome = '$produtoEscolhido'";

            if (mysqli_query($conexao, $sql_code)) {
                $dados = mysqli_query($conexao, $sql_code);
                $linha = mysqli_fetch_assoc($dados);
                if (isset($linha)) {
                    echo "<p>ID: $linha[produtoID] - Nome: $linha[nome] - Preco: $linha[preco]</p>";
                }
            }
        }


        ?>

        <h2>Atualização de produto</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
            <select name="nome_atualizacao">
                <option selected>Selecione</option>
                <?php
                include("database.php");

                $sql_code = "SELECT * FROM etiquetas";

                if (mysqli_query($conexao, $sql_code)) {
                    $dados = mysqli_query($conexao, $sql_code);
                    while ($linha = mysqli_fetch_assoc($dados)) {
                        echo "<option value='$linha[nome]'>$linha[nome]</option>";
                    }
                }

                ?>
            </select>
            <label for="preco_atualizado">Preço:</label>
            <input type="number" name="preco_atualizado">
            <input type="submit">
        </form>

        <?php
        if (isset($_GET["preco_atualizado"]) && isset($_GET["nome_atualizacao"])) {
            $preco_atualizado = $_GET["preco_atualizado"];
            $nome_atualizacao = $_GET["nome_atualizacao"];

            include("database.php");

            $sql_code = "UPDATE etiquetas SET preco = '$preco_atualizado' WHERE nome = '$nome_atualizacao'";

            if (mysqli_query($conexao, $sql_code)) {
                echo "<p>Produto $nome_atualizacao atualizado com sucesso</p>";
            }
        }

        ?>

        <h2>Deletar produto</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
            <select name="nome_excluir">
                <option selected>Selecione</option>
                <?php
                include("database.php");

                $sql_code = "SELECT * FROM etiquetas";

                if (mysqli_query($conexao, $sql_code)) {
                    $dados = mysqli_query($conexao, $sql_code);
                    while ($linha = mysqli_fetch_assoc($dados)) {
                        echo "<option value='$linha[nome]'>$linha[nome]</option>";
                    }
                }

                ?>
            </select>
            <input type="submit">
        </form>
        <?php
        if (isset($_GET["nome_excluir"])) {
            $produto_excluir = $_GET["nome_excluir"];
            $sql_code = "DELETE FROM etiquetas WHERE nome = '$produto_excluir'";

            if (mysqli_query($conexao, $sql_code)) {
                echo "<p>Produto: $produto_excluir excluido com sucesso</p>";
            }
        }
        ?>

    </main>

</body>

</html>