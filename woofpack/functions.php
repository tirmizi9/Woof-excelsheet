<?php

require_once( trailingslashit( get_template_directory() ) . 'inc/mjt-csv-handler.php' );
function mjt_woofpack_style() {	
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' ); 
	wp_enqueue_style( 'main-style', get_stylesheet_directory_uri(). '/css/main.css' );
	wp_enqueue_style( 'styles', get_stylesheet_directory_uri(). '/css/styles.css' );
	wp_register_script( 'choices', get_template_directory_uri() . '/js/extention/choices.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'choices' );
	wp_register_script( 'choices', get_template_directory_uri() . '/js/extention/flatpickr.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'choices' );
	/*wp_register_script( 'latest', get_template_directory_uri() . '/calender/js/query.latest.min.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'latest' ); */
}
add_action( 'wp_enqueue_scripts', 'mjt_woofpack_style' , 10);

function register_my_menus() {  register_nav_menus(
    array(
      'primary' => __( 'Navigation Menu' )
        )
  );
}
add_action( 'init', 'register_my_menus' );

function mjt_woofpack_bootstrap_stylesheet() {
	if(is_page() ){
		echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">';
		echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';
	}
}
add_action('wp_head','mjt_woofpack_bootstrap_stylesheet');

add_action('init', 'session_register', 1);
function session_register() {
    if (!session_id())
        session_start();
}
function mjt_woofpack_choices_script() {
?>

	<?php /*<script>
     	  flatpickr(".datepicker",
      {});

    </script>**/  ?>
    <script>
      const choices = new Choices('[data-trigger]',
      {
        searchEnabled: false,
        itemSelectText: '',
      });

    </script> 
<?php 
} 
// add_action('wp_footer','mjt_woofpack_choices_script');


function mjtcustom_scripts(){
	
	wp_localize_script( 'm_dbupdatedelivered', 'm_dbupdatedelivered', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	wp_localize_script( 'mjt_clearsession', 'mjt_clearsession', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	
}
add_action('wp_enqueue_scripts','mjtcustom_scripts');

add_action( 'wp_ajax_m_dbupdatedelivered', 'm_dbupdatedelivered' );
add_action( 'wp_ajax_nopriv_m_dbupdatedelivered', 'm_dbupdatedelivered' );
function m_dbupdatedelivered(){
	$ordids =  $_POST['ord_ids'];
	global $wpdb;
	$sql = "SELECT  `orderids` FROM `wp21_filterquery` getLastRecord ORDER BY query_id DESC LIMIT 1";
	$results = $wpdb->get_row( $sql );
	$orderids = unserialize( $results->orderids ) ; 
	$orderids = implode(", ",$orderids);
	
	/* echo $orderids; $len = sizeof($orderids); for($kk=0; $kk<$len; $kk++){ $ids = $orderids[$kk].', ';} */
	$sql2 =    $wpdb->query("UPDATE wp21_exorder SET codes='delivered' WHERE `ID` IN($orderids)");
	echo 'Updated delivered orders';
	exit; 
}

add_action( 'wp_ajax_mjt_clearsession', 'mjt_clearsession' );
add_action( 'wp_ajax_nopriv_mjt_clearsession', 'mjt_clearsession' );
function mjt_clearsession(){
	if(isset($_SESSION['delivered']) || isset($_SESSION['main']) ){ 
		unset($_SESSION['delivered']);
		unset($_SESSION['main']);
		$msg = 'Removed files';	
	}else{
		$msg = 'file is not selected';
	}
	echo $msg ;
	exit; 
}