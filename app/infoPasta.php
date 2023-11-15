<?php
session_start();

require_once "conexao.php";
require_once "validar.php";


try {
    if(isset($_GET['id_pasta'])){
        $id= $_GET['id_pasta'];
        $_SESSION['id_pasta'] = $id;
    }else{
        $id = $_SESSION['id_pasta'];
        unset($_SESSION['id_pasta']);
    }

    $query = $conexao->prepare("SELECT * FROM pastas WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();

    $resultado = $query->get_result(); 

    $dados = $resultado->fetch_all(MYSQLI_ASSOC);

    
          
    
} catch (Exception $error) {
    echo "erro na query $error";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtOrganizer</title>

    <!-- bootstrap5 -->
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    <!-- bootstrap-icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- fonte-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Gothic&display=swap" rel="stylesheet">


    <!--css-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/sidebar.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg color-nav">
        <div class="container-fluid">
            <div class="col-md-2">
                <a class="navbar-brand " href="#">
                    <img src="img/LOGOS/logo.png" alt="Logo" width="200rem" height="70rem"
                        class="mx-3 d-inline-block align-text-top">

                </a>
            </div>
            
            <div class="ml-2 col-md-2  menu-icons">
                <!--<img class="m-1" src="img/navbar_home/notificação.svg" alt="Notificação" height="30rem">-->

                <div class="dropstart">
                    <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="m-1 mx-4 img-perfil"
                            src="<?php if (isset($_SESSION['img-perfil'])) { ?>../upload/img-perfil/<?php echo $_SESSION['img-perfil'];
                                                                                                                                } else {
                                                                                                                                    echo "img/navbar_home/perfil.svg";
                                                                                                                                } ?>" alt="perfil"
                            height="50rem">
                    </a>

                    <ul class="dropdown-menu">
                        <li><span class="m-2"><?php echo "@" . $_SESSION['Nick']; ?></span></li>
                        <li><a class="dropdown-item" href="logout.php">Sair</a></li>

                    </ul>
                </div>

                <a href="configuracao.php"><img class="m-1" src="img/navbar_home/config.svg" alt="Configurações"
                        height="30rem"></a>
            </div>
        </div>
    </nav>

    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col d-flex justify-content-center align-itens-center m-5" id="content">
                <form action="attPasta.php" method="post">                                                                                                              
                <div class="container " id="informacoesArtigo">
                    <div class="row">
                        <h1>Informações da pasta</h1>
                    </div>
                    <div class="row">
                        <div class="row">
                            <div class="mb-3">
                              <label for="nomePasta" class="form-label">Nome</label>
                              <input type="text"
                                class="form-control" name="nomePasta" id="nomePasta" aria-describedby="helpId" placeholder="<?= $dados[0]['nome_pasta']; ?>">
                              <small id="helpId" class="form-text text-muted">Renomeie a pasta</small>
                            </div>
                        </div> 
                        
                        <div class="row">
                            <div class="mb-3">
                              <label for="autor" class="form-label">Descrição</label>
                              <input type="text"
                                class="form-control" name="desc" id="desc" aria-describedby="helpId" placeholder="<?= $dados[0]['descricao']; ?>">
                              <small id="helpId" class="form-text text-muted">Mude a descrição</small>
                            </div>
                        </div> 
                                                                                                                              
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-end align-itens-center">
                            <a name="voltar" id="btn_voltar" class="btn button m-2" href="home.php" role="button">voltar</a>
                            <button type="submit" class="btn button m-2">Atualizar</button>
                            
                        </div>
                    </div>
                </div>
                </form>

            </div>



            <!--sidebar Menu -->

            <nav class="mx-3 barra-menu">
                <div class="row" id="head_sidebar">

                    <div class="col-4 d-flex align-items-center justify-content-center ">

                        <i class="bi bi-list" id="botao-esconder-menu"></i>

                    </div>


                    <div class="col">

                        <div id="h2_menu" class="col">
                            <h1 class="texto">Menu</h1>
                        </div>

                    </div>

                </div>

                <div id="menu">
                    <ul id="links_menu" class="menu-list nav flex-column">
                        <li><a class="h5 texto nav-link link-dark" href="home.php">Minha Biblioteca</a></li>
                        <!--<li><a class="h5 texto nav-link link-dark" href="#">Explorar</a></li>-->
                    </ul>
                </div>
            </nav>

        </div>

    </div>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/sidebar.js"></script>
    <!--Navegação Menu -->
    <script src="js/index.js"></script>
</body>


</html>