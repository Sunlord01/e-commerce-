<?php

require 'modele/modele_forum.php';

add_msg();

pagination();

$msg = get_forum($depart,$articleParPage);

require 'vue/vue_forum.php';

?> 