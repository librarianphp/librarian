<?php

namespace App;

class Stencil
{
    protected $stencil_dir;

    public function __construct($stencil_dir)
    {
        $this->stencil_dir = $stencil_dir;
    }

    public function applyTemplate($template_name, array $variables = [])
    {
        $template = file_get_contents($this->stencil_dir . '/' . $template_name . '.tpl');

        foreach ($variables as $variable_name => $variable_value) {
            $template = str_replace("{{ $variable_name }}", $variable_value, $template);
        }

        return $template;
    }
}