<?php

namespace Miniweb\Provider;

use Minicli\App;
use Twig\Loader\FilesystemLoader;
use Minicli\ServiceInterface;
use Twig\Environment as TwigEnvironment;
use Twig\TwigFunction;

class TwigServiceProvider implements ServiceInterface
{
    /** @var string */
    protected $templates_path;
    /** @var TwigEnvironment */
    protected $twig;

    public function load(App $app)
    {
        if (!$app->config->has('templates_path')) {
            throw new \Exception("Missing Templates Path.");
        }

        $this->setTemplatesPath($app->config->templates_path);
        $loader = new FilesystemLoader($this->getTemplatesPath());

        $this->twig = new TwigEnvironment($loader, [
            //'cache' => $this->getTemplatesPath() . '/compilation_cache',
        ]);

        $this->twig->addFunction(new TwigFunction('include_snippet', function() {
            return "[FILE CONTENT HERE]";
        }));
    }

    public function setTemplatesPath($path)
    {
        $this->templates_path = $path;
    }

    public function getTemplatesPath()
    {
        return $this->templates_path;
    }

    public function render($template_file, array $data)
    {
        $template = $this->twig->load($template_file);
        return $template->render($data);
    }
}