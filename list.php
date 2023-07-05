<?php


define('CLI_SCRIPT', true);

require __DIR__.'/../../config.php';
require_once $CFG->libdir.'/clilib.php';      // cli only functions
require_once $CFG->libdir . '/adminlib.php';
require_once $CFG->libdir . '/filelib.php';
// Define the input options.
$longparams = array(
        'help' => false,
        'list' => false,
);

$shortparams = array(
        'h' => 'help',
        'l' => 'list',
);

// now get cli options
list($options, $unrecognized) = cli_get_params($longparams, $shortparams);

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}

if ($options['help']) {
    $help =
    "List external plugin paths to copy in new instalations

Options:
-h, --help                    Print out this help


Example:
\$sudo -u www-data /usr/bin/php admin/cli/reset_password.php
\$sudo -u www-data /usr/bin/php admin/cli/reset_password.php --username=rosaura --password=jiu3jiu --ignore-password-policy
";

    echo $help;
    die;
}
if (!function_exists('str_starts_with')) {
    function str_starts_with($str, $start)
    {
        return (@substr_compare($str, $start, 0, strlen($start))==0);
    }
}
  
function iscontained($folders,$folder)
{
    foreach ($folders as $fold)
    {
        if(str_starts_with($folder, $fold."/")) {
            return true;
        }
    }
    return false;
}
if ($options['list']) {
    $pluginman = core_plugin_manager::instance();
    $plugininfo = $pluginman->get_plugins();
    $folders=array();
    foreach ($plugininfo as $type => $plugins) {
        foreach ($plugins as $name => $plugin) {
            if (!$plugin->is_standard()) {
                if(!iscontained($folders, $plugin->rootdir)) {
                    if($plugin->rootdir!=null || $plugin->rootdir!='') {
                        array_push($folders, $plugin->rootdir);
                        
                    }
                    else
                    {
                        //echo "the name: ".$name."\n";
                    }
                }
                else
                {
                    //echo "este no".$plugin->rootdir."\n";
                }
            }
        }
    }
    sort($folders);
    foreach ($folders as $folder)
    {
        echo $folder."\n";
    }
    die;
}
