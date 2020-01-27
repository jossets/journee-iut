# journee-iut

# Configuration du serveur

    sudo apt update
    sudo apt-get install python-minimal
    sudo apt install zip
    sudo apt install docker-compose
    sudo gpasswd -a $USER docker



# Installation initiale

## Installation du proxy HTTPS Traefik


    git clone https://github.com/jossets/journee-iut.git
    cd journee-iut/

    cp traefik.toml.ori traefik.toml
    Mettre à  jour les champs en XXXXX

    cp traefik_acme/acme.json.default traefik_acme/acme.json
    chmod 600 traefik_acme/acme.json
    cd traefik_acme
    docker-compose up -d
    cd ..

    Une fois la config définitive, remplacer dans traefik_acme/traefik.toml
    caServer = "https://acme-staging-v02.api.letsencrypt.org/directory"
    par
    caServer = "https://acme-v02.api.letsencrypt.org/directory"



## Instalaltion du serveur web

Définir un LOGIN PASSWDORD pour accéder aux info d'administration

    cp www_site/conf/htpasswd.ori www_site/conf/htpasswd
    htpasswd -b ./htpasswd LOGIN PASSWORD
    docker-compose up -d



