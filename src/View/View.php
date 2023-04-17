<?php 
namespace Makaroni\Core\View;

class View{

    function __construct(private string $basePath, private string $fileExtension)
    {
        $this->basePath = $basePath;
        $this->fileExtension = $fileExtension;
    }

    public function make(string $view, array|null $data = null): void
    {
        if (!file_exists($this->basePath . $view . $this->fileExtension)) {
            throw new \Exception("The {$view} view not found!");
        }

        if(! is_null($data)){
            extract($data);
        } 
        require_once $this->basePath . $view . $this->fileExtension;
    }
}