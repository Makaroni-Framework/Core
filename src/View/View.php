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
        $basePath = $this->basePath;;
        $fileExtension = $this->fileExtension;;

        if (!file_exists($basePath . $view . $fileExtension)) {
            throw new \Exception("The {$view} view not found!");
        }

        if(! is_null($data)){
            extract($data);
        } 
        require_once $basePath . $view . $fileExtension;
    }
}