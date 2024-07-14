<?php

namespace model;

class BaseClass {
    public $error;
    public $errorMessage;
    public $message;

    public function error()
    {
        return $this->error;
    }

    public function errorMessage()
    {
        return $this->errorMessage;
    }

    public function message()
    {
        return $this->message;
    }
}