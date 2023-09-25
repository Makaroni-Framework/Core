<?php

namespace Makaroni\Core\Request;

class Request
{

    private $request;

    public function __construct()
    {
        $this->request = $_REQUEST;
    }

    public function all(): array
    {
        return $this->request;
    }

    public function input(string $key): mixed
    {
        return $this->request[$key] ?? null;
    }
}
