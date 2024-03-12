<?php
include('verifica_login.php');
?>

<?php

// Checa se o &idImpressora=X for apagado da URL
if (!isset($_POST["nomeImpressora"]) || !isset($_POST["cursoImpressora"]) || !isset($_POST["semestreImpressora"]) || !isset($_POST["dataImpressora"])) {
    header('Location: index.php?menuop=impressora');
    exit();
}

// Adquire as variáveis do passo 1 e 3
$nomeImpressora = $_POST['nomeImpressora'];
$cursoImpressora = $_POST['cursoImpressora'];
$semestreImpressora = $_POST['semestreImpressora'];
$dataImpressora = $_POST['dataImpressora'];

// Adquire os dados baseado no idImpressora
$idImpressora = $_POST["idImpressora"];

$sql = "SELECT * FROM tbimpressora WHERE idImpressora = '{$idImpressora}'";
$rs = mysqli_query($conexao, $sql) or die("Erro na recuperação dos dados do registro. " . mysqli_error($conexao));
$dados = mysqli_fetch_assoc($rs);
$nomeImpressora = $dados["nomeImpressora"];
if ($dados["idUsuario"] != $_SESSION["usuario_id"] && $_SESSION['administrador'] != 1) {
    header('Location: index.php?menuop=impressora');
    exit();
}

$deHoraImpressora = $dados['deHoraImpressora'];
$ateHoraImpressora = $dados['ateHoraImpressora'];


// echo "DATA= | $dataImpressora | \r\n";
$dataAtual = date("Y-m-d");
// echo "HOJE= | $dataAtual | \r\n";

$date = date_create($dataAtual);

$dataAtualPlus1day = date_add($date, date_interval_create_from_date_string("1 days"));
$dataAtualPlus1day = $dataAtualPlus1day->format('Y-m-d');  // data atual + 1 dia
// echo "HOJE +1 = | $dataAtualPlus1day | \n";

$dataAtualPlus1Months = date_add($date, date_interval_create_from_date_string("1 months"));
$dataAtualPlus1Months = $dataAtualPlus1Months->format('Y-m-d');  // data atual + 1 mês


// Verifica se o curso foi inserido corretamente
$cursosPermitidos = [
    'Administração', 'Análise e Desenvolvimento de Sistemas', 'Arquitetura e Urbanismo', 'Biomedicina', 'Ciência da Computação',
    'Ciência de dados e Machine Learning', 'Ciências Biológicas', 'Ciências Contábeis', 'Direito', 'Educação Física', 'Enfermagem',
    'Engenharia Civil', 'Engenharia de Computação', 'Engenharia Elétrica', 'Fisioterapia', 'Jornalismo', 'Marketing', 'Medicina',
    'Medicina Veterinária', 'Nutrição', 'Psicologia', 'Publicidade e Propaganda', 'Relações Internacionais'
];

if (!in_array($cursoImpressora, $cursosPermitidos)) {
    header('Location: index.php?menuop=impressora');
    exit();
}

// Data atual para print
$dateAux = date_create($dataImpressora);
$dateAux = $dateAux->format('d/m/Y');

// Data atual + 1 dia para print
$dateAux2 = date_create($dataAtualPlus1day);
$dateAux2 = $dateAux2->format('d/m/Y');

// Data atual + 1 mês para print
$dateAux3 = date_create($dataAtualPlus1Months);
$dateAux3 = $dateAux3->format('d/m/Y');

?>

<div class="container">

    <?php
    if ($dataImpressora < $dataAtualPlus1day || $dataImpressora > $dataAtualPlus1Months) { ?>

        <body>
            <div class="mt-5 d-flex justify-content-center">
                <div class="rounded-4 p-4 border border-4 shadow-sm text-center">
                    <div class="fs-3">
                        Favor, escolher uma data entre <br><span class="fw-bold"><?= $dateAux2 ?></span> e <span class="fw-bold"><?= $dateAux3 ?></span>
                    </div>
                    <div class="text-center">
                        <form action="index.php?menuop=impressora-edit-step1&idImpressora=<?=$idImpressora?>" method="post">
                            <input class="btn btn-light mt-2" type="submit" value="Voltar">
                            <input type="hidden" name="nomeImpressora" value="<?= $nomeImpressora ?>">
                            <input type="hidden" name="semestreImpressora" value="<?= $semestreImpressora ?>">
                            <input type="hidden" name="cursoImpressora" value="<?= $cursoImpressora ?>">
                            <input type="hidden" name="dataImpressora" value="<?= $dataImpressora ?>">
                        </form>
                    </div>
                </div>
            </div>
        </body>

    <?php exit();
    } ?>

    <header>
        <div class="mt-3 text-center">
            <img src="img/progress2.png" class="img-fluid" width="1000 px" alt="">
        </div>
    </header>

    <body>
        <!-- div englobando tudo -->
        <div class="container mt-3">
            <!-- Formulário -->
            <form action="index.php?menuop=impressora-edit-step3" method="post">
                <div class="row">
                    <!-- Horários -->
                    <div class="col-2">
                        <label class="form-label" for="deHoraImpressora">De:</label>
                        <select class="form-control" name="deHoraImpressora" id="deHoraImpressora" required>
                            <?php if ($deHoraImpressora == '') { ?><option selected value="">Horário</option><?php
                                                                                                            } else { ?><option value="">De</option><?php } ?>
                            <?php if ($deHoraImpressora == '08:00:00') { ?><option selected value="08:00:00">08:00</option><?php
                                                                                                                        } else { ?><option value="08:00:00">08:00</option><?php } ?>
                            <?php if ($deHoraImpressora == '09:00:00') { ?><option selected value="09:00:00">09:00</option><?php
                                                                                                                        } else { ?><option value="09:00:00">09:00</option><?php } ?>
                            <?php if ($deHoraImpressora == '10:00:00') { ?><option selected value="10:00:00">10:00</option><?php
                                                                                                                        } else { ?><option value="10:00:00">10:00</option><?php } ?>
                            <?php if ($deHoraImpressora == '11:00:00') { ?><option selected value="11:00:00">11:00</option><?php
                                                                                                                        } else { ?><option value="11:00:00">11:00</option><?php } ?>
                            <?php if ($deHoraImpressora == '12:00:00') { ?><option selected value="12:00:00">12:00</option><?php
                                                                                                                        } else { ?><option value="12:00:00">12:00</option><?php } ?>
                            <?php if ($deHoraImpressora == '13:00:00') { ?><option selected value="13:00:00">13:00</option><?php
                                                                                                                        } else { ?><option value="13:00:00">13:00</option><?php } ?>
                            <?php if ($deHoraImpressora == '14:00:00') { ?><option selected value="14:00:00">14:00</option><?php
                                                                                                                        } else { ?><option value="14:00:00">14:00</option><?php } ?>
                            <?php if ($deHoraImpressora == '15:00:00') { ?><option selected value="15:00:00">15:00</option><?php
                                                                                                                        } else { ?><option value="15:00:00">15:00</option><?php } ?>
                            <?php if ($deHoraImpressora == '16:00:00') { ?><option selected value="16:00:00">16:00</option><?php
                                                                                                                        } else { ?><option value="16:00:00">16:00</option><?php } ?>
                            <?php if ($deHoraImpressora == '17:00:00') { ?><option selected value="17:00:00">17:00</option><?php
                                                                                                                        } else { ?><option value="17:00:00">17:00</option><?php } ?>
                            <?php if ($deHoraImpressora == '18:00:00') { ?><option selected value="18:00:00">18:00</option><?php
                                                                                                                        } else { ?><option value="18:00:00">18:00</option><?php } ?>
                            <?php if ($deHoraImpressora == '19:00:00') { ?><option selected value="19:00:00">19:00</option><?php
                                                                                                                        } else { ?><option value="19:00:00">19:00</option><?php } ?>
                            <?php if ($deHoraImpressora == '20:00:00') { ?><option selected value="20:00:00">20:00</option><?php
                                                                                                                        } else { ?><option value="20:00:00">20:00</option><?php } ?>
                        </select>
                    </div>

                    <div class="col-2">
                        <label class="form-label" for="ateHoraImpressora">Até:</label>
                        <select class="form-control" name="ateHoraImpressora" id="ateHoraImpressora" required>
                            <?php if ($ateHoraImpressora == '') { ?><option selected value="">Horário</option><?php
                                                                                                            } else { ?><option value="">Até</option><?php } ?>
                            <?php if ($ateHoraImpressora == '09:00:00') { ?><option selected value="09:00:00">09:00</option><?php
                                                                                                                        } else { ?><option value="09:00:00">09:00</option><?php } ?>
                            <?php if ($ateHoraImpressora == '10:00:00') { ?><option selected value="10:00:00">10:00</option><?php
                                                                                                                        } else { ?><option value="10:00:00">10:00</option><?php } ?>
                            <?php if ($ateHoraImpressora == '11:00:00') { ?><option selected value="11:00:00">11:00</option><?php
                                                                                                                        } else { ?><option value="11:00:00">11:00</option><?php } ?>
                            <?php if ($ateHoraImpressora == '12:00:00') { ?><option selected value="12:00:00">12:00</option><?php
                                                                                                                        } else { ?><option value="12:00:00">12:00</option><?php } ?>
                            <?php if ($ateHoraImpressora == '13:00:00') { ?><option selected value="13:00:00">13:00</option><?php
                                                                                                                        } else { ?><option value="13:00:00">13:00</option><?php } ?>
                            <?php if ($ateHoraImpressora == '14:00:00') { ?><option selected value="14:00:00">14:00</option><?php
                                                                                                                        } else { ?><option value="14:00:00">14:00</option><?php } ?>
                            <?php if ($ateHoraImpressora == '15:00:00') { ?><option selected value="15:00:00">15:00</option><?php
                                                                                                                        } else { ?><option value="15:00:00">15:00</option><?php } ?>
                            <?php if ($ateHoraImpressora == '16:00:00') { ?><option selected value="16:00:00">16:00</option><?php
                                                                                                                        } else { ?><option value="16:00:00">16:00</option><?php } ?>
                            <?php if ($ateHoraImpressora == '17:00:00') { ?><option selected value="17:00:00">17:00</option><?php
                                                                                                                        } else { ?><option value="17:00:00">17:00</option><?php } ?>
                            <?php if ($ateHoraImpressora == '18:00:00') { ?><option selected value="18:00:00">18:00</option><?php
                                                                                                                        } else { ?><option value="18:00:00">18:00</option><?php } ?>
                            <?php if ($ateHoraImpressora == '19:00:00') { ?><option selected value="19:00:00">19:00</option><?php
                                                                                                                        } else { ?><option value="19:00:00">19:00</option><?php } ?>
                            <?php if ($ateHoraImpressora == '20:00:00') { ?><option selected value="20:00:00">20:00</option><?php
                                                                                                                        } else { ?><option value="20:00:00">20:00</option><?php } ?>
                            <?php if ($ateHoraImpressora == '21:00:00') { ?><option selected value="21:00:00">21:00</option><?php
                                                                                                                        } else { ?><option value="21:00:00">21:00</option><?php } ?>
                        </select>
                    </div>

                    <!-- Nº de Impressoras -->
                    <div class="col-2 form-text">
                        <br>É possível reservar apenas uma impressora 3D por vez.
                    </div>

                    <input type="hidden" name="nomeImpressora" value="<?= $nomeImpressora ?>">
                    <input type="hidden" name="semestreImpressora" value="<?= $semestreImpressora ?>">
                    <input type="hidden" name="cursoImpressora" value="<?= $cursoImpressora ?>">
                    <input type="hidden" name="dataImpressora" value="<?= $dataImpressora ?>">
                    <input type="hidden" name="idImpressora" value="<?=$idImpressora?>">
                </div>

                <div class="mt-4">
                    <?php $date = date_create($dataImpressora);
                    $dateAux = date_format($date, 'd/m'); ?>
                    <h3 class="fs-4">Disponibilidade das impressoras 3D em <?= $dateAux ?></h3>
                </div>

                <!-- Lista de Tabelas   Impressora 1 | Impressora 2 -->
                <div class="d-flex flex-column mt-3 border border-2 rounded shadow-sm">
                    <!-- Impressora 1 -->
                    <div class="p-2">
                        <h3 class="fs-4">Impressora 1</h3>
                        <div class="d-flex flex-row ">
                            <?php
                            // BUSCA PARA 08:00:00

                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '08:00:00' AND ateHoraImpressora >= '08:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">08:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 09:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '09:00:00' AND ateHoraImpressora >= '09:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">09:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 10:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '10:00:00' AND ateHoraImpressora >= '10:00:00'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">10:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 11:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '11:00:00' AND ateHoraImpressora >= '11:00:00'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">11:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 12:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '12:00:00' AND ateHoraImpressora >= '12:00:00'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">12:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 13:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '13:00:00' AND ateHoraImpressora >= '13:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">13:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 14:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '14:00:00' AND ateHoraImpressora >= '14:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){
                                $livre=1;
                            }else{
                                $livre=0;
                            }
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">14:00</div>
                                <div class=""><?php if($livre == 1){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 15:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '15:00:00' AND ateHoraImpressora >= '15:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">15:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 16:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '16:00:00' AND ateHoraImpressora >= '16:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">16:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 17:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '17:00:00' AND ateHoraImpressora >= '17:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">17:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 18:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '18:00:00' AND ateHoraImpressora >= '18:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">18:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 19:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '19:00:00' AND ateHoraImpressora >= '19:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">19:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 20:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '20:00:00' AND ateHoraImpressora >= '20:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">20:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 21:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 1 AND deHoraImpressora <= '21:00:00' AND ateHoraImpressora >= '21:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">21:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Impressora 2 -->
                    <div class="p-2">
                        <h3 class="fs-4">Impressora 2</h3>
                        <div class="d-flex flex-row">
                            <?php
                            // BUSCA PARA 08:00:00

                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '08:00:00' AND ateHoraImpressora >= '08:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">08:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 09:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '09:00:00' AND ateHoraImpressora >= '09:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">09:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 10:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '10:00:00' AND ateHoraImpressora >= '10:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">10:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 11:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '11:00:00' AND ateHoraImpressora >= '11:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">11:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 12:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '12:00:00' AND ateHoraImpressora >= '12:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">12:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 13:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '13:00:00' AND ateHoraImpressora >= '13:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">13:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 14:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '14:00:00' AND ateHoraImpressora >= '14:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">14:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 15:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '15:00:00' AND ateHoraImpressora >= '15:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">15:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 16:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '16:00:00' AND ateHoraImpressora >= '16:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">16:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 17:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '17:00:00' AND ateHoraImpressora >= '17:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">17:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 18:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '18:00:00' AND ateHoraImpressora >= '18:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">18:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 19:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '19:00:00' AND ateHoraImpressora >= '19:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">19:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 20:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '20:00:00' AND ateHoraImpressora >= '20:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">20:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>

                            <?php
                            // BUSCA PARA 21:00:00
                            
                            // Método SQL para mostrar a tabela
                            $sql = "SELECT idImpressora, dataImpressora, deHoraImpressora, ateHoraImpressora, qualImpressora FROM tbimpressora 
                            WHERE dataImpressora = '$dataImpressora' AND qualImpressora = 2 AND deHoraImpressora <= '21:00:00' AND ateHoraImpressora >= '21:00:00' 
                            AND idImpressora != '{$idImpressora}'";
                            // Variável para executar a consulta
                            $rs = mysqli_query($conexao, $sql) or die("Erro ao executar consulta!" . mysqli_error($conexao));
                            $dados = mysqli_fetch_assoc($rs);
                            // Se o usuário alterar o idProjeto da Página para algum não existente, redireciona para a página de projetos
                            if (mysqli_num_rows($rs) == 0){$livre=1;}else{$livre=0;}
                            ?>
                            <div class="p-2 d-flex flex-column text-center rounded">
                                <div class=" fs-5">21:00</div>
                                <div class=""><?php if($livre){echo "<i class='bx bx-md bx-check bx-tada-hover' style='color: #00A300;'></i>";}
                                else{echo "<i class='bx bx-x bx-md bx-tada-hover' style='color: #D10000;'></i>";}?></div>
                            </div>


                        </div>
                    </div>

                </div>

                <!-- DIV com os Botões -->
                <div class="mt-4 d-flex flex-row-reverse">
                    <!-- Submit button -->
                    <div class="">
                        <input class="btn btn-light" type="submit" value="Atualizar">
            </form>
        </div>
        <!-- Back button -->
        <div class="me-2">
            <form action="index.php?menuop=impressora-edit-step1&idImpressora=<?=$idImpressora?>" method="post">
                <input class="btn btn-outline-ceub" type="submit" value="Voltar">
                <input type="hidden" name="nomeImpressora" value="<?= $nomeImpressora ?>">
                <input type="hidden" name="semestreImpressora" value="<?= $semestreImpressora ?>">
                <input type="hidden" name="cursoImpressora" value="<?= $cursoImpressora ?>">
                <input type="hidden" name="dataImpressora" value="<?= $dataImpressora ?>">
            </form>
        </div>
</div>

</div>
</body>

</div>