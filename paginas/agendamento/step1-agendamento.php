<?php
include('verifica_login.php');
?>

<?php

if (!isset($_SESSION['nome']) || !isset($_POST['atividadeAgenda']) || !isset($_POST['cursoAgenda']) || !isset($_POST['dataAgenda'])) {
    header('Location: index.php?menuop=agendamento');
    exit();
}

// Adquirindo dados do usuários (NULOS ou do PASSO 2)
$nomeAgenda = $_SESSION['nome'];
$atividadeAgenda = $_POST['atividadeAgenda'];
$cursoAgenda = $_POST['cursoAgenda'];
$dataAgenda = $_POST['dataAgenda'];
// $idUsuario = $_SESSION["usuario_id"];
?>

<div class="container">
    <header>
        <div class="mt-3 text-center">
            <img src="img/progress1.png" class="img-fluid" width="1000 px" alt="">
        </div>
    </header>

    <body>
        <div class="mt-3">
            <form action="index.php?menuop=step2-agendamento" method="post">
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
                    <input class="form-control" type="text" name="atividadeAgenda" value="<?= $atividadeAgenda ?>" pattern="\S(.*\S)?" minlength="5" maxlength="50" required>
                </div>
                <div class="row">
                    <div class="mb-3 col-4">
                        <label class="form-label" for="cursoAgenda">Curso</label>
                        <select class="form-select" aria-label="select" name="cursoAgenda" required>
                            <?php if ($cursoAgenda == '') { ?><option selected value="">Curso</option><?php } else { ?><option value="">Curso</option><?php } ?>
                            <?php if ($cursoAgenda == 'Administração') { ?><option selected value="Administração">Administração</option><?php } else { ?><option value="Administração">Administração</option><?php } ?>
                            <?php if ($cursoAgenda == 'Análise e Desenvolvimento de Sistemas') { ?><option selected value="Análise e Desenvolvimento de Sistemas">Análise e Desenvolvimento de Sistemas</option><?php } else { ?><option value="Análise e Desenvolvimento de Sistemas">Análise e Desenvolvimento de Sistemas</option><?php } ?>
                            <?php if ($cursoAgenda == 'Arquitetura e Urbanismo') { ?><option selected value="Arquitetura e Urbanismo">Arquitetura e Urbanismo</option><?php } else { ?><option value="Arquitetura e Urbanismo">Arquitetura e Urbanismo</option><?php } ?>
                            <?php if ($cursoAgenda == 'Biomedicina') { ?><option selected value="Biomedicina">Biomedicina</option><?php } else { ?><option value="Biomedicina">Biomedicina</option><?php } ?>
                            <?php if ($cursoAgenda == 'Ciência da Computação') { ?><option selected value="Ciência da Computação">Ciência da Computação</option><?php } else { ?><option value="Ciência da Computação">Ciência da Computação</option><?php } ?>
                            <?php if ($cursoAgenda == 'Ciência de dados e Machine Learning') { ?><option selected value="Ciência de dados e Machine Learning">Ciência de dados e Machine Learning</option><?php } else { ?><option value="Ciência de dados e Machine Learning">Ciência de dados e Machine Learning</option><?php } ?>
                            <?php if ($cursoAgenda == 'Ciências Biológicas') { ?><option selected value="Ciências Biológicas">Ciências Biológicas</option><?php } else { ?><option value="Ciências Biológicas">Ciências Biológicas</option><?php } ?>
                            <?php if ($cursoAgenda == 'Ciências Contábeis') { ?><option selected value="Ciências Contábeis">Ciências Contábeis</option><?php } else { ?><option value="Ciências Contábeis">Ciências Contábeis</option><?php } ?>
                            <?php if ($cursoAgenda == 'Direito') { ?><option selected value="Direito">Direito</option><?php } else { ?><option value="Direito">Direito</option><?php } ?>
                            <?php if ($cursoAgenda == 'Educação Física') { ?><option selected value="Educação Física">Educação Física</option><?php } else { ?><option value="Educação Física">Educação Física</option><?php } ?>
                            <?php if ($cursoAgenda == 'Enfermagem') { ?><option selected value="Enfermagem">Enfermagem</option><?php } else { ?><option value="Enfermagem">Enfermagem</option><?php } ?>
                            <?php if ($cursoAgenda == 'Engenharia Civil') { ?><option selected value="Engenharia Civil">Engenharia Civil</option><?php } else { ?><option value="Engenharia Civil">Engenharia Civil</option><?php } ?>
                            <?php if ($cursoAgenda == 'Engenharia de Computação') { ?><option selected value="Engenharia de Computação">Engenharia de Computação</option><?php } else { ?><option value="Engenharia de Computação">Engenharia de Computação</option><?php } ?>
                            <?php if ($cursoAgenda == 'Engenharia Elétrica') { ?><option selected value="Engenharia Elétrica">Engenharia Elétrica</option><?php } else { ?><option value="Engenharia Elétrica">Engenharia Elétrica</option><?php } ?>
                            <?php if ($cursoAgenda == 'Fisioterapia') { ?><option selected value="Fisioterapia">Fisioterapia</option><?php } else { ?><option value="Fisioterapia">Fisioterapia</option><?php } ?>
                            <?php if ($cursoAgenda == 'Jornalismo') { ?><option selected value="Jornalismo">Jornalismo</option><?php } else { ?><option value="Jornalismo">Jornalismo</option><?php } ?>
                            <?php if ($cursoAgenda == 'Marketing') { ?><option selected value="Marketing">Marketing</option><?php } else { ?><option value="Marketing">Marketing</option><?php } ?>
                            <?php if ($cursoAgenda == 'Medicina') { ?><option selected value="Medicina">Medicina</option><?php } else { ?><option value="Medicina">Medicina</option><?php } ?>
                            <?php if ($cursoAgenda == 'Medicina Veterinária') { ?><option selected value="Medicina Veterinária">Medicina Veterinária</option><?php } else { ?><option value="Medicina Veterinária">Medicina Veterinária</option><?php } ?>
                            <?php if ($cursoAgenda == 'Nutrição') { ?><option selected value="Nutrição">Nutrição</option><?php } else { ?><option value="Nutrição">Nutrição</option><?php } ?>
                            <?php if ($cursoAgenda == 'Psicologia') { ?><option selected value="Psicologia">Psicologia</option><?php } else { ?><option value="Psicologia">Psicologia</option><?php } ?>
                            <?php if ($cursoAgenda == 'Publicidade e Propaganda') { ?><option selected value="Publicidade e Propaganda">Publicidade e Propaganda</option><?php } else { ?><option value="Publicidade e Propaganda">Publicidade e Propaganda</option><?php } ?>
                            <?php if ($cursoAgenda == 'Relações Internacionais') { ?><option selected value="Relações Internacionais">Relações Internacionais</option><?php } else { ?><option value="Relações Internacionais">Relações Internacionais</option><?php } ?>
                        </select>
                    </div>
                    <div class="mb-3 col-3">
                        <label class="form-label" for="dataAgenda">Data</label>
                        <input class="form-control" type="date" name="dataAgenda" value="<?= $dataAgenda ?>" required>
                    </div>
                    <div class="row g-0">
                        <div class="col-4"></div>
                        <div class="alert col alert-warning alert-dismissible fade show align-items-center d-flex flex-row p-2" role="alert">
                            <i class='bx bxs-error-circle bx-sm me-2'></i>
                            <div>
                                Só serão aceitas reservas com pelo menos <br>1 dia, até 1 mês de antecedência
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class=" col text-end">
                            <input class="btn btn-light mt-2" type="submit" value="Próximo">
                        </div>
                    </div>

                </div>
                <?php // Input invisível para enviar o dado idUsuario 
                ?>
                <input type="hidden" name="horaAgenda" value="">
                <input type="hidden" name="bancadaTechAgenda" value="">
                <input type="hidden" name="bancadaGeralAgenda" value="">
            </form>
        </div>

    </body>
</div>