<?php
use Minicli\App;
use Librarian\Provider\ContentServiceProvider;
use Librarian\Provider\LibrarianServiceProvider;
use Librarian\Provider\TwigServiceProvider;

beforeEach(function () {
    $this->config = [
        'debug' => true,
        'templates_path' => __DIR__ . '/../resources',
        'data_path' => __DIR__ . '/../resources',
        'cache_path' => __DIR__ . '/../resources'
    ];

    $app = new App($this->config);
    $app->addService('content', new ContentServiceProvider());
    $app->addService('twig', new TwigServiceProvider());
    $app->addService('librarian', new LibrarianServiceProvider());
    $this->app = $app;
});

it('Boots the app and loads content', function () {
    $content = $this->app->content->fetch('posts/test0');
    expect($content->frontMatterGet('title'))->toEqual("Devo Produzir Conteúdo em Português ou Inglês?");
    expect($content->body_markdown)->toBeString();
});