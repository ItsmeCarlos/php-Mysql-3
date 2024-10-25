<?php
$conn = new mysqli('localhost', 'root', '', 'gestao_alunos');
if ($conn->connect_error) { die("Falha na conexão: " . $conn->connect_error); }

$sql = "SELECT * FROM alunos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lista de Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Lista de Alunos</h1>
        <div class="text-center mb-3">
            <a href="adicionar.php" class="btn btn-primary">Adicionar Novo Aluno</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Contacto</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($linha = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $linha['id'] . "</td>";
                            echo "<td>" . $linha['nome'] . "</td>";
                            echo "<td>" . $linha['email'] . "</td>";
                            echo "<td>" . $linha['contacto'] . "</td>";
                            echo "<td>
                                <a href='editar.php?id=" . $linha['id'] . "' class='btn btn-warning btn-sm'>Editar</a>
                                <a href='eliminar.php?id=" . $linha['id'] . "' class='btn btn-danger btn-sm delete-confirm' data-id='" . $linha['id'] . "'>Eliminar</a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>Nenhum registo encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-confirm').forEach(button => {
            button.addEventListener('click', function(event) {
                const confirmation = confirm('Tens a certeza que desejas eliminar este registo?');
                if (!confirmation) {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
