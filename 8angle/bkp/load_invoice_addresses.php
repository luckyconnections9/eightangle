<?php  include 'includes/common.php';
$meta_title = "Address - 8angle | POS  ";
$userDetails=$userClass->userDetails($session_uid);
isCompany($company_id);
include_once 'includes/addressesClass.php';
$addresses = new addressesClass();
include_once 'includes/customersClass.php';
$customers = new customersClass();
$customer_id = ($_GET['customer']);
if(isset($_GET['customer']) and $customers->getID($customer_id)) {
	$customer_id = ($_GET['customer']);
} else {
	$customer_id = "";
}
$type=($_GET['type']);
 ?>
 <table id="dataTable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
								<thead>					
									<tr>
										 <th>#</th>
										 <th>Customer Name</th>
										 <th>Company Name</th>
										 <th>Address</th>
										 <th>GSTIN</th>
										 <th>City</th>
										 <th>State</th>
										 <th>PIN</th>
									 </tr>
								 </thead>
								 <tbody>
								<?php
								$params = array();
								$params[':company_id'] = $company_id;
								if($customer_id)  {
									$query ="SELECT * FROM addresses WHERE customer_id=:customer_id  AND `deleted` = 'N' AND `company_id` = :company_id";
									$params[':customer_id'] = $customer_id;
								} else {
									$query ="SELECT * FROM addresses WHERE `deleted` = 'N' AND (customer_id='' OR customer_id='0' ) AND `company_id` = :company_id";
								}
								$stmt = getDB()->prepare($query);
								$stmt->execute($params);
									 $i = 1;
										if($stmt->rowCount()>0)
										{
											while($row=$stmt->fetch(PDO::FETCH_OBJ))
											{
												$cust_data = $addresses->getCustomer($row->customer_id);
												$city_data = $addresses->getCity($row->city);
											?>
												<tr>
													<td>
													<?php if($type == "billing") { ?>
													<a class="btn btn-sm" href="javascript:;" onclick='addinvcust(<?php echo $row->id;?>,<?php echo $row->customer_id;?>,"<?php echo $cust_data->name;?>", "","<?php echo $row->gst_number;?>","<?php echo $row->address;?>","<?php echo $cust_data->email;?>",<?php echo $row->city;?>,"<?php if(!empty($row->city)) echo $city_data->Name;?>","<?php if(!empty($row->state)) echo $row->state;?>","<?php echo $row->pin;?>"); ' data-dismiss="modal">
														Select
													</a>
													<?php } ?>
													<?php if($type == "shipping") { ?>
													<a class="btn btn-sm" href="javascript:;" onclick='addshippingaddress(<?php echo $row->id;?>,<?php echo $row->customer_id;?>,"", "","<?php echo $row->gst_number;?>","<?php echo $row->address;?>","",<?php echo $row->city;?>,"<?php if(!empty($row->city)) echo $city_data->Name;?>","<?php if(!empty($row->state)) echo $row->state;?>","<?php echo $row->pin;?>"); ' data-dismiss="modal">
														Select
													</a>
													<?php } ?>
													</td>
													<td><?php if(!empty($row->customer_id)) print(html_entity_decode($cust_data->name));  ?></td>
													<td><?php print(html_entity_decode($row->name)); ?></td>
													<td><?php print(html_entity_decode($row->address)); ?></td>
													<td><?php print(html_entity_decode($row->gst_number)); ?></td>
													<td><?php if(!empty($row->city)) print(html_entity_decode($city_data->Name));  ?></td>
													<td><?php print(html_entity_decode($row->state)); ?></td>
													<td><?php print(html_entity_decode($row->pin)); ?></td>
												</tr>
												<?php
											}
										} else { ?>
										
										<?php } 
								?>
								<tr><td colspan="8">
										
										<a style="cursor: pointer;" onclick="window.open('addresses_add.php?customer_id=<?php echo $customer_id;?>','',' scrollbars=yes,width=600, resizable=yes,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0').focus()" class="btn btn-large btn-info"  data-dismiss="modal"><i class="glyphicon glyphicon-plus" ></i> Add More Addresses</a>
										
										</td></tr>
								</tbody>
							</table>