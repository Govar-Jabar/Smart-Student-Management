<?php
require 'conn.php';
require 'inc/function.php';

if (isset($_POST['user'])) {
    $user=output($_POST['user']);
    $stm = $db->prepare("SELECT * FROM account WHERE user=:user");
    $stm->bindParam(":user", $user, PDO::PARAM_STR);
    $stm->execute();
    $rowCount = $stm->rowCount();
        if($rowCount > 0){
            echo '1';
        }else {
            echo '2';
        }
}

$db = null;
