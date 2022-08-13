<?php
require 'modele/modele_connexion.php';

send_mail();
oublier();
connexion_auto();
inscription();
connexion();

require 'vue/vue_connexion.php';
?>