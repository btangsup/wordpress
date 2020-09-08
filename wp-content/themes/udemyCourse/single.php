<?php get_header();

    while(have_posts()) {
        the_post();
        pageBanner();
        ?>

        <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a href="<?php echo site_url('/blog');?>" class="metabox__blog-home-link"><i class="fa fa-home"></i>Blog Home</a><span class="metabox__main"><?php the_title();?></span></p>
        </div>
            <div class="generic-content">
                <?php the_content();?>
            </div>
        </div>
        <?php
    }

get_footer();
?>