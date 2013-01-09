<div class="row">
	<div class="span6">
		<?
			global $core;
			$lodeliv_id = $core->view[0];
			$all_addrs = $core->view[1];
			$count = $core->view[2];

			$deliv = core::model('lo_order_deliveries')->load($lodeliv_id);
			$addresses = array();

			if(intval($deliv['deliv_address_id'])==0 || intval($deliv['pickup_address_id'])==0) {
				foreach ($all_addrs as $addr) {
					$addresses[$addr['address_id']] = $addr['formatted_address'];
				}
			} else {
				$addresses[$deliv['pickup_address_id']] =  $deliv['pickup_address'].', '.$deliv['pickup_city'].', '.$deliv['pickup_code'].', '.$deliv['pickup_postal_code'];
			}
			//print_r($options);
			//echo $core->config['domain']['feature_force_items_to_soonest_delivery'];
			//if($core->config['domain']['feature_force_items_to_soonest_delivery'] == 1)

			if ($deliv['pickup_address_id']) {
				echo "<span class='delivery'>Pickup #".$count.":</span> ";				
				echo "<span class='delivery_date'>".core_format::date($deliv['pickup_start_time'],"short-weekday");
					echo " between ".date('g:i a',$deliv['pickup_start_time'])."-".date('g:i a',$deliv['pickup_end_time']);	
				echo "</span> ";
			} else {
				echo "<span class='delivery'>Delivery #".$count.":</span> ";
				echo "<span class='delivery_date'>".core_format::date($deliv['delivery_start_time'],"short-weekday");
					echo " between ".date('g:i a',$deliv['delivery_start_time'])."-".date('g:i a',$deliv['delivery_end_time']);
				echo "</span> ";
			}
			
				// else
			//print_r($deliv);
			# print a generic header than will be updated by JS
			# when the user picks a delivery day
			//echo($core->i18n['field:checkout_pickup']);

			//choose address
			if(count($addresses) > 1) {
				echo '<select name="delivgroup-'.$deliv['dd_id_group'].'">';
					foreach($addresses as $id=>$address) {
						echo '<option value="'.$id.'">'.$address.'</option>';
					}
				echo '</select>';
			} else {
				list($id, $address) = each($addresses);
				echo '<input name="delivgroup-'.$deliv['dd_id_group'].'" type="hidden" value="'.$id.'" />';
				echo $address;
			}
		?>
	</div>
</div>
