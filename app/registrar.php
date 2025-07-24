<?php
session_start();

// Lista de avatares disponíveis
$avatarFolder = '../avatars/';
$avatars = array_diff(scandir($avatarFolder), array('.', '..'));
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Registro</title>
  <link rel="stylesheet" href="css/registrar.css">
</head>
<body>

  <div class="form" id="divPrincipal">
    <h2>Registrar</h2>
    <form id="registroForm" method="POST" action="conexao/registrar.php">
      <div class="avatar">
        <img id="previewAvatar" src="" alt="Avatar escolhido" style="display: none;" required>
        <button type="button" id="openAvatarModal">Escolher Avatar</button>
        <input type="hidden" name="valor_custom" id="valor_custom">
        <input type="hidden" name="avatar" id="selectedAvatar" required>
      </div>

      <input type="text" name="name" placeholder="Nome" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Senha" required>

      <button type="submit" id="btn_cadastrar" >Cadastrar</button>
    </form>

    <button class="register-btn" onclick="carregarTela('app/login.php')">Login</button>
  </div>

  <!-- Modal de Avatar -->
  <div id="avatarModal" class="modal">
    <div class="modal-content">
      <span id="closeModal" class="close">&times;</span>
      <h3>Escolha seu Avatar</h3>
      <div class="avatar-grid">
        <?php foreach ($avatars as $avatar): ?>
          <div class="avatar-option" data-avatar="avatars/<?= $avatar ?>">
            <img src="../avatars/<?= $avatar ?>" alt="Avatar">
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- JS: Modal de Avatar -->
  <script>
  const openModalBtn = document.getElementById('openAvatarModal');
  const closeModalBtn = document.getElementById('closeModal');
  const modal = document.getElementById('avatarModal');
  const avatarOptions = document.querySelectorAll('.avatar-option');
  const selectedAvatarInput = document.getElementById('selectedAvatar');
  const previewAvatar = document.getElementById('previewAvatar');

  openModalBtn.onclick = () => modal.classList.add('active');
  closeModalBtn.onclick = () => modal.classList.remove('active');

  avatarOptions.forEach(option => {
    option.addEventListener('click', () => {
      avatarOptions.forEach(o => o.classList.remove('selected'));
      option.classList.add('selected');

      const avatarPath = option.getAttribute('data-avatar');
      selectedAvatarInput.value = avatarPath;
      previewAvatar.src = '../' + avatarPath;
      previewAvatar.style.display = 'block';
      modal.classList.remove('active');
    });
  });

  window.onclick = function(event) {
    if (event.target === modal) {
      modal.classList.remove("active");
    }
  }
  </script>
      <script>
        const divPrincipal = document.getElementById('divPrincipal');
        const inputEscondido = document.getElementById('valor_custom');

        // Set the hidden input's value before submission
        inputEscondido.value = divPrincipal.dataset.customValue;
    </script>
</body>
</html>
