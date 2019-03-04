<?php
/**
 * @package DeeHants\Daeman
 * Contains the DeeHants\Daeman\Config class.
 */
namespace DeeHants\Daeman;

/**
 * @package DeeHants\Daeman
 * Config class that manages the library configuration, both in a site and
 * server context.
 */
class Config {
    private $config = array();

    private function __construct() {
        // For now, we hard code the config until it can be loaded from an external file
        $this->config = array(
            // These will all need to be changed to point at your mysql server.
            "Database" => array(
                "Host" => "localhost",
                "Name" => "daeman",
                "Username" => "daeman",
                "Password" => "<password>",
            ),
        );
    }

    public static function getKeyStatic(...$keys) {
        // If called statically, grab a "default" instance and call on that
        $new_this = new Config();
        return call_user_func_array(array($new_this,"getKey"), $keys);
    }

    public function getKey(...$keys) {
        // If called statically, grab a "default" instance and call on that
        if (!isset($this)) {
            $new_this = new Config();
            return call_user_func_array(array($new_this,"getKey"), $keys);
        }

        // Extract the requested value
        $block = $this->config;
        foreach ($keys as $key) {
            $block = $block[$key];
        }
        return $block;
    }
}
