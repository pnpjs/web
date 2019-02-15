<?php
/**
 * Adds custom classes to the array of body classes.
 */
function pnp_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'pnp_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function pnp_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	$title .= get_bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'dw-minion' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'pnp_wp_title', 10, 2 );

/**
 * Display Logo
 */
function pnp_logo() {
  $header_display = (pnp_get_theme_option( 'header_display', 'site_title') == 'site_title') ? 'display-title' : 'display-logo';
  $logo = pnp_get_theme_option( 'logo' );
  $tagline = pnp_get_theme_option( 'about', get_bloginfo( 'description' ) );

  echo '<h1 class="site-title '.$header_display.'"><a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" rel="home">';
  if ($header_display == 'display-logo') {
    echo '<img alt="'.esc_attr( get_bloginfo( 'name', 'display' ) ).'" src="'.$logo.'" />';
  } else {
    echo get_bloginfo( 'name' );
  }
  echo '</a></h1>';

  echo '<h2 class="site-description">'.$tagline.'</h2>';
}

/**
 * Site Actions
 */
add_action('after_navigation', 'pnp_site_actions');
function pnp_site_actions() {
  $social_links['facebook'] = pnp_get_theme_option( 'facebook', '' );
  $social_links['twitter'] = pnp_get_theme_option( 'twitter', '' );
  $social_links['google_plus'] = pnp_get_theme_option( 'google_plus', '' );
  $social_links['youtube'] = pnp_get_theme_option( 'youtube', '' );
  $social_links['linkedin'] = pnp_get_theme_option( 'linkedin', '' );
  ?>
        <div id="actions" class="site-actions clearfix">
            <div class="action show-site-nav">
                <i class="icon-reorder"></i>
            </div>

            <div class="clearfix actions">
                <div class="action search">
                    <form onsubmit="doSearch(this.searchTerm.value); return false;" class="action searchform">
                        <input type="text" placeholder="Search" id="s" name="s" class="search-query">
                        <label for="s"></label>
                    </form>
                </div>

                <a class="back-top action" href="#page"><i class="icon-chevron-up"></i></a>

                <?php ?>

                <div class="action socials">
                    <i class="icon-link active-socials"></i>
                    <?php if(count($social_links) > 0 ) { ?><ul class="unstyled list-socials clearfix" style="width: <?php echo count($social_links)*40; ?>px;">
                        <?php if($social_links['facebook']!='') { ?><li class="social"><a href="<?php echo $social_links['facebook']; ?>"><i class="icon-facebook"></i></a></li><?php } ?>
                        <?php if($social_links['twitter']!='') { ?><li class="social"><a href="<?php echo $social_links['twitter']; ?>"><i class="icon-twitter"></i></a></li><?php } ?>
                        <?php if($social_links['google_plus']!='') { ?><li class="social"><a href="<?php echo $social_links['google_plus']; ?>"><i class="icon-google-plus"></i></a></li><?php } ?>
                        <?php if($social_links['youtube']!='') { ?><li class="social"><a href="<?php echo $social_links['youtube']; ?>"><i class="icon-youtube"></i></a></li><?php } ?>
                        <?php if($social_links['linkedin']!='') { ?><li class="social"><a href="<?php echo $social_links['linkedin']; ?>"><i class="icon-linkedin"></i></a></li><?php } ?>
                    </ul><?php } ?>
                </div>
            </div>
        </div>
<?php }

/**
 * Filters post_gallery to display gallery as carousel.
 */

add_filter( 'post_gallery', 'pnp_post_gallery', 10, 2 );
function pnp_post_gallery( $output, $attr) {
  global $post, $wp_locale;

  static $instance = 0;
  $instance++;

  if ( isset( $attr['orderby'] ) ) {
      $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
      if ( !$attr['orderby'] )
          unset( $attr['orderby'] );
  }

  extract(shortcode_atts(array(
      'order'      => 'ASC',
      'orderby'    => 'menu_order ID',
      'id'         => $post->ID,
      'itemtag'    => 'div',
      'icontag'    => 'div',
      'captiontag' => 'div',
      'columns'    => 3,
      'size'       => array(620,350),
      'include'    => '',
      'exclude'    => ''
  ), $attr));

  $id = intval($id);
  if ( 'RAND' == $order )
      $orderby = 'none';

  if ( !empty($include) ) {
      $include = preg_replace( '/[^0-9,]+/', '', $include );
      $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

      $attachments = array();
      foreach ( $_attachments as $key => $val ) {
          $attachments[$val->ID] = $_attachments[$key];
      }
  } elseif ( !empty($exclude) ) {
      $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
      $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  } else {
      $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
  }

  if ( empty($attachments) )
      return '';

  if ( is_feed() ) {
      $output = "\n";
      foreach ( $attachments as $att_id => $attachment )
          $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
      return $output;
  }

	$itemtag = tag_escape($itemtag);
	$selector = "carousel-{$instance}";
	$captiontag = tag_escape($captiontag);

  $output = "<div class='entry-gallery'>";

	$output .= "<div id='{$selector}' class='carousel slide carousel-{$id}'>";

	$output .= "<ol class='carousel-indicators'>";
	$j = 0;
  foreach ( $attachments as $id => $attachment ) {
  	$itemclass = ($j==0) ? 'active' : '';
  	$output .= "<li class='{$itemclass}' data-slide-to='{$j}' data-target='#{$selector}'></li>";
  	$j++;
  }
  $output .= "</ol>";

	$i = 0;
  $output .= "<div class='carousel-inner'>";
  foreach ( $attachments as $id => $attachment ) {
  	$itemclass = ($i==0) ? 'item active' : 'item';
  	$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

  	$output .= "<{$itemtag} class='{$itemclass}'>";
  	$output .= "
      <{$icontag} class='carousel-icon'>
        $link
      </{$icontag}>";

  	if ( $captiontag && trim($attachment->post_excerpt) ) {
      $output .= "
        <{$captiontag} class='carousel-caption'>
        " . wptexturize($attachment->post_excerpt) . "
        </{$captiontag}>";
    }
  	$output .= "</{$itemtag}>";
  	$i++;
  }
  $output .= "</div>";
  $output .= "<a data-slide='prev' href='#{$selector}' class='carousel-control left'><i class='icon-chevron-left'></i></a>";
  $output .= "<a data-slide='next' href='#{$selector}' class='carousel-control right'><i class='icon-chevron-right'></i></a>";

  $output .= "</div>";
  $output .= "</div>";
  return $output;
}

/**
 * Remove #more Anchor from Permalinks
 */
add_filter('the_content_more_link', 'remove_more_jump_link');
function remove_more_jump_link($link) {
  $offset = strpos($link, '#more-');
  if ($offset) { $end = strpos($link, '"',$offset); }
  if ($end) { $link = substr_replace($link, '', $offset, $end-$offset); }
  return $link;
}

/**
 * Custom functions that act independently of the theme templates
 * Eventually, some of the functionality here could be replaced by core features
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function casper_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'casper_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function casper_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'casper_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function casper_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'casper' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'casper_wp_title', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function casper_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'casper_setup_author' );
