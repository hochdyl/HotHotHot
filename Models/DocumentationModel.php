<?php

namespace App\Models;

use App\Core\System\Model;

class DocumentationModel extends Model {

    protected int $id;
    protected string $username;
    protected string $page;
    protected string $title;
    protected string $content;
    protected string $updated_at;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }

    /**
     * @param string $username
     * @return DocumentationModel
     */
    public function setUsername(string $username): DocumentationModel {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPage(): string {
        return $this->page;
    }

    /**
     * @param string $page
     * @return DocumentationModel
     */
    public function setPage(string $page): DocumentationModel {
        $this->page = $page;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param string $title
     * @return DocumentationModel
     */
    public function setTitle(string $title): DocumentationModel {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }

    /**
     * @param string $content
     * @return DocumentationModel
     */
    public function setContent(string $content): DocumentationModel {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     * @return DocumentationModel
     */
    public function setUpdatedAt(string $updated_at): DocumentationModel {
        $this->updated_at = $updated_at;
        return $this;
    }

}
