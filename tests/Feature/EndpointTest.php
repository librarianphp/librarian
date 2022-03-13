<?php

it('serves the index page', function () {
    $response = getResponseCode('/');
    expect($response)->toBe(200);
})->skip(getenv('GITHUB_ACTIONS'), 'Running on GH...');

it('redirects to 404 page when content is not found', function () {
    $response = getResponseCode('/lskdsajdlajdlkad');
    expect($response)->toBe(303);
})->skip(getenv('GITHUB_ACTIONS'), 'Running on GH...');;