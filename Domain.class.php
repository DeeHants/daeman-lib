<?php
namespace DeeHants\Daeman;
/**
 * @package Domain
 */
class Domain extends DBItem {
    /**
     * Returns the table name for domain records.
     *
     * @return string Returns the table name.
     */
    protected function _table() {
        return "domain";
    }
}
