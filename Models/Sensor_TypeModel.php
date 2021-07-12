<?php

namespace App\Models;

use App\Core\System\Model;

class Sensor_TypeModel extends Model {

    protected int $id;
    protected string $name;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Sensor_TypeModel
     */
    public function setName(string $name): Sensor_TypeModel {
        $this->name = $name;
        return $this;
    }

}
