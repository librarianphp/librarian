<?php

test('the "help" command prints the command tree', function () {
    $app = getApp();
    $app->runCommand(['librarian', 'help']);
})->expectOutputRegex("/librarian help/");

test('default command "help" is correctly loaded', function () {
    $app = getApp();
    $app->runCommand(['librarian', 'help']);
})->expectOutputRegex("/help/");
