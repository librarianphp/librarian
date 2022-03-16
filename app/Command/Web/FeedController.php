<?php

namespace App\Command\Web;

use Librarian\Content;
use Librarian\WebController;
use Librarian\Provider\ContentServiceProvider;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class FeedController extends WebController
{
    public function handle()
    {
        $feed = new Feed();
        $channel = new Channel();
        $channel
            ->title($this->getApp()->config->site_name)
            ->description($this->getApp()->config->site_description)
            ->url($this->getApp()->config->site_url)
            ->feedUrl($this->getApp()->config->site_url . '/feed')
            ->language('en-US')
            ->copyright('Copyright ' . date('Y') . ', '. $this->getApp()->config->site_name)
            ->pubDate(strtotime(date('Y-m-d H:i:s')))
            ->lastBuildDate(strtotime(date('Y-m-d H:i:s')))
            ->ttl(60)
            ->appendTo($feed);

        /** @var ContentServiceProvider $content_provider */
        $content_provider = $this->getApp()->content;
        $content_list = $content_provider->fetchAll();

        /** @var Content $content */
        foreach ($content_list as $content) {
            $item = new Item();
            $item
                ->title($content->title ?? '')
                ->description('<div>'.($content->description ?? '').'</div>')
                ->contentEncoded('<div>'.($content->description ?? '').'</div>')
                ->url($this->getApp()->config->site_url . '/' . $content->getLink())
                ->author($this->getApp()->config->site_author)
                ->pubDate(strtotime($content->getDate()))
                ->guid($this->getApp()->config->site_url . '/' . $content->getLink(), true)
                ->preferCdata(true) // By this, title and description become CDATA wrapped HTML.
                ->appendTo($channel);
        }

        header('Content-type: application/rss+xml');
        echo $feed;
    }
}
