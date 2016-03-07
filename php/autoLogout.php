<?php
session_start();

$idletime=10;//after 60 seconds the user gets logged out
if (time()-$_SESSION['login']['timestamp']>$idletime){
    session_destroy();
    session_unset();
    $result = 'destroy';
}else{
    $_SESSION['login']['timestamp']=time();
}
echo json_encode($result);