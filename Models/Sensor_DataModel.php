<?php

namespace App\Models;

use App\Core\System\Model;
use JsonSerializable;

class Sensor_DataModel extends Model implements JsonSerializable {

    protected int $id;
    protected int $sensor_id;
    protected float $temperature;
    protected string $timestamp;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSensorId(): int {
        return $this->sensor_id;
    }

    /**
     * @param int $sensor_id
     * @return Sensor_DataModel
     */
    public function setSensorId(int $sensor_id): Sensor_DataModel {
        $this->sensor_id = $sensor_id;
        return $this;
    }

    /**
     * @return float
     */
    public function getTemperature(): float {
        return $this->temperature;
    }

    /**
     * @param float $temperature
     * @return Sensor_DataModel
     */
    public function setTemperature(float $temperature): Sensor_DataModel {
        $this->temperature = $temperature;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimestamp(): string {
        return $this->timestamp;
    }

    public function jsonSerialize() {
        return
            [
                'id' => $this->getId(),
                'sensor_id' => $this->getSensorId(),
                'temperature' => $this->getTemperature(),
                'time' => $this->getTimestamp()
            ];
    }

}
