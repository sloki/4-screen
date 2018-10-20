<?php

namespace App\Helpers;

use PDO;
use PDOException;

class Database
{
    private static $database;

    private $pdo;
    private $query;
    private $error = false;
    private $results = [];
    private $count = 0;

    private function __construct()
    {
        try {
            $host = Config::get('DATABASE_HOST');
            $name = Config::get('DATABASE_NAME');
            $username = Config::get('DATABASE_USERNAME');
            $password = Config::get('DATABASE_PASSWORD');
            $this->pdo = new PDO("mysql:host={$host};dbname={$name}", $username, $password);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function action($action, $table, array $where = [])
    {
        if (\count($where) === 3) {
            $operator = $where[1];
            $operators = ["=", ">", "<", ">=", "<="];
            if (in_array($operator, $operators)) {
                $field = $where[0];
                $value = $where[2];
                $params = [":value" => $value];
                if (!$this->query("{$action} FROM `{$table}` WHERE `{$field}` {$operator} :value", $params)->error()) {
                    return $this;
                }
            }
        } else {
            if (!$this->query("{$action} FROM `{$table}`")->error()) {
                return $this;
            }
        }

        return false;
    }

    public function count()
    {
        return $this->count;
    }

    public function delete($table, array $where = [])
    {
        return $this->action('DELETE', $table, $where);
    }

    public function error()
    {
        return $this->error;
    }

    public function first()
    {
        return $this->results(0);
    }

    public static function getInstance()
    {
        if (!isset(self::$database)) {
            self::$database = new Database();
        }

        return self::$database;
    }

    public function insert($table, array $fields)
    {
        if (\count($fields)) {
            $params = [];
            foreach ($fields as $key => $value) {
                $params[":{$key}"] = $value;
            }
            $columns = implode("`, `", array_keys($fields));
            $values = implode(", ", array_keys($params));
            if (!$this->query("INSERT INTO `{$table}` (`{$columns}`) VALUES({$values})", $params)->error()) {
                return ($this->pdo->lastInsertId());
            }
        }

        return false;
    }

    public function query($sql, array $params = [])
    {
        $this->count = 0;
        $this->error = false;
        $this->results = [];
        if (($this->query = $this->pdo->prepare($sql))) {
            foreach ($params as $key => $value) {
                $this->query->bindValue($key, $value);
            }
            if ($this->query->execute()) {
                $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
                $this->count = $this->query->rowCount();
            } else {
                $this->error = true;
            }
        }

        return $this;
    }

    public function results($key = null)
    {
        return (isset($key) ? $this->results[$key] : $this->results);
    }

    public function select($table, array $where = [])
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function update($table, $id, array $fields)
    {
        if (\count($fields)) {
            $tmp = 1;
            $set = "";
            $params = [];
            foreach ($fields as $key => $value) {
                $params[":{$key}"] = $value;
                $set .= "`{$key}` = :$key";
                if ($tmp < count($fields)) {
                    $set .= ", ";
                }
                $tmp++;
            }
            if (!$this->query("UPDATE `{$table}` SET {$set} WHERE `id` = {$id}", $params)->error()) {
                return true;
            }
        }

        return false;
    }

}
