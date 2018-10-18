<?php include 'includes/common.php';
$meta_title = "Add Company - 8angle | POS  ";
require('header.php');
require('left.php');
?>
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content-header">
		<h1>
			Add Company
		   <small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li><a href="<?php echo BASE_URL;?>companies.php">Companies</a></li>
			<li class="active">Add Company</li>
		</ol>
    </section>
	<section class="content">
		<!-- Default box -->
		<div class="box">
		<?php	
			$failure = "";
			$inserted = "";
			$name= "";
						$gst= "";
						$address= "";
						$city= 0;
						$state= "";
						$pin= "";
						$disclaimer= "";
						$description= "";
						$status= "";
						$invoice_number = "";
						$invoice_prefix ="";
						$hsn_code ="Disable";
						$sale_tax = "";
						$purchase_tax = "";
						$bank= "";
						$branch= "";
						$account_name= "";
						$account_number= "";
						$ifsc= "";
						$remarks= "";
						$bank1= "";
						$branch1= "";
						$account_name1= "";
						$account_number1= "";
						$ifsc1= "";
						$remarks1= "";
						$invoice_number_start= 1;
						$purchase_invoice_number="AutoIncrement";
						$purchase_invoice_prefix = "";
						$purchase_invoice_number_start = 1;
						
			if(isset($_POST['AddCompany']))
				{
					$name = ($_POST['name']);
					$gst = strtoupper($_POST['gst']);
					$address = ($_POST['address']);
					$city = ($_POST['city']);
					$state = ($_POST['state']);
					$pin = ($_POST['pin']);
					$disclaimer = ($_POST['disclaimer']);
					$description = ($_POST['description']);
					$status = ($_POST['status']);
					$invoice_number = ($_POST['invoice_number']);
					$invoice_prefix = strtoupper($_POST['invoice_prefix']);
					$hsn_code = ($_POST['hsn_code']);
					$sale_tax =  ($_POST['sale_tax']);
					$purchase_tax =  ($_POST['purchase_tax']);
					$bank=  ($_POST['bank']);
					$branch=  ($_POST['branch']);
					$account_name= ($_POST['account_name']);
					$account_number=  ($_POST['account_number']);
					$ifsc=  ($_POST['ifsc']);
					$remarks=  ($_POST['remarks']);
					$bank1=  ($_POST['bank1']);
					$branch1=  ($_POST['branch1']);
					$account_name1=  ($_POST['account_name1']);
					$account_number1=  ($_POST['account_number1']);
					$ifsc1=  ($_POST['ifsc1']);
					$remarks1=  ($_POST['remarks1']);
					$invoice_number_start=  ($_POST['invoice_number_start']);
					$purchase_invoice_number="Manual";
					$purchase_invoice_prefix  = strtoupper($_POST['invoice_prefix']);
					$purchase_invoice_number_start = ($_POST['invoice_number_start']);
					$logo=""; 
					if(!empty($_FILES['logo']['name'])) {
						$logoinfo=pathinfo($_FILES['logo']['name']);
						$ext=$logoinfo['extension'];
						$tempFileName = $_FILES['logo']['tmp_name'];
						$logo="logo"."m_".date('y').date('n').date('d').date('G').date('i').date('s').".$ext";
						$newFilePath = "uploads/logo/$logo";
						if(is_uploaded_file($tempFileName))
						{ 
							move_uploaded_file($tempFileName,$newFilePath);
						}
					} 
					if($crud->create($name,$gst,$description,$status,$address,$city,$state,$pin,$disclaimer,$logo,$invoice_number,$invoice_prefix,$hsn_code,$sale_tax,$purchase_tax,$bank,$branch,$account_name,$account_number,$ifsc,$remarks,$bank1,$branch1,$account_name1,$account_number1,$ifsc1,$remarks1,$invoice_number_start,$purchase_invoice_number,$purchase_invoice_prefix,$purchase_invoice_number_start))
					{
						$inserted ="Company was added successfully";
					}
					else
					{
						$failure = "Error while adding Company!";
					}
				}
				?>
				<?php
				if($inserted)
				{
				 ?>
					<div class="alert alert-success alert-dismissible"><strong>WOW! </strong><?php echo $inserted ?></div>
				<?php
				}
				if($failure)
				{
				 ?>
					<div class="alert alert-danger alert-dismissible"><?php echo $failure ?></div>
				<?php
				}
				?>
				<form class="form-horizontal" id="formCompany"  method='post' action="" enctype="multipart/form-data">
				<div class="box-body">
					<div class="col-sm-6" style="border-right:1px solid lightgray">
						<div class="form-group">
							<label for="name" class="col-sm-4 control-label">Company Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="name" value="<?php echo html_entity_decode($name); ?>" autocomplete="off" placeholder="Company Name" required>
							</div>
						</div>
						<div class="form-group">
							<label for="gst" class="col-sm-4 control-label">GSTIN</label>

							<div class="col-sm-8">
								<input type="text" class="form-control text-uppercase" value="<?php echo html_entity_decode($gst); ?>" name="gst" id="gstin" autocomplete="off" placeholder="GSTIN"> ex:- 22AAAAA0000A1Z2
							</div>
						</div>
						<div class="form-group">
						<label for="address" class="col-sm-4 control-label">Address</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="address" value="<?php echo html_entity_decode($address); ?>" autocomplete="off" placeholder="Address">
							</div>
						</div>

						<div class="form-group">
							<label for="state" class="col-sm-4 control-label">State</label>
							<div class="col-sm-8">
								<select class="form-control" name="state" onChange="getCity(this.value)">
									<option value="">Select State</option>
									<?php 
										$stmt_state = getDB()->prepare("SELECT * FROM `city` WHERE `CountryCode`='IND' GROUP BY `District` ORDER BY `District` ASC");
										$stmt_state->execute();
										$state_sel = "";
										 while($data_state=$stmt_state->fetch(PDO::FETCH_OBJ))
										 {
											if($data_state->District == $state) { $state_sel ="selected='selected'";} else { $state_sel ="";}
											echo "<option ".$state_sel." value=".$data_state->District.">".$data_state->District."</option>";
										 }
									 ?>
								 </select>
							</div>
						</div>
						<div class="form-group">
						<label for="city" class="col-sm-4 control-label">City</label>
							<div class="col-sm-8">
								<select name="city" id="city" class="form-control city"  title="Select City">
									<option value="0">Select City</option>
									<?php
									$stmt_city = getDB()->prepare("SELECT * FROM `city` WHERE (District=:state) ORDER BY `Name` ASC");
									$stmt_city->bindparam(":state",$state,PDO::PARAM_STR);
									$stmt_city->execute();	
									
									$city_sel = "";
									 while($data_city=$stmt_city->fetch(PDO::FETCH_OBJ))
										{
										if($data_city->ID == $city) { $city_sel ="selected='selected'";}  else { $city_sel ="";}
										echo "<option ".$city_sel." value=".$data_city->ID.">".$data_city->Name."</option>";
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
						<label for="pin" class="col-sm-4 control-label">Pin Code</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="pin" value="<?php echo html_entity_decode($pin); ?>" autocomplete="off" placeholder="141009">
							</div>
						</div>
						<div class="form-group">
							<label for="logo" class="col-sm-4 control-label">Logo (400 X 100)</label>
								<div class="col-sm-8">
									<input name="logo" type="file" class="text" /> 
								</div>
						</div>
						<div class="form-group">
							<label for="description" class="col-sm-4 control-label">Description</label>

							<div class="col-sm-8">
								<textarea class="form-control" name="description" rows="3" placeholder="Enter ..."><?php echo html_entity_decode($description); ?></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-4 control-label">Bank Details <i>(optional)</i></label>
						</div>
						<div class="form-group">
							<label for="bank" class="col-sm-4 control-label">Bank Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="bank" value="<?php echo html_entity_decode($bank); ?>" autocomplete="off" placeholder="Bank Name">
							</div>
						</div>
						<div class="form-group">
							<label for="branch" class="col-sm-4 control-label">Branch</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="branch" value="<?php echo html_entity_decode($branch); ?>" autocomplete="off" placeholder="Branch/Address">
							</div>
						</div>
						<div class="form-group">
							<label for="account_name" class="col-sm-4 control-label">Account Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="account_name" value="<?php echo html_entity_decode($account_name); ?>" autocomplete="off" placeholder="Account Name">
							</div>
						</div>
						<div class="form-group">
							<label for="account_number" class="col-sm-4 control-label">Account Number</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="account_number" value="<?php echo html_entity_decode($account_number); ?>" autocomplete="off" placeholder="a/c number">
							</div>
						</div>
						<div class="form-group">
							<label for="ifsc" class="col-sm-4 control-label">IFSC Code</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="ifsc" value="<?php echo html_entity_decode($ifsc); ?>" autocomplete="off" placeholder="IFSC CODE">
							</div>
						</div>
						<div class="form-group">
							<label for="remarks" class="col-sm-4 control-label">Remarks</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="remarks" value="<?php echo html_entity_decode($remarks); ?>" autocomplete="off" placeholder="">
							</div>
						</div>
						
						<input type="hidden" class="form-control" name="bank1" value="<?php echo html_entity_decode($bank1); ?>" autocomplete="off" placeholder="Bank Name">
						<input type="hidden" class="form-control" name="branch1" value="<?php echo html_entity_decode($branch1); ?>" autocomplete="off" placeholder="Branch/Address">
						<input type="hidden" class="form-control" name="account_name1" value="<?php echo html_entity_decode($account_name1); ?>" autocomplete="off" placeholder="Account Name">
						<input type="hidden" class="form-control" name="account_number1" value="<?php echo html_entity_decode($account_number1); ?>" autocomplete="off" placeholder="a/c number">
						<input type="hidden" class="form-control" name="ifsc1" value="<?php echo html_entity_decode($ifsc1); ?>" autocomplete="off" placeholder="IFSC CODE">
						<input type="hidden" class="form-control" name="remarks1" value="<?php echo html_entity_decode($remarks1); ?>" autocomplete="off" placeholder="">
						
					</div>
					<div class="col-sm-6">
						
						<div class="form-group">
							<label for="invoice_number" class="col-sm-4 control-label">Invoice Number</label>
							<div class="col-sm-8">
								<select class="form-control" name="invoice_number" id="invoice_number">
									<option <?php if($invoice_number == "AutoIncrement") { echo "selected"; } ?>  value="AutoIncrement" >Auto Generated</option>
									</select>
							</div>
						</div>
						<div class="form-group">
							<label for="invoice_prefix" class="col-sm-4 control-label">Invoice Number Prefix</label>
								<div class="col-sm-4">
									<input name="invoice_prefix"  style="text-transform: uppercase" id="invoice_prefix"  class="form-control" type="text" class="text" placeholder="INV (Max. 2-5 Characters)" value="<?php echo html_entity_decode($invoice_prefix); ?>" /> 
								</div>
								<div class="col-sm-4">
									<input name="invoice_number_start"  id="invoice_number_start"  class="form-control" type="text" class="text" placeholder="Starts from" value="<?php echo html_entity_decode($invoice_number_start); ?>" /> 
								</div>
						</div>
						<div class="form-group">
                            <label class="col-sm-4 control-label">Sale Tax</label>
                            <div class="col-sm-8">
                                <div class="radio  col-sm-4">
                                   <label></label>
                                        <input type="radio" name="sale_tax" <?php if($sale_tax == "Enable") { echo "checked"; } ?> id="sale_tax" value="Enable" /> Enable
                                     
                                </div>
                                <div class="radio col-sm-4">
                                      <label> </label>
                                        <input type="radio"  <?php if($sale_tax == "Disable") { echo "checked"; } ?>  name="sale_tax"  id="sale_tax" value="Disable" /> Disable
                                 
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-sm-4 control-label">Purchase Tax</label>
                            <div class="col-sm-8">
                                <div class="radio col-sm-4">
                                     <label> </label>
                                        <input type="radio" <?php if($purchase_tax == "Enable") { echo "checked"; } ?> name="purchase_tax" id="purchase_tax" value="Enable" /> Enable
                                  
                                </div>
                                <div class="radio col-sm-4">
                                   <label></label>
                                        <input type="radio" <?php if($purchase_tax == "Disable") { echo "checked"; } ?> name="purchase_tax"  id="purchase_tax" value="Disable" /> Disable
                                     
                                </div>
                            </div>
                        </div>
						<div class="form-group">
							<label for="hsn_code" class="col-sm-4 control-label">HSN Code in Invoice</label>
							<div class="col-sm-8">
								<select class="form-control" name="hsn_code">
									<option <?php if($hsn_code == "Enable") { echo "selected"; } ?>  value="Enable" >Enable</option>
									<option <?php if($hsn_code == "Disable") { echo "selected"; } ?>  value="Disable"  >Disable</option>
								 </select>
							</div>
						</div>
						<div class="form-group">
							<label for="disclaimer" class="col-sm-4 control-label">Disclaimer</label>

							<div class="col-sm-8">
								<textarea class="form-control" name="disclaimer" rows="3" placeholder="Enter ..."><?php echo html_entity_decode($disclaimer); ?></textarea>
							</div>
						</div>
					</div>
				</div>
					<input type="hidden" class="form-control" name="status" autocomplete="off" value="Enable">
				<div class="box-footer">
					<a href="<?php echo BASE_URL;?>companies.php" class="btn btn-default">Cancel</a>
					<button type="submit" name="AddCompany" class="btn btn-info pull-right" value="Add">Add Company</button>
				</div>
					<!-- /.box-footer -->
			</form>
		</div>
		<!-- /.box-body -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php	require('footer.php');
?>
