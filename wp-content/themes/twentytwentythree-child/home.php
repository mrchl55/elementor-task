<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('product-gallery', get_stylesheet_directory_uri()
        . '/styles/home.css',);
});
add_action('wp_head', function () {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';

});
get_header();

?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'post_status' => 'publish'
            );
            $query = new WP_Query($args);
            if ($query->have_posts()):
            ?>
            <div class="products-wrapper">

                <?php
                while ($query->have_posts()): $query->the_post();
                    $ID = get_the_ID();
                    $title = get_the_title();
                    $main_image = get_the_post_thumbnail_url();
                    $is_on_sale = get_post_meta($ID, '_product_is_on_sale', true);
                    ?>
                    <div class="single-product <?php echo($is_on_sale ? 'on-sale' : '') ?>">
                        <a href="<?php echo get_the_permalink() ?>">
                            <div class="single-product__image"><img src="<?php echo $main_image; ?>"/></div>
                            <p class="single-product__title"><?php echo $title; ?></p>

                        </a>
                    </div>

                <?php
                endwhile;
                echo '</div>';
                wp_reset_postdata();
                else:{
                    ?>
                    <div class="no-products">
                        No products to display.
                    </div>
                    <?php
                }
                endif;

                ?>


        </main>
    </div>

<?php get_footer(); ?>