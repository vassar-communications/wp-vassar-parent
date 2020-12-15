Dec 15, 2020 - v-1.1
====================

* archive.php
** Changed some classnames to match the other templates
** Added the nav.

archive.php is one of these pages where I'm wondering if the entire thing can be replaced with simply including index.php. archive.php does have code for redirecting archive pages to the main page, so that should be kept, but currently we're dealing with two different templates that I have to make sure are the same.


* header.php
** Added wp_body_open() hook

* single.php
** Added vassarparent__before_header hook

* index.php
** Added vassarparent__before_header hook



Nov 30, 2020 - v-1.0.3
======================

* functions.php
	** Removed aforementioned priority of 100000 on the the_content filter. I had a priority set on the Dropdownizer filter; removed that, and the vassar-parent priority, and everything runs in its proper order.


Nov 30, 2020 - v-1.0.2
======================

* functions.php
	** Added a priority of 100000 to the the_content filter. Unintuitively, this means a *lower* priority; the idea is to make sure the_content runs last.
	
	This is because I have a plugin, Dropdownizer, that parses blocks. Dropdownizer relies on WordPress's parse_blocks() function to pick out the individual Gutenberg blocks on a page; Dropdownizer then identifies any group with a class of "dropdown" and modifies the content. 
	
	However, Dropdownizer *has* to have the raw post content with all the block designations still in place. WP grabs the post content and then renders all the blocks, removing those block designations (the special WP HTML comments) which means that by the time you call the the_content variable that you'd usually use when filtering WordPress content, there aren't any block designations left for parse_blocks() to parse. parse_blocks() can't find any blocks.
	
	So Dropdownizer can't accept the_content. It has to pull unmodified post content straight from the post object. It then reads the blocks from it, and modifies those as needed.
	
	However, what happened was the following:

	- the filters in vassar_parent's functions.php were applied first: post content was scanned, phone numbers were linked, FAQs got formatted, etc.
	- but then the Dropdownizer plugin ran. It wasn't accepting the modified content from the parent theme's functions.php, for the reasons I mentioned above; it was grabbing the unmodified post content straight from the post, doing its thing, and then returning the content. So it was wiping out - well, overriding - the modified content from the theme's filter.

	In order to fix that, I had to make sure the plugin filter ran *first*. That way, the plugin gets the raw post content, still with all the block designations. It runs through that, modifies the blocks as needed, and then returns the modified content, at which point the functions.php file in vassar-parent takes over and does its thing.
	
	** I noticed that, for some reason, the FAQ system started missing straight quotes. Maybe that's because it's accepting modified content from the plugin. In any case, I had to add another search-and-replace rule to functions: $content = str_replace("'", "’", $content);



Nov 10, 2020 - v-1.0.1
======================

* header.php: Fixed bug where I was using the wrong function to pull in the featured image for the page banner. Wasn't throwing an error, but the image wasn't showing up.


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


