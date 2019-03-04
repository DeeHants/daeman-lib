<?php
/**
 * Bootstrapper module for the Daeman library.
 */

/**
 * Class auto loader module.
 * 
 * Auto loads modules in the \DeeHants\Daeman namespace from the current folder.
 * 
 * @arg string class_name Fully qualified name of the class attempting being loaded.
 */
spl_autoload_register(function ($class_name) {
    // Only attempt to auto load \DeeHants\Daeman 
    $prefix = "DeeHants\\Daeman\\";
    $prefix_len = strlen($prefix);
    if (substr_compare($class_name, $prefix, 0, $prefix_len, true) == 0) {
        // Convert the class name into a path we can load
        $local_name = substr($class_name, $prefix_len);
        $local_name = str_replace("\\", DIRECTORY_SEPARATOR, $local_name);
        $local_name = __DIR__ . DIRECTORY_SEPARATOR . $local_name . ".class.php";
        // Require() the file
        // If it doesn't exist, we fail here
        require($local_name);
    }
});
