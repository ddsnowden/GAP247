<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/assets/php/db.php';

    $_SESSION['form']['clientList'] = '';
    unset($_SESSION['form']['clientList']);
    
    if($_POST) {
        $id = $_POST['id'];
        $sql = "SELECT * FROM client LEFT JOIN clientname as CN on client.clientNameID = CN.clientNameID WHERE clientID = ?";
        $query = $DBH->prepare($sql);
        $query->execute(array($id));
        $list = $query->fetch();
        
        if(isset($_SESSION['form'])){
            
        }
        else {
            $_SESSION['form'] = '';
        }

        $_SESSION['form'] = array_merge($_SESSION['form'], $list);
    
        $data = 'success';
        
        echo json_encode($data);
    }