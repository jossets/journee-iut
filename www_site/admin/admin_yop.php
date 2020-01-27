<!DOCTYPE html>
<html lang="fr">


<head>
    <title><?php echo "DAYCTF 2020-02-05 - DUT Réseaux & Télécom / Lycées" ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://bulma.io/css/bulma-docs.min.css?v=201911141434">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <link rel="stylesheet" href="/style.css">
    <script defer src="lycees_details.js"></script>
	<style>
        .table-fixed {
            table-layout: fixed;
            width: 100%;
        }
        .table-container {
            overflow-x: scroll;
        }
    </style>
</head>

<body>

<body bgcolor='black'>

<div class="column auto">
<figure width="100%" style="text-align:center">
                    <img src="/img/dayctf_20200205.png">
		</figure>
</div>

    <?php require_once('../header.php'); 
/*    
        if (isset($_GET['dropuid'])) {
            $uid = $_GET['dropuid'];
            $db = new SQLite3('../conf/ctf_iut.sqlite', SQLITE3_OPEN_READWRITE);
            $results = $db->query("
                DELETE                    
                FROM participants 
                WHERE uid = '$uid'
            ;");
            $db=null;
        }
 */   
    ?>    
    <?php  function table_begin() { ?>
        <div class="container table-container">
            <table class="table is-fullwidth">
            <thead>
                    <tr>
                    <th></th>
                    <th>N° Arrivé</th>
                    <th>Lycée</th>
                    <th>Team Id</th>
                    <th>Team Name</th>
                    <th>1-Id</th>                    
                    <th>1-Nom</th>
                    <th>1-Prénom</th>
                    <th>1-eMail</th>                    
                    <th>1-eMail validé ?</th>
                    <th>2-Id</th>
                    <th>2-Nom</th>
                    <th>2-Prenom</th>
                    <th>2-eMail</th>                    
                    <th>2-eMail validé ?</th>
                    <th>status</th>
                    <th>Flags</th>
                    </tr>
                </thead>
                <tbody>
    <?php   }  ?>

    <?php  function table_row($count, $row) { ;
        ?>
                    <tr>
                        <td><?php echo htmlspecialchars($count); ?></td>
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
        </div>
    <?php   }  ?>

    <section class="hero is-link">
        <div class="hero-body">
            <div class="container ">
                <h2 class="title"> </h2>
            </div>
            </br><a href="/admin/admin_get_data.php" class="button">CSV File complet</a></br>

            <div class="container ">


                <?php
                if (file_exists('../conf/ctf_iut.sqlite')) {
                    $db = new SQLite3('../conf/ctf_iut.sqlite',  SQLITE3_OPEN_READWRITE);

                    $results = $db->query("
                        SELECT 
                            p.*, count(f.flag) AS flag 
                            
                        FROM participants p 
                        LEFT JOIN flags f
                        on p.uid = f.uid
                        GROUP BY p.id
                        ORDER BY etablissement, lycee
                    ;");
                    $current_iut="";
                    $current_lycee="";
                    $count=0;
                    while ($row = $results->fetchArray()) {

                        if ($row['etablissement'] != $current_iut) {
                            if ($current_iut!=""){
                                table_end();
                            }
                            echo '<h1 class="title">'.$row['etablissement'].'</h1></br>';
                            echo '</br><a href="/admin/admin_get_data.php?iut='.$row['etablissement'].'" class="button">CSV File</a></br>';
                            $current_iut = $row['etablissement'];
                            table_begin();
                            $count=0;
                        }
                        $count = $count+1;
                        table_row($count, $row);
                                                
                    } 
                    table_end()  ;
                    
                } 
            ?>

            </div>
    </section>

</body>

</html>
