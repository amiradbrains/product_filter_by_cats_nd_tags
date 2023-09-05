<?php 
//cwl certificate filter
function cwl_certificate_shortcode($atts) {
    ob_start();
    // Query for product categories
    $categories = get_terms('product_cat');
    echo '
    <div class="product-filters" id="product-tag-filter">
		 	 <ul class="category-filters" id="category-filter">';
    foreach ($categories as $category) {
    if ($category->slug !== 'uncategorized') {  
        echo '<li><a href="#" data-category="' . $category->slug . '">' . $category->name . '</a></li>';
    }
}
    echo '</ul>';
	echo '<ul class="tag-filters" id="tag-filter" style="display:none;"></ul></div>';
   
    // Query for products
    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
		'order' => 'DESC'
    ];
    $query = new WP_Query($args);

    // HTML for Products
    echo '<div id="product-list" class="product-list  cwl_pdct">';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
         
            $cat_slugs = [];
            $tag_slugs = [];
            $categories = get_the_terms(get_the_ID(), 'product_cat');
            $tags = get_the_terms(get_the_ID(), 'product_tag');

            if (!empty($categories) && !is_wp_error($categories)) {
                foreach ($categories as $cat) {
                    $cat_slugs[] = $cat->slug;
                }
            }

            if (!empty($tags) && !is_wp_error($tags)) {
                foreach ($tags as $tag) {
                    $tag_slugs[] = $tag->slug;
                }
            }

            echo '<div class="product-item" data-categories="' . implode(' ', $cat_slugs) . '" data-tags="' . implode(' ', $tag_slugs) . '">';
				$text_1 = get_post_meta(get_the_ID(), 'text_1', true);
				$text_2 = get_post_meta(get_the_ID(), 'text_2', true);
				$text_3 = get_post_meta(get_the_ID(), 'text_3', true);
				$text_4 = get_post_meta(get_the_ID(), 'text_4', true);
				$strip = get_post_meta(get_the_ID(), 'strip', true);
				$delivery_mode = get_post_meta(get_the_ID(), 'delivery_mode', true);
			
 		 	echo $product->get_image('thumbnail'); ?> <br>
			<div class="stripWrapper">
				<h5 class="strip <?php echo $strip; ?>"><?php echo $strip; ?></h5>
			</div>
            <h4><a href="<?php echo get_permalink( $product_id ); ?>"><?php echo get_the_title( $product_id ); ?></a></h4>
			 <p><span><?php echo $delivery_mode; ?></span></p>
			<h3 class="price"><?php echo str_replace('.00', '', $product->get_price_html()); ?></h3>
			<?php 
  				$product_url = wc_get_cart_url();
  				$add_to_cart_url =  esc_url( $product_url . '?add-to-cart=' . get_the_ID() );
				$allow_add_to_cart = get_field('allow_add_to_cart', $product_id);
			?>
				<a href="<?php echo ($allow_add_to_cart === 'No') ? '#' : $add_to_cart_url; ?>"
				   class="elementor-button-link elementor-button elementor-size-md elementor-animation-grow productTile" role="button">
  				<?php echo ($allow_add_to_cart === 'No') ? 'Coming Soon' : $product->add_to_cart_text(); ?>
				</a>
            <h4 class="highlights">Highlights</h4>
			<?php
			if($text_1 && $text_2 && $text_3 && $text_4 !=0){ ?>
			<div class="hghLights">
				<ul>
				<li><svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" height="12" width="12" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg><?php echo $text_1; ?></li>
				<li><svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" height="12" width="12" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg><?php echo $text_2; ?></li>
				<li><svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" height="12" width="12" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg><?php echo $text_3; ?></li>
				<li><svg aria-hidden="true" class="e-font-icon-svg e-fas-check" viewBox="0 0 512 512" height="12" width="12" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg><?php echo $text_4; ?></li>
			</ul>
			</div>
            <div class="pReadmore"><a href="<?php echo get_permalink( $product_id ); ?>">Learn More >></a></div>
			<?php } else {
				echo '<p>Coming Soon</p>';
			}
    echo '</div>';
		}}
    ?>
    <script>
jQuery(document).ready(function($) {
    var selectedCategory = '';
    var selectedTag = '';

    function populateTags(category) {
        var uniqueTags = [];
        $('#product-list .product-item[data-categories*="' + category + '"]').each(function() {
            var tags = $(this).data('tags').split(' ');
            uniqueTags = [...new Set([...uniqueTags, ...tags])];
        });

        $('#tag-filter').empty().show();
		$('#tag-filter').prepend('<li><a href="#" data-tag="all" class="active">All</a></li>');
        uniqueTags.forEach(function(tag) {
            $('#tag-filter').append('<li><a href="#" data-tag="' + tag + '">' + tag + '</a></li>');
        });
        selectedTag = 'all';
    }

    $('a[data-category="all"]').addClass('active');
    selectedCategory = 'all';
    populateTags('all');
    
    selectedTag = 'all';
    
    $('#category-filter').on('click', 'a', function(e) {
        e.preventDefault();
        $('#category-filter a').removeClass('active');
        $(this).addClass('active');
        
        selectedCategory = $(this).data('category');
        
        $('#product-list .product-item').hide();
        $('#product-list .product-item[data-categories*="' + selectedCategory + '"]').show();
        
        populateTags(selectedCategory);
        
        $('#tag-filter a[data-tag="all"]').click();
    });
    
    $('#tag-filter').on('click', 'a', function(e) {
        e.preventDefault();
        
        $('#tag-filter a').removeClass('active');
        $(this).addClass('active');
        
        selectedTag = $(this).data('tag');
        
        $('#product-list .product-item').hide();
        if (selectedTag === 'all') {
            $('#product-list .product-item[data-categories*="' + selectedCategory + '"]').show();
        } else {
            $('#product-list .product-item[data-tags*="' + selectedTag + '"][data-categories*="' + selectedCategory + '"]').show();
        }
    });
});
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('cwl_product_filter', 'cwl_certificate_shortcode');
//End cwl certificate filter
