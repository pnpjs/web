<?php
//search.php
//index.php
?>
<?php get_header(); ?>

	<div id="primary" class="content-area">
		<div class="primary-inner">
			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'dw-minion' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>
			<div id="content" class="site-content content-list" role="main">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					get_template_part( 'content', 'search' );
				endwhile;
				pnp_content_nav( 'nav-below' );
			else :
				get_template_part( 'no-results', 'search' );
			endif; ?>
		<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>
				<?php twentytwelve_content_nav( 'nav-above' ); ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>
				<?php twentytwelve_content_nav( 'nav-below' ); ?>
				<?php else : ?>
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>
					</header>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentytwelve' ); ?></p>
						<?php get_search_form(); ?>
					</div>
				</article>
				<?php endif; ?>

			</div>
		</div>
	</div>

<?php get_sidebar('secondary'); ?>
<?php get_footer(); ?>
