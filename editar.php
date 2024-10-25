<?php
$conn = new mysqli('localhost', 'root', '', 'gestao_alunos');
if ($conn->connect_error) { die("Falha na conexão: " . $conn->connect_error); }

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM alunos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $aluno = $resultado->fetch_assoc();
    $stmt->close();

    if (!$aluno) { echo "Aluno não encontrado!"; exit(); }
} else { header('Location: index.php'); exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $contacto = $_POST['contacto'];

    if (!empty($nome) && !empty($email) && !empty($contacto)) {
        $stmt = $conn->prepare("UPDATE alunos SET nome = ?, email = ?, contacto = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nome, $email, $contacto, $id);

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
    <title>Editar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Aluno</h1>
        <form method="post" action="" class="text-center" onsubmit="return validateForm()">
            <input type="text" name="nome" id="nome" value="<?php echo $aluno['nome']; ?>" class="form-control my-2" required>
            <input type="email" name="email" id="email" value="<?php echo $aluno['email']; ?>" class="form-control my-2" required>
            <input type="text" name="contacto" id="contacto" value="<?php echo $aluno['contacto']; ?>" class="form-control my-2" required>
            <button type="submit" class="btn btn-primary">Atualizar</button>
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
