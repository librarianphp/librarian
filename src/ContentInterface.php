<?php


namespace Librarian;


interface ContentInterface
{
    public function getTitle();

    public function getCoverImage();

    public function getDescription();

    public function getDatePublished();

    public function getBody();

    public function getSlug();

    public function getLink();

    public function load();

    public function save($content);
}