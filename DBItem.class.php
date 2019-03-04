<?php
namespace DeeHants\Daeman;
/**
 * Base class for any object that is based on a database table.
 * 
 * DBItem provides the base functionality for a database row backed object.
 * Fields are automatically extracted from the specified table and made
 * available as member variables/properties of this object.
 */
abstract class DBItem {
    protected $id = 0;
    protected $field_values = array();

    /**
     * Called when the inheriting object is created.
     * 
     * @param mixed key Lookup key
     */
    public function __construct($key) {
        $table = $this->_table();
        $numeric_key = "{$table}_id";
        $text_key = "{$table}_name";

        // Create the query
        $query = "SELECT * FROM $table WHERE $numeric_key=? OR $text_key=?;";
        $args = array(intval($key), $key);

        // Send to the DB
        $result = DB::queryRow($query, $args);

        if($result === false) {
            throw new \Exception("No matching row in '$table' for '$key'.");
        }

        // Extract the field values
        $this->id = $result[$numeric_key];
        $this->field_values = $result;
    }

    /**
     * Property getter.
     *
     * @param string $name Name of the property to get.
     * @return string The property value.
     */
    public function __get($name) {
        if (isset($this->field_values[$name])) { return $this->field_values[$name]; }
        throw new \ErrorException("Undefined property: " . get_class($this) . "::" . $name, 123, E_NOTICE);
    }

    /**
     * Property issetter.
     *
     * @param string $name Name of the property to check.
     * @return bool true if the property is set, false otherwise.
     */
    public function __isset($name) {
        if (isset($this->field_values[$name])) { return true; }
        return false;
    }

    /**
     * Called to get the database table for this item.
     * Defaults to the lower case of the class name.
     * Can be overridden.
     */
    protected function _table() {
        $class_name = get_class($this);
        if ($pos = strrpos($class_name, '\\')) $class_name = substr($class_name, $pos + 1);
        return strtolower($class_name);
    }

    /**
     * Gets data suitable for rendering or processing.
     *
     * @return array Returns an associative array for this object.
     */
    public function getData() {
        return $this->field_values;
    }
}
