<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('product-gallery', get_stylesheet_directory_uri()
        . '/styles/single-product.css',);
});

get_header();

echo do_shortcode('[product_box id="38" bg_color="red" custom_output="hehe"]');
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
            $yt_video = get_post_meta($ID, '_product_yt_video', true);
            function getYoutubeEmbedUrl($url)
            {
                $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
                $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

                if (preg_match($longUrlRegex, $url, $matches)) {
                    $youtube_id = $matches[count($matches) - 1];
                }

                if (preg_match($shortUrlRegex, $url, $matches)) {
                    $youtube_id = $matches[count($matches) - 1];
                }
                return 'https://www.youtube.com/embed/' . $youtube_id;
            }

            ?>
            <div class="single-product__wrapper <?php echo($is_on_sale ? 'on-sale' : '') ?>">
                <div class="single-product__image"><img
                            src="<?php echo $main_image ?: get_stylesheet_directory_uri() . '/images/nophoto.jpg'; ?>"/>
                </div>
                <h2 class="single-product__title"><?php echo $title; ?></h2>
                <div class="single-product__description">
                    <p> <?php echo $description; ?></p>
                    <?php if (!empty($yt_video)):

                        $yt_video_embed = getYoutubeEmbedUrl($yt_video);
                        ?>
                        <iframe width="400px" height="300px" src="<?php echo $yt_video_embed; ?>"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                    <?php
                    endif;
                    ?>
                </div>
                <div class="single-product__price"><?php echo $price; ?>$</div>
                <?php
                if (!empty($sale_price)):
                    ?>
                    <div class="single-product__sale-price">Now only <?php echo $sale_price; ?>$</div>

                <?php
                endif;
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
                <?php
                $terms = get_the_terms($ID, 'category', 'string');
                $term_ids = wp_list_pluck($terms, 'term_id');
                $related_posts_query = new WP_Query(array(
                    'post_type' => 'product',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'id',
                            'terms' => $term_ids,
                            'operator' => 'IN'
                        )),
                    'posts_per_page' => 3,
                    'ignore_sticky_posts' => 1,
                    'orderby' => 'rand',
                    'post__not_in' => array($ID)
                ));

                if ($related_posts_query->have_posts()) {
                    ?>
                    <h4>You also may like</h4>
                    <div class="single-product__related-products">
                        <?php
                        while ($related_posts_query->have_posts()) : $related_posts_query->the_post();
                            $related_post_ID = get_the_ID();
                            $related_post_title = get_the_title();
                            $related_post_link = get_the_permalink();
                            $related_post_main_image = get_the_post_thumbnail_url();
                            ?>
                            <div class="single-product__related-product">
                                <?php if (!empty($related_post_main_image)) { ?>
                                    <a href="<?php echo $related_post_link ?>"
                                       title="<?php echo $related_post_title; ?>"> <img
                                                src="<?php echo $related_post_main_image; ?>"/> </a>
                                <?php } else { ?>
                                    <a href="<?php echo $related_post_link; ?>"
                                       title="<?php echo $related_post_title; ?>"><?php echo $related_post_title; ?></a>
                                <?php } ?>
                            </div>
                        <?php endwhile;
                        wp_reset_query();
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>

        </main>
    </div>

<?php get_footer(); ?>