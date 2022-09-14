<?php
/**
  * Template Name: Update 
 * 
 */

?>

<?php get_header() ; ?>
<style>
#filteragaindiv{ }
.result .inner-form{
	display: block !important;
    width: 100%;
    margin: auto;
    float: left;
}
.result .inner-form .half-wrap{
	width: 49%;
    float: left; 
}
.right-wrap{
	
}
</style>
   <?php     

  global $wp_session; 

	global $wpdb, $mjtr;
	global $mainfile, $delivered; 
	/*  if(isset($_POST['importSubmit']) && $_POST['status_action'] == 1){ */
	 if( isset($_REQUEST['mainfileSubmit']) || isset($_REQUEST['updateSubmit']) ){
	
					// Allowed mime types
					$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/xlsx', 'application/vnd.msexcel', 'text/plain');
					if( isset($_POST['mainfileSubmit']) ){ $filename= 'mainfile' ;}else{ $filename= 'delivered' ; }
					$tp = $_FILES[$filename]['type'] ;
					$name = $_FILES[$filename]["name"];
					$tmp = explode('.', $name);
					$ext = end($tmp);
					$mjtr =  '<!--'.$tp .', '. $ext .'-->';
					
					// Validate whether selected file is a CSV file
					if(!empty($_FILES[$filename]['name']) && in_array($_FILES[$filename]['type'], $csvMimes)){
						
						// If the file is uploaded
						if(is_uploaded_file($_FILES[$filename]['tmp_name'])){
							
							// Open uploaded CSV file with read-only mode
							$csvFile = fopen($_FILES[$filename]['tmp_name'], 'r');
							
							// Skip the first line
							fgetcsv($csvFile);
							
							// Parse data from CSV file line by line
							while(($line = fgetcsv($csvFile)) !== FALSE){
								// Get row data
									$sr_number   = @$line[0];
									$order_number   = @$line[1];
									$created_at  = @$line[2];
									$email  = @$line[3];
									$lineitem_name = @$line[4];
									$lineitem_variant_title   = @$line[5];
									$lineitem_quantity  = @$line[6];
									$lineitem_price  = @$line[7];
									$shipping_name = @$line[8];
									$shipping_address_1   = @$line[9];
									$shipping_address_2  = @$line[10];
									$shipping_city  = @$line[11];
									$shipping_province_code = @$line[12];
									$shipping_company   = @$line[13];
									$shipping_country_code  = @$line[14];
									$shipping_zip   = @$line[15];
									$size  = @$line[16];
									$allergies   = @$line[17];
									$exception  = @$line[18];
									$message   = @$line[19];
									$customer_orders_count  = @$line[20];
									$discount_codes   = @$line[21];
									$status   = @$line[22];
									 if( isset($_POST['mainfileSubmit']) ){
										 if(isset($_SESSION['main'])){   }
										$_SESSION['main'][] = array($sr_number , $order_number , $created_at, $status  );
									}
									if( isset($_POST['updateSubmit']) ){
										if(isset($_SESSION['delivered'])){  }
										$_SESSION['delivered'][] = array($sr_number , $order_number , $created_at, $status  );
									}
									
									/* if( @$line[21] == '' || @$line[21] == 'in-progress' ){ 
									$status   = $_POST['code_action'];  }else{
										$codes   = @$line[21];
									} */
									
								/* global $wpdb;	
									$wpdb->insert('wp21_exorder', array(
										'order_number' => $order_number,
										'created_at'	 => $created_at,
										'email' => $email,
										'lineitem_name' 	 => $lineitem_name,
										'lineitem_variant_title'	 => $lineitem_variant_title,
										'lineitem_quantity' 	 => $lineitem_quantity,
										'lineitem_price'	 => $lineitem_price,
										'shipping_name'  => $shipping_name,
										'shipping_address_1'  => $shipping_address_1,
										'shipping_address_2' 	 => $shipping_address_2,
										'shipping_city' 	 => $shipping_city,
										'shipping_province_code' 	 => $shipping_province_code,
										'shipping_company' 	 => $shipping_company,
										'shipping_country_code' => $shipping_country_code,
										'shipping_zip'  => $shipping_zip,
										'size'  => $size,
										'allergies' 	 => $allergies,
										'exception' 	 => $exception,
										'message' 	 => $message,
										'customer_orders_count' 	 => $customer_orders_count,
										'discount_codes'  => $discount_codes,
										'codes'  => $codes,											
									)); */
								
								
							}
							
							// Close opened CSV file
				fclose($csvFile);
							
				$qstring = '<b style="color:green">Check your Files '.$mjtr.'</b>';
			}else{
				$qstring = '<b style="color:red">Status => Error '.$mjtr.'</b>';
			}
		}else{
						
			$qstring = '<b style="color:red">Status = Invalid file type '.$mjtr.'</b>';
		}
		echo $qstring ; 
	}
	/* end of importing */
	if(isset($_POST['delete_action']) && $_POST['delete_action'] == 1){
		$query = "DELETE FROM wp21_exorder";	  
		$wpdb->query ( $query );
	}	
	$query = "SELECT COUNT(*) FROM wp21_exorder";
	$total_existing_records = $wpdb->get_var( $query );	
   ?>  
 <div class="s002">             
	
	 <form name="importcsv" method="post" action="" enctype="multipart/form-data" class="woof_form" id="importcsv" style="display:block;">
	
		<div class="import-form">	
			<h3><label>Status Updating page/ comparison page</label></h3>	
		 </div>		
		 <div class="import-form">			
				  <div class="input-field fouth-wrap"> <!---in-progress-->                 
					<input id="mainfile" type="file" name="mainfile" placeholder="Update CSV">
					<input type= "hidden" id="code_action" name="code_action" value="in-progress" />
					<input type="submit" name="mainfileSubmit" value="Import Main File" class="btn-search">
					        
				  </div>
				  <div class="input-field fouth-wrap"><!---delivered-->            
					<input id="delivered" type="file" name="delivered" placeholder="Update CSV">
					<input type= "hidden" id="code_action" name="code_action" value="delivered" />
					<input type="submit" name="updateSubmit" value="Import delivered File" class="btn-search">
					         
				  </div>
				   <div class="input-field fouth-wrap right-wrap">
						<input type="button" onclick="clearfiles();" name="destry_session" value="Remove Files" class="btn-search">
				   </div>
				  
			 
		  </div>
		  
		  
	</form>
  
	  <form name="result" method="post" action="" enctype="multipart/form-data" class="woof_form result" id="result">       
        <div class="inner-form">	
          <div class="input-field half-wrap">
		  <?php
			if(isset($_SESSION['main'])){
				$main = $_SESSION['main'] ;

				  echo '<table><tr><th>Sr. No.</th><th>Record ID</th><th>Order ID</th><th>Created at</th><th>Status</th></tr>'; 
				  $len = sizeof($main) ;
				 for($kk=0;$kk<$len;$kk++){
					 $k = $kk + 1; 	
					echo '<tr><td>'. $k .'</td><td>'.$main[$kk][0].'</td><td>'.$main[$kk][1].'</td><td>'.$main[$kk][2].'</td><td>'.$main[$kk][3].'</td></tr>'; 
				 }
				  echo '</table>';	
			}				  
		  ?>
		  </div>
		  <div class="input-field half-wrap"> 
		  <?php 
			if(isset($_SESSION['delivered'])){
				$delivered = $_SESSION['delivered'] ;
				 
				  echo '<table><tr><th>Sr. No.</th><th>Record ID</th><th>Order ID</th><th>Created at</th><th>Status</th></tr>'; 
				  $len = sizeof($delivered) ;
				 	
				 for($kk=0;$kk<$len;$kk++){
					  $k = $kk + 1; 
					echo '<tr><td>'. $k .'</td><td>'.$delivered[$kk][0].'</td><td>'.$delivered[$kk][1].'</td><td>'.$delivered[$kk][2].'</td><td>'.$delivered[$kk][3].'</td></tr>'; 
				 }
				  echo '</table>'; 
			}
		  ?>
		  </div>
		 </div>
		</form>
		  
   
    </div>	
  	
 <?php    /* if ( is_user_logged_in() ) { }else{ ?> 
	<div class="s002">
		 <form>
			<fieldset>
			  <legend>WoofPack</legend>
			</fieldset>
		</form>
	</div>
  <?php  }  */ ?> 
<?php get_footer() ;
 mjt_woofpack_choices_script();
 
 ?>
 <script>
function deleltconfirm( frm ) {
  var txt;
  var r = confirm("Are You sure to delete all data");
  if (r == true) {
    document.getElementById("delete_action").value = "1";
	frm.form.submit();
	return true;
  } else {
    return false;
  }
}

function statusconfirm(frm ){
	var txt;
  var r = confirm("Whether to update as delivery");
  if (r == true) {
    document.getElementById("status_action").value = "1";
	frm.form.submit();
	return true;
  } else {
    return false;
  }
}

function clearfiles(){
	var adminurl ='<?php echo admin_url('admin-ajax.php' );?>';
	var ordids =  jQuery('#sqlorderids').val();
        var request = jQuery.ajax({           
			type: 'post',
            url: '<?php echo admin_url('admin-ajax.php' );?>',
			data: {action: 'mjt_clearsession', ds_url: adminurl},
            success: function(data) {
                 alert(data);
            }
        });	
	location.reload();
}
</script> 
  