<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
    <title>Cadastro</title>
</head>
<body>

<form action="process/process_cadastro_livro.php" method="post">
    <label>Título:</label><br>
    <input type="text" name="titulo" required><br>

    <label>Autor</label><br>
    <input type="text" name="autor" required><br>

    <label>Ano</label><br>
    <input type="number" name="ano" required><br>

    <label>isbn</label><br>
    <input type="number" name="isbn" required><br>
    
    </select><br><br>

    <button type="submit">Cadastrar</button>
</form>

</body>
</html>
