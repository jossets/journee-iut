<!DOCTYPE html>
<html lang="fr">

<head>
    <title>IUT Réseaux & Télécom - CTF 2020</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://bulma.io/css/bulma-docs.min.css?v=201911141434">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <link rel="stylesheet" href="/style.css">
    <script defer src="lycees_details.js"></script>
</head>

<body>

<script>
    function selectDept() {
      var e = document.getElementById("departement");
      var value = e.options[e.selectedIndex].value;
      var text = e.options[e.selectedIndex].text;
      document.getElementById("lycee").innerHTML = "";
      lycees.forEach(updateLyceeList);

      function updateLyceeList(item, index) {
        var title = item[0] + " " + item[1];

        if (value == title) {

          document.getElementById("lycee").innerHTML += "<option>" + item + "</option><br>";
        }

      }
    }

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function validateForm() {
        var lycee = document.forms["registerForm"]["lycee"].value;
        if (lycee == "") {
            alert("Merci de sélectionner votre lycée.");
            return false;
        }

        var etablissement = document.forms["registerForm"]["etablissement"].value;
        if (etablissement == "") {
            alert("Merci de selectionner l'IUT.");
            return false;
        }


        var nom1 = document.forms["registerForm"]["nom1"].value;
        var prenom1 = document.forms["registerForm"]["prenom1"].value;
        var email1 = document.forms["registerForm"]["email1"].value;
        var nom2 = document.forms["registerForm"]["nom2"].value;
        var prenom2 = document.forms["registerForm"]["prenom2"].value;
        var email2 = document.forms["registerForm"]["email2"].value;
        if (   (nom1 == "") || (prenom1 == "") || (email1 == "")
            || (nom2 == "") || (prenom2 == "") || (email2 == "") ) {
            alert("Merci de remplir les champs nom/prenom/email pour les deux participants.");
            return false;
        }

        if (! validateEmail(email1)) {
            alert("Merci de saisir une adresse mail valide pour le participant 1.");
            return false;
        }
        if (! validateEmail(email2)) {
            alert("Merci de saisir une adresse mail valide pour le participant 2.");
            return false;
        }
        
        return true;
    }
  </script>
    <?php

    require_once('header.php');
    require_once('etablissements.php');
    require_once('lycees.php');
    ?>



    <section class="section">


        <form name="registerForm" action='register.php' method="post" onsubmit="return validateForm()">
            <div class="container">


      <div class="field">
        <label class="label">Departement</label>
        <div class="control">
          <div class="select">
            <select name="departement" id="departement" onchange="selectDept()">
              <?php  foreach ($lycees as $entry) { ?>
                <option><?php echo $entry; ?></option>
              <?php   } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="field">
        <label class="label">Lycées</label>
        <div class="control">
          <div class="select">
            <select name="lycee" id="lycee">
            </select>
          </div>
        </div>
      </div>


                <div class="field">
                    <label class="label">IUT</label>
                    <div class="control">
                        <div class="select">
                            <select name="etablissement">
                            <?php foreach ($etablissements as $entry) { ?>
                                <option><?php echo $entry; ?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>


</br>
                <div class="field">
                    <label class="label">Equipe</label>
</div>
                <div class="columns">

                    <div class="column has-background-grey-lighter as-border">


                        <div class="field">
                            <label class="label">Nom</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" placeholder="nom" name="nom1">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Prenom</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" placeholder="prénom" value="" name="prenom1">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>


                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left">
                                <input class="input" type="email" placeholder="bob@mail.org" value="" name="email1">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                        </div>



                    </div>

                    <div class="column has-background-grey-lighter">



                        <div class="field">
                            <label class="label">Nom</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" placeholder="nom" name="nom2">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Prenom</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" placeholder="prénom" value="" name="prenom2">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>


                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left">
                                <input class="input" type="email" placeholder="bob@mail.org" value="" name="email2">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                        </div>



                    </div>


                </div>
                <div class="container">

                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-link">Valider</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


    </section>



</body>

</html>