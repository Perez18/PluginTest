<?php

/*

 El archivo setup.php del complemento se cargará automáticamente desde el núcleo de GLPI 
 para obtener su versión, verificar los requisitos previos, etc.


*/


define('TEST_VERSION','1.1');

function plugin_init_test(){

    global $PLUGIN_HOOKS,$CFG_GLPI;

    /**autoload class */
    include_once (GLPI_ROOT .'/plugins/test/inc/autoload.php');

    $autoloader = new PluginTestAutoloader();
     $autoloader->register();



}

