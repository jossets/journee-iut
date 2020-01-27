<?php

require_once('ctf_mailer.php');


function getHTML($title, $content) {
    $html = '
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title>'.($title).'</title>
    </head>
    <body>
    <div style="font-family: Arial, Helvetica, sans-serif; ">
        <h1>'.($title).'</h1>
        
        <p>'.($content).'</a></p>
    </div>
    </body>
    </html>';
    return $html;
}

function ctf_send_registered_mail($uid, $uidmail, $to) {
    //echo "Send mail to ".$to;
    $url = "https://dayctf.iut-rt.net/register.php?uid=".$uid."&uidm=".$uidmail;
    
    $subject = "[Day CTF RT] Confirmation d'enregistrement";
    $title = htmlentities("[Day CTF RT] Confirmation d'enregistrement");
    $content =htmlentities("Votre dossier d'inscription pour la journée CTF RT est créé.")."</br>"
        .htmlentities("Les deux email doivent être validés.")."</br>"
        .htmlentities("Pour valider votre email, cliquez sur le lien :")."<a href='{{URL}}'>{{URL}}</br>";
    $htmlbody = getHTML($title, $content); 
    $htmlbody = str_replace("{{URL}}", $url, $htmlbody);
  
    return ctf_send_gmail($to, $subject, $htmlbody, "");
}


function ctf_send_team_validated_mail($uid, $uidmail, $to, $teamname) {
    //echo "Send mail to ".$to;
    $url = "https://dayctf.iut-rt.net/register.php?uid=".$uid."&uidm=".$uidmail;
    
    $subject = "[Day CTF RT] Confirmation de la Team";
    $title = htmlentities("[Day CTF RT] Team validé");
    $content =htmlentities("Vos deux emails sont validés.")."</br>"
    .htmlentities("Le nom de votre team est : ").$teamname.". </br>"
    .htmlentities("Vous pouvez commencer à chercher des Flags en cliquant sur le lien: ")."<a href='{{URL}}'>{{URL}}";
    $htmlbody = getHTML($title, $content); 
    $htmlbody = str_replace("{{URL}}", $url, $htmlbody);
  
    return ctf_send_gmail($to, $subject, $htmlbody, "");
}


function ctf_send_team_validated_mail_waitinglist($uid, $uidmail, $to, $teamname) {
    //echo "Send mail to ".$to;
    $url = "https://dayctf.iut-rt.net/register.php?uid=".$uid."&uidm=".$uidmail;
    
    $subject = "[Day CTF RT] Confirmation de la Team en liste d attente";
    $title = htmlentities("[Day CTF RT] Team validé");
    $content =htmlentities("Vos deux emails sont validés.")."</br>"
    .htmlentities("Le nom de votre team est : ").$teamname.". </br>"
    .htmlentities("Nous sommes désolés, mais toutes les places pour le CTF de cet établissement ont été attribuées. 
    Vous êtes sur la liste d'attente. Nous vous contacterons rapidement par mail pour vous informer de la suite donnée à votre candidature.</br>")
    .htmlentities("Vous pouvez commencer à chercher des Flags en cliquant sur le lien: ")."<a href='{{URL}}'>{{URL}}";
    $htmlbody = getHTML($title, $content); 
    $htmlbody = str_replace("{{URL}}", $url, $htmlbody);
  
    return ctf_send_gmail($to, $subject, $htmlbody, "");
}

?>
