<?php
use Silex\Application;

class PasterDatabase {
    private $db;

    public function __construct(Application $app) {
        $this->db = $app['db'];
        $this->init();
    }

    private function init() {
        if (!$this->db->getSchemaManager()->tablesExist('pastes')) {
            $sql = 'CREATE TABLE pastes (
                id TEXT PRIMARY KEY,
                time INTEGER,
                paste TEXT
            )';
            $this->db->query($sql);
        }
    }

    public function addPaste($content) {
        $id = uniqid();
        $affected = $this->db->insert('pastes', array(
            'id' => $id,
            'time' => time(),
            'paste' => $content
        ));

        if ($affected == 0) {
            return NULL;
        }
        return $id;
    }

    public function getPaste($id) {
        $paste = $this->db->fetchAssoc('SELECT * FROM pastes WHERE id = ?', array($id));
        if (empty($paste)) {
            return NULL;
        }
        return $paste;
    }
} 
