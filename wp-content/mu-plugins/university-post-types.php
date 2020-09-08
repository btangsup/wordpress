<?php



function university_post_types() {
    //event post type
    register_post_type('event', array(
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true, // creates an archive to show a page containing all the events
        'public' => true, // public makes it available to client and dev
        'menu_icon' => 'dashicons-calendar-alt',  //visit dashicons to obtain a custom wordpress icon
        'labels' => array(
            'name' => 'Events', // this parameter names the event
            'add_new_item' => 'Add New Event', // controls the title of the custom post type
            'edit_item' => 'Edit Event', // edit item parameter controls the naming convention of "edit ___"
            'all_items' => 'All Events', 
            'singular_name' => 'Event', // singular name events

        ),

    )); //wordpress function that will register a custom post type

    // programs post type

    register_post_type('program', array(
        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'programs'),
        'has_archive' => true, // creates an archive to show a page containing all the events
        'public' => true, // public makes it available to client and dev
        'labels' => array(
            'name' => 'Programs', // this parameter names the Program
            'add_new_item' => 'Add New Program', // controls the title of the custom post type
            'edit_item' => 'Edit Program', // edit item parameter controls the naming convention of "edit ___"
            'all_items' => 'All Programs', 
            'singular_name' => 'Program', // singular name events
            
        ),
        'menu_icon' => 'dashicons-awards',  //visit dashicons to obtain a custom wordpress icon

    )); //wordpress function that will register a custom post type

    // PROFRESSOR POST TYPE
    register_post_type('professor', array(
        'show_in_rest' => true, // THIS PROPERTY WILL DISPLAY RAW JSON DATA. 'show in rest'
        'supports' => array('title', 'editor', 'thumbnail'), //add thumbnail to allow featured images in wp
        'rewrite' => array('slug' => 'professors'),
        'public' => true, // public makes it available to client and dev
        'labels' => array(
            'name' => 'Professors', // this parameter names the professor
            'add_new_item' => 'Add New Professor', // controls the title of the custom post type
            'edit_item' => 'Edit Professor', // edit item parameter controls the naming convention of "edit ___"
            'all_items' => 'All Professors', 
            'singular_name' => 'Professor', // singular name events
            
        ),
        'menu_icon' => 'dashicons-welcome-learn-more',  //visit dashicons to obtain a custom wordpress icon

    )); //wordpress function that will register a custom post type

    // CAMPUS POST TYPE
    register_post_type('campus', array(
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'campuses'),
        'has_archive' => true, // creates an archive to show a page containing all the campuss
        'public' => true, // public makes it available to client and dev
        'menu_icon' => 'dashicons-location-alt',  //visit dashicons to obtain a custom wordpress icon
        'labels' => array(
            'name' => 'Campuses', // this parameter names the campus
            'add_new_item' => 'Add New Campus', // controls the title of the custom post type
            'edit_item' => 'Edit Campus', // edit item parameter controls the naming convention of "edit ___"
            'all_items' => 'All Campuses', 
            'singular_name' => 'Campus', // singular name campuss

        ),

    )); //wordpress function that will register a custom post type

    // NOTE POST TYPE
    register_post_type('note', array(
        'show_in_rest' => true, // THIS PROPERTY WILL DISPLAY RAW JSON DATA. 'show in rest'
        'supports' => array('title', 'editor'), //add thumbnail to allow featured images in wp
        'public' => false, // make it false because its notes specific to user
        'show_ui' => true,
        'labels' => array(
            'name' => 'Notes', // this parameter names the note
            'add_new_item' => 'Add New Note', // controls the title of the custom post type
            'edit_item' => 'Edit Note', // edit item parameter controls the naming convention of "edit ___"
            'all_items' => 'All Notes', 
            'singular_name' => 'Note', // singular name events
            
        ),
        'menu_icon' => 'dashicons-welcome-write-blog',  //visit dashicons to obtain a custom wordpress icon

    )); //wordpress function that will register a custom post type
}

add_action('init', 'university_post_types');