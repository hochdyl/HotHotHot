<?php

namespace App\Models;

use App\Core\System\Model;

class RoleModel extends Model {

    protected int $id;
    protected string $name;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     * @return RoleModel
     */
    public function setId(int $id): RoleModel {
        $this->id = $id;
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
     * @return RoleModel
     */
    public function setName(string $name): RoleModel {
        $this->name = $name;
        return $this;
    }

}
