<?php

namespace App\Core\System;

class Cache {

    private string|bool $buffer;

    public function __construct(private string $dirname, private float $duration) {}

    private function write(string $filename, string $content): bool|int {
        return file_put_contents("{$this->dirname}/$filename", $content, LOCK_EX);
    }

    private function read(string $filename): bool|string {
        $file_path = "{$this->dirname}/$filename";

        foreach(glob("{$this->dirname}/*") as $file) {
            if((time() - filemtime($file)) / 60 > $this->duration) unlink($file);
        }

        return !file_exists($file_path) || (time() - filemtime($file_path)) / 60 > $this->duration ? false : file_get_contents($file_path);
    }

    public function start(string $cache_name): bool {
        if (!file_exists($this->dirname)) mkdir($this->dirname, 0755);

        if($content = $this->read($cache_name)) {
            echo $content;
            $this->buffer = false;
            return true;
        }

        ob_start();
        $this->buffer = $cache_name;
        return false;
    }

    public function end(): bool|string {
        if(!$this->buffer) return false;

        $content = ob_get_clean();
        $this->write($this->buffer, $content);
        return $content;
    }

    /**
     * Function using to delete all cache files
     */
    private function clear() {
        foreach(glob("{$this->dirname}/*") as $file) unlink($file);
    }

}
