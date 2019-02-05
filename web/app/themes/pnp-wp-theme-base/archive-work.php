<?php

global $wp_query;

$wp_query = new WP_Query("post_type=work&post_status=publish");

while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
    <h1>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h1>

    <?php
    the_content();
endwhile;

query_posts('post_type=work');
query_posts(array('post_type' => array('post', 'work')));
