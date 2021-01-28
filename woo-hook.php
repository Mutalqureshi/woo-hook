function st_product_add_to_cart_link() {
    global $woocommerce;
    global $product;
    $add_to_cart = "";
    if ($product->is_type('variable') && $product->is_in_stock()) {
        $url = get_permalink($product->get_id());
        $add_to_cart = sprintf('<a rel="nofollow" href="%s" data-quantity="1" data-product_id="%s" data-product_sku="%s" class="cartBTN2 %s">%s</a>', esc_url($url), esc_attr($product->get_id()), esc_attr($product->get_sku()), esc_attr(isset($class) ? $class : 'btn-link-atc button'), esc_html("Select options"));
    } elseif (!$product->is_type('variable') && $product->is_in_stock()) {
        $class = implode(' ', array_filter(array(
            'btn-link-atc',
            'button',
            'product_type_' . $product->get_type(),
            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
            $product->supports('ajax_add_to_cart') ? 'ajax_add_to_cart' : '',
        )));
        $price = $product->get_price();
        $add_to_cart = sprintf('<a rel="nofollow" href="%s" data-quantity="1" data-product_id="%s" data-product_sku="%s" class="cartBTN2 %s">%s</a>', esc_url($product->add_to_cart_url()), esc_attr($product->get_id()), esc_attr($product->get_sku()), esc_attr(isset($class) ? $class : 'btn-link-atc button'), esc_html($product->add_to_cart_text())
        );
    }
    return $add_to_cart;
}





------------


<?php
////////////////////////////////////
//Declare WooCommerce support

add_action('after_setup_theme', 'woocommerce_support');

function woocommerce_support() {

    add_theme_support('woocommerce');
}

##################################################################################
# Before Shop Loop Start - Shop Page
##################################################################################

function shop_top_section_wrapper_start() {

    echo "<div class='topSection'>";
}

function shop_top_section_wrapper_end() {

    echo "</div>";
}

function shop_page_title_breadcrumb() {

    $shop_page_url = get_permalink(wc_get_page_id('shop'));
    ?>

    <div class="breadcrumbRow clearfix">

        <div class="row">

            <div class="col-xs-12 col-sm-5 text-xs-center">

                <h2>Shop</h2>

            </div>

            <div class="col-xs-12 col-sm-7">

                <div class="breadcrumb">

                    <ul class="clearfix text-right text-xs-center">

                        <li><a href="<?php echo site_url(); ?>">Home</a></li>

                        <li><a href="<?php echo $shop_page_url; ?>">Shop</a></li>

                        <!--                        <li>4 Grid Layout</li>-->

                    </ul>

                </div><!-- ( BREAD CRUMB END ) -->

            </div>

        </div>



    </div><!-- ( BREAD CRUMB ROW END ) -->

    <?php
}

function shop_sorting_start() {

    echo '<div class="sorting clearfix">';

    echo '<div class="row">';
}

function woocommerce_category_filter() {
    ?>

    <div class="col-xs-12 col-sm-4 col-md-6 text-xs-center">

        <span class="filterBTN"><a href="#_" class="toggleNav"><i class="fa fa-bars"></i><span>Category Filter</span></a></span>



        <aside class="slideNav closed">

            <a class="close-btn"><i class="fa fa-close"></i></a>

            <?php
            if (is_active_sidebar('category-filter')) {

                dynamic_sidebar('category-filter');
            }
            ?>

        </aside>

        <!-- ( SLIDE NAV END ) -->



    </div>

    <?php
}

function shop_sorting_right_area_start() {

    echo '<div class="col-xs-12 col-sm-8 col-md-6">';
}

function shop_sorting_right_area_end() {

    echo '</div>';
}

function shop_sorting_end() {

    echo '</div>';

    echo '</div>';
}

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);



add_action('woocommerce_before_shop_loop', 'shop_top_section_wrapper_start', 8);

add_action('woocommerce_before_shop_loop', 'shop_page_title_breadcrumb', 9);

add_action('woocommerce_before_shop_loop', 'shop_sorting_start', 11);

add_action('woocommerce_before_shop_loop', 'woocommerce_category_filter', 12);

add_action('woocommerce_before_shop_loop', 'shop_sorting_right_area_start', 13);

add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 15);

add_action('woocommerce_before_shop_loop', 'shop_sorting_right_area_end', 29);

add_action('woocommerce_before_shop_loop', 'shop_sorting_end', 30);

add_action('woocommerce_before_shop_loop', 'shop_top_section_wrapper_end', 31);


##################################################################################
# Wrapper around each product box for styling
##################################################################################

function woocommerce_before_shop_loop_item_st() {

    echo '<div class="productBox ">';
}

function woocommerce_after_shop_loop_item_title_st() {

    echo '</div>';
}

add_action('woocommerce_before_shop_loop_item', 'woocommerce_before_shop_loop_item_st', 10);

add_action('woocommerce_after_shop_loop_item', 'woocommerce_after_shop_loop_item_title_st', 50);



##################################################################################
# Remove Add to cart Button from Products Loop
##################################################################################
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);



##################################################################################
# Display 8 products per page
##################################################################################

add_filter('loop_shop_per_page', create_function('$cols', 'return 6;'), 20);

function product_img_wrapper_open() {

    echo '<div class="productImage hoverStyle">';
}

function product_img_wrapper_close() {

    global $product, $post;

    echo '<div class="hoverBox">';

    echo '<div class="hoverIcons">';

    echo '<a href="' . get_permalink($product->get_id()) . '" class="eye hovicon"><i class="fa fa-eye"></i></a>';

    echo do_shortcode('[yith_wcwl_add_to_wishlist]');

    echo '</div><!-- ( HOVER ICONS END ) -->';
}

function product_img_wrapper_end() {

    echo '</div><!-- ( HOVER BOX END ) -->';

    echo '</div><!-- ( PRODUCT IMAGE END ) -->';
}

add_action('woocommerce_before_shop_loop_item_title', 'product_img_wrapper_open', 9);

add_action('woocommerce_before_shop_loop_item_title', 'product_img_wrapper_close', 11);

add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 12);

add_action('woocommerce_before_shop_loop_item_title', 'product_img_wrapper_end', 14);

# shop page Product Widgets
//add_action('woocommerce_after_single_product_summary', 'woocommerce_single_products_widgets', 22);
add_action( 'woocommerce_after_shop_loop', 'woocommerce_shop_products_widgets', 12 );
function woocommerce_shop_products_widgets() {
    echo '<div class="stripe single-bottom-featured">';
        echo '<div class="row test">';
        get_template_part('inc/featured-products-widget');
        echo '</div>';
        echo '<div class="row bottom-woo-4col-products">';
        get_template_part('inc/new-products-widget');
        get_template_part('inc/top-rated-products-widget');
        get_template_part('inc/featured-products-wideget-sm');
        get_template_part('inc/on-sale-products-widget');
        echo '</div>';
    echo '</div>';
}
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

# shop page Product Widgets



##################################################################################
# Wrapper around product description for loop
##################################################################################

function product_desc_wrapper_open() {

    global $st_option;

        echo '<div class="productDesc eq-height-product-bot">';
}
function product_desc_wrapper_close() {
    echo '</div><!-- ( PRODUCT DESCRIPTION END ) -->';
}

add_action('woocommerce_shop_loop_item_title', 'product_desc_wrapper_open', 9);

add_action('woocommerce_after_shop_loop_item_title', 'product_desc_wrapper_close', 11);





##################################################################################
# Wrapper around product title for loop
##################################################################################

 remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');

add_action('woocommerce_shop_loop_item_title', 'loop_product_title_new');

function loop_product_title_new() {

    global $product;

    echo '<span class="product-title"><a href="' . get_permalink($product->get_id()) . '">' . get_the_title() . '</a></span>';
}
 
##################################################################################
# Show Product Excerpt
##################################################################################

function show_woocommerce_product_excerpt() {

    global $post;

    echo '<p>';

    echo get_my_excerpt(9);

    echo '</p>';
}

add_action('woocommerce_after_shop_loop_item_title', 'show_woocommerce_product_excerpt', 4, 2);



##################################################################################
# Wrapper around product price for loop
##################################################################################

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');

add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price_wrapper', 10);

function woocommerce_template_loop_price_wrapper() {

    global $product;

    if ($price_html = $product->get_price_html()) {

        echo '<strong class="productPrice">' . $price_html . ' </strong>';
    }
}

##################################################################################
# Remove Anchor Tag from Products Loop
##################################################################################

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);



##################################################################################
# Wrapper Single Product
##################################################################################

add_action('woocommerce_before_single_product_summary', 'woocommerce_before_single_st', 9);

add_action('woocommerce_after_single_product_summary', 'woocommerce_after_single_st', 9);

function woocommerce_before_single_st() {

    echo '<div class="container">'; //closing at 25

    echo '<hr class="productTop">';

    echo '<div class="stripe">';

    echo '<div class="row">';
}

function woocommerce_after_single_st() {

    echo '</div>'; // .row

    echo '</div>'; // .stripe
}

# Wrapper Tabs

add_action('woocommerce_after_single_product_summary', 'woocommerce_tabs_wrapper_start', 9);

add_action('woocommerce_after_single_product_summary', 'woocommerce_tabs_wrapper_end', 11);



add_filter('woocommerce_product_description_heading', '__return_null');

add_filter('woocommerce_product_additional_information_heading', '__return_null');

function woocommerce_tabs_wrapper_start() {

    echo '<div class="stripe">';

    echo '<div class="product-details">';

    echo '<div class="tabs_container">';
}

function woocommerce_tabs_wrapper_end() {

    echo '</div>'; // .tabs_container

    echo '</div>'; // .product-details

    echo '</div>'; // .stripe
}
# Wrapper Related Products





# Single Product Widgets
add_action('woocommerce_after_single_product_summary', 'woocommerce_single_products_widgets', 22);
function woocommerce_single_products_widgets() {
    echo '<div class="stripe single-bottom-featured">';
        echo '<div class="row test">';
        get_template_part('inc/featured-products-widget');
        echo '</div>';
        echo '<div class="row bottom-woo-4col-products">';
        get_template_part('inc/new-products-widget');
        get_template_part('inc/top-rated-products-widget');
        get_template_part('inc/featured-products-wideget-sm');
        get_template_part('inc/on-sale-products-widget');
        echo '</div>';
    echo '</div>';
}
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
# Single Product Widgets





##################################################################################
# Pagination Arrows
##################################################################################

add_filter('woocommerce_pagination_args', 'rocket_woo_pagination');

function rocket_woo_pagination($args) {

    $args['prev_text'] = '<i class="fa fa-angle-left"></i>';

    $args['next_text'] = '<i class="fa fa-angle-right"></i>';

    return $args;
}

##################################################################################
# Single Product Images
##################################################################################

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

add_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images_st', 20);

function woocommerce_show_product_images_st() {

    global $product;

    $attachment_ids = $product->get_gallery_image_ids();

    $img_url = $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail');



    echo '<div class="col-sm-6 col-xs-12">';

    echo '<ul id="product-slider" class="product-item-slider product-image">';

    echo '<li class="item hoverStyle" data-thumb="' . $image[0] . '">';

    echo '<img src="' . $image[0] . '" data-id="' . $product->get_id() . '">';



    echo '<div class="hoverBox">';

    echo '<div class="hoverIcons">';

    echo '<a href="' . $image[0] . '" class="eye hovicon"><i class="fa fa-expand expand-pic"></i></a>';

    echo do_shortcode('[yith_wcwl_add_to_wishlist]');

    echo '</div><!-- ( HOVER ICONS END ) -->';

    echo '</div><!-- ( HOVER BOX END ) -->';



    echo '</li>';



    foreach ($attachment_ids as $attachment_id) {

        $image_link = wp_get_attachment_url($attachment_id);

        echo '<li class="item hoverStyle" data-thumb="' . $image_link . '">';

        echo '<img src="' . $image_link . '" data-id="' . $attachment_id . '">';

        echo '<div class="hoverBox">';

        echo '<div class="hoverIcons">';

        echo '<a href="' . $image_link . '" class="eye hovicon"><i class="fa fa-expand expand-pic"></i></a>';

        echo do_shortcode('[yith_wcwl_add_to_wishlist]');

        echo '</div><!-- ( HOVER ICONS END ) -->';

        echo '</div><!-- ( HOVER BOX END ) -->';

        echo '</li>';
    }



    echo '</ul>';

    echo '</div>';
}

##################################################################################
# Single Product Summary Area
##################################################################################
# Product Content Wrapper

add_action('woocommerce_single_product_summary', 'product_content_start', 4);

add_action('woocommerce_single_product_summary', 'product_content_end', 51);

function product_content_start() {

    echo '<div class="col-sm-6 col-xs-12">';

    echo '<div class="product-content">';
}

function product_content_end() {

    echo '</div>';

    echo '</div>';
}

# Product Title

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title_start', 4);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title_st', 5);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title_end', 6);

function woocommerce_template_single_title_start() {

    echo '<h3 class="text-inherit cl_000000" itemprop="name">';
}

function woocommerce_template_single_title_st() {

    echo the_title();
}

function woocommerce_template_single_title_end() {

    echo '</h3>';
}

# Price

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price_wrapper', 9);

function woocommerce_template_single_price_wrapper() {

    global $product;

    if ($price_html = $product->get_price_html()) {

        echo '<div class="productPrice"><h2 class="cl_000000">' . $price_html . '</h2></div>';
    }
}

//add clearfix after addtocart button single product page

add_action('woocommerce_single_product_summary', 'woocommerce_template_clearfix_after_addtocart', 31);

function woocommerce_template_clearfix_after_addtocart() {

    echo "<div class='clearfix'></div>";
}

# Social Share Links

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing_st', 50);

function woocommerce_template_single_sharing_st() {

    global $product;

    $img_url = $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail');

    echo '<br><p class="sharewf-title">Share With Friends:</p>';

    echo '<ul class="social_links">';

    echo '<li><a href="http://www.facebook.com/sharer/sharer.php?u=' . get_permalink() . '&title=' . get_the_title() . '"><i class="fab fa-facebook-square"></i>&nbsp;</a></li>';

    echo '<li><a href="http://twitter.com/intent/tweet?status=' . get_the_title() . '+' . get_permalink() . '"><i class="fab fa-twitter-square"></i>&nbsp;</a></li>';

    echo '<li><a href="http://www.linkedin.com/shareArticle?mini=true&url=' . get_permalink() . '&title=' . get_the_title() . '&source=' . get_site_url() . '"><i class="fab fa-linkedin"></i>&nbsp;</a></li>';

   /* echo '<li><a href="https://plus.google.com/share?url=' . get_permalink() . '"><i class="fa fa-google-plus-square"></i>&nbsp;</a></li>';*/

    echo '<li><a href="http://pinterest.com/pin/create/bookmarklet/?media=' . $image[0] . '&url=' . get_permalink() . '&is_video=false&description=' . get_the_title() . '"><i class="fab fa-pinterest-square"></i>&nbsp;</a></li>';

    //echo '<li><a href="#"><i class="fa fa-instagram"></i>&nbsp;</a></li>';

    echo '</ul>';
}

# Quantity

add_action('woocommerce_single_product_summary', 'woocommerce_quantity_start', 29);

add_action('woocommerce_single_product_summary', 'woocommerce_quantity_end', 31);

function woocommerce_quantity_start() {

    echo '<div class="productQuantity productFormOption">';
}

function woocommerce_quantity_end() {

    echo '</div>';
}

##################################################################################
# Flash Badges - Sale - New - Out of Stock
##################################################################################
# Sale

function filter_woocommerce_sale_flash($span_class_onsale_sale_woocommerce_span, $post, $product) {
    echo '<span class="sale">Sale!</span>';
}
;
add_filter('woocommerce_sale_flash', 'filter_woocommerce_sale_flash', 10, 3);



# New

function new_product_flag() {
    global $product, $post;
    $current_product_id = $post->ID;
    $args = array('post_type' => 'product', 'stock' => 1, 'posts_per_page' => 4, 'orderby' => 'date', 'order' => 'DESC');
    $loop = new WP_Query($args);
    while ($loop->have_posts()) : $loop->the_post();
        global $product;
        if ($current_product_id == $product->get_id()) {
            echo '<span class="new">New</span>';
        }
    endwhile;

    wp_reset_query();
}

//add_action( 'woocommerce_before_shop_loop_item_title', 'new_product_flag', 8 );
# Out of Stock

function out_of_stock_sticker_st() {
    global $product;
    if (!$product->is_in_stock()) {
        echo '<span class="out-stock">Out of Stock</span>';
    }
}

add_action('woocommerce_before_shop_loop_item_title', 'out_of_stock_sticker_st', 9);





##################################################################################
# Category Loop Hooks & Actions
##################################################################################
#After li

add_action('woocommerce_before_subcategory', 'st_category_wrapper_start', 9);

add_action('woocommerce_after_subcategory', 'st_category_wrapper_end', 11);

function st_category_wrapper_start() {

    echo '<div class="col-xs-12">';

    echo '<div class="categoryBox productBox">';
}

function st_category_wrapper_end() {

    echo '</div>';

    echo '</div>';
}

#After a

add_action('woocommerce_before_subcategory_title', 'st_category_img_before', 9);

add_action('woocommerce_after_subcategory_title', 'st_category_title_after');

function st_category_img_before() {

    echo '<div class="categoryImage">';
}

function st_category_title_after() {

    echo '</div>';
}

#Title

remove_action('woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10);

add_action('woocommerce_shop_loop_subcategory_title', 'st_category_title', 10);

function st_category_title($category) {
    ?> 

    <div class="title"> 

        <?php
        echo $category->name;



        if ($category->count > 0)
            echo apply_filters('woocommerce_subcategory_count_html', ' <span>(' . $category->count . ')</span>', $category);
        ?> 

    </div> 

    <?php
}
##################################################################################
# Remove and Add WC  All Out put notice
##################################################################################

remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);

add_action('woocommerce_before_single_product', 'custom_woocommerce_output_all_notices', 10);

function custom_woocommerce_output_all_notices() {

    echo '<div class="woocommerce-notices-wrapper container">';

    wc_print_notices();

    echo '</div>';
}

##################################################################################
# Mini Cart - custom message at bottom
##################################################################################

add_action('woocommerce_after_mini_cart', 'woocommerce_after_mini_cart_msg', 50);

function woocommerce_after_mini_cart_msg() {



    global $st_option;



    if (isset($st_option['st-mini-cart-msg']) && !empty($st_option['st-mini-cart-msg'])) {

        echo '<div class="cartSummeryText">' . $st_option['st-mini-cart-msg'] . '</div>';
    } else {

        echo '<div class="cartSummeryText">Free Shipping On Orders Over $100</div>';
    }
}

##################################################################################
# Mini Cart - Ajax Add to cart
##################################################################################
// Ensure cart contents update when products are added to the cart via AJAX

if (!function_exists('theme_cart_link')) {
    function theme_cart_link() {
        global $woocommerce;
        ?>
        <div class="mini-cart stanza-cart">
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>">
                <div class="cartHover">
                    <span class="cartBTN">Cart / <?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span>
                    <span class="cart-icon">
                        <i class="itemCount"><?php echo wp_kses_data(sprintf(_n('%d', '%d', WC()->cart->get_cart_contents_count(), 'stanzastore'), WC()->cart->get_cart_contents_count())); ?></i>
                        <i class="fa fa-shopping-cart"></i>
                    </span><!-- ( CART ICON END ) -->
                </div><!-- ( CART HOVER END ) -->
            </a>
            <div class="cartSummery woocommerce">
                <div class="dropBox">
                    <?php woocommerce_mini_cart() ?>
                </div><!-- ( DROP BOX END ) -->
            </div><!-- ( CART SUMMERY END ) -->
        </div><!-- ( MINI CART END ) -->
        <?php
    }
}
/**

 * Cart Fragments

 * Ensure cart contents update when products are added to the cart via AJAX

 * @param  array $fragments Fragments to refresh via AJAX

 * @return array            Fragments to refresh via AJAX

 */
if (!function_exists('theme_cart_link_fragment')) {



    function theme_cart_link_fragment($fragments) {

        global $woocommerce;

        ob_start();

        theme_cart_link();

        $fragments['div.stanza-cart'] = ob_get_clean();

        return $fragments;
    }

}



if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.3', '>=')) {

    add_filter('woocommerce_add_to_cart_fragments', 'theme_cart_link_fragment');
} else {

    add_filter('add_to_cart_fragments', 'theme_cart_link_fragment');
}



/*----------*/


remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

function stanza_product_images() {

    global $product, $st_option;
    if (has_post_thumbnail($product->get_id())) {
        $style = (isset($_GET['style']) && $_GET['style'] == "masonary" ? $_GET['style'] : "");
        if ($style == "masonary") {
            echo get_the_post_thumbnail($product->get_id(), 'st_768');
        } else {
            echo get_the_post_thumbnail($product->get_id(), 'st_530_480');
        }
    } else {
        echo '<img src="http://placehold.it/526x382">';
    }
}

add_action('woocommerce_before_shop_loop_item_title', 'stanza_product_images', 10);



# cart Product Widgets
add_action('woocommerce_after_cart', 'woocommerce_cart_products_widgets', 15);
function woocommerce_cart_products_widgets() {
        echo '<div class="row cart-bottom-products bottom-woo-4col-products">';
        get_template_part('inc/new-products-widget');
        get_template_part('inc/top-rated-products-widget');
        get_template_part('inc/featured-products-wideget-sm');
        get_template_part('inc/on-sale-products-widget');
        echo '</div>';
   // echo '</div>';
}
# cart Product Widgets
//woocommerce after cart table