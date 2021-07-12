<?php

namespace App\Models;

use App\Core\System\Model;

class SensorModel extends Model {

    protected int $id;
    protected int $type_id;
    protected string $name;
    protected bool $active;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTypeId(): int {
        return $this->type_id;
    }

    /**
     * @param int $type_id
     * @return SensorModel
     */
    public function setTypeId(int $type_id): SensorModel {
        $this->type_id = $type_id;
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
     * @return SensorModel
     */
    public function setName(string $name): SensorModel {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return SensorModel
     */
    public function setActive(bool $active): SensorModel {
        $this->active = $active;
        return $this;
    }

}
