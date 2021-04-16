# Librarian
_This is an experimental project._

Hey there! I'm Librarian, a minimalist file-based CMS created on top of [minicli](https://github.com/minicli/minicli). I don't use a database, I don't have a control panel, or users. 
Everything is pulled from static content in my data dir.

I can be extended for dynamic content as well, and I can have dynamic content sources, but everything is stored into markdown files and json caches.

By default, I can serve static (markdown) content from my data dir, and I can also import content from [dev.to](https://dev.to). 

Configure your username in my `config.php` file, and run `php librarian import devto` to fetch your DEV posts if you'd like to serve them here, too.

I can also be used for Documentation: just place your markdown docs however you'd like in my data dir, and I'll make sure to index everything.

You can try me at DigitalOcean by clicking the following button:

<p align="center">
<a title="Deploy this application to DigitalOceans App Platform in a few clicks!" href="https://cloud.digitalocean.com/apps/new?repo=https://github.com/minicli/librarian/tree/main"><img src="https://mp-assets1.sfo2.digitaloceanspaces.com/deploy-to-do/do-btn-blue.svg" alt="Deploy to DO button"></a>
</p>

For a longer term installation, however, you should fork this repository so that you're able to better customize your templates and other static files.
## About

Librarian is a stateless CMS based on static files. It was built mainly for users who want to create a home for their dev.to posts, or for users who want to create and host their content using a similar format, without dealing with databases and authentication.

* No database
* No sessions
* No users

Librarian supports content written in Markdown with an optional front-matter section for metadata, using the same front-matter format from DEV.

Liquid tags supported at the moment:

* Twitter (embeds a Tweet)
* YouTube (embeds YouTube video)
* GitHub (embeds Gist or Tree File)

Librarian **is not** a static site generator, and the idea is to provide a mix of static files and dynamic capabilities that don't require sessions or databases.
It facilitates contributing via GitHub, so it's great for documentation in general.

## Installation

PHP (command-line) and Composer are required to bootstrap a new Librarian project.

```command
composer create-project minicli/librarian myblog
```

Once the dependencies are installed, you can run Librarian with the built-in PHP server:

```command
cd myblog
php -S 0.0.0.0:8000 -t web/
```

Then you can access the app from your browser at `http://localhost:8000`.

To import DEV posts, first edit the `config.php` file to include your own DEV username, then run:

```command
php librarian import:devto
```

More docs coming soon.