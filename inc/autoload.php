<?php

class PluginTestAutoloader
{


    public function autoload($classname)
    {

        if ($plug = isPluginItemType($classname)) {
            $plugname = strtolower($plug['plugin']);
            $dir      = GLPI_ROOT . "/plugins/test/tools/";
            $item     = str_replace('\\', '/', strtolower($plug['class']));
            // Is the plugin active?
            // Command line usage of GLPI : need to do a real check plugin activation
            if (isCommandLine()) {
                $plugin = new Plugin();
                if (count($plugin->find(['directory' => $plugname, 'state' => Plugin::ACTIVATED])) == 0) {
                    // Plugin does not exists or not activated
                    return false;
                }
            } else {
                // Standard use of GLPI
                if (!Plugin::isPluginLoaded($plugname)) {
                    // Plugin not activated
                    return false;
                }
            }

            if (file_exists("$dir$item.class.php")) {
                include_once("$dir$item.class.php");
                if (
                    isset($_SESSION['glpi_use_mode'])
                    && ($_SESSION['glpi_use_mode'] == Session::DEBUG_MODE)
                ) {
                    $DEBUG_AUTOLOAD[] = $classname;
                }
            }
        }
    }


    public function register()
    {

        spl_autoload_register([$this,'autoload'],false,true);
      
    }
    
}
