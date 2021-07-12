<?php

namespace App\Models;

use App\Core\System\Model;

class AlertModel extends Model {
    protected int $id;
    protected int $sensor_id;
    protected int $user_id;
    protected string $name;
    protected string $description;
    protected int $operator;
    protected int $value;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AlertModel
     */
    public function setId(int $id): AlertModel {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getSensorId(): int {
        return $this->sensor_id;
    }

    /**
     * @param int $sensor_id
     * @return AlertModel
     */
    public function setSensorId(int $sensor_id): AlertModel {
        $this->sensor_id = $sensor_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     * @return AlertModel
     */
    public function setUserId(int $user_id): AlertModel {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     * @return AlertModel
     */
    public function setName(string $name): AlertModel {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @param string $description
     * @return AlertModel
     */
    public function setDescription(string $description): AlertModel {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getOperator(): int {
        return $this->operator;
    }

    /**
     * @param int $operator
     * @return AlertModel
     */
    public function setOperator(int $operator): AlertModel {
        $this->operator = $operator;
        return $this;
    }

    /**
     * @return int
     */
    public function getValue(): int {
        return $this->value;
    }

    /**
     * @param int $value
     * @return AlertModel
     */
    public function setValue(int $value): AlertModel {
        $this->value = $value;
        return $this;
    }

}
