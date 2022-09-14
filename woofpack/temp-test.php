<?php
/**
  * Template Name: Test 
 * 
 */

?>

<?php get_header() ; ?>
<style>
.s002 form {
    width: 100%;
    max-width: 100%;
}
</style>
<div class="s002">   
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
   
          <div class="input-field fifth-wrap">		  
		   <p>&nbsp;&nbsp;&nbsp;</p>
            <input type="submit" class="btn-search" type="button" name="query_form" value="Search Now"/>
			<?php wp_nonce_field( 'mjt_export_csv', 'mjt_export_csv' ); ?>
          </div>
        </div>
      </form>
	  <form name="result" method="post" action="" enctype="multipart/form-data" class="woof_form result" id="result">       
        <div class="inner-form">	
          <div class="input-field full-wrap">
	<?php 	
	  if( isset( $_POST['serach_key'] ) && isset( $_POST['mjt_export_csv'] ) ) {
				$where_final = '';
				$mjt_sql = "select * from wp21_exorder";		
				$serach_key =  $_POST['serach_key']; 
				global $wpdb , $cnt; $cnt = 1;
				$sql = "SELECT * FROM wp21_exorder 
						where lineitem_name LIKE '%".$serach_key."%'
							OR lineitem_variant_title LIKE '%".$serach_key."%'
							OR size LIKE '%".$serach_key."%'
							OR allergies LIKE '%".$serach_key."%'
							OR exception LIKE '%".$serach_key."%'";
					 echo $sql ; echo '<hr></hr>'; 
				$result  = $wpdb->get_results($sql);
				
				if ($result > 0 ) {
					echo '<table border="1" cellpadding="5"><thead><tr>
							<th>Sr No.</th>
							<th>Order Number</th>
							<th>Created At</th>
							<th>Email</th>
							<th>Lineitem Name</th>
							<th>Lineitem Variant Title</th>
							<th>Lineitem Quantity</th>	 ' ;
							/* <th>Lineitem Price</th>
							<th>Shipping Name</th>
							<th>Shipping Address 1</th>	
							<th>Shipping Address 2</th>
							<th>Shipping City</th>
							<th>Shipping Province Code</th>	
							<th>Shipping Company</th>
							<th>Shipping Country Code</th>
							<th>Shipping Zip</th>
							
							<th>Message</th>	
							<th>Customer Orders Count</th>
							<th>Discount Codes </th>							*/
							echo '<th>Size</th>
							<th>Allergies</th>
							<th>Exception</th>	
							
							<th>Codes </th>							
							</tr></thead><tbody><tr>';
					
				 foreach( $result as $results ) {
					echo '<tr>';
					echo '<td>'.$cnt.'</td>';
					echo '<td>'.$results->order_number .'</td>';
					echo '<td>'.$results->created_at .'</td>';
					echo '<td>'.$results->email .'</td>';
					echo '<td>'.$results->lineitem_name .'</td>';
					echo '<td>'.$results->lineitem_variant_title .'</td>';	
					echo '<td>'.$results->lineitem_quantity .'</td>';
					/* echo '<td>'.$results->lineitem_price .'</td>';
					echo '<td>'.$results->shipping_name .'</td>';
					echo '<td>'.$results->shipping_address_1 .'</td>';
					echo '<td>'.$results->shipping_address_2 .'</td>';
					echo '<td>'.$results->shipping_city .'</td>';
					echo '<td>'.$results->shipping_province_code .'</td>';	
					echo '<td>'.$results->shipping_company .'</td>';	
					echo '<td>'.$results->shipping_country_code .'</td>';
					echo '<td>'.$results->shipping_zip .'</td>'; 
					
					echo '<td>'.$results->message.'</td>';	
					echo '<td>'.$results->customer_orders_count.'</td>';	
					echo '<td>'.$results->discount_codes.'</td>';	
					*/
					echo '<td>'.$results->size .'</td>';
					echo '<td>'.$results->allergies.'</td>';
					echo '<td>'.$results->exception.'</td>';
					
					echo '<td>'.$results->codes.'</td>';								
					echo '</tr>';
					$cnt = 1+$cnt ;
				}
				echo '</tbody></table>';
			}
			
	
				/* 
				"Meat only, treats only"; 
				$column_detail_data = array(
					'column_name'   => 'lineitem_name',
					'where' => $lineitem_name_where,
					'serach_value' => $serach_key,
				);
				$where_final .= $this->create_query( $column_detail_data, $where_final ); */
			}
			
		?> 
		 </div>
        </div>
      </form>
</div>

<?php get_footer() ; 
 mjt_woofpack_choices_script();
?>