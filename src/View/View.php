<?php

namespace Makaroni\Core\View;

class View
{

    public function __construct(private string $basePath, private string $fileExtension)
    {
    }

    public function make(string $view, array $data = []): void
    {
        if (!file_exists($this->basePath . $view . $this->fileExtension)) {
            throw new \Exception("The {$view} view not found!");
        }

        extract($data);

        require_once $this->basePath . $view . $this->fileExtension;
    }
}
