<?php
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
$userName   = $isLoggedIn ? $_SESSION['user_name'] : 'Visitante';
$userEmail  = $isLoggedIn && isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'sem login';

$defaultAvatar = 'img/videoframe_12215.png';
$userAvatar = $defaultAvatar;

if ($isLoggedIn && !empty($_SESSION['user_avatar'])) {
    $avatarWebPath = $_SESSION['user_avatar']; // já está com 'avatars/img10.jpg'
    $avatarDiskPath = __DIR__ . '/' . $avatarWebPath;

    if (file_exists($avatarDiskPath)) {
        $userAvatar = $avatarWebPath;
    }
}

$destino = $isLoggedIn ? 'app/perfil.php' : 'app/login.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
  <link rel="stylesheet" href="css/menu.css" />
</head>
<body>
  <div class="layout">
     <main>
      <div class="conteudo" id="conteudoMain"></div>
    </main>
    <nav id="sidebar">
      <div id="sidebar_content">

        <div id="user">
          <img src="<?php echo htmlspecialchars($userAvatar); ?>" id="user_avatar" style="cursor:pointer; width:40px; height:40px; border-radius:50%;" title="<?php echo htmlspecialchars($userName); ?>" onclick="carregarTela('<?php echo $destino; ?>')"/>
          <p id="user_infos">
            <span class="item-description"><?php echo htmlspecialchars($userName); ?></span>
             <span class="item-description"><?php echo htmlspecialchars($userEmail); ?></span>
          </p>
        </div>

        <ul id="side-items">
          <li class="side-item active">
            <a href="index.php">
              <i class="fa-solid fa-house"></i>
              <span class="item-description">Home</span>
            </a>
          </li>

          <li class="side-item">
            <a href="#">
              <i class="fa-solid fa-box"></i>
              <span class="item-description">Produtos</span>
            </a>
          </li>

        <?php if ($isLoggedIn): ?>
            <li class="side-item">
              <a href="#" onclick="carregarTela('app/movie.php')">
                <i class="fa-solid fa-film"></i>
                <span class="item-description">Filmes</span>
              </a>
            </li>

            <li class="side-item">
              <a href="#" onclick="carregarTela('app/qr.php')">
                <i class="fa-solid fa-qrcode"></i>
                <span class="item-description">QR Pix</span>
              </a>
            </li>
          <?php endif; ?>

        <button id="open_btn">
          <i id="open_btn_icon" class="fa-solid fa-chevron-left"></i>
        </button>


      </div>

      <?php if ($isLoggedIn): ?>
     <div id="logout">
      <form action="conexao/logout.php" method="POST">
        <button type="submit" id="logout_btn">
          <i class="fa-solid fa-right-from-bracket"></i>
          <span class="item-description">Logout</span>
        </button>
     </form>
    </div>
    <?php endif; ?>

    </nav>
  </div>


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

  // Exemplo de carregar tela registrar ao clicar no link
  document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'link-registrar') {
      e.preventDefault();
      carregarTela('app/registrar.php');
    }
  });
</script>

 <script src="js/script.js"></script>
 <script src="js/modal_r.js"></script>
 <script src="js/perfil.js"></script>

</body>
</html>
