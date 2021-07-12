<?php

namespace App\Models;

use App\Core\System\Model;

class UserModel extends Model {

    protected int $id;
    protected ?int $id_google;
    protected int $role_id;
    protected ?string $last_name;
    protected string $first_name;
    protected string $email;
    protected ?string $password;
    protected string $avatar;
    protected bool $is_verified;
    protected string $token;
    protected ?string $last_connection;
    protected ?int $nb_connection;
    protected int $nb_values_sensors;
    protected int $nb_values_comparison;
    protected string $created_at;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserModel
     */
    public function setId(int $id): UserModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIdGoogle(): ?int
    {
        return $this->id_google;
    }

    /**
     * @param int|null $id_google
     * @return UserModel
     */
    public function setIdGoogle(?int $id_google): UserModel
    {
        $this->id_google = $id_google;
        return $this;
    }

    /**
     * @return int
     */
    public function getRoleId(): int
    {
        return $this->role_id;
    }

    /**
     * @param int $role_id
     * @return UserModel
     */
    public function setRoleId(int $role_id): UserModel
    {
        $this->role_id = $role_id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string|null $last_name
     * @return UserModel
     */
    public function setLastName(?string $last_name): UserModel
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return UserModel
     */
    public function setFirstName(string $first_name): UserModel
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserModel
     */
    public function setEmail(string $email): UserModel
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return UserModel
     */
    public function setPassword(?string $password): UserModel
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     * @return UserModel
     */
    public function setAvatar(string $avatar): UserModel
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIsVerified(): bool
    {
        return $this->is_verified;
    }

    /**
     * @param bool $is_verified
     * @return UserModel
     */
    public function setIsVerified(bool $is_verified): UserModel
    {
        $this->is_verified = $is_verified;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return UserModel
     */
    public function setToken(string $token): UserModel
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastConnection(): ?string
    {
        return $this->last_connection;
    }

    /**
     * @param string|null $last_connection
     * @return UserModel
     */
    public function setLastConnection(?string $last_connection): UserModel
    {
        $this->last_connection = $last_connection;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNbConnection(): ?int
    {
        return $this->nb_connection;
    }

    /**
     * @param int|null $nb_connection
     * @return UserModel
     */
    public function setNbConnection(?int $nb_connection): UserModel
    {
        $this->nb_connection = $nb_connection;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbValuesSensors(): int
    {
        return $this->nb_values_sensors;
    }

    /**
     * @param int $nb_values_sensors
     * @return UserModel
     */
    public function setNbValuesSensors(int $nb_values_sensors): UserModel
    {
        $this->nb_values_sensors = $nb_values_sensors;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbValuesComparison(): int
    {
        return $this->nb_values_comparison;
    }

    /**
     * @param int $nb_values_comparison
     * @return UserModel
     */
    public function setNbValuesComparison(int $nb_values_comparison): UserModel
    {
        $this->nb_values_comparison = $nb_values_comparison;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return UserModel
     */
    public function setCreatedAt(string $created_at): UserModel
    {
        $this->created_at = $created_at;
        return $this;
    }

}
