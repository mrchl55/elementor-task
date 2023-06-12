<?php

class Product
{

    public function __construct()
    {
//        if ($product->post_type !== 'product') {
//            throw new Error('Not a product instance');
//        }
        add_action('init', array($this, 'add_product_cpt'));
        add_action('admin_init', array($this, 'register_meta_boxes'));
        add_action('save_post', array($this, 'save'));
        add_action('admin_footer', array($this, 'wpdocs_theme_name_scripts'));

    }

    function add_product_cpt()
    {
        register_post_type('product',
            array(
                'labels' => array(
                    'name' => __('Products', 'textdomain'),
                    'singular_name' => __('product', 'textdomain'),
                ),
                'public' => true,
                'has_archive' => true,
                'supports' => array('title', 'excerpt', 'thumbnail', 'custom-fields')

            )
        );
        $labels = array(
            'name' => _x('Categories', 'taxonomy general name'),
            'singular_name' => _x('Category', 'taxonomy singular name'),
            'search_items' => __('Search Category'),
            'all_items' => __('All Categories'),
            'parent_item' => __('Parent Categories'),
            'parent_item_colon' => __('Parent Category:'),
            'edit_item' => __('Edit Category'),
            'update_item' => __('Update Category'),
            'add_new_item' => __('Add New Category'),
            'new_item_name' => __('New Category Name'),
            'menu_name' => __('Categories'),
        );

        register_taxonomy('category', 'product', array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'subject'),
        ));
    }

    function register_meta_boxes()
    {
        add_meta_box(
            '_product_gallery',
            __('product gallery', 'product'),
            array($this, 'render_gallery_meta_box'),
            'product',
            'advanced',
            'high',

        );
        add_meta_box(
            '_product_price',
            __('Price', 'product'),
            array($this, 'render_price_meta_box'),
            'product',
            'advanced',
            'high'
        );
        add_meta_box(
            '_product_sale_price',
            __('Sale Price', 'product'),
            array($this, 'render_sale_price_meta_box'),
            'product',
            'advanced',
            'high'
        );
        add_meta_box(
            '_product_is_on_sale',
            __('Is on sale?', 'product'),
            array($this, 'render_is_on_sale_meta_box'),
            'product',
            'advanced',
            'high'
        );
        add_meta_box(
            '_product_yt_video',
            __('Youtube Video', 'product'),
            array($this, 'render_yt_video_meta_box'),
            'product',
            'advanced',
            'high'
        );

    }

    public function render_price_meta_box($post)
    {

        wp_nonce_field('product_custom_box', 'product_custom_box_nonce');

        // Use get_post_meta to retrieve an existing value from the database.
        $price = get_post_meta($post->ID, '_product_price', true);

        // Display the form, using the current value.
        ?>
        <label for="price_field">
            <?php _e('Price in $', 'textdomain'); ?>
        </label>


        <input style="width:100%" class="form-control" type="number"
               name="price_field" value="<?php echo esc_attr($price); ?>"/>

        <?php
    }

    public function render_sale_price_meta_box($post)
    {

        // Add an nonce field so we can check for it later.
        wp_nonce_field('product_custom_box', 'product_custom_box_nonce');

        // Use get_post_meta to retrieve an existing value from the database.
        $sale_price = get_post_meta($post->ID, '_product_sale_price', true);

        // Display the form, using the current value.
        ?>

        <label for="sale_price_field">
            <?php _e('Sale price in $', 'textdomain'); ?>
        </label>

        <input style="width:100%" class="form-control" type="number"
               name="sale_price_field" value="<?php echo esc_attr($sale_price); ?>"/>

        <?php
    }

    public function render_yt_video_meta_box($post)
    {

        // Add an nonce field so we can check for it later.
        wp_nonce_field('product_custom_box', 'product_custom_box_nonce');

        // Use get_post_meta to retrieve an existing value from the database.
        $yt_video = get_post_meta($post->ID, '_product_yt_video', true);

        // Display the form, using the current value.
        ?>

        <label for="yt_video_field">
            <?php _e('Youtube Video URL', 'textdomain'); ?>
        </label>

        <input style="width:100%" class="form-control"
               name="yt_video_field" value="<?php echo esc_attr($yt_video); ?>"/>

        <?php
    }

    public function render_is_on_sale_meta_box($post)
    {
        wp_nonce_field('product_custom_box', 'product_custom_box_nonce');
        $is_on_sale = get_post_meta($post->ID, '_product_is_on_sale', true);

        ?>

        <label for="is_on_sale_field">
            <?php _e('Check if prouct is on sale', 'textdomain'); ?>
        </label>

        <input class="form-control" type="checkbox"
               name="is_on_sale_field" <?php echo $is_on_sale ? 'checked' : ''; ?>>

        <?php
    }

    public function render_gallery_meta_box($post)
    {
        wp_nonce_field('product_custom_box', 'product_custom_box_nonce');
        $post_id = $post->ID;
        ?>

        <ul class="product-gallery">
            <?php
            $image_ids = ($image_ids = get_post_meta($post_id, '_product_gallery', true)) ? explode(',', $image_ids) : array();

            foreach ($image_ids as $i => &$id) {
                $url = wp_get_attachment_image_url($id, array(80, 80));
                if ($url) {
                    ?>
                    <li data-id="<?php echo $id ?>">
                        <span style="background-image:url('<?php echo $url ?>')"></span>
                        <a href="#" class="product-gallery-remove">&times;</a>
                    </li>
                    <?php
                } else {
                    unset($image_ids[$i]);
                }
            }
            ?>
        </ul>

        <input type="hidden" name="gallery_field" value="<?php echo join(',', $image_ids) ?>"/>
        <!--        <input type="hidden" name="gallery_field" value="--><?php //echo $image_ids
        ?><!--" />-->
        <a href="#" class="button product-upload-button">Add Images</a>

        <?php
    }

    function wpdocs_theme_name_scripts()
    {
        wp_enqueue_style('product-gallery', get_stylesheet_directory_uri()
            . '/product/styles/product-gallery.css',);
        wp_enqueue_media();
        wp_register_script('product-gallery', get_stylesheet_directory_uri()
            . '/product/js/product-gallery.js', array('jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-sortable'), '2.0.0', true);
        wp_enqueue_script('product-gallery');
        wp_register_script('url-validate', get_stylesheet_directory_uri()
            . '/product/js/url-validate.js', array('jquery'), '2.0.0', true);
        wp_enqueue_script('url-validate');
    }

    public function save($post_id)
    {


        if (!isset($_POST['product_custom_box_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['product_custom_box_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'product_custom_box')) {
            return $post_id;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
        }


        $price = sanitize_text_field($_POST['price_field']);
        $sale_price = sanitize_text_field($_POST['sale_price_field']);
        $is_on_sale = $_POST['is_on_sale_field'];
        $gallery = $_POST['gallery_field'];
        $yt_video = sanitize_text_field($_POST['yt_video_field']);
//        if (!empty($yt_video) && filter_var($yt_video, FILTER_VALIDATE_URL) === FALSE) {
//            return $post_id;
//        }
        update_post_meta($post_id, '_product_price', $price);
        update_post_meta($post_id, '_product_sale_price', $sale_price);
        update_post_meta($post_id, '_product_is_on_sale', $is_on_sale);
        update_post_meta($post_id, '_product_gallery', $gallery);
        update_post_meta($post_id, '_product_yt_video', $yt_video);
    }
}

new Product();