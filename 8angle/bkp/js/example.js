function print_today() {
  var now = new Date();
  var months = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
  var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
  function fourdigits(number) {
    return (number < 1000) ? number + 1900 : number;
  }
  var today =  months[now.getMonth()] + " " + date + ", " + (fourdigits(now.getYear()));
  return today;
}

function selvalue(sel) {
    var val = sel.value;  //alert(val);
	var myArray = val.split('-');
	$('.tax_amt').html(myArray['1']);	
}

function roundNumber(number,decimals) {
  var newString;// The new rounded number
  decimals = Number(decimals);
  if (decimals < 1) {
    newString = (Math.round(number)).toString();
  } else {
    var numString = number.toString();
    if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
      numString += ".";// give it one at the end
    }
    var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
    var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
    var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
    if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
      if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
        while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
          if (d1 != ".") {
            cutoff -= 1;
            d1 = Number(numString.substring(cutoff,cutoff+1));
          } else {
            cutoff -= 1;
          }
        }
      }
      d1 += 1;
    } 
    if (d1 == 10) {
      numString = numString.substring(0, numString.lastIndexOf("."));
      var roundedNum = Number(numString) + 1;
      newString = roundedNum.toString() + '.';
    } else {
      newString = numString.substring(0,cutoff) + d1.toString();
    }
  }
  if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
    newString += ".";
  }
  var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
  for(var i=0;i<decimals-decs;i++) newString += "0";
  //var newNumber = Number(newString);// make it a number if you like
  return newString; // Output the result to the form field (change for your purposes)
}

function update_total() {
	var total = 0; 
	var tax = 0; 
	var discount = 0; 
	var cgst = 0;
	var sgst = 0;
	var dis = $('#discount').val(); 
	var freight = $('#freight').val();
	
	var arr = [];
	$('.total_amount_te').each(function(i){
		price = $(this).html().replace("$","");
		arr[i] = price;
		if (!isNaN(price)) total += Number(price);
	});
  
	var tax_cnt = [];
	$('.total_tax').each(function(i){
		taxx = $(this).html().replace("$","");
		tax_cnt[i] = taxx;
		if (!isNaN(taxx)) tax += Number(taxx);
	});
	var discount_cnt = [];
	$('.total_discount').each(function(i){
		diss = $(this).html().replace("$","");
		discount_cnt[i] = diss;
		if (!isNaN(diss)) discount += Number(diss);
	});
	
	var cgst_amt_cnt = [];
	$('.cgst_amt').each(function(i){
		cgst_amt = $(this).html().replace("$","");
		cgst_amt_cnt[i] = cgst_amt;
		if (!isNaN(cgst_amt)) cgst += Number(cgst_amt);
	});

	
	var sgst_amt_cnt = [];
	$('.sgst_amt').each(function(i){
		sgst_amt = $(this).html().replace("$","");
		sgst_amt_cnt[i] = sgst_amt;
		if (!isNaN(sgst_amt)) sgst += Number(sgst_amt);
	});
	
  discount = discount; //each item 
  tax = tax;
  dis = dis; // on total amount
  total = Math.round(total);
  cgst = cgst; // on total amount
  sgst = sgst;

	nt = (total - discount) + tax; 
	balance =    nt - dis + Number(freight);
	$('#tax').html(roundNumber(tax,2));
	$('#discount_total').html(roundNumber(discount,2));
	$('#subtotal').html(total);
	$('#total').html(Math.round(nt));
	$('#paid_due').html(Math.round(balance,2));
	$('.due').html(Math.round(balance,2));
	$('.total_cgst').html(roundNumber(cgst,2));
	$('.total_sgst').html(roundNumber(sgst,2));
	$('.total_igst').html(roundNumber(tax,2));
  
  update_balance();
}


function update_balance() {
	
}

function update_price() {
	
	var row = $(this).parents('.item-row');
	var price = row.find('.cost').val().replace("$","") * row.find('.qty').val();
	var discount = row.find('.discount').val().replace("$","");
	
		if(discount.indexOf("%") != -1) {
			
			discount = row.find('.discount').val().replace("%","");
			discount = discount.trim();
			discount = ( row.find('.total_amount_te').html() * discount ) / 100 ;
		} 
	
	var tax_single = ( ( row.find('.cost').val().replace("$","") - discount ) * row.find('.tax_amount').val().replace("$","") ) / 100;
	var tax = ( ( ( row.find('.cost').val().replace("$","")  * row.find('.qty').val() )  - discount ) * row.find('.tax_amount').val().replace("$","") ) / 100;
	var cgst_amt = ( (( row.find('.cost').val().replace("$","")  * row.find('.qty').val() ) - discount) * row.find('#cgst_tax_percent').val()) / 100;
	var sgst_amt =  ( (( row.find('.cost').val().replace("$","")  * row.find('.qty').val() ) - discount) * row.find('#sgst_tax_percent').val()) / 100;

	var grand_total = (price - discount) + tax;
   
	price = roundNumber(price,2);
	isNaN(price) ? row.find('.total_amount_te').html("0.00") : row.find('.total_amount_te').html(price);
  
	tax_single = roundNumber(tax_single,2);
	isNaN(tax_single) ? row.find('.amount_tax').html("0.00") : row.find('.amount_tax').html(tax_single);
  
	tax = roundNumber(tax,2);
	isNaN(tax) ? row.find('.total_tax').html("0.00") : row.find('.total_tax').html(tax);
	
	cgst_amt = roundNumber(cgst_amt,2);
	isNaN(cgst_amt) ? row.find('#cgst_amt').html("0.00") : row.find('#cgst_amt').html(cgst_amt);
	
	sgst_amt = roundNumber(sgst_amt,2);
	isNaN(sgst_amt) ? row.find('#sgst_amt').html("0.00") : row.find('#sgst_amt').html(sgst_amt);
 
	discount = roundNumber(discount,2);
	isNaN(discount) ? row.find('.total_discount').html("0.00") : row.find('.total_discount').html(discount);
	
	grand_total = roundNumber(grand_total,2);
	isNaN(grand_total) ? row.find('.grand_total').val("0.00") : row.find('.grand_total').val(grand_total);
  
  update_total();
}

function update_grand_total() {
	
	var row = $(this).parents('.item-row'); 

	var grand_total = row.find('.grand_total').val(); 
	
	var discount = Number(row.find('.total_discount').html(),2);
	
	var tax_amount = (100 + Number(row.find('.tax_amount').val().replace("$",""))); //alert(tax_amount);
	
	var form_tax_amount = roundNumber(((grand_total) / tax_amount) * 100 ,2); //alert(form_tax_amount);
	
	var tax = roundNumber(( form_tax_amount * (row.find('.tax_amount').val().replace("$","") )) / 100,2);  //alert(tax);
		
	var gt_wd = grand_total - tax; // grand total without discount
	
	var price = (gt_wd + discount) /  row.find('.qty').val(); 

	price = roundNumber(price,2);
	isNaN(price) ? row.find('.cost').val("0.00") : row.find('.cost').val(price);

	var price1 = row.find('.cost').val().replace("$","") * row.find('.qty').val();
	var discount1 = row.find('.discount').val().replace("$","");
	
		if(discount1.indexOf("%") != -1) {
			
			discount1 = row.find('.discount').val().replace("%","");
			discount1 = discount1.trim();
			discount1 = ( row.find('.total_amount_te').html() * discount1 ) / 100 ;
		} 
	
	var tax_single1 = ( ( row.find('.cost').val().replace("$","") - discount1 ) * row.find('.tax_amount').val().replace("$","") ) / 100;
	var tax1 = ( ( ( row.find('.cost').val().replace("$","")  * row.find('.qty').val() )  - discount1 ) * row.find('.tax_amount').val().replace("$","") ) / 100;
	var cgst_amt1 = ( (( row.find('.cost').val().replace("$","")  * row.find('.qty').val() ) - discount1) * row.find('#cgst_tax_percent').val()) / 100;
	var sgst_amt1 =  ( (( row.find('.cost').val().replace("$","")  * row.find('.qty').val() ) - discount1) * row.find('#sgst_tax_percent').val()) / 100;

	var grand_total1 = (price1 - discount1) + tax1;
   
	price1 = roundNumber(price1,2);
	isNaN(price1) ? row.find('.total_amount_te').html("0.00") : row.find('.total_amount_te').html(price1);
  
	tax_single1 = roundNumber(tax_single1,2);
	isNaN(tax_single1) ? row.find('.amount_tax').html("0.00") : row.find('.amount_tax').html(tax_single1);
  
	tax1 = roundNumber(tax1,2);
	isNaN(tax1) ? row.find('.total_tax').html("0.00") : row.find('.total_tax').html(tax1);
	
	cgst_amt1 = roundNumber(cgst_amt1,2);
	isNaN(cgst_amt1) ? row.find('#cgst_amt').html("0.00") : row.find('#cgst_amt').html(cgst_amt1);
	
	sgst_amt1 = roundNumber(sgst_amt1,2);
	isNaN(sgst_amt1) ? row.find('#sgst_amt').html("0.00") : row.find('#sgst_amt').html(sgst_amt1);
 
	discount1 = roundNumber(discount1,2);
	isNaN(discount1) ? row.find('.total_discount').html("0.00") : row.find('.total_discount').html(discount1);
	
	grand_total1 = roundNumber(grand_total,2);
	isNaN(grand_total1) ? row.find('.grand_total').val("0.00") : row.find('.grand_total').val(grand_total1);
  
  update_total();
}

function  binds() {
	
	$(".cost").blur(update_price);
	$(".qty").blur(update_price);
	$(".discount").blur(update_price);
	$(".grand_total").blur(update_grand_total);
	$("#discount").blur(update_total);
	$("#freight").blur(update_total);
}

function addidtodiv() {
	
	var numItems = $('.item-row').length; //alert(numItems);
    for(i=0; i<=numItems; i++){
			$('.item-row:nth-child('+i+')').attr("id","inv"+i );
    }
}
function addidtoshow() {
	var numshow = $('.showdata').length; //alert(numshow);
  
	$( ".showdata" )
	  .attr( "id", function( arr ) {
		return "showdata" + arr;
	  });
}
$(document).ready(function() {

	$('.form-control').keypress(function (e) {
         if (e.which === 13) {
			 e.preventDefault();
             var index = $('.form-control').index(this) + 1;
             $('.form-control').eq(index).focus();
         }
     });

	addidtodiv(); addidtoshow();
	
  $('input').click(function(){
    $(this).select();
  });
  
	var Show_HSN_Code = $('#Show_HSN_Code').val(); 
	if(Show_HSN_Code == "Enable") { Show_HSN = "visible"; } else { Show_HSN = "none";}
	
		
	var Show_Saletax = $('#Show_Saletax').val(); 
	if(Show_Saletax == "Enable") { Show_Sale = "visible"; } else { Show_Sale = "none";}
	

  $("#addRow").click(function(){
	var d = $("#items .item-row:last").attr("id").replace("inv", ""); var h = parseInt(d) + parseInt(1);
	var s = $("#items .showdata:last").attr("id").replace("showdata", ""); var t = parseInt(s) + parseInt(1);
	var numIteml = $('.item-row').length; 
    $(".item-row:last").after( '<tr  id="inv'+ ( h )+'"  class="item-row"><td><a class="delete" title="remove Item"><i class="glyphicon glyphicon-remove-circle"></i></a></td><input  name="inv_product_id[]" readonly="readonly" type="hidden"  value="" id="inv_product_id"  tabindex="1" /><td><input name="inv_product_name[]" class="form-control"  value="" id="inv_product_name" autocomplete="off" onkeyup="load_search(this.value,'+d+')" tabindex="1" /><br/><span id="showdata'+d+'" class="showdata"></span></td><td><select  name="inv_product_type[]" id="inv_product_type"  class="inv_product_type  form-control" ><option value="Goods">Goods</option><option value="Services">Services</option></select></td><td style="display:'+Show_HSN+'"><span class="HSN_code_show"></span></td><td><select  name="inv_product_unit[]" id="inv_product_unit"  class="inv_product_unit  form-control" ></select></td><td><input type="text" value="1"  class="qty form-control" name="inv_product_qty[]"  id="inv_product_qty" /></td><td><input type="text" value="0.00" class="cost form-control" name="inv_product_cost[]"  id="inv_product_cost" /></td><td style="display:'+Show_Sale+'"><select name="tax_type[]" onChange="load_taxes(this.value,'+d+')" id="tax_type"  class="tax_type form-control" ></select><input  name="tax_amount[]" class="tax_amount" readonly="readonly" type="hidden"  value="" id="tax_amount"  tabindex="1" /><span class="row_number">'+d+'</span></td><td><input type="text" value="0.00"  class="discount form-control" name="inv_product_discount[]"  id="inv_product_discount" /> <span class="discount_amount"></span></td><td><span class="total_amount_te">0.00</span></td><td style="display:'+Show_Sale+'"><span class="total_tax">0.00</span><span class="tax_hidden"><input type="hidden" name="cgst_tax_percent[]" id="cgst_tax_percent" class="cgst_tax_percent" value="0"><span id="cgst_amt" class="cgst_amt"></span> [ <input type="hidden" name="sgst_tax_percent[]" id="sgst_tax_percent" class="sgst_tax_percent" value="0"><span id="sgst_amt" class="sgst_amt"></span>]</span></td><td><span class="total_discount">0.00</span></td><td><input type="text" value="0"  class="grand_total  form-control" name="grand_total[]"  id="grand_total" /></td></tr>');
    if ($(".delete").length > 0) $(".delete").show();
	$('.item-row:last .inv_product_unit').load( "global_product_unit_list.php" );
	$('.item-row:last .tax_type').load( "global_tax_list.php" );
	
	binds();
	update_total();

  });
  
  binds();
  
  $("#items").on('click','.delete',function(){ 
    $(this).parents('.item-row').remove();
    update_total();
    if ($(".delete").length < 2) $(".delete").hide();
	
  });

  
});

	function addinvcust(billing_address_id,id,name,phone,gst_num,address,email,city_id,city,state,pin)
	{
		document.getElementById('inv_user').value=id;			
		document.getElementById('inv_user_name').value=name;
		var Company_State = document.getElementById('Company_State').value;
		$("#inv_address").html(address);
		$("#inv_city_id").html(city_id);
		$("#inv_city").html(city);
		$("#inv_state").html(state);
		$("#billing_address_id").val(billing_address_id);
		$("#inv_gst").html(gst_num);
		$("#inv_pin").html(pin);
		//$("#inv_phone").html(phone);
		//$("#inv_email").html(email);
		document.getElementById('customer_state').value= state;	
		document.getElementById("auto").innerHTML="";
		document.getElementById("showBillingAddress").innerHTML='<a href="invoice_addresses.php?customer='+id+'&type=billing" data-toggle="modal" data-target="#billingAddress'+id+'" title="" data-refresh="true"><i class="fa fa-plus">Add Billing Address</i></a><div id="billingAddress'+id+'" class="modal fade"><div class="modal-content"></div><div class="modal-footer"><button type="button" class="btn btn-outline" data-dismiss="modal">Close</button></div></div>';
		document.getElementById("showShippingAddress").innerHTML='<a href="invoice_addresses.php?customer='+id+'&type=shipping" data-toggle="modal" data-target="#shippingAddress'+id+'" title="" data-refresh="true"><i class="fa fa-plus">Add Shipping Address</i></a><div id="shippingAddress'+id+'" class="modal fade"><div class="modal-content"></div><div class="modal-footer"><button type="button" class="btn btn-outline" data-dismiss="modal">Close</button></div></div>';

		matchAddress();
	}
	
	function addshippingaddress(billing_address_id,id,name,phone,gst_num,address,email,city_id,city,state,pin)
	{
		var Company_State = document.getElementById('Company_State').value;
		document.getElementById('inv_shipping_address').value= address;		
		document.getElementById('inv_shipping_state').value= state;		
		document.getElementById('ship_to').value= name;	
		document.getElementById('pin').value= pin;		
		document.getElementById('gst').value= gst_num;	
		document.getElementById('city').value= city_id;
		document.getElementById('ship_address').innerHTML= address;		
		document.getElementById('state_name').innerHTML= state;		
		document.getElementById('city_name').innerHTML= city;	
		document.getElementById('ship_pin').innerHTML= pin;		
		document.getElementById('gst_num').innerHTML= gst_num;	
		document.getElementById('ship_to_name').innerHTML= name;	
			
		if(Company_State != state) {
			 $(".cgst_div").css("display", "none");
			 $(".sgst_div").css("display", "none");
			 $(".igst_div").css("display", "block");
		} else {
			$(".igst_div").css("display","none");
			$(".cgst_div").css("display", "block");
			$(".sgst_div").css("display", "block");
		}
	}
	
	
	function matchAddress()
	{
		var address = document.getElementById('inv_address').innerHTML;
		var state = document.getElementById('inv_state').innerHTML;	
		var ship_to = document.getElementById('inv_user_name').value;
		var pin = document.getElementById('inv_pin').innerHTML;	
		var gst = document.getElementById('inv_gst').innerHTML;
		var city = document.getElementById('inv_city').innerHTML;
		
		if(document.getElementById("sameAddress").checked) {			
			document.getElementById('inv_shipping_address').value= address;		
			document.getElementById('inv_shipping_state').value= state;		
			document.getElementById('ship_to').value= ship_to;	
			document.getElementById('pin').value= pin;		
			document.getElementById('gst').value= gst;	
			document.getElementById('city').value= city;	
				
			document.getElementById('ship_address').innerHTML= address;		
			document.getElementById('state_name').innerHTML= state;		
			document.getElementById('city_name').innerHTML= city;	
			document.getElementById('ship_pin').innerHTML= pin;		
			document.getElementById('gst_num').innerHTML= gst;	
			document.getElementById('ship_to_name').innerHTML= ship_to;	
		} else {	
		//	document.getElementById('inv_shipping_address').value= "";		
		//	document.getElementById('inv_shipping_state').value= state;		
		//	document.getElementById('city').value= 0;
		//	document.getElementById('ship_to').value= "";	
		//	document.getElementById('pin').value= "";		
		//	document.getElementById('gst').value= "";	
			
		//	document.getElementById('ship_address').innerHTML= "";		
		//	document.getElementById('state_name').innerHTML= state;		
		//	document.getElementById('city_name').innerHTML= "";	
		//	document.getElementById('ship_pin').innerHTML= "";		
		//	document.getElementById('gst_num').innerHTML= "";	
		//	document.getElementById('ship_to_name').innerHTML= "";	
			}
			var Company_State = document.getElementById('Company_State').value;
			var shipstate = document.getElementById('inv_shipping_state').value;	
			if(Company_State != shipstate) {
			 $(".cgst_div").css("display", "none");
			 $(".sgst_div").css("display", "none");
			 $(".igst_div").css("display", "block");
			} else {
				$(".igst_div").css("display","none");
				$(".cgst_div").css("display", "block");
				$(".sgst_div").css("display", "block");
			}
		
	}
	
	function load_ajax_cust(val) 
	{ 
		$.post('global_search.php', {'search_term':val}, function(data){
			var Company_State = document.getElementById('Company_State').value;
           $("#auto").html(data);
		   if($(data).text().trim() == "No Customer Found. Add new") {
				document.getElementById('inv_user').value = 0;
				var Company_State = document.getElementById('Company_State').value;
				$("#inv_address").html("");
				$("#inv_city_id").html("");
				$("#inv_city").html("");
				$("#inv_pin").html("");
				$("#inv_gst").html("");
				$("#inv_state").html(Company_State);
				document.getElementById('customer_state').value= Company_State;	
				document.getElementById('inv_shipping_state').value= Company_State;	
				document.getElementById('state_name').innerHTML= Company_State;	
				document.getElementById("showBillingAddress").innerHTML='';
				document.getElementById("showShippingAddress").innerHTML='';
				
		   }
		   
		  var state = document.getElementById('inv_shipping_state').value;
		   if(Company_State != state) {
					 $(".cgst_div").css("display", "none");
					 $(".sgst_div").css("display", "none");
					 $(".igst_div").css("display", "block");
				} else {
					$(".igst_div").css("display","none");
					$(".cgst_div").css("display", "block");
					$(".sgst_div").css("display", "block");
				}
		   
        });
	}
	
	function load_search(the_search,div) 
	{  
		var divs = div + 1;
		var desc = "";
        $.post('global_product.php', {'sa':the_search, 'div': div, 'desc': desc}, function(data){
           $("#showdata"+div).html(data);
			binds();
		   update_total();
        });
	}
	
	function load_taxes(the_search,div) 
	{  
		var divs = div + 1;
        $.post('global_tax.php', {'sa':the_search, 'div': div}, function(data){
			var temp = new Array();
			temp = data.trim().split(",");
			
			$("#inv"+divs+" #tax_amount").val(temp[0]);
		   
			var row = $("#showdata"+div).parents('.item-row');
			row.find('#cgst_tax_percent').val(temp[1]);
			row.find('#sgst_tax_percent').val(temp[2]);
			var price = row.find('.cost').val().replace("$","") * row.find('.qty').val();
			var discount = row.find('.discount').val().replace("$","");
		
			if(discount.indexOf("%") != -1) {
				
				discount = row.find('.discount').val().replace("%","");
				discount = discount.trim();
				discount = ( row.find('.total_amount_te').html() * discount ) / 100 ;
			} 
			
			var tax_single = ( ( row.find('.cost').val().replace("$","") - discount ) * row.find('.tax_amount').val().replace("$","") ) / 100;
			var tax = ( ( ( row.find('.cost').val().replace("$","")  * row.find('.qty').val() )  - discount ) * row.find('.tax_amount').val().replace("$","") ) / 100;
			var cgst_amt = ( (( row.find('.cost').val().replace("$","")  * row.find('.qty').val() ) - discount) * row.find('#cgst_tax_percent').val()) / 100;
			var sgst_amt =  ( (( row.find('.cost').val().replace("$","")  * row.find('.qty').val() ) - discount) * row.find('#sgst_tax_percent').val()) / 100;
			
			var grand_total = (price - discount) + tax;
		   
			price = roundNumber(price,2);
			isNaN(price) ? row.find('.total_amount_te').html("0.00") : row.find('.total_amount_te').html(price);
		  
			tax_single = roundNumber(tax_single,2);
			isNaN(tax_single) ? row.find('.amount_tax').html("0.00") : row.find('.amount_tax').html(tax_single);
		  
			tax = roundNumber(tax,2);
			isNaN(tax) ? row.find('.total_tax').html("0.00") : row.find('.total_tax').html(tax);
		 
			cgst_amt = roundNumber(cgst_amt,2);
			isNaN(cgst_amt) ? row.find('#cgst_amt').html("0.00") : row.find('#cgst_amt').html(cgst_amt);
			
			sgst_amt = roundNumber(sgst_amt,2);
			isNaN(sgst_amt) ? row.find('#sgst_amt').html("0.00") : row.find('#sgst_amt').html(sgst_amt);

			discount = roundNumber(discount,2);
			isNaN(discount) ? row.find('.total_discount').html("0.00") : row.find('.total_discount').html(discount);
			
			grand_total = roundNumber(grand_total,2);
			isNaN(grand_total) ? row.find('.grand_total').val("0.00") : row.find('.grand_total').val(grand_total);
			
		   binds();
		   update_total();
        });
	}
	
	function load_ajax_data(div,pro,divs,desc) 
	{
		var Show_HSN_Code = document.getElementById('Show_HSN_Code').value;
		var Show_Saletax = document.getElementById('Show_Saletax').value; 
		$.post('global_product_data.php', {'sa':pro,'div':divs, 'desc': desc, 'show_hsn': Show_HSN_Code, 'show_tax': Show_Saletax}, function(data){
           $('#'+div).html(data);
		  $('.showdata').html("");
		   binds();
		   update_total();
		   
		   var row = $("#showdata"+divs).parents('.item-row');
		   var index = row.find('.form-control').index(this) + 2;
            row.find('.form-control').eq(index).focus();
			
        });
	}
	
	function load_invoice(val) 
	{
		$.post('invoice_search.php', {'search_term':val}, function(data){ 
		   $("#auto").html(data);
		  });
	}
	
	function setInvoiceNumber(val) {
		if(val == "AutoIncrement") { 
		var Company_inv_prefix = document.getElementById('Company_inv_prefix').value;
			if(Company_inv_prefix == "") {
				alert("Please add Prefix in Company Details");
				return false;
			} else {
			document.getElementById("invoice_number_value").setAttribute("readonly", "readonly"); 
			document.getElementById("invoice_number_value").value = document.getElementById("Company_inv_value").value;
			return true;
			}
		}
		if(val == "Manual") { 
			document.getElementById("invoice_number_value").removeAttribute("readonly", "readonly"); 
			return true;
		}
	}
	