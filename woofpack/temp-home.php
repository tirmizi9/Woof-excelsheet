<?php
/**
  * Template Name: Order Filtering
 * 
 */

?>

<?php get_header() ; ?>
<style>
#filteragaindiv{ }
.seventh-wrap{width:70%;float: left;}
#filteragaindiv .fifth-wrap{
	width: 25%;
    max-width: 25%;
    /* min-width: 220px !important; */
    float: right;
}
.woof-download-btn{
	float: left;
    line-height: 45px;
	text-transform:uppercase;
}
.s002 form .inner-form .input-field.fifth-wrap .btn-search {
    background: #7bb215 !important;
    padding: 5px 20px;
    margin-top: 20px;
	text-align: center;
}
.s002 form .inner-form .input-field input.usethisfile{
	background: #7bb215 !important;
    padding: 10px 20px;
    margin-top: 20px;
    text-align: center;
    color: #fff;
}
.s002 form#resortingcsv .inner-form .input-field.fifth-wrap{
	min-width: 290px;
}
.s002 form .inner-form .input-field.first-wrap .btn-search{
	height: 70px;
    width: 100%;
    background: #7bb215 !important;
    padding: 10px 20px;
    margin-top: 20px;
    white-space: nowrap;
    border-radius: .5px;
    font-size: 20px;
    color: #fff;
    transition: all .2s ease-out, color .2s ease-out;
    border: 0;
    cursor: pointer;
    font-weight: 400;
    font-family: 'Poppins', sans-serif;
}
.button:not(.components-button):not(.customize-partial-edit-shortcut-button), input[type="button"]:not(.components-button):not(.customize-partial-edit-shortcut-button), input[type="reset"]:not(.components-button):not(.customize-partial-edit-shortcut-button), input[type="submit"]:not(.components-button):not(.customize-partial-edit-shortcut-button){
    color: #fff;
    background: #ff9800;
}
.mjt_import_wrap .mjt_btn_import{
	width: 45% !important;
    float: left;
    margin: 0 5px 0 0;
}
.mjt_import_wrap input[type=file] {
	width: 45% !important;
    float: left;
    margin: 0 5px 0 0;
}
.mjt_advance{
	color: #ffeb3b;
    font-weight: 500;
    float: none;
    font-size: 16px;
    letter-spacing: 1px;
}
.mjt_btn_import{ margin-top: 0px !important}
#deleteSubmit{
	float: right;
    color: #fff;
    padding: 10px 20px;
}
</style>
   <?php
 // https://mdbootstrap.com/snippets/jquery/mdbootstrap/920555
	global $wpdb;
	
	/*  if(isset($_POST['importSubmit']) && $_POST['status_action'] == 1){ */
	 if( isset($_POST['importSubmit']) ){
					// Allowed mime types
					$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/xlsx', 'application/vnd.msexcel', 'text/plain');
					$tp = $_FILES['orderList']['type'] ;
					$name = $_FILES["orderList"]["name"];
					$tmp = explode('.', $name);
					$ext = end($tmp);
					echo  '<!--'.$tp .', '. $ext .'-->';
					
					// Validate whether selected file is a CSV file
					if(!empty($_FILES['orderList']['name']) && in_array($_FILES['orderList']['type'], $csvMimes)){
						
						// If the file is uploaded
						if(is_uploaded_file($_FILES['orderList']['tmp_name'])){
							
							// Open uploaded CSV file with read-only mode
							$csvFile = fopen($_FILES['orderList']['tmp_name'], 'r');
							
							// Skip the first line
							fgetcsv($csvFile);
							
							// Parse data from CSV file line by line
							while(($line = fgetcsv($csvFile)) !== FALSE){
								// Get row data
									$order_number   = @$line[0];
									$created_at  = @$line[1];
									$email  = @$line[2];
									$lineitem_name = @$line[3];
									$lineitem_variant_title   = @$line[4];
									$lineitem_quantity  = @$line[5];
									$lineitem_price  = @$line[6];
									$shipping_name = @$line[7];
									$shipping_address_1   = @$line[8];
									$shipping_address_2  = @$line[9];
									$shipping_city  = @$line[10];
									$shipping_province_code = @$line[11];
									$shipping_company   = @$line[12];
									$shipping_country_code  = @$line[13];
									$shipping_zip   = @$line[14];
									$size  = @$line[15];
									$allergies   = @$line[16];
									$exception  = @$line[17];
									$message   = @$line[18];
									$customer_orders_count  = @$line[19];
									$discount_codes   = @$line[20];
									
										$codes   = $_POST['code_action'];
									/* if( @$line[21] == '' || @$line[21] == 'in-progress' ){ }else{
										$codes   = @$line[21];
									} */
									
								global $wpdb;	
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
									));
								
								
							}
							
							// Close opened CSV file
				fclose($csvFile);
							
				$qstring = '<b style="color:green">Status => Success</b>';
			}else{
				$qstring = '<b style="color:red">Status => Error</b>';
			}
		}else{
						
			$qstring = '<b style="color:red">Status = Invalid file type</b>';
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
	
	 <form name="importcsv" method="post" action="" enctype="multipart/form-data" class="woof_form" id="importcsv">
		 <div class="import-form inner-form">			
				  <div class="input-field half-wrap mjt_import_wrap">
					<div class="icon-wrapp">		
						<p><label>Import CSV</label>	</p>		
					</div>
					<input id="csvfile" type="file" name="orderList" placeholder="Import CSV" id="file" aria-label="File browser example">
					<span class="file-custom"></span>
					<input type="submit" name="importSubmit" value="Import Excelsheet" class="btn-search mjt_btn_import">
					<input type= "hidden" id="code_action" name="code_action" value="in-progress" />				
					
					<?php
						echo ($total_existing_records > 0 ? '<p style="color:#fff ">Please delete old data before import new CSV </p><!---'.$total_existing_records.'--->':'') ;
					/* echo ($total_existing_records > 0 ? '<p style="color:#fff ">There are '.$total_existing_records.' records in the database, Please delete the records to import the new sheet</p>':'') ; */?>
					
				  </div>
				  <div class="input-field fifth-wrap">
				  <?php if( $total_existing_records > 0 ){ ?>
					<input type="button" id="deleteSubmit" value="DELETE" name="deleteSubmit" class="button button-primary" style="float:right" onclick="deleltconfirm(this)"><input type= "hidden" id="delete_action" name="delete_action" value="" />
				  <?php } ?>
				 </div>
			 
		  </div>
		 
		  
	</form>
  
	
      <form name="sortingcsv" method="post" action="" enctype="multipart/form-data" class="woof_form" id="sortingcsv">       
        <div class="inner-form">	
          <div class="input-field fouth-wrap">
				<div class="icon-wrapp">		
				 <p><label>Sort By</label>	</p>		
				</div>	
				<div class="icon-wrap">
				  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16 8v-4l8 8-8 8v-4h-5v-8h5zm-7 0h-2v8h2v-8zm-4.014 0h-1.986v8h1.986v-8zm-3.986 0h-1v8h1v-8z"/></svg>			 
				</div>			
				<select data-trigger="" name="orderid"> 
				  <option value="">All</option>	
				  <option value="single">Single Line</option>
				  <option value="double" >Double Line</option>
				  <option value="multiple">Multiple Line</option>
				</select>
          </div>		  
		  <div class="input-field first-wrap">
			   <div class="icon-wrapp">		
				 <p><label>Sort By Any Keyword</label>	</p>		
				</div>
				<div class="icon-wrap">
				  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16 8v-4l8 8-8 8v-4h-5v-8h5zm-7 0h-2v8h2v-8zm-4.014 0h-1.986v8h1.986v-8zm-3.986 0h-1v8h1v-8z"/></svg>			   
				</div>
				<input id="search" type="text" name="serach_key" placeholder="What are you looking for?">
          </div>
		   <div class="input-field fouth-wrap">
				<div class="icon-wrapp">		
				 <p><label>Field Name</label>	</p>		
				</div>	
				<div class="icon-wrap">
				  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16 8v-4l8 8-8 8v-4h-5v-8h5zm-7 0h-2v8h2v-8zm-4.014 0h-1.986v8h1.986v-8zm-3.986 0h-1v8h1v-8z"/></svg>			 
				</div>			
				<select data-trigger="" name="field_name"> 
					<option value="">All</option>
					<option value="allergies">Allergies</option>
					<option value="exception">Exception</option>						
					<option value="lineitem_name">lineitem Name</option>
					<option value="lineitem_variant_title">lineitem Variant Title</option>							
					<option value="size">Size</option>
				</select>	  
				
          </div>
   
          <div class="input-field fifth-wrap">		 
		  <p><a href="<?php echo get_bloginfo('url');?>/advance-filtration/ " class="mjt_advance" target="_blank">Advance Search</a>
		  <input type="hidden" name="wheree" value="in"></p>
		  <?php /*  <p><a href="#" class="mjt_advance" onclick="toggle_advancesearchform();">Advance Search</a>
		 </p> */ ?>
            <input type="submit" class="btn-search" type="button" name="exportorderlist" id="toggle_btn" value="Filter Now"/>
			<?php  wp_nonce_field( 'mjt_export_csv', 'mjt_export_csv' );  ?>
			 	
          </div>
        </div>
     </form>
	 <?php /*  <!--  Advance Form-->  <form name="sortingcsv" method="post" action="" enctype="multipart/form-data" class="woof_form" >      
	
        <div class="inner-form" id="mjt_advancesearchform" style="display:none;">	
          <div class="input-field fouth-wrap">
            <div class="icon-wrapp">		
             <p><label style="margin-top: 30px;">Size</label>	</p>		
            </div>				
		<?php 
			global $wpdb ;
			$sql = "SELECT DISTINCT `size` FROM `wp21_exorder`";
			$results = $wpdb->get_results( $sql );
			echo '<select data-trigger="" name="size">
              <option placeholder="">All</option>';
			if ($results > 0 ) { 
				foreach( $results as $result ) { ?>            
					<option value="<?php echo $result->size ; ?>"><?php echo $result->size ; ?></option>		  
					<?	}
			} 
			echo '</select>'; ?>			
         
          </div>

	 <div class="input-field fouth-wrap">
            <div class="icon-wrapp">
              <label>Exception</label>
			  <p><label><input type="radio" name="rd_exception" value="in"> Include </label>
			<label><input type="radio" name="rd_exception" value="not_in"> Exclude </label></p>
            </div>
			
		<?php 
		global $wpdb ;
		$sql = "SELECT DISTINCT `exception` FROM `wp21_exorder`";
		$results = $wpdb->get_results( $sql );
		echo '<select data-trigger="" name="exception">
              <option placeholder="">Exception</option>';
		if ($results > 0 ) { 
			 foreach( $results as $result ) { ?>            
				<option value="<?php echo $result->exception ; ?>"><?php echo $result->exception ; ?></option>		  
             <?	} 
		 
			} echo '</select>'; ?>
       </div>
        <div class="input-field fouth-wrap">
            <div class="icon-wrapp">
              <label>Allergies</label><p> <label><input type="radio" name="allergies" value="in"> Include </label>
			<label><input type="radio" name="allergies" value="not_in"> Exclude </label></p>
            </div>
			<?php 
		global $wpdb ;
		$sql = "SELECT DISTINCT `allergies` FROM `wp21_exorder`";
		$results = $wpdb->get_results( $sql );
		echo '<select data-trigger="" name="dd_allergies">
		 <option placeholder="">Allergies</option>';
		if ($results > 0 ) { 
			 foreach( $results as $result ) {		?>
				 <option value="<?php echo $result->allergies ; ?>"><?php echo $result->allergies ; ?></option>		  
			 <?	} 
		 
			} echo '</select>'; ?> 
         
          </div> 
          <div class="input-field fouth-wrap">
            <div class="icon-wrapp">
				<label>Lineitem Name</label><p><label><input type="radio" name="lineitem_name" value="in"> Include </label>
				<label><input type="radio" name="lineitem_name" value="not_in"> Exclude </label></p>
            </div>
			<?php 
				global $wpdb ;
				$sql = "SELECT DISTINCT `lineitem_name` FROM `wp21_exorder`";
				$results = $wpdb->get_results( $sql );
				 echo '<select data-trigger="" name="dd_lineitem_name">
				 <option placeholder="">Lineitem Name</option>';
				if ($results > 0 ) {
					 foreach( $results as $result ) { ?>            
						  <option value="<?php echo $result->lineitem_name ; ?>"><?php echo $result->lineitem_name ; ?></option>
						<?	} 
				} echo '</select>'; ?>
          </div> 		  
		
   
          <div class="input-field fifth-wrap">		  
		   <p style="margin-top: 30px;">&nbsp;&nbsp;&nbsp;</p>
            <input type="submit" class="btn-search" type="button" name="exportorderlist" value="Filter Now"/>
			<?php wp_nonce_field( 'mjt_export_csv', 'mjt_export_csv' ); ?>
          </div>
        </div>
      </form>
	  <!---End of advance form---> 
	  */ ?>
	  
	  
	   <form name="resortingcsv" method="post" action="" enctype="multipart/form-data" class="woof_form" id="resortingcsv" style="opacity:0">
			<div class="inner-form" id="usefilediv">
			
				<div class="input-field fifth-wrap"> 
					<?php 					
						global $wpdb;
						$sql = "SELECT `csv_url`, `query_value`, `query_id` FROM `wp21_filterquery` getLastRecord ORDER BY query_id DESC LIMIT 1";
						$results = $wpdb->get_row( $sql );
					?>
					<a href="<?php echo $results->csv_url ;?>" class="btn-search woof-download-btn" name="downloadorderlist" title="Download now" download> Download now</a>				
				</div>
				<div class="input-field fifth-wrap"> 				
					<input type="hidden"  name="sqllastquery" value="<?php echo $results->query_value ;?>">	
					<input type="hidden" name="sqlorderids" id="sqlorderids" value="<?php echo $results->query_id ;?>">	
					<input type="button" class="usethisfile" name="usethisfile" onclick="usethisfiles();" value="Use This File">				
				</div>
				<?php /* $odd =   unserialize($results->orderids  ) ;
				print_r($odd); */
				?>
			</div>
			<div class="inner-form" id="filteragaindiv" style="display:none;">
				<div class="input-field seventh-wrap">
				   <div class="icon-wrapp">		
					 <p><label>Sort By Any Keyword</label>	</p>		
					</div>
					<div class="icon-wrap">
					  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16 8v-4l8 8-8 8v-4h-5v-8h5zm-7 0h-2v8h2v-8zm-4.014 0h-1.986v8h1.986v-8zm-3.986 0h-1v8h1v-8z"/></svg>
					</div>
					<input id="search" type="text" name="serach_key" placeholder="Enter Keyword">
				</div>
		   
				  <div class="input-field fifth-wrap">		  
				   <p>&nbsp;&nbsp;&nbsp;</p>
					<input type="submit" class="btn-search" type="button" name="filter-again" value="Filter Again"/>
					<?php wp_nonce_field( 'mjt_export_csvv', 'mjt_export_csvv' ); ?>
				  </div>
			</div>
			
      </form>
    </div>	
  	
 <?php /* if ( is_user_logged_in() ) {    }else{ ?> 
	<div class="s002">
		 <form>
			<fieldset>
			  <legend>WoofPack</legend>
			</fieldset>
		</form>
	</div>
  <?php  } */  ?> 
<?php get_footer() ;
 mjt_woofpack_choices_script();
 /*<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M16 8v-4l8 8-8 8v-4h-5v-8h5zm-7 0h-2v8h2v-8zm-4.014 0h-1.986v8h1.986v-8zm-3.986 0h-1v8h1v-8z"/></svg> */
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
function usethisfiles(){
	var adminurl ='<?php echo admin_url('admin-ajax.php' );?>';
	var ordids =  jQuery('#sqlorderids').val();
        var request = jQuery.ajax({           
			type: 'post',
            url: '<?php echo admin_url('admin-ajax.php' );?>',
			data: {action: 'm_dbupdatedelivered', ds_url: adminurl,ord_ids:ordids},
            success: function(data) {
                 alert(data);
            }
        });	
/* var x = document.getElementById("filteragaindiv");
  if (x.style.display === "none") {
    x.style.display = "flex";
  } else {
    x.style.display = "none";
  } */
	
} 
function toggle_advancesearchform(){
	/*mjt_advance*/
var x = document.getElementById("mjt_advancesearchform");
var btn = document.getElementById("toggle_btn");
  if (x.style.display === "none") {
    x.style.display = "flex";
  } else {
    x.style.display = "none";
  }
   if (btn.style.display === "none") {
    btnstyle.display = "flex";
  } else {
    btn.style.display = "none";
  }
}
/* 
document.getElementById("csvfile").onchange = function() {
    document.getElementById("form").submit();
}; */

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
</script>