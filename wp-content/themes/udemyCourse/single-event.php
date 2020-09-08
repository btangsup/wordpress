<?php get_header();

    while(have_posts()) {
        the_post(); 
        pageBanner();
        ?>

        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p><a href="<?php echo site_url('/event');?>" class="metabox__blog-home-link"><i class="fa fa-home"></i>Event Home</a><span class="metabox__main"><?php the_title();?></span></p>
            </div>
            <div class="generic-content">
                <?php the_content();?>
            </div>
                <?php
                    $relatedPrograms = get_field('related_programs'); //what this field returns is an array

                    if ($relatedPrograms) {
                        echo '<hr class="section-break">';
                        echo '<h2 class="headLine headLine--medium">Related Program(s)</h2>';
                        echo '<ul class="link-list min-list">';
                        foreach($relatedPrograms as $program) { ?> 
                            <li><a href="<?php echo get_the_permalink($program);?>"><?php echo get_the_title($program);?></a></li>
                        <?php }
                        // this for each loop runs through the array and returns a single variable, we loop through it and display it on the front end
                        echo '</ul>';
                    }
                ?>
            
        </div>
    <?php }

    get_footer();
?>