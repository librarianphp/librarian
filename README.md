# Librarian
Librarian is a stateless CMS based on static files. It uses the same format as DEV.to for markdown files with a front matter and liquid tags for custom functionality.
The front matter is fluid and doesn't have a fixed spec, meaning you can include any custom fields you want and fetch them from your templates.

![Librarian default index page screenshot](https://librarianphp.dev/img/librarian_default_page.png)

Librarian doesn't use databases, sessions, or users. Administration is made from the command-line.
For multiple authors, author information must be defined as metadata within the front matter.

This is an **experimental** project built to keep content decoupled from the application itself, while keeping a very low footprint and functioning as a middle ground between static sites and dynamic CMSs.

Liquid tags supported at the moment:

| Tag | Example | Description |
|-----|---------|-------------|
| `audio` | `{% audio path_to_mp3.mp3 %}` | embeds mp3 audio |
| `video` | `{% video path_to_mp4.mp4 %}` | embeds mp4 video |
| `twitter` | `{% twitter tweet_id %}` | embeds a Tweet |
| `youtube` | `{% youtube video_ID %}` | embeds a YouTube video |
| `github` | `{% github file_url %}` | embeds File from Github (Gists aren't supported at the moment) |

Librarian **is not** a static site generator, and the idea is to provide a mix of static files and dynamic capabilities that don't require sessions or databases.

## Using the included Docker Compose setup

The latest Librarian version includes a built-in Docker + Docker Compose setup.

Once the files are in place, you can get the environment up and running with:

```shell
docker-compose up -d
```

This will run the containers in background.

To execute commands such as `composer install`, run:

```shell
docker-compose exec app composer install
```

Running NPM:

```shell
docker-compose exec app npm install
```

Compiling css assets:

```shell
docker-compose exec app npm run dev
```

Stopping the environment:

```shell
docker-compose stop
```

Re-starting the environment:

```shell
docker-compose start
```

Destroying the environment:

```shell
docker-compose down
```

## Documentation

The official documentation is available at https://librarianphp.dev. It is by no means complete, more content will be added as soon as possible.
You can [contribute to Librarian's documentation via GitHub](https://github.com/librarianphp/librarian-docs).

## Projects Using Librarian

- [sponsoropensource.dev](https://sponsoropensource.dev) - A list of underrepresented open source creators that can be sponsored via GitHub Sponsors.
- [Librarian Documentation](https://librarianphp.dev) - The official Librarian documentation, built with Librarian.
