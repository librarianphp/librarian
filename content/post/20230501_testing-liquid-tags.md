---
title: Testing Liquid Tags
description: Demonstration of built-in content types
tags: example, liquidTags
created_at: 2023-05-01
cover_image: https://picsum.photos/780/300?r=5
---

A simple post demonstrating our liquid tags. Librarian has a couple basic liquid tags, and you can create custom ones for your site.

### YouTube Video

Example tag: 
```shell
 {% youtube Pfkp-lrJTWM %}
```

Rendered result:

{% youtube Pfkp-lrJTWM %}

### GitHub File
Embeds a file from a GitHub repository. Gists are not supported at this moment.

Example tag:

```shell
 {% github https://github.com/librarianphp/librarian/blob/main/.php-cs-fixer.php %}
```

Rendered result:
{% github https://github.com/librarianphp/librarian/blob/main/.php-cs-fixer.php %}
