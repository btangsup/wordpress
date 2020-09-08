<?php

get_header();

while(have_posts()) {
the_post();
pageBanner();
?>

<div class="container container--narrow page-section">

    <?php

    $theParent = wp_get_post_parent_id(get_the_ID());

        if ($theParent) { ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a href="<?php echo get_permalink($theParent);?>" class="metabox__blog-home-link"><i class="fa fa-home"></i>Back to <?php echo get_the_title($theParent);?></a><span class="metabox__main"><?php the_title();?></span></p>
        </div>
        <?php  }
    ?>
</div>


<?php
$testArray = get_pages(array(
    'child of' => get_the_ID()
));
if ($theParent or $testArray)  {?>


<div class="page-links">
    <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent);?>"><?php echo get_the_title($theParent);?></a></h2>
    <ul class="min-list">
        <?php

            if($theParent) {
                $findChildrenOf = $theParent;
            } else {
                $findChildrenOf = get_the_ID();
            }

            wp_list_pages(array(
                'title_li' => NULL,
                'child_of' => $findChildrenOf,
                'sort_column' => 'menu_order'

            ));
        ?>
    </ul>
</div>

        <?php } ?>


<div class="generic-content">
    <?php the_content();?>
</div>


<?php }

get_footer();

?>