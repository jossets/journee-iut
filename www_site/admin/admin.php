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

    <?php require_once('../header.php'); ?>
    
    <?php  function table_begin() { ?>
            <table class="table is-fullwidth">
            <thead>
                    <tr>
                    <th>Id</th>
                    <th>Lycée</th>
                    <th>Team Id</th>
                    <th>Team Name</th>
                    <th>Id</th>                    
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>eMail</th>                    
                    <th>eMail validé ?</th>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>eMail</th>                    
                    <th>eMail validé ?</th>
                    <th>status</th>
                    <th>Flags</th>
                    </tr>
                </thead>
                <tbody>
    <?php   }  ?>

    <?php  function table_row($row) { ;
        ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['lycee']); ?></td>
                        <td><?php echo htmlspecialchars($row['uid']); ?></td>
                        <td><?php echo htmlspecialchars($row['teamname']); ?></td>
                        <td><?php echo htmlspecialchars($row['uid1']); ?></td>
                        <td><?php echo htmlspecialchars($row['nom1']); ?></td>
                        <td><?php echo htmlspecialchars($row['prenom1']); ?></td>
                        <td><?php echo htmlspecialchars($row['email1']); ?></td>
                        <td><?php echo htmlspecialchars($row['ismail1confirmed']); ?></td>
                        <td><?php echo htmlspecialchars($row['uid2']); ?></td>
                        <td><?php echo htmlspecialchars($row['nom2']); ?></td>
                        <td><?php echo htmlspecialchars($row['prenom2']); ?></td>
                        <td><?php echo htmlspecialchars($row['email2']); ?></td>
                        <td><?php echo htmlspecialchars($row['ismail2confirmed']); ?></td>
                        <td><?php echo htmlspecialchars($row['state']); ?></td>
                        <td><?php echo htmlspecialchars($row['flag']); ?></td>
                    </tr>
                
    <?php   }  ?>

    <?php  function table_end() { ?>
                </tbody>
        </table>
    <?php   }  ?>

    <section class="hero is-link">
        <div class="hero-body">
            <div class="container">
                <h1 class="title"> </h1></br>
            </div>


            <div class="container">


                <?php
                if (file_exists('../conf/ctf_iut.sqlite')) {
                    $db = new SQLite3('../conf/ctf_iut.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

                    $results = $db->query("
                        SELECT 
                            p.*, count(f.flag) AS flag 
                            
                        FROM participants p 
                        LEFT JOIN flags f
                        on p.uid = f.uid
                        GROUP BY p.id
                    ;");
                    $current_iut="";
                    $current_lycee="";
                    while ($row = $results->fetchArray()) {

                        if ($row['etablissement'] != $current_iut) {
                            if ($current_iut!=""){
                                table_end();
                            }
                            echo '<h1 class="title">'.$row['etablissement'].'</h1></br>';
                            $current_iut = $row['etablissement'];
                            table_begin();
                        }
                        table_row($row);
                                                
                    } 
                    table_end()  ;
                } 
            ?>

            </div>
    </section>

</body>

</html>