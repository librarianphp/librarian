# Librarian
Librarian is a static site builder and Markdown document indexer inspired by Hugo but written in PHP. It uses the same format as DEV.to for markdown files with a front matter and liquid tags for custom functionality.
The front matter is fluid and doesn't have a fixed spec, meaning you can include any custom fields you want and fetch them from your templates.

```markdown
---
title: This Is My About Page
published: true
created_at: 2023-04-01
description: Hey there! I'm Librarian, a small file-based CMS and static site generator created in PHP, on top of Minicli.
cover_image: https://picsum.photos/780/300?r=8
---

Hey there! I'm Librarian, a small file-based CMS and static site generator created in PHP, on top of Minicli. I don't use a database, I don't have a control panel, or users. Everything is pulled from static content in my content dir.
...
```
![Librarian default index page screenshot](https://librarianphp.dev/img/librarian_default_page.png)

Librarian doesn't use databases, sessions, or users. Administration is made from the command-line.
For multiple authors, author information must be defined as metadata within the front matter.

Liquid tags supported at the moment:

| Tag | Example | Description |
|-----|---------|-------------|
| `audio` | `{% audio path_to_mp3.mp3 %}` | embeds mp3 audio |
| `video` | `{% video path_to_mp4.mp4 %}` | embeds mp4 video |
| `youtube` | `{% youtube video_ID %}` | embeds a YouTube video |
| `github` | `{% github file_url %}` | embeds File from Github (Gists aren't supported at the moment) |

Check the [doc page on how to create your own custom liquid tags](https://librarianphp.dev/customizing-librarian/custom-liquid-tags/).

## Documentation

The official documentation is available at https://librarianphp.dev. You can [contribute to Librarian's documentation via GitHub](https://github.com/librarianphp/docs).

## Projects Using Librarian

- [OnLinux Systems](https://onlinux.systems) - A blog about Linux, with tutorials and hardware reviews.
- [sponsoropensource.dev](https://sponsoropensource.dev) - A list of underrepresented open source creators that can be sponsored via GitHub Sponsors.
- [Librarian Documentation](https://librarianphp.dev) - The official Librarian documentation, built with Librarian.
- Your project! Send a PR :)