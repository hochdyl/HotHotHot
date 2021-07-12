<?php

namespace App\Models;

use App\Core\System\Model;

class BanModel extends Model {

    protected int $id;
    protected string $ip;
    protected int $attempt;
    protected string $time;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     * @return BanModel
     */
    public function setId(int $id): BanModel {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp(): string {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return BanModel
     */
    public function setIp(string $ip): BanModel {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return int
     */
    public function getAttempt(): int {
        return $this->attempt;
    }

    /**
     * @param int $attempt
     * @return BanModel
     */
    public function setAttempt(int $attempt): BanModel {
        $this->attempt = $attempt;
        return $this;
    }

    /**
     * @return string
     */
    public function getTime(): string {
        return $this->time;
    }

    /**
     * @param string $time
     * @return BanModel
     */
    public function setTime(string $time): BanModel {
        $this->time = $time;
        return $this;
    }

}
