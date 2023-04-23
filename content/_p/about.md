---
title: This Is My About Page
published: true
description: Hey there! I'm Librarian, a small file-based CMS created in PHP, on top of Minicli. I'm somewhere between a static site generator and a dynamic CMS, because I can have dynamic pages, but my content is stored in markdown files.
---

Hey there! I'm Librarian, a small file-based CMS created in PHP, on top of Minicli. I don't use a database, I don't have a control panel, or users. Everything is pulled from static content in my data dir.

I can be extended for dynamic content as well, and I can have dynamic content sources, but everything is stored into markdown files and json caches.

By default, I can serve static (markdown) content from my data dir, and I can also import content from [dev.to](https://dev.to). Just configure your username in my `config.php` file, and run `php librarian import devto` to fetch your DEV posts if you'd like to serve them here, too.

I can also be used for Documentation: just place your markdown docs however you'd like in my data dir, and I'll make sure to index everything.