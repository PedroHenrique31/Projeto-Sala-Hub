<?php
include('verifica_login.php');
?>

<?php

if (
    !isset($_SESSION['nome']) || !isset($_POST['nomeMonitor']) || !isset($_POST['telefoneMonitor']) || !isset($_POST['deHoraMonitor']) ||
    !isset($_POST['ateHoraMonitor']) || $_SESSION['administrador'] != 1
) {
    header('Location: index.php?menuop=monitores');
    exit();
}

// Adquirindo dados do usuários (NULOS ou do PASSO 2)
$nomeMonitor = $_POST['nomeMonitor'];
$telefoneMonitor = $_POST['telefoneMonitor'];
$deHoraMonitor = $_POST['deHoraMonitor'];
$ateHoraMonitor = $_POST['ateHoraMonitor'];
?>

<div class="container">
    <header class="text-center mt-3 mb-4">
        <div class="rounded shadow" style="background-image: url('./img/strip.jpg'); background-size:cover;">
            <span class="fs-1" style="color:white;">Cadastro de Monitores</span>
        </div>
    </header>

    <body>
        <div class="mt-3">
            <form action="index.php?menuop=step2-monitores" method="post">
                <div class="mb-3">
                    <label class="form-label" for="nomeMonitor">Nome</label>
                    <input class="form-control" type="text" name="nomeMonitor" value="<?= $nomeMonitor ?>" pattern="[A-Za-zÀ-ú \']+" minlength="3" maxlength="30" required>
                </div>
                <div class="row">
                    <div class="mb-3 col-3">
                        <label class="form-label" for="telefoneMonitor">Telefone</label>
                        <input class="form-control" type="text" name="telefoneMonitor" value="<?= $telefoneMonitor ?>" placeholder="(99) 99999-9999" minlength="3" maxlength="20" required>
                    </div>
                    <!-- Horários -->
                    <div class="col-2">
                        <label class="form-label" for="deHoraMonitor">De:</label>
                        <select class="form-control" name="deHoraMonitor" id="deHoraMonitor" required>
                            <?php if ($deHoraMonitor == '') { ?><option selected value="">Horário</option><?php
                                                                                                        } else { ?><option value="">De</option><?php } ?>
                            <?php if ($deHoraMonitor == '08:00:00') { ?><option selected value="08:00:00">08:00</option><?php
                                                                                                                    } else { ?><option value="08:00:00">08:00</option><?php } ?>
                            <?php if ($deHoraMonitor == '09:00:00') { ?><option selected value="09:00:00">09:00</option><?php
                                                                                                                    } else { ?><option value="09:00:00">09:00</option><?php } ?>
                            <?php if ($deHoraMonitor == '10:00:00') { ?><option selected value="10:00:00">10:00</option><?php
                                                                                                                    } else { ?><option value="10:00:00">10:00</option><?php } ?>
                            <?php if ($deHoraMonitor == '11:00:00') { ?><option selected value="11:00:00">11:00</option><?php
                                                                                                                    } else { ?><option value="11:00:00">11:00</option><?php } ?>
                            <?php if ($deHoraMonitor == '12:00:00') { ?><option selected value="12:00:00">12:00</option><?php
                                                                                                                    } else { ?><option value="12:00:00">12:00</option><?php } ?>
                            <?php if ($deHoraMonitor == '13:00:00') { ?><option selected value="13:00:00">13:00</option><?php
                                                                                                                    } else { ?><option value="13:00:00">13:00</option><?php } ?>
                            <?php if ($deHoraMonitor == '14:00:00') { ?><option selected value="14:00:00">14:00</option><?php
                                                                                                                    } else { ?><option value="14:00:00">14:00</option><?php } ?>
                            <?php if ($deHoraMonitor == '15:00:00') { ?><option selected value="15:00:00">15:00</option><?php
                                                                                                                    } else { ?><option value="15:00:00">15:00</option><?php } ?>
                            <?php if ($deHoraMonitor == '16:00:00') { ?><option selected value="16:00:00">16:00</option><?php
                                                                                                                    } else { ?><option value="16:00:00">16:00</option><?php } ?>
                            <?php if ($deHoraMonitor == '17:00:00') { ?><option selected value="17:00:00">17:00</option><?php
                                                                                                                    } else { ?><option value="17:00:00">17:00</option><?php } ?>
                            <?php if ($deHoraMonitor == '18:00:00') { ?><option selected value="18:00:00">18:00</option><?php
                                                                                                                    } else { ?><option value="18:00:00">18:00</option><?php } ?>
                            <?php if ($deHoraMonitor == '19:00:00') { ?><option selected value="19:00:00">19:00</option><?php
                                                                                                                    } else { ?><option value="19:00:00">19:00</option><?php } ?>
                            <?php if ($deHoraMonitor == '20:00:00') { ?><option selected value="20:00:00">20:00</option><?php
                                                                                                                    } else { ?><option value="20:00:00">20:00</option><?php } ?>
                        </select>
                    </div>

                    <div class="col-2">
                        <label class="form-label" for="ateHoraMonitor">Até:</label>
                        <select class="form-control" name="ateHoraMonitor" id="ateHoraMonitor" required>
                            <?php if ($ateHoraMonitor == '') { ?><option selected value="">Horário</option><?php
                                                                                                        } else { ?><option value="">Até</option><?php } ?>
                            <?php if ($ateHoraMonitor == '09:00:00') { ?><option selected value="09:00:00">09:00</option><?php
                                                                                                                        } else { ?><option value="09:00:00">09:00</option><?php } ?>
                            <?php if ($ateHoraMonitor == '10:00:00') { ?><option selected value="10:00:00">10:00</option><?php
                                                                                                                        } else { ?><option value="10:00:00">10:00</option><?php } ?>
                            <?php if ($ateHoraMonitor == '11:00:00') { ?><option selected value="11:00:00">11:00</option><?php
                                                                                                                        } else { ?><option value="11:00:00">11:00</option><?php } ?>
                            <?php if ($ateHoraMonitor == '12:00:00') { ?><option selected value="12:00:00">12:00</option><?php
                                                                                                                        } else { ?><option value="12:00:00">12:00</option><?php } ?>
                            <?php if ($ateHoraMonitor == '13:00:00') { ?><option selected value="13:00:00">13:00</option><?php
                                                                                                                        } else { ?><option value="13:00:00">13:00</option><?php } ?>
                            <?php if ($ateHoraMonitor == '14:00:00') { ?><option selected value="14:00:00">14:00</option><?php
                                                                                                                        } else { ?><option value="14:00:00">14:00</option><?php } ?>
                            <?php if ($ateHoraMonitor == '15:00:00') { ?><option selected value="15:00:00">15:00</option><?php
                                                                                                                        } else { ?><option value="15:00:00">15:00</option><?php } ?>
                            <?php if ($ateHoraMonitor == '16:00:00') { ?><option selected value="16:00:00">16:00</option><?php
                                                                                                                        } else { ?><option value="16:00:00">16:00</option><?php } ?>
                            <?php if ($ateHoraMonitor == '17:00:00') { ?><option selected value="17:00:00">17:00</option><?php
                                                                                                                        } else { ?><option value="17:00:00">17:00</option><?php } ?>
                            <?php if ($ateHoraMonitor == '18:00:00') { ?><option selected value="18:00:00">18:00</option><?php
                                                                                                                        } else { ?><option value="18:00:00">18:00</option><?php } ?>
                            <?php if ($ateHoraMonitor == '19:00:00') { ?><option selected value="19:00:00">19:00</option><?php
                                                                                                                        } else { ?><option value="19:00:00">19:00</option><?php } ?>
                            <?php if ($ateHoraMonitor == '20:00:00') { ?><option selected value="20:00:00">20:00</option><?php
                                                                                                                        } else { ?><option value="20:00:00">20:00</option><?php } ?>
                            <?php if ($ateHoraMonitor == '21:00:00') { ?><option selected value="21:00:00">21:00</option><?php
                                                                                                                        } else { ?><option value="21:00:00">21:00</option><?php } ?>
                        </select>
                    </div>
                </div>
                <div class=" col text-end">
                    <input class="btn btn-light mt-2" type="submit" value="Próximo">
                </div>
        </div>
</div>
</form>
</div>

</body>
</div>