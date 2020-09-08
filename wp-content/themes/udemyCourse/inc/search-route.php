<!-- // WHY WE'D CREATE OUR OWN API RAW JSON SEARCH QUERY
// 1. custom search logic
// 2. respond with less json data
// 3. get ONE json request instead of 6 in this case (campus, posts, pages, etc.
// 4. php skillss -->

<?php
add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE, // for api, similar to 'GET'
        'callback' => 'universitySearchResults'// a function that'll return data
    )); // THIS WP FUNCTION TAKES 3 PARAMETERS (must be spelt like this). 1 is the name space of the rest name ('university'), 2 is the route. 3 is an associative array
}

function universitySearchResults($data) {
    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'page', 'professor', 'event', 'program', 'campus'), // create an array to add multiple custom search
        's' => sanitize_text_field($data['term']) // the parameter 'S' stands for search, needs this as a query to be flexible.
        // WP FUNCTION KNOWN AS SANITIZE WILL PREVENT HACKERS FROM INJECTING MALICIOUS CODE
    )); // need a variable and set it to a new instance of WP query to target json data, dont require a while loop to show data

    // create multiple arrays inside array to categorize search content

    $results = array(
        'generalInfo' => array(),
        'professors' => array(),
        'programs' => array(),
        'events' => array(),
        'campuses' => array()
    );

    while($mainQuery->have_posts()) { // do a while loop to grab all the data by looking inside variable and checking 'have_posts'
        $mainQuery->the_post(); // return data inside variable for each content
        // use get post type WP function to place data properly
        if(get_post_type() == 'post' OR get_post_type() == 'page') {
            array_push($results['generalInfo'], array( //push items into the array to view json data
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'postType' => get_post_type(), 
                'author' => get_the_author(),
            ));
        }  

        if(get_post_type() == 'professor') {
            array_push($results['professors'], array( //push items into the array to view json data
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
            ));
        }

        if(get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            $description = null; // logic for description 
            if (has_excerpt()) {
                $description = get_the_excerpt();
                } else {
                $description = wp_trim_words(get_the_content(), 10);
            }
            array_push($results['events'], array( //push items into the array to view json data
                'title' => get_the_title(),
                'url' => get_the_permalink(),
                'month' => $eventDate->format('M'),
                'day' => $eventDate-> format('d'),
                'description' => $description
            ));
        }

        if(get_post_type() == 'campus') {
            array_push($results['campuses'], array( //push items into the array to view json data
                'title' => get_the_title(),
                'url' => get_the_permalink(),
            ));
        }

        if(get_post_type() == 'program') {
            array_push($results['programs'], array( //push items into the array to view json data
                'title' => get_the_title(),
                'url' => get_the_permalink(),
            ));
        }
    }

    return $results;

}
