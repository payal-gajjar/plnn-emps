<?php
/**
 * employee Plugin 
 *
 * @package employee
 * @author employee
 * @license GPL-2.0+
 * @link http://localhost/payal-wp/
 * @copyright 2021. All rights reserved.
 *
 *            @wordpress-plugin
 *            Plugin Name: employee
 *            Plugin URI: http://localhost/payal-wp/
 *            Description: employee
 *            Version: 3.0
 *            Author: employee
 *            Text Domain: employee
 *            Contributors: employee
 *            License: GPL-2.0+
 *            License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
 
/* Employee css & js */ 
function employee_assets() {
wp_enqueue_style('employee-style', plugins_url('/assets/css/style.css', __FILE__), '', '1.0', false);
}
add_action( 'admin_init','employee_assets');


/*** Register Employee CPT ***/
add_action( 'init', 'employee_register_services' );
function employee_register_services() {
    $labels = array(
        'name'               => _x( 'Employee', 'post type general name' ),
        'singular_name'      => _x( 'Employee', 'post type singular name' ),
        'menu_name'          => _x( 'Employee', 'admin menu' ),
        'name_admin_bar'     => _x( 'Employee', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'Employee' ),
        'add_new_item'       => __( 'Add New Employee' ),
        'new_item'           => __( 'New Employee' ),
        'edit_item'          => __( 'Edit Employee' ),
        'view_item'          => __( 'View Employee' ),
        'all_items'          => __( 'All Employee' ),
        'search_items'       => __( 'Search Employee' ),
        'parent_item_colon'  => __( 'Parent Employee:' ),
        'not_found'          => __( 'No Employee found.' ),
        'not_found_in_trash' => __( 'No Employee found in Trash.' )
    );
    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'employee' ),
        'menu_icon'          => 'dashicons-clipboard',
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    );
    register_post_type( 'employee', $args );
}


/* add shortcode for employee data */ 
add_shortcode('employeedata','employee_shortcode');
function employee_shortcode($args) { 
    ob_start();
   ?>
    <div class="vc_row wpb_row vc_inner vc_row-fluid">
            <div class="vc_col-sm-12">
                <div class="form">
        			<form method="post" enctype="multipart/form-data">
					  First name:<br>
					  <input type="text" name="firstname" id="firstname" >
					  <br>
					  Last name :<br>
					  <input type="text" name="lastname" id="lastname">
					  Email:<br>
					  <input type="text" name="email" id="email">
					  Phone No:<br>
					  <input type="text" name="phone" id="phone">
					  <br>
					  Experience:<br>
					  <input type="text" name="experience" id="experience">
					  <br>
					  Salary:<br>
					  <input type="number" name="salary" id="salary">
					  <br>
					  Profile photo:<br>
					  <input type="file" name="post_Fimage" id="post_Fimage">
					  <br><br>
					  <input type="submit" value="Submit">
					  <input type="hidden" name="action" value="new_post" />
					  <?php wp_nonce_field( 'new-post' ); ?>
					</form> 
                </div>
            </div> 
    </div>


<?php
if($_POST['action'] == "new_post") {
echo "hii";
    // Do some minor form validation to make sure there is content
    if (isset ($_POST['firstname'])) {
        $titlee =  $_POST['firstname'];
    } else {
        echo 'Please enter a  title';
    }
    if (isset ($_POST['lastname'])){
    	$titles = $_POST['lastname'];
    }

    if(isset ($_POST['post_Fimage'])){
      $wp_filetype = $_POST['post_Fimage'];  
     }
$title = $titlee.$titles;
$uploaddir = wp_upload_dir();
$file = $_FILES["post_Fimage"]["name"];

$uploadfile = $uploaddir['path'] . '/' . basename( $file );

move_uploaded_file( $_FILES["post_Fimage"]["tmp_name"] , $uploadfile );
$filename = basename( $uploadfile );

$wp_filetype = wp_check_filetype(basename($filename), null );

    // Add the content of the form to $post as an array
    $new_post = array(
        'post_title'    => $title,
        'post_mime_type' => $wp_filetype['type'],
        'post_status'   => 'publish',           // Choose: publish, preview, future, draft, etc.
        'post_type' => 'employee'  //'post',page' or use a custom post type if you want to
    );
    $pid = wp_insert_post($new_post); 
    $attach_id = wp_insert_attachment( $new_post, $uploadfile ); 
    //echo "<pre>";print_r($wp_filetype);echo "</pre>";
    //echo "<pre>";print_r($_FILES);echo "</pre>";
    set_post_thumbnail( $pid, $attach_id ); 
    }
    //save the new post
    
    //insert taxonomies

     if($pid){
         echo "Employee data added";
     }else{
         echo "Employee Data not added";
     }

?>




<?php return ob_get_clean(); }


// remove default date column in employee cpt
add_filter('manage_employee_posts_columns', 'ST4_columns_remove_category');
 
function ST4_columns_remove_category($defaults) {
    unset($defaults['date']);
    return $defaults;
}

// ONLY Employee CUSTOM TYPE POSTS
add_filter('manage_employee_posts_columns', 'ST4_columns_head_only_employee', 5);
add_action('manage_employee_posts_custom_column', 'ST4_columns_content_only_employee', 5, 2);
 
// CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
function ST4_columns_head_only_employee($defaults) {
    $defaults['Email'] = 'Email';
    $defaults['Phone_No'] = 'Phone No';
    $defaults['Experience'] = 'Experience';
    $defaults['Salary'] = 'Salary';
    $defaults['Profile_Photo'] = 'Profile Photo';
    return $defaults;
}
function ST4_columns_content_only_employee($column_name, $post_ID) {
    if ($column_name == 'Profile_Photo') {
       echo get_the_post_thumbnail($post_id, 'medium');
    }
}


/* meta box */
function global_notice_meta_box() {

    $screens = array( 'post', 'page', 'book' );

    foreach ( $screens as $screen ) {
        add_meta_box(
            'global-notice',
            __( 'Global Notice', 'sitepoint' ),
            'global_notice_meta_box_callback',
            $screen
        );
    }
}

add_action( 'add_meta_boxes', 'global_notice_meta_box' );