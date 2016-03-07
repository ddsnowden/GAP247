<?php
if(($_SESSION['login']['access'] >= 20) || ($_SESSION['login']['access'] == 2)) {

} 
else {
    $_SESSION = array();
    session_destroy();
    echo '<script>alert("You are trying to access a restricted page, please log in and try again"</script>';
    header("location: /assets/php/logout.php");
}