Apr 15, 2025 - v-1.8
======================

## functions.php
* Dequeued some stylesheets
* Added an extra font size to the Gutenberg styles

Aug 28, 2023 - v-1.7
======================

## inc/template-tags.php
* Added a custom field for the description meta tag. If this is present, it's used; if not, the excerpt is used instead.


July 18, 2023 - v-1.6.5
======================

## functions.php
* Commented out: `$content = str_replace("'", "’", $content);` Megg noticed that this was causing problems on Gravity Forms.


Oct 11, 2022 - v-1.6.4
======================

## sidebar.php
* Commented out the aside widget area


Oct 11, 2022 - v-1.6.3
======================

## template-parts/content.php
* Removed some weird gremlin characters that suddenly started breaking the site (back-end server config change, maybe?)

June 1, 2021 - v-1.6.2
======================

## 404.php
* Removed squirrel image


June 1, 2021 - v-1.6.1
======================

## functions.php
* Added small font size to editor font-size list
* Added a hack to undo international phone numbers getting auto-linked twice

## header.php
* Added a check for a `vpress__no-sidebar` custom field to make sure the `no-subnav` class can be manually applied
* Added `$post->ID` to `has_post_thumbnail()`; I think the `has-post-thumbnail` class may not have been applied otherwise.

## template-parts/content.php
* Added support for a `no-summary` field applied to blogposts, where a user can make sure a post doesn't display a summary when it appears in a listing.



Apr 15, 2021 - v-1.5.1
======================

## header.php
* Moved the Google Tag Manager code up, past wp_body_open() and the $site_header stuff, right after the opening body tag, since I realized it should come immediately after the tag.
* Added accessibility code: CSS for visually hiding links, and then revealing them on focus (when the user tabs to them); and links that jump to the content and nav. This CSS is inline; I don't normally do that, but this should be on every page, and should be a standard part of all themes, so it belongs in the parent theme.

## index.php
* added a `vassarparent__after_entryContent` hook right before the end `</main>` tag.

## single.php
* added a `vassarparent__after_entryContent` hook right before the end `</main>` tag.

## archive.php
* added a `vassarparent__after_entryContent` hook right before the end `</main>` tag.

## _changelog.md
* Adjusted the format slightly


Mar 11, 2021 - v-1.4
====================

## functions.php
* Added a function to get the root parent of a page, so I can add its slug as a class in the HTML tag. This means that if you wanted to apply specific styling to any section's child page, no matter how far down it is, you can do that.
* (Mar 24) In the FAQ formatting section, I now have it check to see not only if a page has FAQ in its title, but also if the `has-index` meta field has been applied to the page. There are two ways to generate TOCs now; the original way, which auto-generated them for FAQs pages, and a more general-purpose way implemented in the PageTOC plugin I wrote later. PageTOC allows one to add a TOC to any page via the `has-index` meta field, regardless of whether it's an FAQ page or not. The issue is that if I removed the first way, there are a lot of FAQ pages without `has-index` that would lose their TOCs; we'd have to go back through and add them back. So I left both methods in place. However, Beth had a page that had both the "FAQ" in its title and the `has-index` meta field, and the scripts were conflicting, generating two different TOCs. So I now have the first method check to see if a page already has a TOC specified before generating one.

## header.php
* Via the aforementioned get_root_parent() function, added the root parent's slug to the HTML tag.

## search.php
* I removed the get_post_type() parameter from get_template_part() because it was causing problems with search results for pages. The entire page was appearing in the results, as opposed to results for posts, which displayed excerpts, and the page titles were h1s, not h2s, which breaks the outline hierarchy. All search result items should look the same. I might add back get_post_type() as a cfg option in the future if I see a need for it.


Feb 22, 2021 - v-1.3.1
======================

## header.php
* Bug: cfg('SITE__HIDE_TAGLINE') was checking to see if it was *not* false; if it wasn't false, it displayed the tagline. Changed condition check to (cfg('SITE__HIDE_TAGLINE') !== true).
* Added config variable and code for Typekit markup

## inc/template-tags.php
* In vassar_entry_meta(), replaced the hardcoded comma delimiters for lists of tags and categories with two cfg variables, POST__CAT_DELIMITER and POST__TAG_DELIMITER. If unspecified, a comma is used.



Feb 19, 2021 - v-1.2
====================

## functions.php
* In filter_the_content_in_the_main_loop(), adjusted the regex for matching phone numbers, so numbers will be linked even if an en or em dash is used instead of a hyphen. Beth noticed that one of the offices had a number with an en dash, so it wasn't being linked. (All matched dashes will be replaced with hyphens.)


Dec 15, 2020 - v-1.1
====================

## archive.php
* Changed some classnames to match the other templates
* Added the nav.

archive.php is one of these pages where I'm wondering if the entire thing can be replaced with simply including index.php. archive.php does have code for redirecting archive pages to the main page, so that should be kept, but currently we're dealing with two different templates that I have to make sure are the same.


## header.php
* Added wp_body_open() hook

## single.php
* Added vassarparent__before_header hook

## index.php
* Added vassarparent__before_header hook



Nov 30, 2020 - v-1.0.3
======================

## functions.php
* Removed aforementioned priority of 100000 on the the_content filter. I had a priority set on the Dropdownizer filter; removed that, and the vassar-parent priority, and everything runs in its proper order.


Nov 30, 2020 - v-1.0.2
======================

## functions.php
* Added a priority of 100000 to the the_content filter. Unintuitively, this means a *lower* priority; the idea is to make sure the_content runs last.

	This is because I have a plugin, Dropdownizer, that parses blocks. Dropdownizer relies on WordPress's parse_blocks() function to pick out the individual Gutenberg blocks on a page; Dropdownizer then identifies any group with a class of "dropdown" and modifies the content.

	However, Dropdownizer *has* to have the raw post content with all the block designations still in place. WP grabs the post content and then renders all the blocks, removing those block designations (the special WP HTML comments) which means that by the time you call the the_content variable that you'd usually use when filtering WordPress content, there aren't any block designations left for parse_blocks() to parse. parse_blocks() can't find any blocks.

	So Dropdownizer can't accept the_content. It has to pull unmodified post content straight from the post object. It then reads the blocks from it, and modifies those as needed.

	However, what happened was the following:

	- the filters in vassar_parent's functions.php were applied first: post content was scanned, phone numbers were linked, FAQs got formatted, etc.
	- but then the Dropdownizer plugin ran. It wasn't accepting the modified content from the parent theme's functions.php, for the reasons I mentioned above; it was grabbing the unmodified post content straight from the post, doing its thing, and then returning the content. So it was wiping out - well, overriding - the modified content from the theme's filter.

	In order to fix that, I had to make sure the plugin filter ran *first*. That way, the plugin gets the raw post content, still with all the block designations. It runs through that, modifies the blocks as needed, and then returns the modified content, at which point the functions.php file in vassar-parent takes over and does its thing.

* I noticed that, for some reason, the FAQ system started missing straight quotes. Maybe that's because it's accepting modified content from the plugin. In any case, I had to add another search-and-replace rule to functions: $content = str_replace("'", "’", $content);



Nov 10, 2020 - v-1.0.1
======================

## header.php
* Fixed bug where I was using the wrong function to pull in the featured image for the page banner. Wasn't throwing an error, but the image wasn't showing up.


Oct 14, 2020 - v-1.0.0
======================

## VERSIONING
* switching to SemVer.

## header.php: Added option where it checks the child theme includes folder for something
## functions.php
* $child_path was formerly the specific path to the _config.php file. I changed that variable to $child_cfg_file, so $child_path could be a more generic path to the child theme directory (it's just get_stylesheet_directory()).
* Added variables for $site_header and $site_footer. These are paths to two files in the child theme: header_markup.php and footer_markup.php. These files are optional; I'm using them for the universal header and footer on Offices. (The plugin I was using - the one that used the buffer technique to grab all the page markup and insert the markup at the beginning and end of it - that conflicted with another plugin.)

## header.php
* added include for header_markup.php

## footer.php
* added include for footer_markup.php


July 28, 2020 - v-3
===================

## functions.php
* FAQS
	* Added a classname to the top link
	* Fixed a problem where if someone added a straight apostrophe to an FAQ title, the link didn't work; the search-and-replace was failing because I was looking for ’ and WordPress converts apostrophes to the HTML entity, not ’ directly. So I now search for the curly-quote HTML entity and replace it with ’.
	* Tightened up the iterating-over-the-content mechanism. Formerly I had it generate a DOMDoc, scan for h3s, add them to an array, and then iterate over the array; now it doesn't add the h3s to an array and scans only once.

## header.php
* Added cfg var SITE__HIDE_TAGLINE to show or hide the tagline
* Added inline styling to make the page featured image available as a CSS variable.

## inc/template-tags.php
* vassar_socialcard():
	* changed is_single() to is_singular(). is_single() resolves to false when called on a page, and as a result, pages were being treated as if they were the homepage; the Twitter and Facebook cards were displaying the wrong info.
	* vassar_posted_on() - There was a glitch where the "posted on" label container encompassed the entire date so you couldn't target the label. Fixed.

## template-parts/content-page.php
* It used to display any featured images by default; I added a cfg() var, PAGE__HIDE_FEATURED_IMG, to turn this off.

## 404.php
* Removed the standard WordPress cruft, added the language and Google search from the standard Vassar 404 page, and even included that nice picture of a squirrel. (It is a squirrel, not a skunk.)


## inc/nav
* Added container for menu toggle text ///explain


July 6, 2020 - v-2
==================

## inc/navigation.php (NEW).
* Contains all menu code.
## index.php
* Added link to close open nav menu.
* Removed nav code, replaced with include that brings in inc/navigation.php

## functions.php
* FAQ code: Changed "FAQs" to "FAQ" (the string it searches for to determine whether a page gets FAQ formatting)

## single.php
* Removed "unused-" prefix from filename
* Adjusted template code to match index.php

## template-parts/content.php
* Fixed a bug where single blog posts would display an excerpt instead of the full post.



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
