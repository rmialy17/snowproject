# snowproject

## Objectifs

Création d'un site collaboratif pour faire connaître les figures de snowboard.

## Environnement de développement

- Symfony 5
- Composer 2.1.9
- Bootstrap 4.1.1
- jQuery 3.2.1
- WampServer 3.2.3.3
  - Apache 2.4.46
  - PHP 7.4.9
  - MySQL 8.0.21

## Installation

1.	Clonez ou téléchargez le repository GitHub dans le dossier souhaité :
    > git clone https://github.com/rmialy17/snowproject.git

2.	Modifiez le fichier .env avec vos variables d'environnement 
    (connexion à la base de données, votre serveur SMTP , adresse mail). 

3.	Téléchargez et installez les dépendances du projet avec la commande: 
    > composer install

4.	Importez le fichier "snowtricks.sql" dans votre base de données

5.	Afin de tester l’envoi et la réception de mail en local, installer MailDev : 
      https://grafikart.fr/tutoriels/maildev-tester-emails-595 puis configurez le fichier 
      php.ini selon votre environnement comme suit : 

      - SMTP= adresse du serveur smtp de votre operateur (ex : smtp.orange.fr ) 
      - smtp_port = 1025 
      - sendmail_from = votre_adresse_email 
      - Pour consulter la liste des serveurs smtp rendez vous sur : 
      https://www.commentcamarche.net/applis-sites/mail/981-pop-imap-smtp 
      adresses-serveurs-mail/ 

      - Dans le fichier src/GlobalController, modifiez la ligne 141 avec votre adresse mail : 
                  ->from(‘votre_adresse_mail ‘)

      - Vous pourrez ainsi réceptionner tous les mails provenant du site à l’adresse : 
      http://localhost:1080  en lançant au préalable la commande:
      maildev --hide-extensions STARTTLS 

N.B. Si vous utilisez le site en local sur Windows avec Wamp, la solution n'intègre pas l'envoi d'email. 
Vous devez donc au préalable configurer sendmail : https://grafikart.fr/blog/mail-local-wamp.

Le projet est à présent installé, vous pouvez commencer à l'utiliser.
