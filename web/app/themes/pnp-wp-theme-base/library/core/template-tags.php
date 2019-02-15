<?php

/**
 * Custom template tags for this theme.
 * Eventually, some of the functionality here could be replaced by core features.
 */

if ( ! function_exists( 'pnp_content_nav' ) ) {
	function pnp_content_nav( $nav_id ) {
		global $wp_query, $post;

		if ( is_single() ) {
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous )
				return;
		}

		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
			return;

		$nav_class = ( is_single() ) ? 'post-navigation pager' : 'paging-navigation pager';

		?>
		<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<?php if ( is_single() ) : ?>

			<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav btn">' . _x( '<i class="icon-chevron-left"></i>', 'Previous post link', 'dw-minion' ) . '</span> <span class="pager-title">%title</span>' ); ?>
			<?php next_post_link( '<div class="nav-next">%link</div>', '<span class="meta-nav btn">' . _x( '<i class="icon-chevron-right"></i>', 'Next post link', 'dw-minion' ) . '</span><span class="pager-title">%title</span>' ); ?>

		<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?>

			<div class="nav-previous">
				<?php if ( get_next_posts_link() ) : ?>
					<?php next_posts_link( __( '<span class="meta-nav btn"><i class="icon-chevron-left"></i></span>', 'dw-minion' ) ); ?>
				<?php else: ?>
					<span class="btn disabled"><i class="icon-chevron-left"></i></span>
				<?php endif; ?>
			</div>

			<div class="nav-next">
				<?php if ( get_previous_posts_link() ) : ?>
					<?php previous_posts_link( __( '<span class="meta-nav btn"><i class="icon-chevron-right"></i></span>', 'dw-minion' ) ); ?>
				<?php else: ?>
					<span class="btn disabled"><i class="icon-chevron-right"></i></span>
				<?php endif; ?>
			</div>


		<?php endif; ?>

		</nav>
		<?php
	}
}

if ( ! function_exists( 'pnp_comment' ) ) {
	function pnp_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php _e( 'Pingback:', 'dw-minion' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'dw-minion' ), '<span class="edit-link">', '</span>' ); ?>
			</div>

		<?php else : ?>

		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, 60 ); ?>
						<?php printf( __( '%s', 'dw-minion' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</div>

					<div class="comment-metadata">
						<a class="comment-datetime" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<i class="icon-time"></i>
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'dw-minion' ), get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php edit_comment_link( __( '<i class="icon-pencil"></i> Edit', 'dw-minion' ), '<span class="edit-link">', '</span>' ); ?>
					</div>

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'dw-minion' ); ?></p>
					<?php endif; ?>
				</footer>

				<div class="comment-content">
					<?php comment_text(); ?>
				</div>

				<span class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'reply_text' => '<i class="icon-reply"></i> Reply' ,'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</span>
			</article>

		<?php
		endif;
	}
}

if ( ! function_exists( 'pnp_category_entry_meta' ) ) {
    function pnp_category_entry_meta() {
        if ( 'post' != get_post_type() || has_post_format('link') ) return false;
        echo '<div class="entry-meta">';

        if ( ! has_post_format('quote') ) {
            $categories_list = get_the_category_list( __( ', ', 'dw-minion' ) );

            if( 'gallery' == get_post_format() ) {
                $post_format_icon = 'icon-picture';
            } else if ( 'video' == get_post_format() ) {
                $post_format_icon = 'icon-facetime-video';
            } else if ( 'quote' == get_post_format() ) {
                $post_format_icon = 'icon-quote-left';
            } else if ( 'link' == get_post_format() ) {
                $post_format_icon = 'icon-link';
            } else {
                $post_format_icon = 'icon-file-text';
            }

            printf( __( '<span class="sep"><span class="post-format"><i class="%1$s"></i></span></span>', 'dw-minion' ), $post_format_icon );
        }

        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() )
        );

        printf( __( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark"><i class="icon-calendar-empty"></i> %3$s</a></span>', 'dw-minion' ),
            esc_url( get_permalink() ),
            esc_attr( get_the_time() ),
            $time_string
        );

        echo '</div>';
    }
}

if ( ! function_exists( 'pnp_entry_meta' ) ) {
	function pnp_entry_meta() {
		if ( 'post' != get_post_type() || has_post_format('link') ) return false;
		echo '<div class="entry-meta">';

		if ( ! has_post_format('quote') ) {
			printf( __( '<span class="byline">By <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span></span>', 'dw-minion' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'dw-minion' ), get_the_author() ) ),
				esc_html( get_the_author() )
			);

			$categories_list = get_the_category_list( __( ', ', 'dw-minion' ) );
			if ( $categories_list )
				printf( __( '<span class="cat-links"> in %1$s</span>', 'dw-minion' ), $categories_list );

			if( 'gallery' == get_post_format() ) {
				$post_format_icon = 'icon-picture';
			} else if ( 'video' == get_post_format() ) {
				$post_format_icon = 'icon-facetime-video';
			} else if ( 'quote' == get_post_format() ) {
				$post_format_icon = 'icon-quote-left';
			} else if ( 'link' == get_post_format() ) {
				$post_format_icon = 'icon-link';
			} else {
				$post_format_icon = 'icon-file-text';
			}

			printf( __( '<span class="sep"><span class="post-format"><i class="%1$s"></i></span></span>', 'dw-minion' ), $post_format_icon );
		}

		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		printf( __( '<span class="posted-on"><a href="%1$s" title="%2$s" rel="bookmark"><i class="icon-calendar-empty"></i> %3$s</a></span>', 'dw-minion' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			$time_string
		);

		if ( ! post_password_required() && comments_open() ) { ?>
			<span class="comments-link"><?php comments_popup_link( __( '<i class="icon-comment-alt"></i> 0 Comment', 'dw-minion' ), __( '<i class="icon-comment-alt"></i> 1 Comment', 'dw-minion' ), __( '<i class="icon-comment-alt"></i> % Comments', 'dw-minion' ) ); ?></span>
		<?php }

		echo '</div>';
	}
}

if ( ! function_exists( 'pnp_paging_nav' ) ) :
    /**
     * Display navigation to next/previous set of posts when applicable.
     *
     * @return void
     */
    function pnp_paging_nav() {
        // Don't print empty markup if there's only one page.
        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
            return;
        }
        global $wp_query;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        ?>
        <nav class="pagination navigation paging-navigation" role="navigation">
            <div class="nav-links">
                <?php if ( get_next_posts_link() ) : ?>
                <div class="older-posts"><?php next_posts_link( __( 'Older Posts <span class="meta-nav">&rarr;</span>', 'casper' ) ); ?></div>
                <?php endif; ?>
                    <div class="page-number"><?php printf( __( 'Page', 'casper' ).' %1$s '.__( 'of', 'casper' ).' %2$s', $paged, $wp_query->max_num_pages ); ?></div>
                <?php if ( get_previous_posts_link() ) : ?>
                <div class="newer-posts"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Newer Posts', 'casper' ) ); ?></div>
                <?php endif; ?>

            </div><!-- .nav-links -->
        </nav><!-- .navigation -->
        <?php
    }
endif;

if ( ! function_exists( 'pnp_post_nav' ) ) :
    /**
     * Display navigation to next/previous post when applicable.
     *
     * @return void
     */
    function pnp_post_nav() {
        // Don't print empty markup if there's nowhere to navigate.
        $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
        $next     = get_adjacent_post( false, '', false );

        if ( ! $next && ! $previous ) {
            return;
        }
        global $wp_query;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        ?>
        <nav class="pagination navigation post-navigation" role="navigation">
            <div class="nav-links">
                <?php
                    previous_post_link( '<div class="older-posts">%link</div>', _x( '%title <span class="meta-nav">&rarr;</span>', 'Previous post link', 'casper' ) ); ?>
                    <div class="page-number">&bull;</div>
                    <?php next_post_link(     '<div class="newer-posts">%link</div>',     _x( '<span class="meta-nav">&larr;</span> %title', 'Next post link',     'casper' ) );
                ?>
            </div><!-- .nav-links -->
        </nav><!-- .navigation -->
        <?php
    }
endif;

if ( ! function_exists( 'pnp_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function pnp_posted_on() {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            //$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );

        printf( __( '<span class="posted-on">%1$s</span><span class="byline"> by %2$s</span>', 'casper' ),
            sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
                esc_url( get_permalink() ),
                $time_string
            ),
            sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                esc_html( get_the_author() )
            )
        );
    }
endif;


function pnp_related_post($post_id) {
	$tags = wp_get_post_tags($post_id);
	if ($tags) {
		$tag_ids = array();
		foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
		$args = array (
			'tag__in' => $tag_ids,
			'post__not_in' => array($post_id),
			'posts_per_page' => 5,
			'ignore_sticky_posts'=>1
		);
	} else {
		$args = array (
			'post__not_in' => array($post_id),
			'posts_per_page' => 5,
			'ignore_sticky_posts'=>1
		);
	} ?>

	<?php $related_query = new wp_query( $args ); ?>
		<?php if ( $related_query->have_posts() ) : ?>
		<div class="related-posts">
			<h2 class="related-posts-title"><?php _e( 'Related Articles.', 'pnp' ); ?></h2>
			<div class="related-content">
				<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
				<article class="related-post clearfix">
					<h3 class="related-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					<div class="related-meta"><time class="related-date"><?php echo get_the_date('d M, Y'); ?></time></div>
				</article>
				<?php endwhile; ?>
			</div>
		</div>
		<?php endif; ?>
	<?php wp_reset_query(); ?>
<?php }



/**
 * Returns true if a blog has more than 1 category.
 */
function pnp_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so pnp_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so pnp_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in pnp_categorized_blog.
 */
function pnp_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'pnp_category_transient_flusher' );
add_action( 'save_post',     'pnp_category_transient_flusher' );
