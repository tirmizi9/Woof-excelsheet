<?php
/**
 * Handles CSV export.
 *
 * @package     Mjt_Csv
 * @copyright   Copyright (c) 2021
 * @license     https://opensource.org/licenses/GPL-3.0 GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The class that handles CSV export.
 */
class Mjt_Csv_Handler_woofpack {
	public function __construct() {
		add_action( 'init', array( $this, 'mjt_init' ) );

	}
	public function mjt_init( $order_id ) {
		if ( isset( $_POST['mjt_export_csv'] ) && wp_verify_nonce( $_POST['mjt_export_csv'], 'mjt_export_csv' ) ) {
			
			$group_by_filter = '';
			$where_final = '';
			$mjt_sql = "select * from wp21_exorder WHERE codes NOT IN ('delivered') ";	
			if( isset( $_POST['serach_key'] )){
				$serach_key =  $_POST['serach_key']; 
				if ( isset( $_POST['field_name'] )  ) {
					 $field_name = $_POST['field_name'] ;
					 $wheree = $_POST['wheree'] ;
					 $column_detail_data = array(
						'column_name'   => $field_name,
						'where' => $wheree,
						'serach_value' => $serach_key,
					);
					$where_final .= $this->create_query( $column_detail_data, $where_final );
				}else{
					$where_final .= " AND lineitem_name LIKE '%".$serach_key."%'
							OR lineitem_variant_title LIKE '%".$serach_key."%'
							OR size LIKE '%".$serach_key."%'
							OR allergies LIKE '%".$serach_key."%'
							OR exception LIKE '%".$serach_key."%'";
				}
			}else{
				
			}	
			if ( isset( $_POST['column_name'] ) && isset( $_POST['where'] ) ) {
				$column_name   = wp_unslash( $_POST['column_name'] );
				$where   = wp_unslash( $_POST['where'] );
				$serach_value   = wp_unslash( $_POST['serach_value'] );	
				$check_duplicacy = array();
				foreach ( $column_name as $i => $name ) {
					if ( empty( $serach_value[ $i ] ) || empty( $column_name[ $i ] ) || in_array( $column_name[ $i ] , $check_duplicacy ) ) {
						continue;
					}
					$column_detail_data = array(
						'column_name'   => $column_name[ $i ],
						'where' => $where[ $i ],
						'serach_value' => $serach_value[ $i ],
					);
					$where_final .= $this->create_query( $column_detail_data, $where_final );
					$column_detail[] = $column_detail_data;
					$check_duplicacy[] = $column_name[ $i ];
				}
			}
			if ( isset( $_POST['exception'] ) && isset( $_POST['rd_exception'] ) ) {
				$exception = $_POST['exception'];
				$exception_where = $_POST['rd_exception'];
				if ( ! empty( $exception_where ) ) {
					$column_detail_data = array(
						'column_name'   => 'exception',
						'where' => $exception_where,
						'serach_value' => $exception,
					);
					$where_final .= $this->create_query( $column_detail_data, $where_final );
				}				
			}
			if ( isset( $_POST['dd_allergies'] ) && isset( $_POST['allergies'] ) ) {
				$allergies = $_POST['dd_allergies'];
				$allergies_where = $_POST['allergies'];
				if ( ! empty( $allergies_where ) ) {
					$column_detail_data = array(
						'column_name'   => 'allergies',
						'where' => $allergies_where,
						'serach_value' => $allergies,
					);
					$where_final .= $this->create_query( $column_detail_data, $where_final );
				}				
			}
			if ( isset( $_POST['dd_lineitem_name'] ) && isset( $_POST['lineitem_name'] ) ) {
				$lineitem_name = $_POST['dd_lineitem_name'];
				$lineitem_name_where = $_POST['lineitem_name'];
				$column_detail_data = array(
					'column_name'   => 'lineitem_name',
					'where' => $lineitem_name_where,
					'serach_value' => $lineitem_name,
				);
				$where_final .= $this->create_query( $column_detail_data, $where_final );
			}
			 
/* 			$column_detail_data2 = array(
				'column_name'   => 'codes',
				'where' => 'not_in',
				'serach_value' => 'delivered',
			);
			$where_final .= $this->create_query( $column_detail_data2, $where_final );  */
			
			
			
			if( isset( $_POST['orderid'] ) ) {
				$order_id = $_POST['orderid'];
				$where_final = $this->group_by_filter( $order_id, $where_final );
			}
			$order_by = 'order by order_number ASC';
			$final_sql_query = $mjt_sql . ' ' . $where_final . ' ' . $group_by_filter . ' ' . $order_by;
			$this->export_data( $final_sql_query );
		}
	}
	public function create_query( $column_detail = '', $where = '', $and_or_where = 'AND' ) {
		//echo '<pre>';
		//print_r($column_detail);die;
		/* if ( empty( $where ) ) {
			$and_or_where = 'WHERE';
		} */
		$column_name = $column_detail['column_name'];
		$where_val = $column_detail['where'];
		$serach_value = $column_detail['serach_value'];
		if ( empty( $column_name ) ) {
			return $where;
		}	
			
		switch ($where_val) {
		case "eq":
			//$serach_value = strval( $serach_value );
			$where = " {$and_or_where} {$column_name} = '$serach_value'";
			break;
		case "lt":
			$where = " {$and_or_where} {$column_name} < '$serach_value'";
			break;
		case "gt":
			$where = " {$and_or_where} {$column_name} > '$serach_value'";
			break;
		case "lt_equal_to":
			$where = " {$and_or_where} {$column_name} <= '$serach_value'";
			break;
		case "gt_equal_to":
			$where = " {$and_or_where} {$column_name} >= '$serach_value'";
			break;
		case "is_not_equal":
			$where = " {$and_or_where} {$column_name} != '$serach_value'";
			break;
		case "like":
			$where = " {$and_or_where} {$column_name} LIKE '{$serach_value}%'";
			break;
		case "like_all":
			$where = " {$and_or_where} {$column_name} LIKE '%{$serach_value}%'";
			break;
		case "not_like":
			$serach_value = strval( $serach_value );
			$where = " {$and_or_where} {$column_name} NOT LIKE '{$serach_value}%'";
			break;
		case "in":
			if ( ! is_array( $serach_value ) ) {
				$serach_value = explode( ',', $serach_value );
			}			
			$serach_value = array_map( array( $this, 'cast_to_string' ), $serach_value );
			$serach_value = implode( ',', $serach_value );
			$where = " {$and_or_where} {$column_name} IN ($serach_value)";		
			break;
		case "not_in":
			if ( ! is_array( $serach_value ) ) {
				$serach_value = explode( ',', $serach_value );
			}
			$serach_value = array_map( array( $this, 'cast_to_string' ), $serach_value );
			$serach_value = implode( ',', $serach_value );
			$where = " {$and_or_where} {$column_name} NOT IN ($serach_value)";
			break;
		default:
		$where = $where;
		}
		return $where;
	}
	public function cast_to_string( $value ) {
		return "'{$value}'";
	}
	public function group_by_filter( $orderid = '', $where = '', $and_or_where = 'AND' ) {
		if ( strpos( $where, 'order_number =' ) !== false ) {
			return $where;
		}
		if ( empty( $where ) ) {
			$and_or_where = 'WHERE';
		}
		if ( 'single' === $orderid ) {
			$where .= " {$and_or_where} `order_number` in (select `order_number` from `wp21_exorder` group by `order_number` having count(*) < 2)";
		} elseif ( 'double' === $orderid ) {
			$where .= " {$and_or_where} `order_number` in (select `order_number` from `wp21_exorder` group by `order_number` having count(*) = 2)";
		} elseif ( 'multiple' === $orderid ) {
			$where .= " {$and_or_where} `order_number` in (select `order_number` from `wp21_exorder` group by `order_number` having count(*) > 2)";
		}
		return $where;
	}
	public function export_data( $sql ) {
	/* echo $_POST['field_name'] ;
	  print_r($sql);    echo '<pre>'; die; */
		global $wpdb;
		$results = $wpdb->get_results( $sql ); 
		global $orderid ; global $orderids;  $orderid = array();
		$crnttime  = strtotime("now") ;
		$filename = $crnttime.'-order.csv';
		/* header( 'Content-type: application/csv' );
		header( 'Content-Disposition: attachment; filename=' . $filename );  */
		$upload_dir = wp_upload_dir();
		$direurl = $upload_dir['path'] ; 
		$dir_url = $direurl .'/'.$filename ; 
		$full_url = $upload_dir['url'].'/'.$filename ;
			$wpdb->insert('wp21_filterquery', array(						
				'query_value'	 => $sql,
				'csv_url' => 	$full_url			
			));		
		/* $fp = fopen( 'php://output', 'w' ); */
		$fp =   fopen($dir_url, 'a');
		$header = array( 'Order Number', 'created_at', 'email', 'lineitem_name', 'lineitem_variant_title', 'lineitem_quantity', 'lineitem_price', 'shipping_name', 'shipping_address_1', 'shipping_address_2', 'shipping_city', 'shipping_province_code', 'shipping_company', 'shipping_country_code', 'shipping_zip', 'size', 'allergies', 'exception', 'message', 'customer_orders_count', 'discount_codes' );
		fputcsv( $fp, $header );
		foreach ( $results as $data ) {			
		/* 	echo '<pre>';
			print_r($data);die; */
			$orderid[] = $data->ID; $orderids = serialize($orderid);
			$data_csv = array( $data->order_number, $data->created_at, $data->email, $data->lineitem_name, $data->lineitem_variant_title, $data->lineitem_quantity, $data->lineitem_price, $data->shipping_name, $data->shipping_address_1, $data->shipping_address_2, $data->shipping_city, $data->shipping_province_code, $data->shipping_company, $data->shipping_country_code, $data->shipping_zip, $data->size, $data->allergies, $data->exception, $data->message, $data->customer_orders_count, $data->discount_codes );
		 fputcsv( $fp, $data_csv );
		}
		global $wpdb;     
		$sql =    $wpdb->query("UPDATE wp21_filterquery SET orderids='".$orderids."' order by `query_id` DESC limit 1");
		/* $sql = "UPDATE `wp21_filterquery` SET `orderids`=\'test\'  order by `query_id` DESC limit 1"; */
		
		/* fclose( $fp );	 */
		/* echo '<script type="text/javascript">alert("hi");</script>'; */
		echo '<style>#sortingcsv, #importcsv{display:none;} #resortingcsv{opacity:1!important;}</style>';
		/* $page = get_page_by_title('update');
		wp_redirect(get_permalink($page->ID));
		exit; */
	}
}
new Mjt_Csv_Handler_woofpack();
