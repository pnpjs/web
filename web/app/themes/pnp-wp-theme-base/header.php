<!DOCTYPE html>
<!--[if lt IE 9]>
    <html class="no-js ie lt-ie9" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>>
<![endif]-->
<!--[if gt IE 9]>
    <html class="no-js" prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>>
<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title><?php
        // @see WordPress SEO title
        if ( is_home() ) {
            bloginfo('name'); echo " - "; bloginfo('description');
        } elseif ( is_category() ) {
            single_cat_title(); echo " - "; bloginfo('name');
        } elseif (is_single() || is_page() ) {
            single_post_title();
        } elseif (is_search() ) {
            echo "搜索结果"; echo " - "; bloginfo('name');
        } elseif (is_404() ) {
            echo '页面未找到!';
        } else {
            wp_title( '|', true, 'right' );
        }
    ?></title>
    <!-- @https://www.ludou.org/wordpress-exp-1.html -->
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <!-- @see WordPress pingback   -->
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="<?php echo get_bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="<?php bloginfo('comments_rss2_url'); ?>" />
    <?php wp_head(); ?>
</head>
<?php flush(); ?>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<div class="container clearfix">
		<?php do_action( 'before' ); ?>
		<div id="navigation" class="site-nav">
			<div class="site-nav-inner">
				<div class="container">
					<header id="masthead" class="site-header" role="banner">
						<?php //dw_minion_logo(); ?>
					</header>
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
        <?php do_action( 'after_navigation' ); ?>
		<div id="main" class="site-main">
			<div class="site-main-inner">
				<div class="container clearfix">
                <?php if ( is_active_sidebar( 'top-sidebar' ) ) do_action( 'dw_minion_top_sidebar' ); ?>
