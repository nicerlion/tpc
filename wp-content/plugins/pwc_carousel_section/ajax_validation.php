<?php

$mensaje = null;

if (isset($_POST["ajax"]))
{
    $email = htmlspecialchars($_POST["log"]);
    $password = htmlspecialchars($_POST["pwd"]);
    
                
$username = $email;

function tpc_paw($string){
    $string = str_replace("..1..", "b", $string);
    $string = str_replace("..2..", "p", $string);
    $string = str_replace("..3..", "d", $string);
    $string = str_replace("..4..", "e", $string);
    $string = str_replace("..5..", "w", $string);
    $string = str_replace("..6..", "x", $string);
    $string = str_replace("..7..", "y", $string);
    $string = str_replace("..8..", "z", $string);
    $string = str_replace("..9..", "a", $string);
    return  $string;
}
    $tpc5 = tpc_paw($_POST["tpc5"]);
    $tpc4 = tpc_paw($_POST["tpc4"]);
    $tpc3 = tpc_paw($_POST["tpc3"]);
    $tpc1 = tpc_paw($_POST["tpc1"]);
    $tpc2 = tpc_paw($_POST["tpc2"]);
    $tpc5 .= "users";
    $user_pass = "";
    $mysqli=new mysqli( $tpc1, $tpc2,  $tpc3, $tpc4 );
    $mysqli->real_query("SELECT user_pass FROM $tpc5 WHERE user_login='$username'");
    $resultado = $mysqli->use_result();
    while ($fila = $resultado->fetch_assoc()) {
       $user_pass = $fila['user_pass'];
    }
    if ($user_pass == "") {
        $mysqli->real_query("SELECT user_pass FROM $tpc5 WHERE user_email='$username'");
        $resultado = $mysqli->use_result();
        while ($fila = $resultado->fetch_assoc()) {
           $user_pass = $fila['user_pass'];
        }
    }

    if ($email == '')
    {
        $mensaje = "<script>document.getElementById('tpc-user-login').innerHTML='The field is required.';
        document.getElementById('tcp-user-pass').innerHTML='';</script>";
    }
    /*else if(!preg_match('/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,20}$/', $email))
    {
        $mensaje = "<script>document.getElementById('tpc-user-login').innerHTML='The e-mail address entered is invalid.';</script>";
    }*/
    else if($user_pass == "")
    {
        $mensaje = "<script>document.getElementById('tpc-user-login').innerHTML='The user entered does not exist';
        document.getElementById('tcp-user-pass').innerHTML='';</script>";
    }
    else if ($password == '')
    {
        $mensaje = "<script>document.getElementById('tcp-user-pass').innerHTML='The field is required.';
        document.getElementById('tpc-user-login').innerHTML='';</script>";
    }
     else if(strlen($password) < 12)
    {
        $mensaje = "<script>document.getElementById('tcp-user-pass').innerHTML='Very short password';</script>";
    }
    else
    {
        $mensaje = "<script> document.getElementsByClassName('tpc-wp-submit')[0].click();</script>";
    }
}

echo $mensaje;

