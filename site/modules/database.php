<?php
class Database {
    private $db;

    public function __construct($path) {
        $this->db = new SQLite3($path);
    }

    public function Execute($sql) {
        return $this->db->exec($sql);
    }

    public function Fetch($sql) {
        $result = $this->db->query($sql);
        return $result->fetchArray(SQLITE3_ASSOC);
    }

    public function Create($table, $data) {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
        $this->Execute($sql);
        return $this->db->lastInsertRowID();
    }

    public function Read($table, $id) {
        $sql = "SELECT * FROM {$table} WHERE id = {$id}";
        return $this->Fetch($sql);
    }

    public function Update($table, $id, $data) {
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = "{$key} = '{$value}'";
        }
        $sql = "UPDATE {$table} SET " . implode(", ", $updates) . " WHERE id = {$id}";
        return $this->Execute($sql);
    }

    public function Delete($table, $id) {
        $sql = "DELETE FROM {$table} WHERE id = {$id}";
        return $this->Execute($sql);
    }

    public function Count($table) {
        $sql = "SELECT COUNT(*) as count FROM {$table}";
        $result = $this->Fetch($sql);
        return $result['count'];
    }
}   