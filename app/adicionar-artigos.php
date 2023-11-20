<?php
require_once __DIR__ . "/../vendor/autoload.php";


use artorganizer\src\Entity\Artigo;
use artorganizer\src\Entity\Pasta;
use artorganizer\src\RelArtigoPasta;
use artorganizer\src\Arquivo;
use artorganizer\src\Repository\ArtigoRepository;

//definição de variaveis
    $titulo = $_POST['titulo-artigo'];
    $autor = $_POST['autor-artigo'];

    $img = $_FILES['img-previw'];
    $artigo = $_FILES['artigo'];

    $id_user = $_SESSION['ID'];

    $artigoRepository = new ArtigoRepository($conexao);

    if (isset($_SESSION['id_pasta'])) {
        $id_pasta = $_SESSION['id_pasta'];

        $query = $conexao->prepare("
        SELECT  * FROM pasta_user 
        INNER join pastas ON pasta_user.id_pasta = pastas.id
        WHERE pasta_user.id_user = ? AND pastas.id = ?

        ");
        $query->bind_param("ss", $id_user, $id_pasta);
        $query->execute();
        $resultado = $query->get_result();
        $dados = $resultado->fetch_array(MYSQLI_ASSOC);
        $id_pasta = $dados['id_pasta'];
    } else {

        $query = $conexao->prepare("
        SELECT  * FROM pasta_user 
        INNER join pastas ON pasta_user.id_pasta = pastas.id
        WHERE pasta_user.id_user = ? AND pastas.nome_pasta = 'root'

        ");
        $query->bind_param("s", $id_user);
        $query->execute();
        $resultado = $query->get_result();
        $dados = $resultado->fetch_array(MYSQLI_ASSOC);
        $id_pasta = $dados['id_pasta'];
    }

try {

    //tratamento de arquivos
    if (!(isset($img)) && !(isset($artigo))) {
        die();   
    }

    $arqImg = new arquivo(__DIR__ ."/../public/upload/artigo/img/", $img);
    $arqArtigo = new Arquivo(__DIR__ . "/../public/upload/artigo/artigo/", $artigo);
    $arqImg->moverImg($img);
    $arqArtigo->moverArtigo($artigo);

    //adiciona pasta no banco
    $artigo = new Artigo($titulo, $autor, $arqImg->gerarNome(), $arqArtigo->gerarNome());
    $artigoRepository->add($artigo);
    

    //adiciona relacionamento user-pasta no banco
    $relacionamento = new RelArtigoPasta($id_pasta, $artigo->getId()); 
    $relacionamento->inserirRelacionameto($conexao);

    header("Location:/home");

} catch (Exception $error) {
    echo "Não foi possivel adicionar artigo $error";
}
