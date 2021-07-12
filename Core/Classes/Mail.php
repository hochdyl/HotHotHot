<?php

namespace App\Core\Classes;

use JetBrains\PhpStorm\ArrayShape;

class Mail {
    private array $header;

    public function __construct(private string $to, private string $subject, private string $template_path) {
        $this->header = $this->addHeader();
    }

    #[ArrayShape(['From' => "string", 'MIME-Version' => "string", 'X-Priority' => "string", 'X-Mailer' => "string", 'Content-type' => "string", 'Content-Transfer-Encoding' => "string"])] private function addHeader(): array {
        return array(
            'From' => NO_REPLY_EMAIL,
            'MIME-Version' => '1.0',
            'X-Priority' => '1',
            'Content-type' => 'text/html; charset=utf-8',
            'Content-Transfer-Encoding' => '8bit'
        );
    }

    private function buffer(?array $params): bool|string {
        if (!is_null($params)) extract($params);

        ob_start();
        include_once "$this->template_path";
        return ob_get_clean();
    }

    public function send(array $params = null): bool {
        return mail($this->to, $this->subject, $this->buffer($params), $this->header);
    }

}
