<?php
namespace DeeHants\Daeman;
/**
 * @package Alias
 */
class Alias extends DBItem {
    private $_recipients;

    protected function _table() {
        return "alias";
    }

    /**
     * Loads the email recipients for this alias
     *
     * @return void
     */
    private function _loadRecipients() {
        // If already populated, don't do it again
        if (isset($this->_recipients)) { return; }

        $query = "SELECT * FROM recipient WHERE alias_id=?;";
        $args = array(intval($this->id));

        // Send to the DB
        $results = DB::querySet($query, $args);

        if($results === false) {
            throw new \Exception("Unable to get recipients for {$this->id}.");
        }

        $this->_recipients = array();
        foreach ($results as $result) {
            $recipient = new \DeeHants\Daeman\Recipient($result);
            $this->_recipients[] = $recipient;
        }
    }

    public function getData() {
        // Get the base data
        $data = parent::getData();

        // Add any recipients
        $this->_loadRecipients();
        $data['recipients'] = array();
        foreach ($this->_recipients as $recipient) {
            $data['recipients'][] = $recipient->getData();
        }

        return $data;
    }
}
