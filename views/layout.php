<?php require_once __DIR__.'/../includes/app.php';

importTemplate('header', 'actual', $actual ?? '');

// Mostrar mensaje predefinido (Para editar los mensajes que se muestran puede revisar Misc.php))
if (!empty($msg)) {
    $msg_content = $msg[0];
    $msg_class = $msg[1] ?? 'alert-danger';

    ?>
    <div class="">
        <div class="alert <?php echo $msg_class?> alert-dismissible fade show" role="alert">
            <?php echo $msg_content?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>


    <?php
}

// Sistema de alertas en la parte superior de la pantalla
if(!empty($messages)) {
    ?> <div class=""> <?php
    foreach($messages as $message) {
        ?> 
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
    }
    ?> </div> <?php
}  
?> <div class="mt-5"> <?php
    echo $content;
?> </div> <?php

importTemplate('footer');
