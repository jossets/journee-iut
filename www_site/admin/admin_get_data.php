<?php

function dump_header() { 
    $tab = "; ";
    $ret = "";
    $ret = $ret."Count".$tab;
    $ret = $ret."id".$tab; 
    $ret = $ret."etablissement".$tab; 
    $ret = $ret."lycee".$tab; 
    $ret = $ret."uid".$tab; 
    $ret = $ret."teamname".$tab; 
    $ret = $ret."uid1".$tab;
    $ret = $ret."nom1".$tab; 
    $ret = $ret."prenom1".$tab; 
    $ret = $ret."email1".$tab; 
    $ret = $ret."ismail1confirmed".$tab;
    $ret = $ret."uid2".$tab; 
    $ret = $ret."nom2".$tab; 
    $ret = $ret."prenom2".$tab; 
    $ret = $ret."email2".$tab; 
    $ret = $ret."ismail2confirmed".$tab; 
    $ret = $ret."state".$tab;
    $ret = $ret."flag"; 
    $ret = $ret."\n";
    return $ret;
} 

function dump_row($count, $row) { 
    $tab = "; ";
    $ret = "";
    $ret = $ret.htmlspecialchars($count).$tab; 
    $ret = $ret.htmlspecialchars($row['id']).$tab; 
    $ret = $ret.htmlspecialchars($row['etablissement']).$tab; 
    $ret = $ret.htmlspecialchars($row['lycee']).$tab; 
    $ret = $ret.htmlspecialchars($row['uid']).$tab; 
    $ret = $ret.htmlspecialchars(trim($row['teamname']," \t\n\r")).$tab; 
    $ret = $ret.htmlspecialchars($row['uid1']).$tab;
    $ret = $ret.htmlspecialchars($row['nom1']).$tab; 
    $ret = $ret.htmlspecialchars($row['prenom1']).$tab; 
    $ret = $ret.htmlspecialchars($row['email1']).$tab; 
    $ret = $ret.htmlspecialchars($row['ismail1confirmed']).$tab;
    $ret = $ret.htmlspecialchars($row['uid2']).$tab; 
    $ret = $ret.htmlspecialchars($row['nom2']).$tab; 
    $ret = $ret.htmlspecialchars($row['prenom2']).$tab; 
    $ret = $ret.htmlspecialchars($row['email2']).$tab; 
    $ret = $ret.htmlspecialchars($row['ismail2confirmed']).$tab; 
    $ret = $ret.htmlspecialchars($row['state']).$tab;
    $ret = $ret.htmlspecialchars($row['flag']); 
    $ret = $ret."\n";
    return $ret;
} 


    $data = "aa, bbb, ccc\nzzz, eee, rrr";
    $data="";

    $db = new PDO('sqlite:../conf/ctf_iut.sqlite');
    $iut="";
    if (isset($_GET['iut'])) {
        $iut = $_GET['iut'];
    
    } 
    $statement = $db->prepare("
            SELECT 
                p.*, count(f.flag) AS flag 
                
            FROM participants p 
            LEFT JOIN flags f
            on p.uid = f.uid
            GROUP BY p.id
            ORDER BY etablissement, lycee
        ;");
    $statement->execute();
    
    $current_iut="";
    $current_lycee="";
    $count=0;
    $data = $data.dump_header();
    while ($row = $statement->fetch()) {
        if ($row['etablissement'] != $current_iut) {
            if ($current_iut!=""){
                
            }
            $current_iut = $row['etablissement'];
            $count=0;
        }
        $count = $count+1;
        if ($iut=="") {
            $data = $data.dump_row($count, $row);
        } elseif ($current_iut == $iut) {
            $data = $data.dump_row($count, $row);
        }
                                
    } 
    
    

    header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
    header("Cache-Control: public"); // needed for internet explorer
    header("Content-Type: application/text");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length:".strlen($data));
    header("Content-Disposition: attachment; filename=data.csv");
    echo $data;
    die();        

?>