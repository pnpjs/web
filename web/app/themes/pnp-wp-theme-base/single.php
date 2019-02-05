<?php get_header(); ?>

<div id="primary" class="content-area">
	<div class="primary-inner">
		<div id="content" class="site-content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'single' ); ?>
				<?php pnp_content_nav( 'nav-below' ); ?>
				<?php dw_minion_related_post($post->ID); ?>
				<?php if ( comments_open() ) comments_template(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>
				<nav class="nav-single">
					<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
				</nav>
				<?php comments_template( '', true ); ?>
			<?php endwhile; ?>
		</div>
	</div>
</div>

<?php get_sidebar('secondary'); ?>

<?php get_footer(); ?>
