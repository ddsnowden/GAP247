<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once $root.'/assets/php/db.php';

    if($_POST['type'] == 'clientName') {
        $keyword = '%'.$_POST['key'].'%';
        $sql = "SELECT * FROM clientname
                    WHERE (clientName LIKE :clientName OR postcode LIKE :postcode)
                    GROUP BY clientNameID ORDER BY clientName ASC ";
        $query = $DBH->prepare($sql);
        $query->bindParam(':clientName', $keyword, PDO::PARAM_STR);
        $query->bindParam(':postcode', $keyword, PDO::PARAM_STR);
        $query->execute();
        $list = $query->fetchAll();
        
        $_SESSION['form']['clientList'] = $list;
    
        echo json_encode($list);
    }
    elseif($_POST['type'] == 'client') {
        $keyword = '%'.$_POST['key'].'%';
        $sql = "SELECT * FROM client 
                    JOIN clientname AS CN ON client.clientNameID = CN.clientNameID 
                    WHERE (client.firstName LIKE :firstName OR client.lastName LIKE :lastName OR client.landline LIKE :landline OR client.mobile LIKE :mobile OR CN.clientName LIKE :clientName OR CN.postcode LIKE :postcode)
                    ORDER BY CN.clientName ASC, client.firstName ASC, client.lastName ASC ";
        $query = $DBH->prepare($sql);
        $query->bindParam(':firstName', $keyword, PDO::PARAM_STR);
        $query->bindParam(':lastName', $keyword, PDO::PARAM_STR);
        $query->bindParam(':landline', $keyword, PDO::PARAM_STR);
        $query->bindParam(':mobile', $keyword, PDO::PARAM_STR);
        $query->bindParam(':clientName', $keyword, PDO::PARAM_STR);
        $query->bindParam(':postcode', $keyword, PDO::PARAM_STR);
        $query->execute();
        $list = $query->fetchAll();
        
        $_SESSION['form']['clientList'] = $list;
    
        echo json_encode($list);
    }
    elseif($_POST['type'] == 'temp') {
        $keyword = '%'.$_POST['key'].'%';
        $sql = "SELECT * FROM temp 
                    WHERE (firstName LIKE :firstName OR lastName LIKE :lastName OR landline LIKE :landline OR mobile LIKE :mobile OR postcode LIKE :postcode)
                    ORDER BY lastName ASC, firstName ASC";
        $query = $DBH->prepare($sql);
        $query->bindParam(':firstName', $keyword, PDO::PARAM_STR);
        $query->bindParam(':lastName', $keyword, PDO::PARAM_STR);
        $query->bindParam(':landline', $keyword, PDO::PARAM_STR);
        $query->bindParam(':mobile', $keyword, PDO::PARAM_STR);
        $query->bindParam(':postcode', $keyword, PDO::PARAM_STR);
        $query->execute();
        $list = $query->fetchAll();
        
        $_SESSION['form']['tempList'] = $list;
    
        echo json_encode($list);
    }