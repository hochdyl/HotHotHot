<?php

namespace App\Models;

use App\Core\System\Model;

class CommentModel extends Model {

    protected int $id;
    protected int $user_id;
    protected string $title;
    protected string $content;
    protected string $created_at;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     * @return CommentModel
     */
    public function setUserId(int $user_id): CommentModel {
        $this->user_id = $user_id;
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
     * @return CommentModel
     */
    public function setTitle(string $title): CommentModel {
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
     * @return CommentModel
     */
    public function setContent(string $content): CommentModel {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string {
        return $this->created_at;
    }

}
