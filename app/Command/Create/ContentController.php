<?php

namespace App\Command\Create;

use App\Stencil;
use Minicli\Command\CommandController;
use Minicli\Input;

class ContentController extends CommandController
{
    public function handle()
    {
        if (!$this->getApp()->config->has('stencil_dir')) {
            $this->getApp()->getPrinter()->error("You must define a stencil_dir config option.");
            return;
        }

        if (!$this->getApp()->config->has('stencil_locations')) {
            $this->getApp()->getPrinter()->error("You must define a stencil_locations array config option.");
            return;
        }

        $template_name = $this->getArgs()[3];
        $stencil = new Stencil($this->getApp()->config->stencil_dir);

        $input = new Input(' ');

        $this->getPrinter()->info("Content Title: ");
        $title = $input->read();

        $this->getPrinter()->info("Content Description: ");
        $description = $input->read();

        $content = $stencil->applyTemplate($template_name, [
            'title' => $title,
            'description' => $description
        ]);

        $save_locations = $this->getApp()->config->stencil_locations;

        if (!array_key_exists($template_name, $save_locations)) {
            $this->getPrinter()->error("Save location not found for template $template_name");
            return;
        }

        $path = $save_locations[$template_name];
        $save_name = date('Ymd') . '_' . $this->slugify($title) . '.md';
        $file = fopen($path . '/' . $save_name, 'a+');

        fwrite($file, $content);
        $this->getPrinter()->info("Content generated at " . $path . '/' . $save_name);
    }

    public function slugify($title)
    {
        $slug = strtolower($title);
        $slug = str_replace(' ', '-', $slug);

        return preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
    }
}