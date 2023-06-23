<?php

declare(strict_types=1);

use Librarian\Provider\ContentServiceProvider;
use Librarian\Provider\LibrarianServiceProvider;
use Librarian\Provider\TwigServiceProvider;
use Minicli\Command\CommandRegistry;

beforeEach(function () {
    $this->app = getApp();
});

it('Boots the app and loads CommandRegistry', function () {
    $registry = $this->app->commandRegistry;
    expect($registry)->toBeInstanceOf(CommandRegistry::class);
});

it('Boots the app and loads custom Service Providers', function () {
    expect($this->app->content)->toBeInstanceOf(ContentServiceProvider::class)
        ->and($this->app->twig)->toBeInstanceOf(TwigServiceProvider::class)
        ->and($this->app->librarian)->toBeInstanceOf(LibrarianServiceProvider::class);
});

it('Boots the app and loads content', function () {
    $content = $this->app->content->fetch('posts/test0');
    expect($content->frontMatterGet('title'))->toBe('Devo Produzir Conteúdo em Português ou Inglês?')
        ->and($content->body_markdown)->toBeString();
});
