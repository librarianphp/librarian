<?php

it('serves the index page', function () {
    $response = getResponseCode('/');
    expect($response)->toBe(200);
});

it('redirects to 404 page when content is not found', function () {
    $response = getResponseCode('/lskdsajdlajdlkad');
    expect($response)->toBe(303);
});