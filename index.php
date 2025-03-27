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

    <main>

        <h2>Cadastro de produto</h2>

        <form action="cadastro.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" name="nome">
            <label for="preco">Preço:</label>
            <input type="number" name="preco">
            <input type="submit">
        </form>

        <h2>Leitura de produto</h2>
        
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
            <select name="produto">
                <?php
                include("database.php");

                $sql_code = "SELECT * FROM etiquetas";

                $sql_query = $mysqli->query($sql_code) or die("erro: " . $mysqli->error);

                while ($dados = $sql_query->fetch_assoc()) {
                    echo "<option value='$dados[nome]'>$dados[nome]</option>";
                }
                ?>
            </select>
            <input type="submit">
        </form>

        <?php
        $produtoEscolhido = $_GET["produto"];
        echo "<p>$produtoEscolhido</p>";
        ?>

        <h2>Atualização de produto</h2>

        <?php
        while ($dados = $sql_query->fetch_assoc()) {
            echo "<p>$dados[nome]</p>";
            echo "<p>$dados[preco]</p>";
        }
        ?>

        <form action="atualizar.php" method="get">
            <label for="nome">Nome:</label>
            <input type="text" name="nome">
            <label for="preco">Preço:</label>
            <input type="number" name="preco">
            <input type="submit">
        </form>

    </main>

</body>

</html>