<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Vassar
 */
?>
        <div class="u-lFooter">
            <?php
            $child_footer_path = get_stylesheet_directory();
            $child_footer_path = $child_footer_path.'/assets/includes/footer.php';
            if(file_exists($child_footer_path)) include($child_footer_path);
            
            ?>
        </div>

		</div><!-- #content -->
	<!--</div> .PageContentInner -->
</div><!-- .PageContent -->


<?php 
wp_footer();
global $site_footer;
if(file_exists($site_footer)) { include($site_footer); }
?>

</body>
</html>
