<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('product-gallery', get_stylesheet_directory_uri()
        . '/styles/single-product.css',);
});

get_header();

?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php
            $ID = get_the_ID();
            $title = get_the_title();
            $description = get_the_excerpt();
            $main_image = get_the_post_thumbnail_url();
            $price = get_post_meta($ID, '_product_price', true);
            $sale_price = get_post_meta($ID, '_product_sale_price', true);
            $is_on_sale = get_post_meta($ID, '_product_is_on_sale', true);
            $gallery = get_post_meta($ID, '_product_gallery', true);
            var_dump($main_image);
            ?>
            <div class="single-product__wrapper <?php echo($is_on_sale ? 'on-sale' : '') ?>">
                <div class="single-product__image"><img
                            src="<?php echo $main_image ?: get_stylesheet_directory_uri() . '/images/nophoto.jpg'; ?>"/>
                </div>
                <h2 class="single-product__title"><?php echo $title; ?></h2>
                <div class="single-product__description"><?php echo $description; ?></div>
                <div class="single-product__price"><?php echo $price; ?></div>
                <div class="single-product__sale-price"><?php echo $sale_price; ?></div>
                <?php
                $image_ids = ($image_ids = get_post_meta($ID, '_product_gallery', true)) ? explode(',', $image_ids) : array();
                if (!empty($image_ids)):
                ?>

                <div class="single-product__gallery">
                    <?php
                    foreach ($image_ids as $i => &$id) {
                        $url = wp_get_attachment_image_url($id, array(80, 80));
                        if ($url) {
                            ?>
                            <div class="single-product__gallery--single">
                                <img src="<?php echo $url ?>"/>
                            </div>
                            <?php
                        } else {
                            unset($image_ids[$i]);
                        }
                    }

                    endif;
                    ?>
                </div>

            </div>

        </main>
    </div>

<?php get_footer(); ?>