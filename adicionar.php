<?php
$conn = new mysqli('localhost', 'root', '', 'gestao_alunos');
if ($conn->connect_error) { die("Falha na conexão: " . $conn->connect_error); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $contacto = $_POST['contacto'];

    if (!empty($nome) && !empty($email) && !empty($contacto)) {
        $stmt = $conn->prepare("INSERT INTO alunos (nome, email, contacto) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $contacto);

        if ($stmt->execute()) {
            header('Location: index.php');
            exit();
        } else {
            echo "Erro: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Todos os campos são obrigatórios.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Adicionar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Adicionar Novo Aluno</h1>
        <form method="post" action="" class="text-center" onsubmit="return validateForm()">
            <input type="text" name="nome" id="nome" class="form-control my-2" placeholder="Nome" required>
            <input type="email" name="email" id="email" class="form-control my-2" placeholder="Email" required>
            <input type="text" name="contacto" id="contacto" class="form-control my-2" placeholder="Contacto" required>
            <button type="submit" class="btn btn-primary">Adicionar</button>
            <a href="index.php" class="btn btn-secondary">Voltar à lista</a>
        </form>
    </div>

    <script>
        function validateForm() {
            const nome = document.getElementById('nome').value.trim();
            const email = document.getElementById('email').value.trim();
            const contacto = document.getElementById('contacto').value.trim();

            if (!nome || !email || !contacto) {
                alert('Todos os campos são obrigatórios.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
