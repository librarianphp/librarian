<?php

declare(strict_types=1);

function config_default(string $config_dir): array
{
    $config = [];

    foreach (glob($config_dir . '/*.php') as $config_file) {
        $config_data = include $config_file;
        if (is_array($config_data)) {
            $config = array_merge($config, $config_data);
        }
    }

    return $config;
}

function load_config(): array
{
    return array_merge(config_default(__DIR__ . '/../config'), include __DIR__ . '/../config.php');
}
