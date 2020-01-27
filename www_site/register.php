<?php session_start(); ?>
<?php require_once 'csrfguard.php'; ?>
<?php 
////////////////////////////////////////////////////////////////////////////
// Session Id is UID
//
$isRegistrationClosed=true; 

if (isset($_GET['uid'])) {
    setcookie('uit_ctf_uid', $_GET['uid'], time() + (86400 * 30), "/"); // 86400 = 1 day
}

function isCaptchaOk()
{
	if (!isset($_POST["g-recaptcha-response"])) {
		return false;
	}

	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => '6LdAw9EUAAAAAHvEKpe4OFgN493M48zvfO--NYWK',
		'response' => $_POST["g-recaptcha-response"]
	);
	$options = array(
		'http' => array (
			'method' => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success=json_decode($verify);

	if ($captcha_success->success==true) {
		return true;
	}
	return false;	
}

////////////////////////////////////////////////////////////////////////////
// Register Form ?
//
if (isset($_POST['etablissement'])) {
	
	if (!$isRegistrationClosed) {
	
    //
    // Create DB ???
    //
    $test=false;
    if (!file_exists('conf/ctf_iut.sqlite')) {
        $db = new SQLite3('conf/ctf_iut.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        $result = $db->query('CREATE TABLE IF NOT EXISTS participants (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                lycee VARCHAR,
                etablissement VARCHAR,
                nom1 VARCHAR,
                prenom1 VARCHAR,
                email1 VARCHAR,
                uid1 VARCHAR,
                ismail1confirmed boolean,
                nom2 VARCHAR,
                prenom2 VARCHAR,
                email2 VARCHAR,
                uid2 VARCHAR,
                ismail2confirmed boolean,
                uid VARCHAR,
                teamname VARCHAR,
                state INTEGER
            );');
        if ($test) $resultf = $db->query('INSERT INTO participants (
                lycee, etablissement,
                nom1, prenom1, email1, uid1, ismail1confirmed,
                nom2, prenom2, email2, uid2, ismail2confirmed,
                uid , state) 
            VALUES ("lycee1","iut1",
                "nom11","prenom11","email11@mail.com","ID11",false,
                "nom12","prenom12","email12@mail.com","ID12",false,
                "UID1",0);');
        $resultf = $db->query('CREATE TABLE IF NOT EXISTS flags (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            uid VARCHAR,
            flag VARCHAR
        );');
        if ($test) $resultf = $db->query('INSERT INTO flags (uid, flag) VALUES ("","");');
    }
    //
    // Save Form
    //
    $db = new PDO('sqlite:conf/ctf_iut.sqlite');
    if ($db) {
		if (isCaptchaOk()) {
			$lycee = filter_var($_POST['lycee'], FILTER_SANITIZE_STRING);
			$etablissement = filter_var($_POST['etablissement'], FILTER_SANITIZE_STRING);
			$nom1 = filter_var($_POST['nom1'], FILTER_SANITIZE_STRING);
			$prenom1 = filter_var($_POST['prenom1'], FILTER_SANITIZE_STRING);
			$email1 = filter_var($_POST['email1'], FILTER_VALIDATE_EMAIL);
			$uid1 =uniqid();
			$nom2 = filter_var($_POST['nom2'], FILTER_SANITIZE_STRING);
			$prenom2 = filter_var($_POST['prenom2'], FILTER_SANITIZE_STRING);
			$email2 = filter_var($_POST['email2'], FILTER_VALIDATE_EMAIL);
			$uid2 =uniqid();
			$uid = uniqid();
			$_SESSION["uid"] = $uid;

			setcookie('uit_ctf_uid', $uid, time() + (86400 * 30), "/"); // 86400 = 1 day

			$statement = $db->prepare('INSERT INTO participants (
				lycee, etablissement, 
				nom1, prenom1, email1, uid1, ismail1confirmed,
				nom2, prenom2, email2, uid2, ismail2confirmed,  
				uid, teamname, state)
				VALUES (:lycee, :etablissement, 
				:nom1, :prenom1, :email1, :uid1, false,
				:nom2, :prenom2, :email2, :uid2, false,
				:uid, "no_name_yet", 0)');

			$statement->execute([
				'lycee' => $lycee,
				'etablissement' => $etablissement,
				'nom1' => $nom1,
				'prenom1' => $prenom1,
				'email1' => $email1,
				'uid1' => $uid1,
				'nom2' => $nom2,
				'prenom2' => $prenom2,
				'email2' => $email2,
				'uid2' => $uid2,
				'uid' => $uid,
			]);

			require_once('var_env.php');
			if ($ctf_mail_enabled){
				require_once('ctf_mail.php');
				//echo "Register: Send mail to ".$email1;
				ctf_send_registered_mail($uid, $uid1, $email1);  
				ctf_send_registered_mail($uid, $uid2, $email2);  
			} else {
				//echo "Mail not enabled";
			}
		} else {
			print("Captcha ko");
		}
    } else {
        print("DB ko");
    }
	}
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
<?php
//-- Fonction de récupération de l'adresse IP du visiteur
    if ( isset ( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    elseif ( isset ( $_SERVER['HTTP_CLIENT_IP'] ) )
    {
        $ip  = $_SERVER['HTTP_CLIENT_IP'];
    }
    else
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $ipe = base64_encode(base64_encode("Flag_" . $ip));
?>
<!-- double decode base64 -->
    <title><?php echo "DAYCTF 2020-02-05 - DUT Réseaux & Télécom / Lycées - " . $ipe ?></title> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://bulma.io/css/bulma-docs.min.css?v=201911141434">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <link rel="stylesheet" href="/style.css">
</head>




<?php 
        require_once('flags.php');
        if (isset($_COOKIE["uit_ctf_uid"])) {
            $f = "Flag_".md5($flags[1] . $_COOKIE["uit_ctf_uid"]);
            echo "<!-----
            -------
            ------- ".$f."
            -------
            ------>";
        }
?>

<body>

<body bgcolor='black'>
<!--- <div class="container" onclick="window.location.href='/redirect.php';"> -->
<div class="column auto">
<figure onclick="window.location.href='/redirect.php';" width="50%" style="text-align:center">
                    <img src="/img/dayctf_20200205.png">  </figure>
</div>

<?php
////////////////////////////////////////////////////////////////////////////
// Validate a mail
//


function countAlreadyRegistered($etablissement){
    $db = new PDO('sqlite:conf/ctf_iut.sqlite');
    if ($db) {
        $statement = $db->prepare('SELECT count(nom1) as count_nom from  participants where ismail1confirmed=true AND ismail2confirmed=true AND  etablissement=:etablissement;');
        $statement->execute([
            'etablissement' => $etablissement,
        ]);
        $row = $statement->fetch();
        
        if (isset($row['count_nom'])) {
            return $row['count_nom'];
        } else {
            return 0;
        }
    }
}



function isOnWaitingList($uid) {
    include('etablissements.php');
    $db = new PDO('sqlite:conf/ctf_iut.sqlite');
    if ($db) {
        $iut="";

        $statement = $db->prepare('SELECT etablissement FROM participants WHERE uid=:uid');
        $statement->execute([
            'uid' => $uid,
        ]);
        if ($row =  $statement->fetch()) {
            $iut = trim($row['etablissement']);
	} else {
		return false;
	}

        $registeredcount = countAlreadyRegistered($iut);
        $places = $etablissements_places[$iut];
        $onwaiting = ($registeredcount>$places);
        if ($registeredcount>$places) {
            //setOnWaitingList($uid);
            echo "Candidature $registeredcount sur $places places à [$iut]. Mise En liste d'attente.";
            return true;
        } else {
            echo "Candidature $registeredcount sur $places places à $iut. Place ok.";
            return false;
        }

    }
}


function getRandomTeamName() {
    $names_file = file_get_contents('hacker_name.txt');
    $names = $pieces = explode("\n", $names_file);
    $index = rand(0, count($names)-1);
    return $names[$index];
}

function isTeamNameAvailable($name){
    $db = new PDO('sqlite:conf/ctf_iut.sqlite');
    $statement = $db->prepare('SELECT * FROM participants WHERE teamname=:teamname');
    $statement->execute(['teamname' => $name]);
    if ($row = $statement->fetch()){
        return false;
    } else {
        return true;
    }
}

function getNewTeamName() {
    $name = getRandomTeamName();
    while (!isTeamNameAvailable($name)) {
        $name = getRandomTeamName();
    }
    return $name;
}


if (isset($_GET['uid']) && isset($_GET['uidm'])) {
    $db = new PDO('sqlite:conf/ctf_iut.sqlite');
    $statement = $db->prepare('UPDATE participants
        SET ismail1confirmed=true
        WHERE ( uid=:uid and uid1=:uidm)');
    $statement->execute([
            'uid' => $_GET['uid'] ,
            'uidm' => $_GET['uidm']
        ]);
    $statement = $db->prepare('UPDATE participants
        SET ismail2confirmed=true
        WHERE ( uid=:uid and uid2=:uidm)');
    $statement->execute([
            'uid' => $_GET['uid'] ,
            'uidm' => $_GET['uidm']
        ]);
    // 2 mails validated ? and no teamname
    // Set team name
    $statement = $db->prepare('SELECT * from participants WHERE ( uid=:uid and ismail1confirmed=true and ismail2confirmed=true and teamname="no_name_yet" )');
    $statement->execute([
            'uid' => $_GET['uid'] 
    ]);
    if ($row = $statement->fetch()){
        $teamname = getNewTeamName();
        $uid = $row['uid'];
        $mail1 = $row['email1'];
        $uidm1 = $row['uid1'];
        $mail2 = $row['email2'];
        $uidm2 = $row['uid2'];
        $statement = $db->prepare('UPDATE participants
        SET teamname=:teamname
        WHERE ( uid=:uid )');
        $statement->execute([            
            'teamname' => $teamname,
            'uid' => $_GET['uid'] 
        ]);
        // Send mail with team name
	require_once('ctf_mail.php');


        if (isOnWaitingList($id)) {
            ctf_send_team_validated_mail_waitinglist($uid  ,$uidm1 , $mail1, $teamname);
            ctf_send_team_validated_mail_waitinglist($uid  ,$uidm2 , $mail2, $teamname);
        } else {
            ctf_send_team_validated_mail($uid  ,$uidm1 , $mail1, $teamname);
            ctf_send_team_validated_mail($uid  ,$uidm2 , $mail2, $teamname);
        }

    }

    
}


function isFlagAlreadyValidated($uid, $validatedFlag){
    $db = new PDO('sqlite:conf/ctf_iut.sqlite');
    if ($db) {
        $uid = $_COOKIE["uit_ctf_uid"];

        $statement = $db->prepare('SELECT * FROM flags WHERE uid=:uid and flag=:flag');
        $statement->execute([
            'uid' => $uid,
            'flag' => $validatedFlag
        ]);
        if ($row =  $statement->fetch()) {
            return true;
        } else {
            return false;
        }
    }
}

function getIP() {
//-- Fonction de récupération de l'adresse IP du visiteur
    if ( isset ( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    elseif ( isset ( $_SERVER['HTTP_CLIENT_IP'] ) )
    {
        $ip  = $_SERVER['HTTP_CLIENT_IP'];
    }
    else
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
	return $ip;
}
///////////////////////////////////////////////////////////////////////////////////
// Validate FLag
//
if (isset($_POST['flag'])) {
    //echo "Flag :" . $_POST['flag'];
    //echo "uit_ctf_uid :" . $_COOKIE["uit_ctf_uid"];
    if ($_COOKIE["uit_ctf_uid"]) {
        // Is Flag valid ?
        $isflagValif = false;
        $validatedFlag="";
        require_once('flags.php');
        foreach ($flags as $flag) {
            $f = "Flag_".md5($flag . $_COOKIE["uit_ctf_uid"]);
            if ($f === $_POST['flag']) {
                $isflagValif = true;
                $validatedFlag =  $flag;
            }
        }
		$ip = getIP();
		if ( $_POST['flag'] == "Flag_".$ip ) {
			$isflagValif = true;
            $validatedFlag =  "Flag_IP";
		}
        if ($isflagValif) {
            // Déjà validé ?
            if (isFlagAlreadyValidated($uid, $validatedFlag)) {
                $msg =  "Flag déjà validé !";
                include 'msg.php';
            } else {
                // Nouveau Flag
                $msg =  "Flag validé : Félicitation !";
                include 'msg.php';
                $db = new PDO('sqlite:conf/ctf_iut.sqlite');
                if ($db) {
                    $uid = $_COOKIE["uit_ctf_uid"];

                    $statement = $db->prepare('INSERT INTO flags (uid, flag)
                    VALUES (:uid, :flag)');

                    $statement->execute([
                        'uid' => $uid,
                        'flag' => $validatedFlag
                    ]);
                } else {
                    print("DB ko");
                }
            }
        } else {
            $msg =  "Flag non valide";
            include 'msg.php';
        }
    } else {
        $msg = "Veuillez vous enregister";
        include 'msg.php';
    }
}

?>


    <section class="section">

<?php 
    if (isset($_SESSION["uid"]) || isset($_GET['uid']) || isset($_COOKIE['uit_ctf_uid']) ) {
        if (isset($_COOKIE['uit_ctf_uid'])) $id = $_COOKIE['uit_ctf_uid'];
        if (isset($_SESSION["uid"])) $id = $_SESSION["uid"];
        if (isset($_GET['uid'])) $id = $_GET['uid'];
        

        $db = new PDO('sqlite:conf/ctf_iut.sqlite');
        $statement = $db->prepare('SELECT * FROM participants WHERE uid=:uid');
        $statement->execute([
            ':uid' => $id
        ]);
        $fullValidated = false;
        $partialValidated = false;
        if ($row = $statement->fetch()){
            $fullValidated = $row['ismail1confirmed']&&$row['ismail2confirmed'];
            $partialValidated = $row['ismail1confirmed']||$row['ismail2confirmed'];
        } 

        if ($fullValidated) {
        ?>
            <form action='' method="post">
		<div class="container">
                    <label class="label"><font color="white">Votre équipe est enregistrée, les deux mails sont validés.</label>
		    </br>



<?php
        if (isOnWaitingList($id)) {
            echo "<label class='label'>Nous sommes désolés, mais toutes les places pour le CTF de cet établissement ont été attribuées.
            Vous êtes sur la liste d'attente. Nous vous contacterons rapidement par mail pour vous informer de la suite donnée à votre candidature.</label>";
            echo "</br>";
        }
?>
                    <label class="label"><font color="white">Pour marquer des points, cherchez les Flags sur le site et saisissez les ci-dessous.</br></br></label>
                    <div class="field">
                        <label class="label"><font color="white">Flag</label>
                        <div class="control has-icons-left">
                            <input class="input" type="text" placeholder="Flag_xxxxxxxxxxxxxx" name="flag" style="color:black;" >
                            <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-link">Envoyer</button>
                        </div>

                    </div>
                </div>
            </form>
            </section>
            <a href='/flag.php' hidden=true>Test flag</a>
        <?php } else if ($partialValidated) { ?>
	    <div class="container">
            <label class="label"><font color="white">Votre équipe est enregistrée. </br>Un premier mail est validé.</br>Merci de valider le second mail...</label>
            </br>

        </div>
            </section>
        <?php } else { 
		
		if ($isRegistrationClosed) { ?>
	<div class="container">
        <label class="label"><font color="white">Enregistrements terminés...</label>
        </br>

    </div>	
	<?php } else { ?>
	    <div class="container">
            <label class="label"><font color="white">Votre équipe est enregistrée. </br>Merci de valider les deux mails...</label>
            </br>

        </div>
            </section>
        <?php } } ?>
		

		
<?php } else { 
	if ($isRegistrationClosed) { ?>
	<div class="container">
        <label class="label"><font color="white">Enregistrements terminés...</label>
        </br>

    </div>	
	<?php } else { ?>
    <div class="container">
        <label class="label"><font color="white">Merci de vous enregistrer avec le formulaire...</label>
        </br>

    </div>
	<?php }
	}  ?>

</body>

</html>
