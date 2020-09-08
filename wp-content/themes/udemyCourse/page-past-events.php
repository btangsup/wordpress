<?php

get_header();
pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'A recap of our Past Events'
))
?>

    <div class="container container--narrow page-section">
    <?php
        // WHEN USING CUSTOM QUERY, PLZ DO THIS TO REPLICATE PAGINATION
        $today = date('Ymd');
            $pastEvents = new WP_Query(array(
                'paged' => get_query_var('paged', 1), // a function that calls for the current url this is needed for custom query to be able to pull data to display on page
                'post_type' => 'event',
                'meta_key' => 'event_date',
                'orderby' => 'meta_value_num', // orders it on default z-a unless specifying order
                'order' => 'ASC', // orders it in descending or ascending order
                'meta_query' => array( // this will filter out the old dates that are not UPCOMING DATES
                    array(
                        'key' => 'event_date',
                        'compare' => '<', // this specifies if the key is less than todays date, post it
                        'value' => $today,
                        'type' => 'numeric',
                    )
                )
            ));

    while($pastEvents->have_posts()) {
        $pastEvents->the_post();
        get_template_part('/template-parts/content-event');
    }
    echo paginate_links(array(
        'total' => $pastEvents->max_num_pages //this targets the total amount of pages to be paginated
    ));
?>
</div>

<?php get_footer();

?>