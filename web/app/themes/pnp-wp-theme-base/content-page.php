<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
			<?php if ( ! is_page_template( 'page-templates/front-page.php' ) ) : ?>
			<?php the_post_thumbnail(); ?>
			<?php endif; ?>
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header>
	<div class="page-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'dw-minion' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article>