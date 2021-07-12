<?php

namespace App\Core\System;

use App\Core\Database\Database;
use JetBrains\PhpStorm\Pure;
use PDO;
use PDOStatement;

abstract class Model {

    private string $table;

    public function __construct() {
        $this->table = str_replace('model', '', substr(strrchr(strtolower(get_class($this)), "\\"), 1));
    }

    #[Pure] private function match(int|string $key): int
    {
        return match (gettype($key)) {
            'string', 'float' => PDO::PARAM_STR,
            'int' => PDO::PARAM_INT,
            'bool' => PDO::PARAM_BOOL
        };
    }

    private function query(string $sql, array $params = null): bool|PDOStatement
    {
        $db = Database::getPDO();

        if (is_null($params)) {
            $query = $db->query($sql);
        } else {
            $query = $db->prepare($sql);

            foreach ($params as $param) {
                $query->bindValue($param[0], $param[1], $param[2]);
            }

            $query->execute();
        }

        $query->setFetchMode(PDO::FETCH_CLASS, get_class($this));
        return $query;
    }

    /**
     * @return bool|array|$this
     */
    public function findAll(): bool|array|self
    {
        return $this->query("SELECT * FROM {$this->table}")->fetchAll();
    }

    /**
     * @param int $id
     * @return bool|$this
     */
    public function findById(int $id): bool|self
    {
        return $this->query("SELECT * FROM {$this->table} WHERE id = $id LIMIT 1")->fetch();
    }

    /**
     * @param array $filter
     * @return bool|array|$this
     */
    public function findBy(array $filter): bool|array|self
    {
        $fields = [];
        $values = [];

        foreach ($filter as $k => $v) {
            $fields[] = "$k = :$k";
            $values[] = [":$k", $v, $this->match($k)];
        }

        $field_list = implode(' AND ', $fields);

        return $this->query("SELECT * FROM {$this->table} WHERE {$field_list}", $values)->fetchAll();
    }

    /**
     * @param int $limit
     * @param array $filter
     * @return bool|array|$this
     */
    public function findByLimit(array $filter, string $order_by, int $limit): bool|array|self
    {
        $fields = [];
        $values = [];

        foreach ($filter as $k => $v) {
            $fields[] = "$k = :$k";
            $values[] = [":$k", $v, $this->match($k)];
        }

        $field_list = implode(' AND ', $fields);

        return $this->query("SELECT * FROM {$this->table} WHERE {$field_list} ORDER BY {$order_by} DESC LIMIT {$limit}", $values)->fetchAll();
    }

    /**
     * @param array $filter
     * @return bool|PDOStatement|$this
     */
    public function findOneBy(array $filter): bool|PDOStatement|self
    {
        $fields = [];
        $values = [];

        foreach ($filter as $k => $v) {
            $fields[] = "$k = :$k";
            $values[] = [":$k", $v, $this->match($k)];
        }

        $field_list = implode(' AND ', $fields);

        return $this->query("SELECT * FROM {$this->table} WHERE {$field_list} LIMIT 1", $values)->fetch();
    }

    public function create(): bool|PDOStatement
    {
        $fields = [];
        $values = [];
        $params = [];

        foreach ($this as $k => $v) {
            if (!is_null($v) && $k !== 'table') {
                $fields[] = $k;
                $params[] = ":$k";
                $values[] = [":$k", $v, $this->match($k)];
            }
        }

        $field_list = implode(', ', $fields);
        $param_list = implode(', ', $params);

        return $this->query("INSERT INTO {$this->table} ({$field_list}) VALUES ({$param_list})", $values);
    }

    public function update(int $id): bool|PDOStatement
    {
        $fields = [];
        $values = [];

        foreach ($this as $k => $v) {
            if (!is_null($v) && $k !== 'table') {
                $fields[] = "$k = :$k";
                $values[] = [":$k", $v, $this->match($k)];
            }
        }

        $field_list = implode(', ', $fields);

        return $this->query("UPDATE {$this->table} SET {$field_list} WHERE id = $id", $values);
    }

    public function delete(int $id): bool|PDOStatement
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = $id");
    }

}
