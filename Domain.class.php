<?php
namespace DeeHants\Daeman;
/**
 * @package Domain
 */
class Domain extends DBItem {
    private $_aliases;

    /**
     * Returns the table name for domain records.
     *
     * @return string Returns the table name.
     */
    protected function _table() {
        return "domain";
    }

    /**
     * Loads the email aliases for this domain
     *
     * @return void
     */
    private function _loadAliases() {
        // If already populated, don't do it again
        if (isset($this->_aliases)) { return; }

        $query = "SELECT * FROM alias WHERE domain_id=?;";
        $args = array(intval($this->id));

        // Send to the DB
        $results = DB::querySet($query, $args);

        if($results === false) {
            throw new \Exception("Unable to get aliases for {$this->id}.");
        }

        $this->_aliases = array();
        foreach ($results as $result) {
            $alias = new \DeeHants\Daeman\Alias($result);
            $this->_aliases[] = $alias;
        }
    }

    public function getData() {
        // Get the base data
        $data = parent::getData();

        // Add any aliases
        $this->_loadAliases();
        $data['aliases'] = array();
        foreach ($this->_aliases as $alias) {
            $data['aliases'][] = $alias->getData();
        }

        return $data;
    }
}
