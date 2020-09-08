<?php 

require get_theme_file_path('/inc/search-route.php');

function load_stylesheets() {
    wp_register_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i[Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('google-fonts');

    wp_register_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', [], 1, 'all');
    wp_enqueue_style('font-awesome');

    if (strstr($_SERVER['SERVER_NAME'], 'test.local')) {
        wp_enqueue_script('main-js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
    } else {
        
        // javascript
        wp_enqueue_script('our-vendors-js', get_theme_file_uri('/bundled-assets/vendors.js'), NULL, '1.0', true);
        wp_enqueue_script('main-js', get_theme_file_uri('/bundled-assets/scripts.js'), NULL, '1.0', true);

        wp_enqueue_style('stylesheet', get_theme_file_uri('/bundled-assets/styles'));
    }

    // this is to allow dynamic search working via locally to production
    wp_localize_script('main-js', 'universityData', array(
        'root_url' => get_site_url()
    ));

    // wp_register_style('stylesheet', get_stylesheet_uri(), [], 1, 'all');
    // wp_enqueue_style('stylesheet');

    // // javascript
    // wp_register_script('main-js', get_theme_file_uri('js/scripts-bundled.js'), NULL, '1.0', true);
    // wp_enqueue_script('main-js');
}

add_action('wp_enqueue_scripts', 'load_stylesheets');

// ADD ACTION FOR CUSTOM JSON POSTS

function university_custom_rest() {
    register_rest_field('post', 'authorName', array(
        'get_callback' => function() {return get_the_author();}
    )); // this function takes three arguments, this is needed to create unique rest fields. first field is where, second arg is name of the field, third arg is how to manage the array (requires an associative array)

    // register_rest_field('post', 'croppedImageURL', array(
    //     'get_callback' => function() {return }
    // ));
}

add_action('rest_api_init', 'university_custom_rest');

// CREATE A FUNCTION FOR DYNAMIC PAGE BANNERS 

function pageBanner($args = NULL) {
    // specifying NULL will make the $args optional
    // php logic
    if (!$args['title']) {
        $args['title'] = get_the_title(); // this logic is fallback in case no title has been provided
    }

    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!$args['image']) {
        if (get_field('page_banner_background_image')) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'];?>)"></div> 
        <!-- <?php print_r($pageBannerImage);?> PRINT R IS A GOOD DEBUGGING TOOL TO SEE WHAT THE INFO IS -->
        <!-- $pageBannerImage is an array where inside the url there is a value known as URL, thats whats placed in the square background -->
            <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle'];?></p>
            </div>
        </div>
    </div>
<?php }

// ADDING ACTION TO GENERATE A TITLE FOR EACH WEB PAGE

function university_features() {
    register_nav_menu('header-menu-location', 'Header Menu Location');
    register_nav_menu('footer-location-1', 'Footer Menu Location 1');
    register_nav_menu('footer-location-2', 'Footer Menu Location 2');
    
    add_theme_support('post-thumbnails'); // adds theme support and enables post thumbnails, but have to go an extra step to enable it for custom post types
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true); // first argument is name of custom image size, second parametres are size and boolean is whether or not it should be cropped
    add_image_size('pageBanner', 1500, 350, true);

    add_theme_support('title-tag');
}


add_action('after_setup_theme', 'university_features'); //this is for adding wordpress feature support like thumbnails, menus, etc

function university_adjust_queries($query) { //manipulated archive query
    if (!is_admin() AND is_post_type_archive('program') AND is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1); // DEFAULT POSTS PER PAGE FOR WP IS 10, setting to -1 will display no matter
    }
    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
                array(
                        'key' => 'event_date',
                        'compare' => '>=',
                        'value' => $today,
                        'type' => 'numeric',
                    )
        ));
    }
}

add_action('pre_get_posts', 'university_adjust_queries');

// redirect subscribers accounts out of admin and onto homepage

add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend() {
    $currentUser = wp_get_current_user();
    if(count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/')); // redirects user
        exit; // stop function after it redirects someone
    }
}

add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar() {
    $currentUser = wp_get_current_user();
    if(count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}

// allow redirect when clicking wp logo 
add_filter('login_headerurl', 'wpLogoRedirect');

function wpLogoRedirect() {
    return esc_url(site_url('/'));
}

// customize login screen action hook 
// in css, inspect elements and customize in the login screen

add_action('login_enqueue_scripts', 'customLoginCSS');

function customLoginCSS() {
    wp_enqueue_style('stylesheet', get_theme_file_uri('/bundled-assets/styles'));
}

add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle() {
    return get_bloginfo('name');
}



