Oct 14, 2020 - v-1.0.0
======================

* VERSIONING: switching to SemVer.
* header.php: Added option where it checks the child theme includes folder for something
* functions.php
	** $child_path was formerly the specific path to the _config.php file. I changed that variable to $child_cfg_file, so $child_path could be a more generic path to the child theme directory (it's just get_stylesheet_directory()).
	** Added variables for $site_header and $site_footer. These are paths to two files in the child theme: header_markup.php and footer_markup.php. These files are optional; I'm using them for the universal header and footer on Offices. (The plugin I was using - the one that used the buffer technique to grab all the page markup and insert the markup at the beginning and end of it - that conflicted 
	)
* header.php: added include for header_markup.php
* footer.php: added include for footer_markup.php


July 28, 2020 - v-3
===================

* functions.php
	** FAQS
		*** Added a classname to the top link
		*** Fixed a problem where if someone added a straight apostrophe to an FAQ title, the link didn't work; the search-and-replace was failing because I was looking for ’ and WordPress converts apostrophes to the HTML entity, not ’ directly. So I now search for the curly-quote HTML entity and replace it with ’.
		*** Tightened up the iterating-over-the-content mechanism. Formerly I had it generate a DOMDoc, scan for h3s, add them to an array, and then iterate over the array; now it doesn't add the h3s to an array and scans only once.

* header.php
	** Added cfg var SITE__HIDE_TAGLINE to show or hide the tagline
	** Added inline styling to make the page featured image available as a CSS variable.

* inc/template-tags.php
	** vassar_socialcard():
		*** changed is_single() to is_singular(). is_single() resolves to false when called on a page, and as a result, pages were being treated as if they were the homepage; the Twitter and Facebook cards were displaying the wrong info.
	** vassar_posted_on() - There was a glitch where the "posted on" label container encompassed the entire date so you couldn't target the label. Fixed.

* template-parts/content-page.php
	** It used to display any featured images by default; I added a cfg() var, PAGE__HIDE_FEATURED_IMG, to turn this off.

* 404.php
	** Removed the standard WordPress cruft, added the language and Google search from the standard Vassar 404 page, and even included that nice picture of a squirrel. (It is a squirrel, not a skunk.)


* inc/nav
	** Added container for menu toggle text ///explain


July 6, 2020 - v-2
==================

* NEW - inc/navigation.php. Contains all menu code.
* index.php
	** Added link to close open nav menu.
	** Removed nav code, replaced with include that brings in inc/navigation.php
* functions.php
	** FAQ code: Changed "FAQs" to "FAQ" (the string it searches for to determine whether a page gets FAQ formatting)

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


