<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(ini_get("session.use_cookies")){
    $params = session_get_cookie_params();
    setcookie(session_name(),'',time()-42000,$params['path'],$params['domain'],$params['secure'],$params['httponly']);
}
session_unset();
session_destroy();
header("location: login.php");