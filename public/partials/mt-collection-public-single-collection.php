<?php 
get_header();
?>

<div class="container">
    <?php if(have_posts()):
            while(have_posts()):the_post(); 
            $demo_image = site_url() .'/wp-content/plugins/mt-collection/public/images/social.jpeg';
            $featured_image_url = get_the_post_thumbnail_url() ?: $demo_image;
            ?>
            <h1><?php the_title(); ?></h1>
            <figure>
                        <img src="<?php echo $featured_image_url; ?>" alt="" />
                     </figure>
            <p><?php the_content(); ?></p>
        <?php endwhile; endif;?>
</div>

<?php get_footer(); ?>



