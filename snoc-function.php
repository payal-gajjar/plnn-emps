<?php

// Defines
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );

// Classes
require_once 'classes/class-fl-child-theme.php';

// Actions
add_action( 'wp_enqueue_scripts', 'FLChildTheme::enqueue_scripts', 1000 );
/*** Calling Assets ***/
add_action( 'wp_enqueue_scripts', 'snoc_assets' );
function snoc_assets() {
		wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery' ), true  );
		wp_localize_script('custom-js', 'object', array('ajax_url' => admin_url('admin-ajax.php')));
}
/* set the admin login design */
function custom_login_head() {
 
    //if ( has_custom_logo() ) :
 
        $image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
        ?>
        <style type="text/css">
            .login h1 a {
                background-image: url("<?php  echo site_url();?>/wp-content/uploads/2019/03/logo.png");
                -webkit-background-size: 100%;
                background-size: auto;
                background-position: center;
                height: 150px;
                width: 200px;
            }
			body.login {
			    background-image:url("<?php  echo site_url();?>/wp-content/uploads/2019/03/Main-banner.jpg");
			   
			    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
				font-size: 13px;
			    background-repeat: no-repeat;
                background-size: cover;
			
			}
				#login {
				background: rgba(0,0,0,0.6);
				background-size: cover;
				width: 350px;
				margin: auto;
				padding: 50px;
				border: 1px solid #558424;
			    display: block;
			  
			}
			.login form {
			    margin-top: 20px;
				margin-left: 0;
				padding: 26px 24px 46px;
				font-weight: 400;
				overflow: hidden;
				background-image: url("<?php  echo site_url();?>/wp-content/uploads/2019/03/imge-logo.png");
				background-repeat: no-repeat;
				background-position: center;
				background-size: auto;
				background-color: rgb(85,132,36,0.7);
			  
			}
				 
			.login label  {
			    color: #ffffff;
			}
			body.login div#login form#loginform p.submit input#wp-submit, form#lostpasswordform  p.submit input#wp-submit {
			   background-color: #f5a700;
			    border-color: #f5a700;
			    box-shadow: none;
			    font-size: 16px;
			    font-weight: bold;
			    text-shadow: none;
			}
			body.login div#login form#loginform p.submit input#wp-submit:hover, form#lostpasswordform  p.submit input#wp-submit:hover {
				background-color: #69961f;
				border-color: #69961f;
			}
			input[type=text]:focus, input[type=password]:focus, input[type=checkbox]:focus,
			.login a:focus {
			      border-color: #69961f;
			     box-shadow: 0 0 2px rgba(245,167,0,0.8);
			}
			body.login div#login form#loginform p.forgetmenot input[type=checkbox]:checked:before {
			    content: "\f147";
			    margin: -3px 0 0 -4px;
			    color: #558424;
			}

			.login #login #nav a, .login #login #backtoblog a, .login #login_error a  {
			    color: #f5a700;
			}
			body.login div#login p#nav a:hover, body.login div#login p#backtoblog a:hover{
			    color: #558424;
			}
			.login .message,
			.login .success,
			.login #login_error {
			    border-left: 4px solid #558424;
			    padding: 12px;
			    color: #558424;
			    margin-left: 0;
			    margin-bottom: 20px;
			    background-color: #fff;
			    box-shadow: 0 1px 1px 0 rgba(0,0,0,0.1);
			}

			.login .success {
			    border-left-color: #558424;
			}

			.login #login_error {
			    border-left-color: #558424;
			}
			

        </style>
        <?php
   // endif;
}
 
add_action( 'login_head', 'custom_login_head', 100 );
// changing the logo link from wordpress.org to your site
function filter_login_url() {  return home_url(); }
add_filter( 'login_headerurl', 'filter_login_url' );

// changing the alt text on the logo to show your site name
function filter_login_title() { return get_option( 'blogname' ); }
add_filter( 'login_headertitle', 'filter_login_title' );


/*** Register History CPT ***/
add_action( 'init', 'snoc_register_history' );
function snoc_register_history() {
    $labels = array(
        'name'               => _x( 'History', 'post type general name' ),
        'singular_name'      => _x( 'History', 'post type singular name' ),
        'menu_name'          => _x( 'History', 'admin menu' ),
        'name_admin_bar'     => _x( 'History', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'History' ),
        'add_new_item'       => __( 'Add New History' ),
        'new_item'           => __( 'New History' ),
        'edit_item'          => __( 'Edit History' ),
        'view_item'          => __( 'View History' ),
        'all_items'          => __( 'All Historys' ),
        'search_items'       => __( 'Search History' ),
        'parent_item_colon'  => __( 'Parent History:' ),
        'not_found'          => __( 'No History found.' ),
        'not_found_in_trash' => __( 'No History found in Trash.' )
    );
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.' ),
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'history' ),
        'menu_icon'          => 'dashicons-nametag',
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor','excerpt', 'thumbnail' )
    );
    register_post_type( 'history', $args );
}


/*** Register News CPT ***/
add_action( 'init', 'snoc_register_news' );
function snoc_register_news() {
    $labels = array(
        'name'               => _x( 'News', 'post type general name' ),
        'singular_name'      => _x( 'News', 'post type singular name' ),
        'menu_name'          => _x( 'News', 'admin menu' ),
        'name_admin_bar'     => _x( 'News', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'News' ),
        'add_new_item'       => __( 'Add New News' ),
        'new_item'           => __( 'New News' ),
        'edit_item'          => __( 'Edit News' ),
        'view_item'          => __( 'View News' ),
        'all_items'          => __( 'All News' ),
        'search_items'       => __( 'Search News' ),
        'parent_item_colon'  => __( 'Parent News:' ),
        'not_found'          => __( 'No History found.' ),
        'not_found_in_trash' => __( 'No History found in Trash.' )
    );
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'news' ),
        'menu_icon'          => 'dashicons-microphone',
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor','excerpt', 'thumbnail' )
    );
    register_post_type( 'news', $args );
}
//taxonomy for News 
add_action( 'init', 'news_custom_taxonomy', 0 );
function news_custom_taxonomy() {

$labels = array(
'name' => _x( 'News Types', 'News general name' ),
'singular_name' => _x( 'News Type', 'News singular name' ),
'search_items' => __( 'Search News Types' ),
'all_items' => __( 'All News Types' ),
'parent_item' => __( 'Parent News Type' ),
'parent_item_colon' => __( 'Parent News Type:' ),
'edit_item' => __( 'Edit Type' ), 
'update_item' => __( 'Update Type' ),
'add_new_item' => __( 'Add New Type' ),
'new_item_name' => __( 'New News Type Name' ),
'menu_name' => __( 'News Types' ),
); 

register_taxonomy('news_types',array('news'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_admin_column' => true,
'query_var' => true,
'rewrite' => array( 'slug' => 'news_types' ),
));
}

//taxonomy for tag news year tag
add_action( 'init', 'newsyear_custom_taxonomy', 0 );
function newsyear_custom_taxonomy() {

$labels = array(
'name' => _x( 'News Year', 'News general name' ),
'singular_name' => _x( 'News Year', 'News singular name' ),
'search_items' => __( 'Search News Year' ),
'all_items' => __( 'All News Years' ),
'parent_item' => __( 'Parent News Year' ),
'parent_item_colon' => __( 'Parent News Year:' ),
'edit_item' => __( 'Edit Year' ), 
'update_item' => __( 'Update Year' ),
'add_new_item' => __( 'Add New Year' ),
'new_item_name' => __( 'New News Year Name' ),
'menu_name' => __( 'News Years' ),
); 

register_taxonomy('news_year',array('news'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_admin_column' => true,
'query_var' => true,
'rewrite' => array( 'slug' => 'news_year' ),
));
}

/*add_action('wp_head',function(){ if(is_page('sajaa-assets-timeline')) { ?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			var YearTitle = $('.history-info .uabb-blog-post-section').html();
			$('<h3 class="snoc-uabb-post-heading uabb-post-heading uabb-blog-post-section">'+YearTitle+'</h3>').insertBefore( ".uabb-blog-posts-carousel" );
		});
	</script>
<?php }}); */



// adds descriptions to menus
function prefix_nav_description( $item_output, $item, $depth, $args ) {
 if ( !empty( $item->description ) ) {
 $item_output = str_replace( $args->link_after . '</a>', '<p class="menu-item-description">' . $item->description . '</p>' . $args->link_after . '</a>', $item_output );
 }
 return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'prefix_nav_description', 10, 4 );

//Allow HTML In The Description Area To WordPress Menus
remove_filter('nav_menu_description', 'strip_tags');
add_filter( 'wp_setup_nav_menu_item', 'cus_wp_setup_nav_menu_item' );
function cus_wp_setup_nav_menu_item($menu_item) {
	$menu_item->description = apply_filters( 'nav_menu_description', $menu_item->post_content );
	return $menu_item;
}

// allows shortcodes in the menu 
add_filter('wp_nav_menu', 'do_menu_shortcodes'); 
function do_menu_shortcodes( $menu_item ){ 
 return do_shortcode( $menu_item ); 
}

/* contact form 7 submit to thankyou page redirect*/

add_action( 'wp_footer', 'redirect_cf7' );
function redirect_cf7() { ?>
	<script type="text/javascript">
		document.addEventListener( 'wpcf7mailsent', function( event ) {
			location = '<?php echo get_site_url();?>/thank-you/';
		}, false );
	</script>
<?php }



/* news listing for press release page */
add_shortcode( 'post-lists-filter', 'press_filter_listsing_shortcode' );
function press_filter_listsing_shortcode() {
	ob_start();
	?>	<div class="press-release-list">
			<div class="before-load"><div class="snocnews-loader"></div></div>
			<div class="news-search-section">
						
			<div class="row">
				<div class="col-sm-6">
					<div class="common-main-title"><h2>Other Press Releases</h2></div>
				</div>
				<div class="col-sm-6">
				<form method="POST" action="" id="findnewsForm" name="findnewsForm" enctype="multipart/form-data" class="findnewsForm">
				<div class="row">
					<div class="col-sm-7">
						<div class="selecticon">
							<?php
	$args = array(
               'taxonomy' => 'news_types',
           );
							$categories = get_categories($args);												
							?>
							<select id="news_category" name="news_category">
									<option value="">All News</option>
								<?php if ( $categories ){ foreach ($categories as $category) { ?>
									<option value="<?php echo $category->term_id;?>" <?php if($category->term_id == $getCat){ echo 'selected="selected"';}?> ><?php echo $category->name;?></option>
								<?php } ?>
							
							<?php }	?>
								</select>
						</div>
					</div>
					<div class="col-sm-5">
						<div class="selecticon">
							<?php 
	$args = array(
               'taxonomy' => 'news_year',
           );
							$tags = get_categories($args);													
							if ( $tags ){?>
							<select id="news_tags" name="news_tags">
									<option value="">Filter Year</option>
								<?php foreach ($tags as $tag) { ?>
									<option value="<?php echo $tag->term_id;?>" <?php if($tag->term_id == $getCat){ echo 'selected="selected"';}?> ><?php echo $tag->name;?></option>
								<?php } ?>
							</select>
							<?php }	?>
						</div>
					</div>
				</div>
				</form>
				</div>
			</div>
			</div>
			<div class="news-list-block"></div>
			<div class="text-center">
				<div class="snoc-loadmore" data-offset="4">load more</div>
			</div>
		</div>
	<?php 	
	return ob_get_clean();
}

/* get the news data */
add_action( 'wp_ajax_get_newslist_data', 'get_newslist_data' );
add_action( 'wp_ajax_nopriv_get_newslist_data', 'get_newslist_data' );
function get_newslist_data() {
	$CategoryID = absint($_POST['CategoryID']);
	$TagID = absint($_POST['TagID']);
	$offset = absint($_POST['offset']);
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$tax_query = array('relation' => 'AND');
	if(!empty($CategoryID)){
		$tax_query[] =  array(
                'taxonomy' => 'news_types',
                'field' => 'term_id',
				'terms' => $CategoryID
         );
	}
	if(!empty($TagID)){
		$tax_query[] =  array(
                'taxonomy' => 'news_year',
                'field' => 'term_id',
				'terms' => $TagID
         );
	}
	$args = array(
		'post_type' => 'news',
		'post_status' => 'publish',
		'posts_per_page' => 4,
		'tax_query' => $tax_query,
		'orderby' => 'date',
		'order' => 'DESC',
		'offset'=> $offset
	);
	
	$the_query = new WP_Query( $args );
	ob_start ();
	if ($the_query->have_posts()){
		?>
		<div class="row">
		<?php while ($the_query->have_posts() ) : $the_query->the_post(); 
		?>
			<div class="col-md-6 col-sm-6 postnews">
				<div>
					<div class="post-thumbnail">
						<?php if(has_post_thumbnail()){?>
							<a href="<?php the_permalink();?>"><?php the_post_thumbnail();?></a>
						<?php }?>
					</div>
					<div class="blog-post-content">
						<div class="post-date"><?php echo get_the_date('d F, Y'); ?></div>
						<h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
						<div class="readmore"><a href="<?php the_permalink();?>">Read more</a></div>
					</div>
				</div>
			</div>
		<?php endwhile;?>
		</div>
	<?php	
	}
	else{ 
		echo "<div class='notfound'>Sorry, we couldn't find any posts. Please try a different filter.</div>";
	}
	wp_reset_postdata();
	$response = ob_get_contents();
	ob_end_clean();
	$args['offset'] = $offset + 4;
	$nextEvents = new WP_Query($args);
    $count = $nextEvents->post_count;
    echo json_encode(array('html'=>$response,'count'=>$count));	
	exit;
}




/*** Register Social Activity CPT ***/
add_action( 'init', 'snoc_register_socialactivities' );
function snoc_register_socialactivities() {
    $labels = array(
        'name'               => _x( 'Social Activities', 'post type general name' ),
        'singular_name'      => _x( 'Social Activities', 'post type singular name' ),
        'menu_name'          => _x( 'Social Activities', 'admin menu' ),
        'name_admin_bar'     => _x( 'Social Activities', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'Social Activities' ),
        'add_new_item'       => __( 'Add New Social Activities' ),
        'new_item'           => __( 'New Social Activities' ),
        'edit_item'          => __( 'Edit Social Activities' ),
        'view_item'          => __( 'View Social Activities' ),
        'all_items'          => __( 'All Social Activities' ),
        'search_items'       => __( 'Search Social Activities' ),
        'parent_item_colon'  => __( 'Parent Social Activities:' ),
        'not_found'          => __( 'No History found.' ),
        'not_found_in_trash' => __( 'No History found in Trash.' )
    );
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'socialactivities' ),
        'menu_icon'          => 'dashicons-calendar-alt',
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor','excerpt', 'thumbnail' )
    );
    register_post_type( 'socialactivities', $args );
}
//taxonomy for Social Activity 
add_action( 'init', 'socialactivities_custom_taxonomy', 0 );
function socialactivities_custom_taxonomy() {

$labels = array(
'name' => _x( 'Social Activities Types', 'Social Activities general name' ),
'singular_name' => _x( 'Social Activities Type', 'Social Activities singular name' ),
'search_items' => __( 'Search Social Activities Types' ),
'all_items' => __( 'All Social Activities Types' ),
'parent_item' => __( 'Parent Social Activities Type' ),
'parent_item_colon' => __( 'Parent Social Activities Type:' ),
'edit_item' => __( 'Edit Type' ), 
'update_item' => __( 'Update Type' ),
'add_new_item' => __( 'Add New Type' ),
'new_item_name' => __( 'New Social Activities Type Name' ),
'menu_name' => __( 'Social Activities Types' ),
); 

register_taxonomy('socialactivities_types',array('socialactivities'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_admin_column' => true,
'query_var' => true,
'rewrite' => array( 'slug' => 'socialactivities_types' ),
));
}

//taxonomy for tag Social Activity year tag
add_action( 'init', 'socialactivitiesyear_custom_taxonomy', 0 );
function socialactivitiesyear_custom_taxonomy() {

$labels = array(
'name' => _x( 'Social Activities Year', 'Social Activities general name' ),
'singular_name' => _x( 'Social Activities Year', 'Social Activities singular name' ),
'search_items' => __( 'Search Social Activities Year' ),
'all_items' => __( 'All Social Activities Years' ),
'parent_item' => __( 'Parent Social Activities Year' ),
'parent_item_colon' => __( 'Parent Social Activities Year:' ),
'edit_item' => __( 'Edit Year' ), 
'update_item' => __( 'Update Year' ),
'add_new_item' => __( 'Add New Year' ),
'new_item_name' => __( 'New Social Activities Year Name' ),
'menu_name' => __( 'Social Activities Years' ),
); 

register_taxonomy('socialactivities_year',array('socialactivities'), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_admin_column' => true,
'query_var' => true,
'rewrite' => array( 'slug' => 'socialactivities_year' ),
));
}


/* news listing for social activities page */
add_shortcode( 'post-sociallists-filter', 'social_filter_listsing_shortcode' );
function social_filter_listsing_shortcode() {
    ob_start();
    ?>  <div class="social-release-list">
            <div class="before-loads"><div class="snocnews-loader"></div></div>
            <div class="news-search-section">
                        
            <div class="row">
                <div class="col-sm-6">
                    <div class="common-main-title"><h2>Other Social Activities</h2></div>
                </div>
                <div class="col-sm-6">
                <form method="POST" action="" id="findnewsForm" name="findnewsForm" enctype="multipart/form-data" class="findnewsForm">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="selecticon">
                            <?php
    $args = array(
               'taxonomy' => 'socialactivities_types',
           );
                            $categories = get_categories($args);                                                
                            ?>
                            <select id="social_category" name="social_category">
                                    <option value="">All Social Activities</option>
                                <?php if ( $categories ){ foreach ($categories as $category) { ?>
                                    <option value="<?php echo $category->term_id;?>" <?php if($category->term_id == $getCat){ echo 'selected="selected"';}?> ><?php echo $category->name;?></option>
                                <?php } ?>
                            
                            <?php } ?>
								</select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="selecticon">
                            <?php 
    $args = array(
               'taxonomy' => 'socialactivities_year',
           );
                            $tags = get_categories($args);                                                  
                            if ( $tags ){?>
                            <select id="social_tags" name="social_tags">
                                    <option value="">Filter Year</option>
                                <?php foreach ($tags as $tag) { ?>
                                    <option value="<?php echo $tag->term_id;?>" <?php if($tag->term_id == $getCat){ echo 'selected="selected"';}?> ><?php echo $tag->name;?></option>
                                <?php } ?>
                            </select>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                </form>
                </div>
            </div>
            </div>
            <div class="news-list-blocks"></div>
            <div class="text-center">
                <div class="snoc-loadmores" data-offset="4">load more</div>
            </div>
        </div>
    <?php   
    return ob_get_clean();
}


/* get the socialactivities data */
add_action( 'wp_ajax_get_sociallist_data', 'get_sociallist_data' );
add_action( 'wp_ajax_nopriv_get_sociallist_data', 'get_sociallist_data' );
function get_sociallist_data() {
    $CategoryID = absint($_POST['CategoryID']);
    $TagID = absint($_POST['TagID']);
    $offset = absint($_POST['offset']);
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $tax_query = array('relation' => 'AND');
    if(!empty($CategoryID)){
        $tax_query[] =  array(
                'taxonomy' => 'socialactivities_types',
                'field' => 'term_id',
                'terms' => $CategoryID
         );
    }
    if(!empty($TagID)){
        $tax_query[] =  array(
                'taxonomy' => 'socialactivities_year',
                'field' => 'term_id',
                'terms' => $TagID
         );
    }
    $args = array(
        'post_type' => 'socialactivities',
        'post_status' => 'publish',
        'posts_per_page' => 4,
        'tax_query' => $tax_query,
        'orderby' => 'date',
        'order' => 'DESC',
        'offset'=> $offset
    );
    
    $the_query = new WP_Query( $args );
    ob_start ();
    if ($the_query->have_posts()){
        ?>
        <div class="row">
        <?php while ($the_query->have_posts() ) : $the_query->the_post(); 
        ?>
            <div class="col-md-6 col-sm-6 postnews">
                <div>
                    <div class="post-thumbnail">
                        <?php if(has_post_thumbnail()){?>
                            <a href="<?php the_permalink();?>"><?php the_post_thumbnail();?></a>
                        <?php }?>
                    </div>
                    <div class="blog-post-content">
                        <div class="post-date"><?php echo get_the_date('d F, Y'); ?></div>
                        <h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                        <div class="readmore"><a href="<?php the_permalink();?>">Read more</a></div>
                    </div>
                </div>
            </div>
        <?php endwhile;?>
        </div>
    <?php   
    }
    else{ 
        echo "<div class='notfound'>Sorry, we couldn't find any posts. Please try a different filter.</div>";
    }
    wp_reset_postdata();
    $response = ob_get_contents();
    ob_end_clean();
    $args['offset'] = $offset + 4;
    $nextEvents = new WP_Query($args);
    $count = $nextEvents->post_count;
    echo json_encode(array('html'=>$response,'count'=>$count)); 
    exit;
}

//custombox form fields
function snoc_meta_box_option() {
   add_meta_box(
       'marquee_latest_news',
       'Rotation Option Box.',
       'snoc_marquee_meta_box_option',
       'news',
       'side',
       'high' 
   );
}
add_action('add_meta_boxes', 'snoc_meta_box_option');

//showing custom form fields
function snoc_marquee_meta_box_option() {
    global $post;
    wp_nonce_field( basename( __FILE__ ), 'wpse_our_nonce' );
    $checkbox_value = get_post_meta($post->ID, '_marquee_latest_news', true);
    ?>
    <p>Please select option for text rotation on black bar.</p>
    <label><input name="marquee_news_check" type="radio" value="Yes" <?php if($checkbox_value == "Yes"){ echo 'checked'; }?>>Yes&nbsp;&nbsp;</label>
    <label><input name="marquee_news_check" type="radio" value="No" <?php if($checkbox_value != "Yes"){ echo 'checked'; }?>>No</label>
    <?php 
}

//now we are saving the data
function snoc_save_marquee_meta_fields( $post_id ) {
  if (!isset($_POST['wpse_our_nonce']) || !wp_verify_nonce($_POST['wpse_our_nonce'], basename(__FILE__)))
      return 'nonce not verified';
  $marquee_news_check = sanitize_text_field( $_POST['marquee_news_check'] );
  update_post_meta( $post_id, '_marquee_latest_news', $marquee_news_check );

}
add_action( 'save_post', 'snoc_save_marquee_meta_fields' );
add_action( 'new_to_publish', 'snoc_save_marquee_meta_fields' );
/* header latest news marquee shortcode */
/* news listing for press release page */
add_shortcode( 'latestNews_marquee', 'snoc_latestNews_marquee_shortcode' );
function snoc_latestNews_marquee_shortcode() {
	ob_start();
	$args = array(
        'post_type' => 'news',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_key'		=> '_marquee_latest_news',
		'meta_value'	=> 'Yes',
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    $the_query = new WP_Query( $args );
    if($the_query->have_posts()){   
	?>	<div class="latest-news-marquee-list">						
			<div class="row">
				<div class="col-sm-2">
					<div class="marquee-title"><h2>Latest News:</h2></div>
				</div>
				<div class="col-sm-10">
					<div class="marquee-content">
						<p>
							<marquee>
								<?php while ($the_query->have_posts() ) : $the_query->the_post(); ?>
									<a href="<?php the_permalink();?>"><i class="fa fa-dot-circle-o"></i> <?php the_title(); ?></a>
								<?php endwhile; ?>
							</marquee>
						</p>
					</div>
				</div>
			</div>
		</div>
	<?php 
	} else { 
        echo "<div class='notfoundnews'>Sorry, we couldn't find any latest new.</div>";
    }
    wp_reset_postdata();
	return ob_get_clean();

}

function add_query_vars_filter( $vars ){
  $vars[] = "token";
  return $vars;
}

add_filter( 'query_vars', 'add_query_vars_filter' );


/** Redirect to homepage if user not logged and accessing arabic website **/
add_action('wp_head',function(){
if(strpos($_SERVER['REQUEST_URI'], 'ar') !== false && !is_user_logged_in()){
wp_safe_redirect( site_url()); exit;
}
});
/** Disable default wordpress lazy loading **/
add_filter( 'wp_lazy_loading_enabled', '__return_false' );