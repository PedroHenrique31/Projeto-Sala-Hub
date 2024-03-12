<?php
include('verifica_login.php');
?>

<?php

// Checa se o &idAgendamento=X for apagado da URL
if (!isset($_GET["idAgenda"])) {
    header('Location: index.php?menuop=agendamento');
    exit();
}

// Adquire os dados baseado no idAgenda
$idAgenda = $_GET["idAgenda"];

$sql = "SELECT * FROM tbagenda WHERE idAgenda = '{$idAgenda}'";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);

if(is_null($dados)){
    header('Location: index.php?menuop=agendamento');
    exit();
}
if (($dados["idUsuario"] != $_SESSION["usuario_id"] && $_SESSION['administrador'] != 1)) {
    header('Location: index.php?menuop=agendamento');
    exit();
}
$nomeAgenda = $dados["nomeAgenda"];
?>

<div class="container">

    <header>
        <div class="mt-3 text-center">
            <img src="img/progress1.png" class="img-fluid" width="1000 px" alt="">
        </div>
    </header>

    <body>
        <div class="mt-3">
            <form action="index.php?menuop=edit-step2-agendamento" method="post">
                <div class="mb-3">
                    <i class="bi bi-person-fill"></i> <label class="form-label bi" for="nomeAgenda">Organizador</label>
                    <?php if ($_SESSION['administrador'] != 1) {
                        echo "<input type='text' readonly class='form-control-plaintext readonly' name='nomeAgenda' value='$nomeAgenda'>";
                    } else {
                        echo '<input class="form-control" type="text" name="nomeAgenda" value="' . $nomeAgenda . '" pattern="[A-Za-zÀ-ú \']+" minlength="3" maxlength="30" required>';
                    } ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="atividadeAgenda">Atividade</label>
                    <input class="form-control" type="text" name="atividadeAgenda" value="<?= $dados["atividadeAgenda"] ?>" pattern="\S(.*\S)?" minlength="5" maxlength="50" required>
                </div>
                <div class="row">
                    <div class="mb-3 col-3">
                        <label class="form-label" for="cursoAgenda">Curso</label>
                        <select class="form-select" aria-label="select" name="cursoAgenda" required>
                            <?php if ($dados["cursoAgenda"] == '') { ?><option selected value="">Curso</option><?php } else { ?><option value="">Curso</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Administração') { ?><option selected value="Administração">Administração</option><?php } else { ?><option value="Administração">Administração</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Análise e Desenvolvimento de Sistemas') { ?><option selected value="Análise e Desenvolvimento de Sistemas">Análise e Desenvolvimento de Sistemas</option><?php } else { ?><option value="Análise e Desenvolvimento de Sistemas">Análise e Desenvolvimento de Sistemas</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Arquitetura e Urbanismo') { ?><option selected value="Arquitetura e Urbanismo">Arquitetura e Urbanismo</option><?php } else { ?><option value="Arquitetura e Urbanismo">Arquitetura e Urbanismo</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Biomedicina') { ?><option selected value="Biomedicina">Biomedicina</option><?php } else { ?><option value="Biomedicina">Biomedicina</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Ciência da Computação') { ?><option selected value="Ciência da Computação">Ciência da Computação</option><?php } else { ?><option value="Ciência da Computação">Ciência da Computação</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Ciência de dados e Machine Learning') { ?><option selected value="Ciência de dados e Machine Learning">Ciência de dados e Machine Learning</option><?php } else { ?><option value="Ciência de dados e Machine Learning">Ciência de dados e Machine Learning</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Ciências Biológicas') { ?><option selected value="Ciências Biológicas">Ciências Biológicas</option><?php } else { ?><option value="Ciências Biológicas">Ciências Biológicas</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Ciências Contábeis') { ?><option selected value="Ciências Contábeis">Ciências Contábeis</option><?php } else { ?><option value="Ciências Contábeis">Ciências Contábeis</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Direito') { ?><option selected value="Direito">Direito</option><?php } else { ?><option value="Direito">Direito</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Educação Física') { ?><option selected value="Educação Física">Educação Física</option><?php } else { ?><option value="Educação Física">Educação Física</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Enfermagem') { ?><option selected value="Enfermagem">Enfermagem</option><?php } else { ?><option value="Enfermagem">Enfermagem</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Engenharia Civil') { ?><option selected value="Engenharia Civil">Engenharia Civil</option><?php } else { ?><option value="Engenharia Civil">Engenharia Civil</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Engenharia de Computação') { ?><option selected value="Engenharia de Computação">Engenharia de Computação</option><?php } else { ?><option value="Engenharia de Computação">Engenharia de Computação</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Engenharia Elétrica') { ?><option selected value="Engenharia Elétrica">Engenharia Elétrica</option><?php } else { ?><option value="Engenharia Elétrica">Engenharia Elétrica</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Fisioterapia') { ?><option selected value="Fisioterapia">Fisioterapia</option><?php } else { ?><option value="Fisioterapia">Fisioterapia</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Jornalismo') { ?><option selected value="Jornalismo">Jornalismo</option><?php } else { ?><option value="Jornalismo">Jornalismo</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Marketing') { ?><option selected value="Marketing">Marketing</option><?php } else { ?><option value="Marketing">Marketing</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Medicina') { ?><option selected value="Medicina">Medicina</option><?php } else { ?><option value="Medicina">Medicina</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Medicina Veterinária') { ?><option selected value="Medicina Veterinária">Medicina Veterinária</option><?php } else { ?><option value="Medicina Veterinária">Medicina Veterinária</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Nutrição') { ?><option selected value="Nutrição">Nutrição</option><?php } else { ?><option value="Nutrição">Nutrição</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Psicologia') { ?><option selected value="Psicologia">Psicologia</option><?php } else { ?><option value="Psicologia">Psicologia</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Publicidade e Propaganda') { ?><option selected value="Publicidade e Propaganda">Publicidade e Propaganda</option><?php } else { ?><option value="Publicidade e Propaganda">Publicidade e Propaganda</option><?php } ?>
                            <?php if ($dados["cursoAgenda"] == 'Relações Internacionais') { ?><option selected value="Relações Internacionais">Relações Internacionais</option><?php } else { ?><option value="Relações Internacionais">Relações Internacionais</option><?php } ?>
                        </select>
                    </div>
                    <div class="mb-3 col-3">
                        <label class="form-label" for="dataAgenda">Data</label>
                        <input class="form-control" type="date" name="dataAgenda" value="<?= $dados["dataAgenda"] ?>" required>
                    </div>
                    <div class="text-end">
                        <input class="btn btn-light mt-2" type="submit" value="Próximo">
                    </div>
                    <!-- Input invisível para enviar o dado idAgenda -->
                    <input type="hidden" name="idAgenda" value="<?= $idAgenda ?>">
                    <input type="hidden" name="horaAgenda" value="<?= $dados['horaAgenda'] ?>">


                </div>
            </form>
        </div>

    </body>
</div>