
July 6, 2020 - v-2
==================

* NEW - inc/navigation.php. Contains all menu code.
* index.php
	** Added link to close open nav menu.
	** Removed nav code, replaced with include that brings in inc/navigation.php
* functions.php
	** FAQ code: Changed "FAQs" to "FAQ" (the string it searches for to determine whether a page gets FAQ formatting)
* _changelog.md
	** Switched from 0.1 to v-1. Version will wind up in the high numbers pretty quickly, but I think that's okay. I don't want to spend time - at least not right now - thinking about what's a major-number release vs a minor-number release; the versioning is just an indicator that tells me approximately how old a particular installation of this is. All I need is a number, and I think the standard versioning system doesn't apply here, requires more thought than is warranted, and may even be misleading.

* single.php
	** Removed "unused-" prefix from filename
	** Adjusted template code to match index.php

* template-parts/content.php
	** Fixed a bug where single blog posts would display an excerpt instead of the full post.



June 10, 2020 - v-1
===================

* Added back "single.php"
* Added back "archive.php". This was so I could add a config variable, SITE__REDIRECT_ARCHIVES_TO_HOME. 
* Added cfg var, SITE__REDIRECT_ARCHIVES_TO_HOME. This means that if someone hits an archive page, they will be bounced to the site homepage rather than seeing the archive.
* Added the following to functions.php:
	** socialcard. This generates og: tags for Facebook and Twitter.
	** modify_read_more_link(). Allows customization of the text for "read more" links on posts.
	** code for cfg var SITE__HAS_ADMIN_CSS. If set, adds a custom "admin.css" stylesheet to the WP admin area.

* Added updated Google Analytics/tag manager code
* Added a CSS variable, --site-header-image. If a header image is set for the site, it's accessible here.
* Added cfg var BLOG__SOMETHING_ELSE_FOR_HP_PAGINATION. Lets you specify something less out-of-date-sounding for the "Older posts" pagination item on the homepage.


