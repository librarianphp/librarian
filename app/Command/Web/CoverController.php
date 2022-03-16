<?php

namespace App\Command\Web;

use Librarian\Provider\ContentServiceProvider;
use Librarian\Response;
use Librarian\WebController;
use Twig\Environment;

class CoverController extends WebController
{
    public function handle()
    {
        /** @var Environment $twig */
        $twig = $this->getApp()->twig;
        /** @var ContentServiceProvider $content_provider */
        $content_provider = $this->getApp()->content;

        $request = $this->getRequest();

        $content_slug = str_replace('-', '/', $request->getSlug());

        try {
            $content = $content_provider->fetch($content_slug);

            if ($content === null) {
                echo "null content";
                Response::redirect('/notfound');
            }
        } catch (\Exception $exception) {
            Response::redirect('/notfound');
        }


        $title = $content->frontMatterGet('title');
        $description = $content->frontMatterGet('description');
        $author = $content->frontMatterGet('author') ?? $this->getApp()->config->site_author;
        $author_avatar = $content->frontMatterGet('author_avatar');

        if (!$author_avatar) {
            //tries to get user avatar with gravatar
            if ($this->getApp()->config->has('author_email')) {
                $email = $this->config->author_email;
                $default = "https://librarianphp.dev/img/default_author.png";
                $size = 60;
                $author_avatar = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size;
            } else {
                $author_avatar = "/img/default_author.png";
            }
        }

        $cover_width = 1000;
        $cover_height = 420;
        $font = __DIR__ . '/../../Resources/fonts/AbrilFatface-Regular.otf';
        $image = imagecreatetruecolor($cover_width, $cover_height);

        $color_black = imagecolorallocate($image, 0, 0, 0);
        $color_white = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 233, 14, 91);

        imagefill($image, 0, 0, $color_white);

        //imagestring($image, 1, 5, 5,  $title, $text_color);
        imagettftext($image, 20, 0, 10, 20, $color_black, $font, $title);

        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
}
