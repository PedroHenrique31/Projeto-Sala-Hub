<?php
include('verifica_login.php');
?>

<?php

// Variável máxima para imagens
$maxImgFiles = 5;
$maxImgSize = 4194304; // bytes

// Variável máxima para arquivos
$maxFileSize = 4194304; // bytes

// Checa se apagaram o ID do projeto de alguma forma
if (!isset($_POST['idProjetos']) or $_POST['idProjetos'] == NULL) {
    header('Location: index.php?menuop=projetos');
    exit();
}

$idProjetos = $_POST['idProjetos'];

//Pega os dados do projeto com o ID dado
$sql = "SELECT * FROM tbprojetos WHERE idProjetos = {$idProjetos}";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);

// Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
if (mysqli_num_rows($rs) == 0 || $dados['visivelProjetos'] != 0) {
    header("Location: index.php?menuop=projetos");
    exit();
}

// Se o usuário não for admin e nem autor do projeto
if(($_SESSION['usuario_id'] != $dados['usuarioIdProjetos']) && ($_SESSION['administrador'] != 1)){
    header("Location: index.php?menuop=projetos");
    exit();
}

// Recebe os dados do forms
$idProjetos = mysqli_real_escape_string($conexao, $_POST["idProjetos"]);
$titulo = mysqli_real_escape_string($conexao, $_POST["nomeProjeto"]);
$autores = mysqli_real_escape_string($conexao, $_POST["autoresProjeto"]);
$curso = mysqli_real_escape_string($conexao, $_POST["cursoProjeto"]);
$semestre = mysqli_real_escape_string($conexao, $_POST["semestreProjeto"]);
$orientador = mysqli_real_escape_string($conexao, $_POST["orientadorProjeto"]);
$resumo = mysqli_real_escape_string($conexao, $_POST["resumoProjeto"]);

?>

<div class="container">

    <body>
        <div class="mt-5 d-flex justify-content-center">
            <div class="rounded-4 p-4 border border-4 shadow-sm">

                <?php

                $check = 1;

                $cursosPermitidos = [
                    'Administração', 'Análise e Desenvolvimento de Sistemas', 'Arquitetura e Urbanismo', 'Biomedicina', 'Ciência da Computação',
                    'Ciência de dados e Machine Learning', 'Ciências Biológicas', 'Ciências Contábeis', 'Direito', 'Educação Física', 'Enfermagem',
                    'Engenharia Civil', 'Engenharia de Computação', 'Engenharia Elétrica', 'Fisioterapia', 'Jornalismo', 'Marketing', 'Medicina',
                    'Medicina Veterinária', 'Nutrição', 'Psicologia', 'Publicidade e Propaganda', 'Relações Internacionais'
                ];

                $semestresPermitidos = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

                // Verificações de preenchimento dos campos de texto
                if(!preg_match("/^[A-Za-z0-9À-ÿ \']+$/", $titulo)){
                    $check = 0; ?>
                    <h4>O título deve conter apenas letras e/ou números.</h4>
                <?php }
                if (!preg_match("/^[A-Za-zÀ-ÿ \']+$/", $autores) || !preg_match("/^[A-Za-zÀ-ÿ \']+$/", $orientador)) {
                    $check = 0; ?>
                    <h4>Os nomes devem conter apenas letras e espaços.</h4>
                <?php }
                if (strlen($titulo) < 3 or strlen($autores) < 3 or strlen($orientador) < 3 or strlen($resumo) < 3) {
                    $check = 0; ?>

                    <h4>Os campos devem conter pelo menos 3 caracteres.</h4>
                <?php  }
                if (strlen($titulo) > 50) {
                    $check = 0; ?>
                    <h4>O campo 'nome' não pode ultrapassar 50 caracteres.</h4>
                <?php  }
                if (strlen($autores) > 500) {
                    $check = 0; ?>
                    <h4>O campo 'autores' não pode ultrapassar 500 caracteres.</h4>
                <?php  }
                if (strlen($orientador) > 50) {
                    $check = 0; ?>
                    <h4>O campo 'orientador' não pode ultrapassar 50 caracteres.</h4>
                <?php  }
                if (strlen($resumo) > 2500) {
                    $check = 0; ?>
                    <h4>O campo 'resumo' não pode ultrapassar 2500 caracteres.</h4>
                <?php  }

                if (!in_array($curso, $cursosPermitidos)) {
                    $check = 0; ?>
                    <h4>Selecione um curso válido.</h4>
                <?php }
                if (!in_array($semestre, $semestresPermitidos)) {
                    $check = 0; ?>
                    <h4>Selecione um semestre válido.</h4>

                <?php }

                if ($check == 0) {
                    // Se houver algum erro acima 
                ?>
                    <div class="text-center">
                        <a href="index.php?menuop=formulario-editar-projetos&idProjetos=<?= $idProjetos ?>" class="btn btn-light mt-2">Voltar</a>
                    </div>
                <?php exit();
                }

                // --- QUANDO TUDO FOR PREENCHIDO CORRETAMENTE ---
                if ($check == 1) {

                    // -------------------------------
                    // CHECAGEM E EXCLUSÃO DE IMAGENS
                    // -------------------------------

                    // Checa se foi marcada checkbox de imagem
                    if (isset($_POST['imgCheck'])) {
                        $imgCheck = $_POST['imgCheck'];

                        $n = count($imgCheck);

                        // echo ("$n selecionadas ");

                        // Apaga a imagem da pasta e da tabela
                        for ($i = 0; $i < $n; $i++) {
                            // echo ("| Deletando arquivo " . $imgCheck[$i] . " em uploads/img/".$idProjetos."/".$imgCheck[$i]);
                            if (file_exists("uploads/img/" . $idProjetos . "/" . $imgCheck[$i])) {
                                unlink("uploads/img/" . $idProjetos . "/" . $imgCheck[$i]);   // Deleta o arquivo no diretório local
                                $sqlImgDel = "DELETE FROM tbimagens WHERE nomeImagem = '$imgCheck[$i]'";    // Deleta na tabela de imagens
                                $rsImgDel = mysqli_query($conexao, $sqlImgDel) or die("Erro ao executar o DELETE!" . mysqli_error($conexao));   // Roda o SQL acima
                                // echo " FILE DELETED ";
                            }
                        }
                    } else {
                        // echo "Nenhuma exclusão de img selecionada. ";
                    }

                    // Checa se foi marcada checkbox de arquivo
                    if (isset($_POST['fileCheck'])) {
                        $fileCheck = $_POST['fileCheck'];
                    }


                    // -------------------------------
                    // CHECAGEM E EXCLUSÃO DE ARQUIVO
                    // -------------------------------

                    // Checa se foi marcada checkbox de arquivo
                    if (isset($_POST['fileCheck']) or (($_FILES['arquivo']['tmp_name']) != NULL)) {
                        if (isset($_POST['fileCheck'])) {
                            $fileCheck = $_POST['fileCheck'];
                        } else if (($_FILES['arquivo']['tmp_name']) != NULL) {
                            $sqlFile = "SELECT nomeArquivo FROM tbarquivos WHERE idSeuProjeto = {$idProjetos}";
                            $rsFile = mysqli_query($conexao, $sqlFile) or die("Erro ao executar consulta" . mysqli_error($conexao));
                            $dadoFile = mysqli_fetch_array($rsFile);
                            $fileCheck = $dadoFile[0];
                        }


                        // Apaga arquivo da pasta e da tabela
                        if (file_exists("uploads/arquivos/" . $idProjetos . "/" . $fileCheck)) {
                            echo " EXISTE FILE: $fileCheck; ; ; ; ";
                            unlink("uploads/arquivos/" . $idProjetos . "/" . $fileCheck);   // Deleta o arquivo no diretório local
                            $sqlFileDel = "DELETE FROM tbarquivos WHERE nomeArquivo = '$fileCheck'";    // Deleta na tabela de arquivos
                            $rsFileDel = mysqli_query($conexao, $sqlFileDel) or die("Erro ao executar o DELETE!" . mysqli_error($conexao));   // Roda o SQL acima
                        }
                    } else {
                        // echo "Nenhuma exclusão de arquivo selecionado. ";
                    }


                    // ------------------
                    // CAPTURA DAS IMAGEM
                    // ------------------

                    // arquivos permitidos
                    $imagens_permitidas = ['jpg', 'jpeg', 'png'];

                    // capturar as imagens do forms
                    $imagens = $_FILES['imagens'];

                    // capturar nomes das imagens
                    $nomes = $imagens['name'];


                    // -----------------------------
                    // ||ARMAZENAMENTO DE IMAGENS ||
                    // -----------------------------

                    // Variável para saber se o diretório já foi criado ou não
                    if (file_exists('uploads/img/' . $idProjetos)) {
                        $diretorio_criado = 1;
                    } else {
                        $diretorio_criado = 0;
                    }



                    // ----------------------
                    // CAPTURA DO ARQUIVO PDF
                    // ----------------------
                    // arquivos permitidos
                    $arquivos_permitidos = ['pdf'];

                    // capturar o arquivo do forms
                    $arquivo = $_FILES['arquivo'];

                    // captura nome do arquivo
                    $nomeArquivo = $arquivo['name'];

                    // ------------------------------
                    // ||ARMAZENAMENTO DE ARQUIVOS ||
                    // ------------------------------

                    // Variável para saber se o diretório já foi criado ou não
                    if (file_exists('uploads/arquivos/' . $idProjetos)) {
                        $diretorio_arquivo_criado = 1;
                    } else {
                        $diretorio_arquivo_criado = 0;
                    }



                    // SQL de contagem de imagens no sistema
                    $sqlImgCount = "SELECT * FROM tbimagens WHERE idSeuProjeto = {$idProjetos}";    // Conta as rows de imagens do projeto
                    $rsImgCount = mysqli_query($conexao, $sqlImgCount) or die("Erro ao executar a consulta!" . mysqli_error($conexao));
                    $numImg = mysqli_num_rows($rsImgCount);  // Armazena numero de imagens já existentes

                    // Validação para checar se as imagens enviadas passam de 5
                    // A contagem leva em consideração as imagens já existentes
                    if ((count($nomes) + $numImg) <= $maxImgFiles) {
                        $aux = count($nomes);
                    } else {
                        $aux = $maxImgFiles - $numImg;
                    }

                    // SQL para atualizar os campos normais (texto e int)
                    $sql = "UPDATE tbprojetos SET 
                    nomeProjetos = '$titulo',
                    autoresProjetos = '$autores',
                    cursoProjetos = '$curso',
                    semestreProjetos = '$semestre',
                    orientadorProjetos = '$orientador',
                    resumoProjetos = '$resumo'
                    WHERE idProjetos = $idProjetos";
                    mysqli_query($conexao, $sql) or die("Erro na execução da consulta. " . mysqli_error($conexao));     // Checagem de erro



                    // ------------------------
                    // ||INSERÇÃO DE IMAGENS ||
                    // ------------------------
                    // Loop para inserir as imagens no diretório
                    for ($i = 0; $i < $aux; $i++) {
                        // Filtra as imagens enviadas como NULL pelo upload_max_filesize do PHP.ini
                        if (($_FILES['imagens']['tmp_name'][$i]) != NULL) {
                            $extensao = explode('.', $nomes[$i]);
                            $extensao = end($extensao);
                            $nomeOriginal = $nomes[$i];
                            $nomes[$i] = rand() . '_' . $nomes[$i];

                            $size = filesize($_FILES['imagens']['tmp_name'][$i]);

                            if (in_array($extensao, $imagens_permitidas) && ($size <= $maxImgSize)) {
                                if ($diretorio_criado) {
                                    $query = $conexao->query("INSERT INTO tbimagens(nomeImagem, idSeuProjeto) VALUES('$nomes[$i]', {$idProjetos})");

                                    if (mysqli_affected_rows($conexao) > 0) {
                                        // diretório de armazenamento de imgs
                                        $mover = move_uploaded_file($_FILES['imagens']['tmp_name'][$i], 'uploads/img/' . $idProjetos . '/' . $nomes[$i]);
                                        $_SESSION['sucesso'] = 'Imagem(s) enviada(s) com sucesso!';
                                    }
                                } else {
                                    if (mkdir('uploads/img/' . $idProjetos)) {
                                        $diretorio_criado = 1;
                                    }
                                    $query = $conexao->query("INSERT INTO tbimagens(nomeImagem, idSeuProjeto) VALUES('$nomes[$i]', {$idProjetos})");

                                    if (mysqli_affected_rows($conexao) > 0) {
                                        // diretório de armazenamento de imgs
                                        $mover = move_uploaded_file($_FILES['imagens']['tmp_name'][$i], 'uploads/img/' . $idProjetos . '/' . $nomes[$i]);
                                        $_SESSION['sucesso'] = 'Imagem(s) enviada(s) com sucesso!';
                                    }
                                }
                            }
                        }
                    }



                    // -----------------------------
                    // ||ARMAZENAMENTO DE ARQUIVO ||
                    // -----------------------------

                    // Filtra os arquivos enviados como NULL pelo upload_max_filesize do PHP.ini
                    if (($_FILES['arquivo']['tmp_name']) != NULL) {

                        // validação para inserir o arquivo no diretório
                        $extensaoArquivo = explode('.', $nomeArquivo);
                        $extensaoArquivo = end($extensaoArquivo);
                        $nomeArquivo = rand() . '_' . $nomeArquivo;

                        $sizeFile = filesize($_FILES['arquivo']['tmp_name']);

                        if (in_array($extensaoArquivo, $arquivos_permitidos) && ($sizeFile <= $maxFileSize)) {
                            if ($diretorio_arquivo_criado) {
                                $query = $conexao->query("INSERT INTO tbarquivos(nomeArquivo, idSeuProjeto) VALUES('$nomeArquivo', {$idProjetos})");

                                if (mysqli_affected_rows($conexao) > 0) {
                                    // diretório de armazenamento de arquivos
                                    $mover = move_uploaded_file($_FILES['arquivo']['tmp_name'], 'uploads/arquivos/' . $idProjetos . '/' . $nomeArquivo);
                                    $_SESSION['sucesso'] = 'Arquivo enviado com sucesso!';
                                }
                            } else {
                                if (mkdir('uploads/arquivos/' . $idProjetos)) {
                                    $diretorio_arquivo_criado = 1;
                                }
                                $query = $conexao->query("INSERT INTO tbarquivos(nomeArquivo, idSeuProjeto) VALUES('$nomeArquivo', {$idProjetos})");

                                if (mysqli_affected_rows($conexao) > 0) {
                                    // diretório de armazenamento de arquivos
                                    $mover = move_uploaded_file($_FILES['arquivo']['tmp_name'], 'uploads/arquivos/' . $idProjetos . '/' . $nomeArquivo);
                                    $_SESSION['sucesso'] = 'Arquivo enviado com sucesso!';
                                }
                            }
                        }
                    }



                ?>
                    <h4 class="text-center">Dados atualizados com sucesso.</h4>
                    <div class="text-center">
                        <form action="index.php?menuop=projetos" method="post">
                            <input class="btn btn-light mt-2" type="submit" value="Voltar">
                        </form>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </body>
</div>