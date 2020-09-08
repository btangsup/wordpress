<?php get_header();

    while(have_posts()) {
        the_post();
        pageBanner();
        ?>

        <div class="container container--narrow page-section">
            <div class="metabox metabox--position-up metabox--with-home-link">
            </div>
            <div class="generic-content">
                <div class="row group">
                    <div class="one-third">
                        <?php the_post_thumbnail('professorPortrait');?>
                    </div>
                    <div class="two-thirds">
                        <?php the_content();?>
                    </div>
                </div>
            </div>
                <?php
                    $relatedPrograms = get_field('related_programs'); //what this field returns is an array

                    if ($relatedPrograms) {
                        echo '<hr class="section-break">';
                        echo '<h2 class="headLine headLine--medium">Subjects Taught</h2>';
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