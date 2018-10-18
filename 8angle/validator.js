$(document).ready(function () {
				
			  $('.sidebar-menu').tree();
			 
				$('#formTaxes').bootstrapValidator({
			//        live: 'disabled',
					message: 'This value is not valid',
					feedbackIcons: {
						valid: 'glyphicon glyphicon-ok',
						invalid: 'glyphicon glyphicon-remove',
						validating: 'glyphicon glyphicon-refresh'
					},
					fields: {
						tax: {
							validators: {
								lessThan: {
									value: 100,
									inclusive: true,
									message: 'The IGST has to be less than 100'
								},
								greaterThan: {
									value: 0,
									inclusive: false,
									message: 'Enter valid IGST amount'
								}
							}
						}
					}
				});
				
				$('#formProductsunit').bootstrapValidator({
			//        live: 'disabled',
					message: 'This value is not valid',
					feedbackIcons: {
						valid: 'glyphicon glyphicon-ok',
						invalid: 'glyphicon glyphicon-remove',
						validating: 'glyphicon glyphicon-refresh'
					},
					fields: {
						name: {
							validators: {
								notEmpty: {
									 message: 'Enter Product unit Name'
								 }
							}
						},
						unit: {
							validators: {
								notEmpty: {
									 message: 'Enter unit '
								 }
							}
						}
					}
				});
				
				$('#formCategory').bootstrapValidator({
			//        live: 'disabled',
					message: 'This value is not valid',
					feedbackIcons: {
						valid: 'glyphicon glyphicon-ok',
						invalid: 'glyphicon glyphicon-remove',
						validating: 'glyphicon glyphicon-refresh'
					},
					fields: {
						name: {
							validators: {
								notEmpty: {
									 message: 'Enter Category Name'
								 }
							}
						}
					}
				});
				
				$('#formExpenses').bootstrapValidator({
			//        live: 'disabled',
					message: 'This value is not valid',
					feedbackIcons: {
						valid: 'glyphicon glyphicon-ok',
						invalid: 'glyphicon glyphicon-remove',
						validating: 'glyphicon glyphicon-refresh'
					},
					fields: {
						expenses_category_id: {
							validators: {
								 greaterThan: {
									value: 0,
									inclusive: false,
									message: 'Select Expense Type'
								}
							}
						},
						name: {
							validators: {
								notEmpty: {
									 message: 'Enter Expense Name'
								 },
								 stringLength: {
									min: 3,
									message: 'Enter atleast 3 characters'
								}
							}
						},
						amt: {
							validators: {
								 greaterThan: {
									value: 0,
									inclusive: false,
									message: 'Enter amount '
								}
							}
						},
					}
				});
				
				$('#formProducts').bootstrapValidator({
			//        live: 'disabled',
					message: 'This value is not valid',
					feedbackIcons: {
						valid: 'glyphicon glyphicon-ok',
						invalid: 'glyphicon glyphicon-remove',
						validating: 'glyphicon glyphicon-refresh'
					},
					fields: {
						name: {
							validators: {
								notEmpty: {
									 message: 'Enter Product Name'
								 },
								 stringLength: {
									min: 3,
									message: 'Enter atleast 3 characters'
								}
							}
						},
						hsn_code: {
							validators: {
							}
						},
						buy_price: {
							validators: {
								greaterThan: {
									value: 0,
									inclusive: true,
									message: 'Enter numeric value only '
								}
							}
						},
						sell_price: {
							validators: {
								 greaterThan: {
									value: 0,
									inclusive: true,
									message: 'Enter sell price '
								}
							}
						},
						price: {
							validators: {
								greaterThan: {
									value: 0,
									inclusive: true,
									message: 'Enter numeric value only '
								}
							}
						}
					}
				});
				
				$('#formVendors').bootstrapValidator({
			//        live: 'disabled',
					message: 'This value is not valid',
					feedbackIcons: {
						valid: 'glyphicon glyphicon-ok',
						invalid: 'glyphicon glyphicon-remove',
						validating: 'glyphicon glyphicon-refresh'
					},
					fields: {
						biz_name: {
							validators: {
								 notEmpty: {
									 message: 'Enter Company Name'
								 }
							}
						},
						c_name: {
							validators: {
								 notEmpty: {
									  message: 'Enter Contact Person'
								 }
							}
						},
						gst_num: {
							validators: {
								notEmpty: {
									 message: 'Enter GSTIN'
								},
								regexp: {
									regexp: /^([0][1-9]|[1-2][0-9]|[3][0-5])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/,
									message: 'Enter valid GSTIN'
								}
							}
						},
						phone: {
							validators: {
								digits: {},
								phone: {
									country: 'US',
									message: 'Enter valid phone number'
								}
							}
						},
						email: {
							validators: {
								emailAddress: {}
							}
						},
						address: {
							validators: {
								 notEmpty: {
									 message: 'Enter Address'
								 }
							}
						},
						state: {
							validators: {
								 notEmpty: {
									  message: 'Select State'
								 }
							}
						},
					}
				});
					
				$('#formCustomers').bootstrapValidator({
			//        live: 'disabled',
					message: 'This value is not valid',
					feedbackIcons: {
						valid: 'glyphicon glyphicon-ok',
						invalid: 'glyphicon glyphicon-remove',
						validating: 'glyphicon glyphicon-refresh'
					},
					fields: {
						name: {
							validators: {
								 notEmpty: {
									 message: 'Enter Party Name'
								 }
							}
						},
						gst_num: {
							validators: {
								regexp: {
									regexp: /^([0][1-9]|[1-2][0-9]|[3][0-5])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/,
									message: 'Enter valid GSTIN'
								}
							}
						},
						phone: {
							validators: {
								digits: {},
								phone: {
									country: 'US',
									message: 'Enter valid phone number'
								}
							}
						},
						email: {
							validators: {
								emailAddress: {}
							}
						},
						address: {
							validators: {
								notEmpty: {
									  message: 'Enter Address'
								 }
							}
						},
						state: {
							validators: {
								 notEmpty: {
									  message: 'Select State'
								 }
							}
						},
					}
				});
					
				$('#formInvoice').bootstrapValidator({
			//        live: 'disabled',
					message: 'This value is not valid',
					feedbackIcons: {
						valid: 'glyphicon glyphicon-ok',
						invalid: 'glyphicon glyphicon-remove',
						validating: 'glyphicon glyphicon-refresh'
					},
					fields: {
						inv_user: {
							validators: {
								 notEmpty: {
									 message: 'Enter Party Name'
								 }
							}
						},
						invoice_number_value: {
							validators: {
								 notEmpty: {
									 message: 'Enter Invoice Number'
								 },
								 stringLength: {
									min: 1,
									max: 20,
									message: 'The invoice number must be more than 1 and less than 20 characters long'
								},
								regexp: {
									regexp: /^[a-zA-Z0-9]+$/,
									message: 'The invoice can only consist of alphabetical, number'
								},
								remote: {
									url: 'check_invoice_number.php',
									message: 'The invoice number already exists',
									type: 'POST'
								}
							}
						},
						inv_user_name: {
							validators: {
								 notEmpty: {
									 message: 'Enter Party/Customer Name'
								 }
							}
						},
						customer_state: {
							validators: {
								 notEmpty: {
									  message: 'Select State'
								 }
							}
						},
						'inv_product_qty[]': {
							validators: {
								notEmpty: {
										message: 'Please enter product quantity'
									},
								 greaterThan: {
									value: 0,
									inclusive: true,
									message: 'Enter numeric value only '
								}
							}
						},
						'inv_product_cost[]': {
							validators: {
								notEmpty: {
										message: 'Please enter product price'
									},
								 greaterThan: {
									value: 0,
									inclusive: true,
									message: 'Enter numeric value only '
								}
							}
						},
						inv_discount: {
							validators: {
								 greaterThan: {
									value: 0,
									inclusive: true,
									message: 'Enter numeric value only '
								}
							}
						}
					}
				});
				
				$('#formReceipt').bootstrapValidator({
				//        live: 'disabled',
					message: 'This value is not valid',
					feedbackIcons: {
						valid: 'glyphicon glyphicon-ok',
						invalid: 'glyphicon glyphicon-remove',
						validating: 'glyphicon glyphicon-refresh'
					},
					fields: {
						cust_name: {
							validators: {
								notEmpty: {
										message: 'Please enter customer name'
									}
							}
						},
						paid_amount: {
							validators: {
								notEmpty: {
										message: 'Please enter amount'
									},
								 greaterThan: {
									value: 0,
									inclusive: true,
									message: 'Enter numeric value only '
								},
							/*	callback: {
										message: 'Amount can not more than the balance amount',
										callback: function(value, validator, $field) {
											var rtotal_amount = $('#rtotal_amount').val(); 
											if(Number(value) <= rtotal_amount) {
											return true;
											} else {
												return false;
											}
										}
									} */
							}
						}
					}
				});
				
				$('#formCompany').bootstrapValidator({
				//        live: 'disabled',
					message: 'This value is not valid',
					feedbackIcons: {
						valid: 'glyphicon glyphicon-ok',
						invalid: 'glyphicon glyphicon-remove',
						validating: 'glyphicon glyphicon-refresh'
					},
					fields: {
						name: {
							validators: {
								 notEmpty: {
									 message: 'Enter Company Name'
								 }
							}
						},
						gst: {
							validators: {
								 stringLength: {
									min: 14,
									max: 15,
									message: 'Enter complete GSTIN'
								},
								regexp: {
									regexp: /^([0][1-9]|[1-2][0-9]|[3][0-5])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/,
									message: 'Enter valid GSTIN.'
								}
							}
						},
						address: {
							validators: {
								 notEmpty: {
									 message: 'Enter Address'
								 }
							}
						},
						sale_tax: {
							validators: {
								 notEmpty: {
									 message: 'Enable/Disable tax in sale invoice'
								 }
							}
						},
						purchase_tax: {
							validators: {
								 notEmpty: {
									 message: 'Enable/Disable tax in purchase invoice'
								 }
							}
						},
						invoice_prefix: {
							validators: {
								 stringLength: {
									min: 2,
									max: 5,
									message: 'Invoice prefix must be 2-5 characters'
								},
								regexp: {
									regexp: /^[a-zA-Z0-9]+$/,
									message: 'The Invoice prefix can only consist of alphabets/numbers'
								},
								callback: {
									message: 'Enter Prefix',
									callback: function(value, validator,$fields) {
										var val = $('#invoice_number').val();
										if(val == "AutoIncrement" && value == "") { 
											return false;
										} else {
											return true;
										}
									}
								},
								'case': 'upper'
							}
						},
						invoice_number_start: {
							validators: {
								greaterThan: {
									value: 1,
									inclusive: true,
									message: 'Enter numeric value only '
								}
							}
						},
						state: {
							validators: {
								 notEmpty: {
									  message: 'Select State'
								 }
							}
						},
						pin: {
							validators: {
								digits: {
									
								},
								notEmpty: {
									 message: 'Enter PIN Code'
								},
								 stringLength: {
									min: 6,
									max: 6,
									message: 'Enter valid PIN'
								}
							}
						},
					}
				});
				
				
				$('#invoice_number').on('change', function() { 
					// Revalidate the fields 
					$('#formCompany').bootstrapValidator('revalidateField', 'invoice_prefix');

				});
				$('#paid_amount').on('blur', function() { 
					// Revalidate the fields 
					//$('#formReceipt').bootstrapValidator('revalidateField', 'paid_amount');

				});
				
				$('#sale_tax').on('click', function() { 
					var gstin = document.getElementById('gstin').value;
					if(gstin.length < 1) {
						$('input[name=sale_tax][value=Disable]').prop('checked', 'checked');
					}

				});
				
				window.setTimeout(function() {
					$(".alert").fadeTo(1000, 0).slideUp(1000, function(){
						$(this).remove(); 
					});
				}, 2000);
				
				

			});
			
			$('#datepicker').datepicker({
				format: 'yyyy-mm-dd',
				autoclose: true
			});
			
			function checkAll() {
					$(".check").prop('checked', $("#checkAll").prop('checked'));
				}
			
			function checkCompany(val) {
				if(confirm("You are about to change Company  and will be redirected to the dashboard."))
				{
					window.location.href= 'index.php?company_id='+val; 
				}
			}
			function getCity(val) {
			  $.post( "getCity.php?id="+val, function( data ) {
					$( "select#city" ).html( data );
					console.log();
				});
			}
			
			function importexport() {
			  
			   var formData = new FormData($("#importBackup"));
				 $.ajax({
					type: 'POST',
					url: 'importexport.php',
					data: formData,
					 success: function (data) {
					   alert(data)
					   if(data == true) {
							$( ".box-header" ).html( "<div class='alert alert-success alert-dismissible'><strong>Wow! </strong>Backup imported 	successfully !</div>" ); 
						  } 
						  else {
							$( ".box-header" ).html( "<div class='alert alert-danger alert-dismissible'><strong></strong>Error while importing Backup !</div>" ); 
						}
					 },
				  });
			}
			
			function checkPaidby(val) {
					if(val == "Cash") {
						$( "#hide_data" ).hide();
					} else {
						$( "#hide_data" ).show();
					}
				}
			function hsn_code_search() {
				var val = 	document.getElementById('hsn_item_name').value; 
				if(val == '' || val.length < 3 ) { alert('Please enter product name'); return false; } 
				$("#hsn_code_data").html('<center><i class="fa fa-spinner fa-spin" style="font-size:48px"></i></center>');
				$.post( "hsn_code_search.php?id="+val, function( data ) {
						$( "#hsn_code_data" ).html( data );
						console.log();
						});
				}
				
				
				function outstanding_invoice(val) {
				
				$("#outstanding_invoice_data").html('<center><i class="fa fa-spinner fa-spin" style="font-size:48px"></i></center>');
				$.post( "outstanding_invoice_search.php?id="+val, function( data ) {
						$( "#outstanding_invoice_data" ).html( data );
						console.log();
						});
				}
				
				function outstanding_expenses(val) {
				
				$("#outstanding_expenses_data").html('<center><i class="fa fa-spinner fa-spin" style="font-size:48px"></i></center>');
				$.post( "outstanding_expenses_search.php?id="+val, function( data ) {
						$( "#outstanding_expenses_data" ).html( data );
						console.log();
						});
				}
				
				
				function number2text(value) 
				{
					var fraction = Math.round(frac(value)*100);
					var f_text  = "";

					if(fraction > 0) {
						f_text = "AND "+convert_number(fraction)+" PAISE";
					}

					return convert_number(value)+" "+f_text+" ONLY";
				}

				function frac(f) 
				{
					return f % 1;
				}

				function convert_number(number)
				{
					if ((number < 0) || (number > 999999999)) 
					{ 
						return "NUMBER OUT OF RANGE!";
					}
					var Gn = Math.floor(number / 10000000);  /* Crore */ 
					number -= Gn * 10000000; 
					var kn = Math.floor(number / 100000);     /* lakhs */ 
					number -= kn * 100000; 
					var Hn = Math.floor(number / 1000);      /* thousand */ 
					number -= Hn * 1000; 
					var Dn = Math.floor(number / 100);       /* Tens (deca) */ 
					number = number % 100;               /* Ones */ 
					var tn= Math.floor(number / 10); 
					var one=Math.floor(number % 10); 
					var res = ""; 

					if (Gn>0) 
					{ 
						res += (convert_number(Gn) + " CRORE"); 
					} 
					if (kn>0) 
					{ 
							res += (((res=="") ? "" : " ") + 
							convert_number(kn) + " LAKH"); 
					} 
					if (Hn>0) 
					{ 
						res += (((res=="") ? "" : " ") +
							convert_number(Hn) + " THOUSAND"); 
					} 

					if (Dn) 
					{ 
						res += (((res=="") ? "" : " ") + 
							convert_number(Dn) + " HUNDRED"); 
					} 


					var ones = Array("", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX","SEVEN", "EIGHT", "NINE", "TEN", "ELEVEN", "TWELVE", "THIRTEEN","FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTEEN","NINETEEN"); 
				var tens = Array("", "", "TWENTY", "THIRTY", "FOURTY", "FIFTY", "SIXTY","SEVENTY", "EIGHTY", "NINETY"); 

					if (tn>0 || one>0) 
					{ 
						if (!(res=="")) 
						{ 
							res += " AND "; 
						} 
						if (tn < 2) 
						{ 
							res += ones[tn * 10 + one]; 
						} 
						else 
						{ 

							res += tens[tn];
							if (one>0) 
							{ 
								res += ("-" + ones[one]); 
							} 
						} 
					}

					if (res=="")
					{ 
						res = "zero"; 
					} 
					return res;
				}