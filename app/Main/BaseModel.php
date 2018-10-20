<?php

namespace App\Core;

use App\Helpers\Database;

/**
 * Class BaseModel
 *
 * @package App\Core
 */
class BaseModel
{
    protected $db;

    protected $data = [];

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    protected function create($table, array $fields)
    {
        return $this->db->insert($table, $fields);
    }

    public function data()
    {
        return $this->data;
    }

    public function exists()
    {
        return !empty($this->data);
    }

    protected function find($table, array $where = [])
    {
        $data = $this->db->select($table, $where);
        if ($data->count()) {
            $this->data = $data->first();
        }

        return $this;
    }

    protected function update($table, array $fields, $recordId = null)
    {
        if (!$recordId && $this->exists()) {
            $recordId = $this->data()->id;
        }

        return (!$this->db->update($table, $recordId, $fields));
    }

}
