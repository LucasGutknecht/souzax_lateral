<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

require 'db.php';
echo "<div class='conteudo' id='conteudoMain'>";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $avatar   = $_POST['avatar'] ?? '';
    $valor_custom = $_POST['valor_custom'] ?? '';

    //verifica se o email já está cadastrado
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();


    $userExiste = ($result->num_rows > 0) ? true : false;

    //insere o novo usuário no banco de dados
    if(!$userExiste) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, avatar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $avatar);
        $stmt->execute();

        //verifica se a inserção foi bem-sucedida
        if ($stmt->affected_rows > 0) {


        } else {

            $_SESSION['erro_registro'] = 'Erro ao cadastrar usuário. Tente novamente.';
            echo"Erro ao cadastrar usuário. Tente novamente.";
            exit;
        }
    }
}

?>
<script>
      // Função para carregar telas no div conteudoMain
      function carregarTela(url) {
        fetch(url)
          .then(res => res.text())
          .then(html => {
            document.getElementById("conteudoMain").innerHTML = html;

            // Inicializa modal de avatar, se existir
            if (typeof setupAvatarModal === 'function') setupAvatarModal();
            if (typeof initAvatarModal === 'function') initAvatarModal();
          })
          .catch(err => console.error('Erro ao carregar tela:', err));
      }
    var user_existe = <?php echo $userExiste; ?>;
    document.addEventListener('DOMContentLoaded', function() {

        if (user_existe) {
           // header('Location: ./app/registrar.php');
            //alert('Email já cadastrado. Por favor, faça login.');
            carregarTela('../app/registrar.php');
        } else {
            alert('Usuário cadastrado com sucesso!');
            //window.location.href = '../app/registrar.php';
        }
    });
</script>
