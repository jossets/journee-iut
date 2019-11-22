<?php

    //
    // POST Data ?
    //
    if ($_POST['etablissement']) {
        $db = new PDO('sqlite:conf/ctf_iut.sqlite');
        if ($db) {
            //print("DB ok");
            $etablissement = $_POST['etablissement'];
            $nom1 = $_POST['nom1'];
            $prenom1 = $_POST['prenom1'];
            $email1 = $_POST['email1'];
            $nom2 = $_POST['nom2'];
            $prenom2 = $_POST['prenom2'];
            $email2 = $_POST['email2'];
            $uid = md5($email1 . $email2);

            setcookie('uit_ctf_uid', $uid, time() + (86400 * 30), "/"); // 86400 = 1 day

            $statement = $db->prepare('INSERT INTO participants (etablissement, nom1, prenom1, email1, nom2, prenom2, email2, uid)
            VALUES (:etablissement, :nom1, :prenom1, :email1, :nom2, :prenom2, :email2, :uid)');

            $statement->execute([
                'etablissement' => $etablissement,
                'nom1' => $nom1,
                'prenom1' => $prenom1,
                'email1' => $email1,
                'nom2' => $nom2,
                'prenom2' => $prenom2,
                'email2' => $email2,
                'uid' => $uid,
            ]);
            print("YOLO".$etablissement);
        } else {
            print("DB ko");
        }
    }

    if ($_POST['flag']) {
        echo "Flag :".$_POST['flag'];
    }
   
    ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>IUT Réseaux & Télécom - CTF 2020</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://bulma.io/css/bulma-docs.min.css?v=201911141434">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <?php require_once('header.php'); ?>
    <section class="section">

        <form action='' method="post">
            <div class="container">
            <label class="label">Votre équipe est enrgistrée.</label>
</br>
            <label class="label">Pour marquer des points, cherchez les Flags sur le site et saisissez les ci-dessous.</br></br></label>
                <div class="field">
                    <label class="label">Flag</label>
                    <div class="control has-icons-left">
                        <input class="input" type="text" placeholder="nom" name="flag">
                        <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link">Submit</button>
                    </div>

                </div>
            </div>
        </form>


    </section>



</body>

</html>