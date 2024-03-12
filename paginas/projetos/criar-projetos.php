<?php
include('verifica_login.php');
?>

<?php
// Variável máxima para imagens
$maxImgFiles = 5;
$maxImgSize = 4194304; // bytes

// Variável máxima para arquivos
$maxFileSize = 4194304; // bytes

// Checa se as variáveis estão definidas
if(!isset($_POST['nomeProjeto']) || !isset($_POST['autoresProjeto']) || !isset($_POST['cursoProjeto']) || !isset($_POST['semestreProjeto']) 
|| !isset($_POST['orientadorProjeto']) || !isset($_POST['resumoProjeto'])){
    header('Location: index.php?menuop=projetos');
    exit();
}

// Adquire os dados do formulário
$nomeProjeto =  mysqli_real_escape_string($conexao, $_POST["nomeProjeto"]);
$autoresProjeto =  mysqli_real_escape_string($conexao, $_POST["autoresProjeto"]);
$cursoProjeto =  mysqli_real_escape_string($conexao, $_POST["cursoProjeto"]);
$semestreProjeto =  mysqli_real_escape_string($conexao, $_POST["semestreProjeto"]);
$orientadorProjeto =  mysqli_real_escape_string($conexao, $_POST["orientadorProjeto"]);
$resumoProjeto =  mysqli_real_escape_string($conexao, $_POST["resumoProjeto"]);

$usuarioId = $_SESSION['usuario_id'];

// Habilita aceitação de caracteres especiais
$utf8 = header("Content-Type:text/html; charset=utf-8");
?>

<div class="container mb-3">
    <div class="mt-5 d-flex justify-content-center">
        <div class="rounded-4 p-4 border border-4 shadow-sm">
            <div class="text-center">




                <?php
                $cursosPermitidos = [
                    'Administração', 'Análise e Desenvolvimento de Sistemas', 'Arquitetura e Urbanismo', 'Biomedicina', 'Ciência da Computação',
                    'Ciência de dados e Machine Learning', 'Ciências Biológicas', 'Ciências Contábeis', 'Direito', 'Educação Física', 'Enfermagem',
                    'Engenharia Civil', 'Engenharia de Computação', 'Engenharia Elétrica', 'Fisioterapia', 'Jornalismo', 'Marketing', 'Medicina',
                    'Medicina Veterinária', 'Nutrição', 'Psicologia', 'Publicidade e Propaganda', 'Relações Internacionais'
                ];

                $semestresPermitidos = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

                // Validações:
                // 1 - titulo, autor, orientador e resumo devem conter mais que 3 caracteres
                // 2, 3, 4 e 5 - titulo, orientador, autor e resumo devem conter menos que 50/500/50,2500 caracteres
                // 6 - nome, autor e orientador devem ser letras
                // 7 - curso deve ser um dos permitidos
                // 8 - semestre deve ser um dos permitidos

                $check = 1;



                if (!preg_match("/^[A-Za-z0-9À-ÿ \']+$/", $nomeProjeto)) {
                    $check = 0; ?>
                    <h4>O título deve conter apenas letras e/ou números.</h4>
                <?php }
                if (!preg_match("/^[A-Za-zÀ-ÿ \']+$/", $autoresProjeto) || !preg_match("/^[A-Za-zÀ-ÿ \']+$/", $orientadorProjeto)) {
                    $check = 0; ?>
                    <h4>Os nomes devem conter apenas letras e espaços.</h4>
                <?php }
                if (strlen($nomeProjeto) < 3 or strlen($autoresProjeto) < 3 or strlen($orientadorProjeto) < 3 or strlen($resumoProjeto) < 3) {
                    $check = 0; ?>

                    <h4>Os campos devem conter pelo menos 3 caracteres.</h4>
                <?php  }
                if (strlen($nomeProjeto) > 50) {
                    $check = 0; ?>
                    <h4>O campo 'nome' não pode ultrapassar 50 caracteres.</h4>
                <?php  }
                if (strlen($autoresProjeto) > 500) {
                    $check = 0; ?>
                    <h4>O campo 'autores' não pode ultrapassar 500 caracteres.</h4>
                <?php  }
                if (strlen($orientadorProjeto) > 50) {
                    $check = 0; ?>
                    <h4>O campo 'orientador' não pode ultrapassar 50 caracteres.</h4>
                <?php  }
                if (strlen($resumoProjeto) > 2500) {
                    $check = 0; ?>
                    <h4>O campo 'resumo' não pode ultrapassar 2500 caracteres.</h4>
                <?php  }

                if (!in_array($cursoProjeto, $cursosPermitidos)) {
                    $check = 0; ?>
                    <h4>Selecione um curso válido.</h4>
                <?php }
                if (!in_array($semestreProjeto, $semestresPermitidos)) {
                    $check = 0; ?>
                    <h4>Selecione um semestre válido.</h4>
                <?php }

                if ($check == 0) {
                    // Se houver algum erro acima 
                ?>
                    <div class="text-center">
                        <form action="index.php?menuop=formulario-projetos" method="post">
                            <input class="btn btn-light mt-2" type="submit" value="Voltar">
                            <input type="hidden" name="nomeProjeto" value="<?= $nomeProjeto ?>">
                            <input type="hidden" name="autoresProjeto" value="<?= $autoresProjeto ?>">
                            <input type="hidden" name="orientadorProjeto" value="<?= $orientadorProjeto ?>">
                            <input type="hidden" name="cursoProjeto" value="<?= $cursoProjeto ?>">
                            <input type="hidden" name="semestreProjeto" value="<?= $semestreProjeto ?>">
                            <input type="hidden" name="resumoProjeto" value="<?= $resumoProjeto ?>">
                        </form>
                    </div>
                <?php exit();
                }

                if ($check == 1) {
                    // SE TUDO CHECAR

                    // Comando SQL para inserir dados de TEXTO na tabela
                    $sql = "INSERT INTO tbprojetos (
                    nomeProjetos,
                    autoresProjetos,
                    cursoProjetos,
                    semestreProjetos,
                    orientadorProjetos,
                    resumoProjetos,
                    usuarioIdProjetos)
                    VALUES(
                    '{$nomeProjeto}',
                    '{$autoresProjeto}',
                    '{$cursoProjeto}',
                    '{$semestreProjeto}',
                    '{$orientadorProjeto}',
                    '{$resumoProjeto}',
                    '{$usuarioId}'
                    )
                    ";
                    // Insere os dados de texto
                    mysqli_query($conexao, $sql) or die("Erro na execução da consulta. " . mysqli_error($conexao));     // Checagem de erro

                    // Maracutaia pra pegar o ID do projeto acima (O ID TA ARMAZENADO NO VETOR $DADO, ENTÃO UTILIZE $dado[0] OU $idProjeto)
                    // A lógica é: o último projeto inserido irá ter o idProjetos mais alto, logo, o projeto atual é o com o ID maior
                    $sqlIdProjeto = "SELECT MAX(idProjetos) FROM tbprojetos";
                    $rs = mysqli_query($conexao, $sqlIdProjeto) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                    $dado = mysqli_fetch_array($rs);
                    $idProjeto = $dado[0]; // armazena o id do projeto atual na variável idProjeto


                    // ------------------------------------
                    // || CAPTURA DOS ARQUIVOS DE IMAGEM ||
                    // ------------------------------------
                    // arquivos permitidos
                    $imagens_permitidas = ['jpg', 'jpeg', 'png'];

                    // capturar as imagens do forms
                    $imagens = $_FILES['imagens'];

                    // capturar nomes das imagens
                    $nomes = $imagens['name'];


                    // -----------------------------
                    // || ARMAZENAMENTO DE IMAGENS ||
                    // -----------------------------

                    // Variável para saber se o diretório já foi criado ou não
                    if (file_exists('uploads/img/' . $idProjeto)) {
                        $diretorio_criado = 1;
                    } else {
                        $diretorio_criado = 0;
                    }

                    // Validação para checar se as imagens enviadas passam de 5
                    if (count($nomes) < $maxImgFiles) {
                        $aux = count($nomes);
                    } else {
                        $aux = $maxImgFiles;
                    }



                    // ----------------------------
                    // || CAPTURA DO ARQUIVO PDF ||
                    // ----------------------------
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
                    if (file_exists('uploads/arquivos/' . $idProjeto)) {
                        $diretorio_arquivo_criado = 1;
                    } else {
                        $diretorio_arquivo_criado = 0;
                    }

                    

                    // ------------------------
                    // || INSERE AS IMAGENS  ||
                    // ------------------------
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
                                    $query = $conexao->query("INSERT INTO tbimagens(nomeImagem, idSeuProjeto) VALUES('$nomes[$i]', {$idProjeto})");

                                    if (mysqli_affected_rows($conexao) > 0) {
                                        // diretório de armazenamento de imgs
                                        $mover = move_uploaded_file($_FILES['imagens']['tmp_name'][$i], 'uploads/img/' . $idProjeto . '/' . $nomes[$i]);
                                        $_SESSION['sucesso'] = 'Imagem(s) enviada(s) com sucesso!';
                                    }
                                } else {
                                    if (mkdir('uploads/img/' . $idProjeto)) {
                                        $diretorio_criado = 1;
                                    }
                                    $query = $conexao->query("INSERT INTO tbimagens(nomeImagem, idSeuProjeto) VALUES('$nomes[$i]', {$idProjeto})");

                                    if (mysqli_affected_rows($conexao) > 0) {
                                        // diretório de armazenamento de imgs
                                        $mover = move_uploaded_file($_FILES['imagens']['tmp_name'][$i], 'uploads/img/' . $idProjeto . '/' . $nomes[$i]);
                                        $_SESSION['sucesso'] = 'Imagem(s) enviada(s) com sucesso!';
                                    }
                                }
                            }
                        }
                    }


                    // -----------------------
                    // || INSERE O ARQUIVO  ||
                    // -----------------------
                    if (($_FILES['arquivo']['tmp_name']) != NULL) {

                        // validação para inserir o arquivo no diretório
                        $extensaoArquivo = explode('.', $nomeArquivo);
                        $extensaoArquivo = end($extensaoArquivo);
                        $nomeArquivo = rand() . '_' . $nomeArquivo;

                        $sizeFile = filesize($_FILES['arquivo']['tmp_name']);


                        if (in_array($extensaoArquivo, $arquivos_permitidos) && ($sizeFile <= $maxFileSize)) {
                            if ($diretorio_arquivo_criado) {
                                $query = $conexao->query("INSERT INTO tbarquivos(nomeArquivo, idSeuProjeto) VALUES('$nomeArquivo', {$idProjeto})");

                                if (mysqli_affected_rows($conexao) > 0) {
                                    // diretório de armazenamento de arquivos
                                    $mover = move_uploaded_file($_FILES['arquivo']['tmp_name'], 'uploads/arquivos/' . $idProjeto . '/' . $nomeArquivo);
                                    $_SESSION['sucesso'] = 'Arquivo enviado com sucesso!';
                                }
                            } else {
                                if (mkdir('uploads/arquivos/' . $idProjeto)) {
                                    $diretorio_arquivo_criado = 1;
                                }
                                $query = $conexao->query("INSERT INTO tbarquivos(nomeArquivo, idSeuProjeto) VALUES('$nomeArquivo', {$idProjeto})");

                                if (mysqli_affected_rows($conexao) > 0) {
                                    // diretório de armazenamento de arquivos
                                    $mover = move_uploaded_file($_FILES['arquivo']['tmp_name'], 'uploads/arquivos/' . $idProjeto . '/' . $nomeArquivo);
                                    $_SESSION['sucesso'] = 'Arquivo enviado com sucesso!';
                                }
                            }
                        }
                    } ?>
                    <h4>Projeto enviado com sucesso!</h4>
                    <div class="text-center">
                        <form action="index.php?menuop=projetos" method="post">
                            <input class="btn btn-light mt-2" type="submit" value="Voltar">
                        </form>
                    </div>
                <?php } ?>

            </div>

        </div>
    </div>
</div>