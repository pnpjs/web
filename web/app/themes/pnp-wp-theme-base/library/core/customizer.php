<?php

include_once ABSPATH . 'wp-includes/class-wp-customize-control.php';

/**
 * Adds textarea support to the theme customizer
 */
class Pnp_Textarea_Custom_Control extends WP_Customize_Control {
    public $type = 'textarea';

    public $statuses;

    public function __construct( $manager, $id, $args = array() ) {

    $this->statuses = array( '' => __( 'Default', 'pnp' ) );
        parent::__construct( $manager, $id, $args );
    }

    public function render_content() {
        ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <textarea class="large-text" cols="20" rows="5" <?php $this->link(); ?>>
                    <?php echo esc_textarea( $this->value() ); ?>
                </textarea>
            </label>
        <?php
    }
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function pnp_customize_register( $wp_customize ) {

    // section pnp_theme_options
    // 关于
    $wp_customize->add_setting('pnp_theme_options[about]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
    $wp_customize->add_control( new Pnp_Textarea_Custom_Control($wp_customize, 'about', array(
        'label'      => __('About', 'pnp'),
        'section'    => 'title_tagline',
        'settings'   => 'pnp_theme_options[about]',
    )));

    // logo
    $wp_customize->add_setting('pnp_theme_options[logo]', array(
        'capability' => 'edit_theme_options',
        'type' => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'logo', array(
        'label' => __('Site Logo', 'pnp'),
        'section' => 'title_tagline',
        'settings' => 'pnp_theme_options[logo]',
    )));

    // 显示头部
    $wp_customize->add_setting('pnp_theme_options[header_display]', array(
        'default'        => 'site_title',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
    $wp_customize->add_control( 'header_display', array(
        'settings' => 'pnp_theme_options[header_display]',
        'label'   => 'Display as',
        'section' => 'title_tagline',
        'type'    => 'select',
        'choices'    => array(
            'site_title' => 'Site Title',
            'site_logo' => 'Site Logo',
        ),
    ));

    // custom
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('background_color')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'refresh';

    // Logo Controls
	$wp_customize->add_section( 'casper_logo_section' , array(
	    'title'       => __( 'Logo', 'casper' ),
	    'priority'    => 30,
	    'description' => 'Upload a logo to display above the site title on each page',
	) );
	$wp_customize->add_setting( 'casper_logo'  , array(
	    'transport'   => 'refresh',
	    'sanitize_callback' => 'casper_sanitize_uri'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'casper_logo', array(
	    'label'    => __( 'Logo', 'casper' ),
	    'section'  => 'casper_logo_section',
	    'settings' => 'casper_logo',
    ) ) );

	// Custom Controls
	$wp_customize->add_section(
	    'casper_custom',
	    array(
	        'title'     => 'Casper Options',
	        'priority'  => 200
	    )
	);
	// Theme header bg color
	$wp_customize->add_setting( 'casper_header_color' , array(
	    'default'     => '#303538',
	    'transport'   => 'postMessage',
	    'sanitize_callback' => 'casper_sanitize_color'
	) );
	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'header_color',
	        array(
	            'label'      => __( 'Header Color', 'casper' ),
	            'section'    => 'colors',
	            'settings'   => 'casper_header_color'
	        )
	    )
    );

	// Home head text color
	$wp_customize->add_setting( 'casper_header_textcolor' , array(
	    'default'     => '#50585D',
	    'transport'   => 'postMessage',
	    'sanitize_callback' => 'casper_sanitize_color'
	) );
	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'casper_header_textcolor',
	        array(
	            'label'      => __( 'Page Header Text Color', 'casper' ),
	            'section'    => 'colors',
	            'settings'   => 'casper_header_textcolor',
	        )
	    )
    );

	// Theme link color
	$wp_customize->add_setting( 'casper_link_color' , array(
	    'default'     => '#4a4a4a',
	    'transport'   => 'postMessage',
	    'sanitize_callback' => 'casper_sanitize_color'
	) );
	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'link_color',
	        array(
	            'label'      => __( 'Link Color', 'casper' ),
	            'section'    => 'colors',
	            'settings'   => 'casper_link_color'
	        )
	    )
    );

	// Theme hover color
	$wp_customize->add_setting( 'casper_hover_color' , array(
	    'default'     => '#57A3E8',
	    'transport'   => 'refresh',
	    'sanitize_callback' => 'casper_sanitize_color'
	) );
	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'hover_color',
	        array(
	            'label'      => __( 'Hover Color', 'casper' ),
	            'section'    => 'colors',
	            'settings'   => 'casper_hover_color'
	        )
	    )
    );

	// Home Menu color
	$wp_customize->add_setting( 'casper_home_menu_color' , array(
	    'default'     => '#ffffff',
	    'transport'   => 'refresh',
	    'sanitize_callback' => 'casper_sanitize_color'
	) );
	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'home_menu_color',
	        array(
	            'label'      => __( 'Home Menu Color', 'casper' ),
	            'section'    => 'colors',
	            'settings'   => 'casper_home_menu_color'
	        )
	    )
    );

	// Menu color
	$wp_customize->add_setting( 'casper_menu_color' , array(
	    'default'     => '#50585D',
	    'transport'   => 'refresh',
	    'sanitize_callback' => 'casper_sanitize_color'
	) );
	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'menu_color',
	        array(
	            'label'      => __( 'Menu Color', 'casper' ),
	            'section'    => 'colors',
	            'settings'   => 'casper_menu_color'
	        )
	    )
	);

	// Display header bg on all pages (vs home only)
	$wp_customize->add_setting(
	    'casper_display_header',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'casper_sanitize_checkbox'
	    )
	);
	$wp_customize->add_control(
	    'casper_display_header',
	    array(
	    	'priority'	=> 1,
	        'section'   => 'casper_custom',
	        'label'     => 'Only display header background on home page',
	        'type'      => 'checkbox'
	    )
    );

	// Display header on all pages (vs home only)
	$wp_customize->add_setting(
	    'casper_display_header_all',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'casper_sanitize_checkbox'
	    )
	);
	$wp_customize->add_control(
	    'casper_display_header_all',
	    array(
	    	'priority'	=> 2,
	        'section'   => 'casper_custom',
	        'label'     => 'Only display header on home page',
	        'type'      => 'checkbox'
	    )
    );

	// Circle logo
	$wp_customize->add_setting(
	    'casper_logo_circle',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'casper_sanitize_checkbox'
	    )
	);
	$wp_customize->add_control(
	    'casper_logo_circle',
	    array(
	    	'priority'	=> 3,
	        'section'   => 'casper_custom',
	        'label'     => 'Make logo circular',
	        'type'      => 'checkbox'
	    )
    );

	// Frame logo
	$wp_customize->add_setting(
	    'casper_logo_frame',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'casper_sanitize_checkbox'
	    )
	);
	$wp_customize->add_control(
	    'casper_logo_frame',
	    array(
	    	'priority'	=> 4,
	        'section'   => 'casper_custom',
	        'label'     => 'Frame logo image',
	        'type'      => 'checkbox'
	    )
    );

	// Casper hide page header dot
	$wp_customize->add_setting(
	    'casper_hide_page_header_dot',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'casper_sanitize_checkbox'
	    )
	);
	$wp_customize->add_control(
	    'casper_hide_page_header_dot',
	    array(
	    	'priority'	=> 5,
	        'section'   => 'casper_custom',
	        'label'     => 'Hide header \'dot\' on pages',
	        'type'      => 'checkbox'
	    )
    );

	// Automatically limit post summary
	$wp_customize->add_setting(
	    'casper_auto_excerpt',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'casper_sanitize_checkbox'
	    )
	);
	$wp_customize->add_control(
	    'casper_auto_excerpt',
	    array(
	    	'priority'	=> 6,
	        'section'   => 'casper_custom',
	        'label'     => 'Auto-limit summary length',
	        'type'      => 'checkbox'
	    )
    );

	// Don't display Categories
	$wp_customize->add_setting(
	    'casper_hide_categories',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'casper_sanitize_checkbox'
	    )
	);
	$wp_customize->add_control(
	    'casper_hide_categories',
	    array(
	    	'priority'	=> 7,
	        'section'   => 'casper_custom',
	        'label'     => 'Don\'t display categories',
	        'type'      => 'checkbox'
	    )
    );

	// Don't display Tags
	$wp_customize->add_setting(
	    'casper_hide_tags',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'casper_sanitize_checkbox'
	    )
	);
	$wp_customize->add_control(
	    'casper_hide_tags',
	    array(
	    	'priority'	=> 8,
	        'section'   => 'casper_custom',
	        'label'     => 'Don\'t display tags',
	        'type'      => 'checkbox'
	    )
    );

	// Don't display Dates
	$wp_customize->add_setting(
	    'casper_hide_dates',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'casper_sanitize_checkbox'
	    )
	);
	$wp_customize->add_control(
	    'casper_hide_dates',
	    array(
	    	'priority'	=> 9,
	        'section'   => 'casper_custom',
	        'label'     => 'Don\'t display dates',
	        'type'      => 'checkbox'
	    )
    );

	// Custom meta
	$wp_customize->add_setting(
        'casper_custom_meta' ,
        array(
            'sanitize_callback' => 'casper_sanitize_meta'
        )
    );
	$wp_customize->add_control(
	    new Pnp_Textarea_Custom_Control(
	        $wp_customize,
	        'casper_custom_meta',
	        array(
	            'label' => 'Custom meta tags',
	            'section' => 'casper_custom',
	            'settings' => 'casper_custom_meta'
	        )
	    )
	);

	// Custom read more link
    $wp_customize->add_setting(
        'casper_read_more_link',
        array(
            'sanitize_callback' => 'casper_sanitize_text'
        )
    );
	$wp_customize->add_control(
	    new Pnp_Textarea_Custom_Control(
	        $wp_customize,
	        'casper_read_more_link',
	        array(
	            'label' => '\'Read More\' link',
	            'section' => 'casper_custom',
	            'settings' => 'casper_read_more_link'
	        )
	    )
	);

	// Custom footer
    $wp_customize->add_setting(
        'casper_custom_footer',
        array(
            'sanitize_callback' => 'casper_sanitize_footer'
        )
    );
	$wp_customize->add_control(
	    new Pnp_Textarea_Custom_Control(
	        $wp_customize,
	        'casper_custom_footer',
	        array(
	            'label' => 'Custom footer',
	            'section' => 'casper_custom',
	            'settings' => 'casper_custom_footer'
	        )
	    )
	);






    // 社交账号设置
    $wp_customize->add_section('pnp_social_links', array(
        'title'    => __('Social Links', 'pnp'),
        'priority' => 110,
    ));
    // 社交账号设置详情
    $wp_customize->add_setting('pnp_theme_options[facebook]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
    $wp_customize->add_control('facebook', array(
        'label'      => __('Facebook', 'pnp'),
        'section'    => 'pnp_social_links',
        'settings'   => 'pnp_theme_options[facebook]',
    ));
    $wp_customize->add_setting('pnp_theme_options[twitter]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
    $wp_customize->add_control('twitter', array(
        'label'      => __('Twitter', 'pnp'),
        'section'    => 'pnp_social_links',
        'settings'   => 'pnp_theme_options[twitter]',
    ));
    $wp_customize->add_setting('pnp_theme_options[google_plus]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
    $wp_customize->add_control('google_plus', array(
        'label'      => __('Google+', 'pnp'),
        'section'    => 'pnp_social_links',
        'settings'   => 'pnp_theme_options[google_plus]',
    ));
    $wp_customize->add_setting('pnp_theme_options[youtube]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
    $wp_customize->add_control('youtube', array(
        'label'      => __('YouTube', 'pnp'),
        'section'    => 'pnp_social_links',
        'settings'   => 'pnp_theme_options[youtube]',
    ));
    $wp_customize->add_setting('pnp_theme_options[linkedin]', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
    ));
    $wp_customize->add_control('linkedin', array(
        'label'      => __('LinkedIn', 'pnp'),
        'section'    => 'pnp_social_links',
        'settings'   => 'pnp_theme_options[linkedin]',
    ));


    // 社交账号配置
	$wp_customize->add_section('casper_social', array(
        'title'     => 'Social URLs',
        'priority'  => 199
    ));
    // 社交账号配置详情
    $wp_customize->add_setting('casper_social_behance', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'casper_sanitize_uri'
    ));
	$wp_customize->add_control('casper_social_behance', array(
        'section' => 'casper_social',
        'label' => 'Behance',
        'type' => 'text'
    ));
	$wp_customize->add_setting('casper_social_bitbucket', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'casper_sanitize_uri'
    ));
	$wp_customize->add_control('casper_social_bitbucket', array(
        'section' => 'casper_social',
        'label' => 'Bitbucket',
        'type' => 'text'
    ));
	$wp_customize->add_setting('casper_social_codepen', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'casper_sanitize_uri'
    ));
	$wp_customize->add_control('casper_social_codepen', array(
        'section' => 'casper_social',
        'label' => 'CodePen',
        'type' => 'text'
    ));
	$wp_customize->add_setting('casper_social_deviantart', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'casper_sanitize_uri'
    ));
    $wp_customize->add_control('casper_social_deviantart', array(
        'section' => 'casper_social',
        'label' => 'Deviant Art',
        'type' => 'text'
    ));
    $wp_customize->add_setting('casper_social_dribbble', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'casper_sanitize_uri'
    ));
	$wp_customize->add_control('casper_social_dribbble', array(
        'section' => 'casper_social',
        'label' => 'Dribbble',
        'type' => 'text'
    ));
	$wp_customize->add_setting('casper_social_facebook', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'casper_sanitize_uri'
    ));
	$wp_customize->add_control('casper_social_facebook', array(
        'section' => 'casper_social',
        'label' => 'Facebook',
        'type' => 'text'
    ));
	$wp_customize->add_setting('casper_social_flickr', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'casper_sanitize_uri'
    ));
	$wp_customize->add_control('casper_social_flickr', array(
        'section' => 'casper_social',
        'label' => 'Flickr',
        'type' => 'text'
    ));
	$wp_customize->add_setting('casper_social_github', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'casper_sanitize_uri'
    ));
	$wp_customize->add_control('casper_social_github', array(
        'section' => 'casper_social',
        'label' => 'GitHub',
        'type' => 'text'
    ));
	$wp_customize->add_setting('casper_social_google', array(
        'transport' => 'refresh',
        'sanitize_callback' => 'casper_sanitize_uri'
    ));
	$wp_customize->add_control('casper_social_google', array(
        'section' => 'casper_social',
        'label' => 'Google+',
        'type' => 'text'
    ));
	$wp_customize->add_setting('casper_social_instagram', array('transport' => 'refresh', 'sanitize_callback' => 'casper_sanitize_uri'));
	$wp_customize->add_control('casper_social_instagram', array('section' => 'casper_social', 'label' => 'Instagram', 'type' => 'text'));
	$wp_customize->add_setting('casper_social_lastfm', array('transport' => 'refresh', 'sanitize_callback' => 'casper_sanitize_uri'));
	$wp_customize->add_control('casper_social_lastfm', array('section' => 'casper_social', 'label' => 'LastFM', 'type' => 'text'));
	$wp_customize->add_setting('casper_social_linkedin', array('transport' => 'refresh', 'sanitize_callback' => 'casper_sanitize_uri'));
	$wp_customize->add_control('casper_social_linkedin', array('section' => 'casper_social', 'label' => 'LinkedIn', 'type' => 'text'));
	$wp_customize->add_setting('casper_social_mail', array('transport' => 'refresh', 'sanitize_callback' => 'casper_sanitize_email'));
	$wp_customize->add_control('casper_social_mail', array('section' => 'casper_social', 'label' => 'Email', 'type' => 'text'));
	$wp_customize->add_setting('casper_social_rss', array('transport' => 'refresh', 'sanitize_callback' => 'casper_sanitize_uri'));
	$wp_customize->add_control('casper_social_rss', array('section' => 'casper_social', 'label' => 'RSS', 'type' => 'text'));
	$wp_customize->add_setting('casper_social_soundcloud', array('transport' => 'refresh', 'sanitize_callback' => 'casper_sanitize_uri'));
	$wp_customize->add_control('casper_social_soundcloud', array('section' => 'casper_social', 'label' => 'SoundCloud', 'type' => 'text'));
	$wp_customize->add_setting('casper_social_stack_overflow', array('transport' => 'refresh', 'sanitize_callback' => 'casper_sanitize_uri'));
	$wp_customize->add_control('casper_social_stack_overflow', array('section' => 'casper_social', 'label' => 'Stack Overflow', 'type' => 'text'));
	$wp_customize->add_setting('casper_social_spotify', array('transport' => 'refresh', 'sanitize_callback' => 'casper_sanitize_uri'));
	$wp_customize->add_control('casper_social_spotify', array('section' => 'casper_social', 'label' => 'Spotify', 'type' => 'text'));
	$wp_customize->add_setting('casper_social_tumblr', array('transport' => 'refresh', 'sanitize_callback' => 'casper_sanitize_uri'));
	$wp_customize->add_control('casper_social_tumblr', array('section' => 'casper_social', 'label' => 'Tumblr', 'type' => 'text'));
	$wp_customize->add_setting('casper_social_twitter', array('transport' => 'refresh', 'sanitize_callback' => 'casper_sanitize_uri'));
	$wp_customize->add_control('casper_social_twitter', array('section' => 'casper_social', 'label' => 'Twitter', 'type' => 'text'));
	$wp_customize->add_setting('casper_social_website', array('transport' => 'refresh', 'sanitize_callback' => 'casper_sanitize_uri'));
	$wp_customize->add_control('casper_social_website', array('section' => 'casper_social', 'label' => 'Website', 'type' => 'text'));
	$wp_customize->add_setting('casper_social_youtube', array('transport' => 'refresh', 'sanitize_callback' => 'casper_sanitize_uri'));
	$wp_customize->add_control('casper_social_youtube', array('section' => 'casper_social', 'label' => 'Youtube', 'type' => 'text'));
}
// 主题自定义设置
add_action( 'customize_register', 'pnp_customize_register' );

function pnp_get_theme_option( $option_name, $default = '' ) {
  $options = get_option( 'pnp_theme_options' );
  if( isset($options[$option_name]) ) {
    return $options[$option_name];
  }
  return $default;
}


/**
 * Sanitize color
 */
function casper_sanitize_color($content){
	$content = str_replace('#', '', $content);
	if (ctype_xdigit($content)) {
	    return '#' . $content;
	}
	return '';
}

/**
 * Sanitize checkbox
 */
function casper_sanitize_checkbox($content){
	if('selected' === $content || 'checked' === $content || 'true' === $content || true === $content){
		return $content;
	}
	return '';
}

/**
 * Sanitize URIs
 */
function casper_sanitize_uri($uri){
	if('' === $uri){
		return '';
	}
	return esc_url_raw($uri);
}

/**
 * Sanitize Text
 */
function casper_sanitize_text($str){
	if('' === $str){
		return '';
	}
	return sanitize_text_field( $str);
}

/**
 * Sanitize email/uri
 */
function casper_sanitize_email($uri){
	if('' === $uri){
		return '';
	}
	if (substr( $uri, 0, 4 ) != 'http' && strpos($uri, '@') === false) {
		$uri = 'mailto:' . $uri;
	}
	return sanitize_email($uri);
}

/**
 * Sanitize meta
 */
function casper_sanitize_meta($content){
	$allowed = array('meta' => array());
	if('' === $content){
		return '';
	}
	return wp_kses($content, $allowed);
}

/**
 * Sanitize footer
 */
function casper_sanitize_footer($content){
	if('' === $content){
		return '';
	}
	if ( current_user_can('unfiltered_html') )
		return wp_kses($content, wp_kses_allowed_html('post'));
	else
		return stripslashes( wp_filter_post_kses( addslashes($content) ) );
}



/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function casper_customize_preview_js() {
	wp_enqueue_script( 'casper_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'jquery', 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'casper_customize_preview_js' );
