# Librarian
_This is an experimental project._

Librarian is a stateless CMS based on static files. It was built mainly for users who want to create a home for their dev.to posts, or for users who want to create and host their content using a similar format, without dealing with databases and authentication.

* No database
* No sessions
* No users

Librarian supports content written in Markdown with an optional front-matter section for metadata, which can be accessed from anywhere in the templates. This allows for great flexibility when customizing templates and content types.

Liquid tags supported at the moment:

* Twitter (embeds a Tweet)
* YouTube (embeds YouTube video)
* GitHub (embeds Gist or Tree File)

Librarian **is not** a static site generator, and the idea is to provide a mix of static files and dynamic capabilities that don't require sessions or databases.
It facilitates contributing via GitHub, so it's great for documentation in general.

## Installation

PHP (command-line) and Composer are required to bootstrap a new Librarian project.

```shell
composer create-project librarianphp/librarian myblog
```

Once the dependencies are installed, you can run Librarian with the built-in PHP server:

```shell
cd myblog
php -S 0.0.0.0:8000 -t web/
```

Then you can access the app from your browser at `http://localhost:8000`.

To import DEV posts, first edit the `config.php` file to include your own DEV username, then run:

```shell
php librarian import:devto
```

To customize the views, you'll need to be able to compile CSS assets and that requires `npm` running at least on your development machine. Otherwise you won't have access to all the Tailwind has to offer!

To compile the CSS assets, run:

```shell
npm run dev
```

More documentation coming.

