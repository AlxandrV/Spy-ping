<?php
namespace App\Twig;

class Twig{
    private $template;

    public function __construct($template_name)
    {
        $loader = new \Twig\Loader\FilesystemLoader(dirname(__FILE__).'/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => dirname(__FILE__).'/../../public/cache',
            'debug' => true,
        ]);
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $this->template = $twig->load($template_name);
    }

    public function render($arr=[]){
        echo $this->template->render($arr);
    }
}