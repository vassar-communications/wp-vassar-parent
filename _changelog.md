
July 6, 2020 - v0.2
===================




June 10, 2020 - v0.1
====================

* Added back "single.php"
* Added back "archive.php". This was so I could add a config variable, SITE__REDIRECT_ARCHIVES_TO_HOME. 
* Added cfg var, SITE__REDIRECT_ARCHIVES_TO_HOME. This means that if someone hits an archive page, they will be bounced to the site homepage rather than seeing the archive.
* Added the following to functions.php:
	* socialcard. This generates og: tags for Facebook and Twitter.
	* modify_read_more_link(). Allows customization of the text for "read more" links on posts.
	* code for cfg var SITE__HAS_ADMIN_CSS. If set, adds a custom "admin.css" stylesheet to the WP admin area.

* Added updated Google Analytics/tag manager code
* Added a CSS variable, --site-header-image. If a header image is set for the site, it's accessible here.
* Added cfg var BLOG__SOMETHING_ELSE_FOR_HP_PAGINATION. Lets you specify something less out-of-date-sounding for the "Older posts" pagination item on the homepage.


