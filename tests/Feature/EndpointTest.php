<?php

beforeEach(function() {
    $this->base_url = getConfigValue('app_testing_url');
});

it('serves the index page', function () {
    $this->matchResponse($this->base_url . '/', 200);
})->skip(getenv('GITHUB_ACTIONS'), 'Running on GH...');

it('redirects to 404 page when content is not found', function () {
    $this->matchResponse($this->base_url . '/pathThatDoesntExist', 303);
})->skip(getenv('GITHUB_ACTIONS'), 'Running on GH...');

it('serves the default about page', function () {
    $this->matchResponse($this->base_url . '/_p/about', 200);
})->skip(getenv('GITHUB_ACTIONS'), 'Running on GH...');
