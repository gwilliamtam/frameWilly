<?php

class Messages
{
    private $messageTypes = [];

    public function __construct()
    {
        $this->messageTypes  = [
            'message' => 'alert-info',
            'error' => 'alert-danger',
            'success' => 'alert-success'
        ];
    }

    public function add($type, $text)
    {
        if (empty($_SESSION['messages'])) {
            $_SESSION['messages'] = [];
        }
        $_SESSION['messages'][] = [
            $type, $text
        ];
    }

    public function display()
    {
        if (array_key_exists('messages', $_SESSION) && !empty($_SESSION['messages'])) {
            echo <<< HTML
            <div class="container">
HTML;

            foreach($_SESSION['messages'] as $index => $pair) {
                $type = $pair[0];
                $text = $pair[1];
                $class = 'alert-primary';
                if (array_key_exists($type, $this->messageTypes)) {
                    $class = $this->messageTypes[$type];
                }
                echo <<<HTML
                <div class="alert $class" role="alert">
                  $text
                </div>
HTML;
                $_SESSION['messages'] = null;
            }
            echo <<< HTML
            </div>
HTML;
        }
    }
}

