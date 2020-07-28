
<?php if(!cfg('SITE__NO_NAV')) { ?>

<nav id="site-navigation" class="u-NavSite u-NavSite__main">
	<a class="menu-toggle" href="#menu" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'vassar' ); ?></a>
	
	<div id="menu" class="menu__container">
		<a class="menu-close" href="#">Close menu</a>
		<?php
		wp_nav_menu( array(
			'theme_location' => 'menu-1',
			'menu_id'        => 'primary-menu',
		) );
		?>
	</div>

</nav><!-- #site-navigation -->

<nav class="u-NavSite u-NavSite__secondary" id="s-navigation" tabindex="-1" aria-hidden="true">

<?php

wp_nav_menu( array(
  'menu'     => 'Main Navigation',
  'sub_menu' => true,
  'container_class' => 'menu-subnav-container',
  'menu_id' => '',
  'menu_class' => 'u-NavSite__level--2',
) );

?>

</nav>

<?php } ?>

