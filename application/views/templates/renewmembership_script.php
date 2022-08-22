<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-validation/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.js"></script>
<script type="text/javascript">
$(document).ready(function (){
	//$("#lumixpurchase_1").mask("9999-99-99");
	$("#mob_no").mask("99 9999 9999");

	var memberid = <?php echo json_encode($memberid);?>;
	var mailexisturl = "<?php echo base_url('users/check_update_email/'); ?>"+memberid;

	var validation = jQuery("#applyNowForm").validate({
      	rules: {
			'lumixcam[0]': {
				required: true,
			},
			'lumixeligi[0]':{
				required: true,
			},
			'lumixserial[0]':{
				required: true,
			},
			// 'purchase_date[0]':{
			// 	required: true,
			// },
      		salutation: {
      			required: true
      		},
			fname: {
				required: true
			},
			lname: {
				required: true
			},
			email: {
				required: true,
				email: true,
				remote: {
	                url: mailexisturl,
	                type: "post"
	            }
			},
			confirmemail: {
				required: true,
				email: true,
				equalTo: "#email"
			},
			age: {
				required: true
			},
			mobile: {
				required: true,
			},
			state: {
				required: true,
			},
			address: {
				required: true,
			},
			suburb: {
				required: true,
			},
			postcode: {
				required: true,
			}
      	},
      	messages: {
			'lumixcam[0]':{
				required: "Please select camera/lens field",
			},
			'lumixeligi[0]':{
				required: "Please select eligibility field",
			},
			'lumixserial[0]':{
				required: "Please enter serial number",
			},
			// 'purchase_date[0]':{
			// 	required: "Please enter purchase date",
			// },
			salutation: {
				required: "Please select your salutation"
			},
			fname: {
				required: "Please enter your first name"
			},
			lname: {
				required: "Please enter your last name"
			},
			email: {
				required: "Please enter your email address",
				email: "Please enter a valid email address",
				remote: "This email is already registered"
			},
			confirmemail: {
				required: "Please confirm your email address",
				email: "Please enter a valid email address",
				equalTo: "Email address does not match"
			},
			age: {
				required: "Please check age critaria"
			},
			mobile: {
				required: "Please enter your mobile number",
			},
			state: {
				required: "Please select state",
			},
			address: {
				required: "Please enter your address",
			},
			suburb: {
				required: "Please enter your suburb",
			},
			postcode: {
				required: "Please enter your postcode",
			}
      	},
		errorElement: "span",
		errorClass: "help-inline"
    });

    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();

    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var target = $(e.target);

        if (target.parent().hasClass('disabled')) {
            return false;
        }

        if (target.parent().hasClass('last-tab')) {

        	// My Lumix data
			var lumixcamera = [], lumixeligi = [], lumixserial = [];//, lumixpurchase = [];

			$.each($("select.lumixcamera"), function(){
				if (this.value != '') {
                	lumixcamera.push(this.value);
                }
            });
            $.each($("select.lumixeligi"), function(){
				if (this.value != '') {
					lumixeligi.push($(this).find(':selected').text());
                }
            });
            $.each($("input.lumixserial"), function(){
				if (this.value != '') {
                	lumixserial.push(this.value);
                }
            });
            // $.each($("input.lumixpurchase"), function(){
			// 	if (this.value != '') {
            //     	lumixpurchase.push(this.value);
            //     }
            // });

			var lumix_data = '<div class="col-md-6"><div class="border-box"><div class="light__gray_bg"><h3>My Lumix</h3></div><div class="panenl-content"><p>Product: '+lumixcamera.join(", ")+'</p><p>Modal No.: '+lumixeligi.join(", ")+'</p><p>Serial Number: '+lumixserial.join(", ")+'</p></div></div></div>';//<p>Purchase Date: '+lumixpurchase.join(", ")+'</p>

        	// Personal detail data
			var sel1 = $('#sel1').val();
			if(sel1 == "mr") {
				var title = "Mr.";
			}
			else if(sel1 == "ms") {
				var title = "Ms.";
			}
			else if(sel1 == "mrs") {
				var title = "Mrs.";
			}
			var fname = $('#fname').val();
			var lname = $('#lname').val();
			var email = $('#email').val();
			var age = ($('#age').val() == 1 ) ? 'Yes' : 'No';
			var mob_no = $('#mob_no').val();
			var address = $('#address').val();

			if ($('#state_id').val() != '') {
				var state = $("select[name='state']").find(':selected').text();
            }

			var suburb = $('#suburb').val();
			var pcode = $('#pcode').val();
			var website = $('#website').val();
			var fb = $('#fb').val();
			var insta = $('#insta').val();
			var youtube = $('#youtube').val();

			var personal_data = '<div class="col-md-6"><div class="border-box"><div class="light__gray_bg"><h3>My Detail</h3></div><div class="panenl-content"><p><p>Title: '+title+'</p></p><p><p>First Name: '+fname+'</p></p><p><p>Last Name: '+lname+'</p></p><p><p>Email: '+email+'</p></p><p><p>Age 18 or Old: '+age+'</p></p><p><p>Mobile Number: '+mob_no+'</p></p><p><p>State: '+state+'</p></p><p><p>Address: '+address+'</p></p><p><p>Suburb: '+suburb+'</p></p><p><p>Pin Code: '+pcode+'</p></p><p><p>Your Website: '+website+'</p></p><p><p>Facebook: '+fb+'</p></p><p><p>Instagram: '+insta+'</p></p><p><p>Youtube: '+youtube+'</p></p></div></div></div>';

			// Confirmation Data
			$(".confirmdetailinfo").append(lumix_data + personal_data);
        }
        else {
        	$(".confirmdetailinfo").empty();
        }

        if (target.parent().hasClass('select-membership')) {

        	// My Membership data
			var camcount = [], lenscount = [], series = [];

			$.each($("select.lumixcamera"), function(){
				if (this.value == 'Camera') {
                	camcount.push(this.value);
                }
                else if (this.value == 'Lens') {
                	lenscount.push(this.value);
                }
            });
            $.each($("select.lumixeligi"), function(){
				if (this.value != '') {
					series.push($(this).find(':selected').text().charAt(0));
                }
            });
            var uniqueSeries = series.filter(function(item, i, series) {
		        return i == series.indexOf(item);
		    });
            $.ajax({
	            url: "<?php echo base_url(); ?>memberships/get_membership_detail",
	            method: 'POST',
	            data: {series:uniqueSeries[0], camcount:camcount.length, lenscount:lenscount.length},
	            success:function(resp){
	            	var resp_data = JSON.parse(resp);
	                $('#accordion').html(resp_data);

	                var pprice = [], sprice = [];
	                $.each(resp_data.data, function(i, value){
						if (value.membership == 'Platinum') {
		                	pprice.push(value.price);
		                }
		                else if (value.membership == 'Silver') {
		                	sprice.push(value.price);
		                }
		            });

	                $("#selectPlatinum").click(function(e) {
	                	e.preventDefault();
	                	if($('input[id=hiddenSilver]').val() != '') {
	                		$('input[id=hiddenSilver]').val('');
	                	}
						$('#membership').html('<p>You have selected <a>Platinum</a> membership.</p>');
						$('.btn-skew').html('Membership Price $'+pprice);
						$('input[id=original_price]').val(pprice);
						$('input[id=hiddenPlatinum]').appendTo('#applyNowForm');

						var this$ = $('#platinumnext p'),
					    _status = !!this$.data('status');
					    this$.html('Selected').data('status', !_status).css({'color':'#e60012','float':'right','margin':'10px'});
					    setTimeout(function(){
					    	this$.html('').data('status', !_status);
                        }, 3000);
					});

					$("#selectSilver").click(function(e) {
						e.preventDefault();
						if($('input[id=hiddenPlatinum]').val() != '') {
	                		$('input[id=hiddenPlatinum]').val('');
	                	}
					    $('#membership').html('<p>You have selected <a>Silver</a> membership.</p>');
					    $('.btn-skew').html('Membership Price $'+sprice);
					    $('input[id=original_price]').val(sprice);
					    $('input[id=hiddenSilver]').appendTo('#applyNowForm');
					    var this$ = $('#silvernext p'),
					    _status = !!this$.data('status');
					    this$.html('Selected').data('status', !_status).css({'color':'#e60012','float':'right','margin':'10px'});
					    setTimeout(function(){
					    	this$.html('').data('status', !_status);
                        }, 3000);
					});
	            }
	        });
        }
        else {
        	$("#accordion").empty();
        }
    });

    $(".next-step").click(function (e) {
    	if (validation.form()) {

    		var active = $('.nav-tabs li.active');
			// My Membership data
			var camcount = [], lenscount = [], series = [];

			$.each($("select.lumixcamera"), function(){
				if (this.value == 'Camera') {
                	camcount.push(this.value);
                }
                else if (this.value == 'Lens') {
                	lenscount.push(this.value);
                }
            });
            $.each($("select.lumixeligi"), function(){
				if (this.value != '') {
					series.push($(this).find(':selected').text().charAt(0));
                }
            });
            var uniqueSeries = series.filter(function(item, i, series) {
		        return i == series.indexOf(item);
		    });
		    $.ajax({
	            url: "<?php echo base_url(); ?>memberships/check_membership",
	            method: 'POST',
	            data: {series:uniqueSeries[0], camcount:camcount.length, lenscount:lenscount.length},
	            success:function(resp){
	            	var resp_data = JSON.parse(resp);
	                if(resp_data == '') {
				    	active.next().addClass('disabled');
				    	var url = "<?php echo base_url('eligibility'); ?>";
				    	$('.lumix-detail-error').html('<div class="alert alert-warning icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa f-close"></i></button>Alert! &nbsp;&nbsp;Current gear does not match to the membership criteria. Please check the criteria <a href="'+url+'" target="_blank">here</a></div>');
				    	setTimeout(function(){
		                    $( ".lumix-detail-error" ).remove();
		                }, 20000);
				    }
	            }
	        });
		    if(uniqueSeries.length > 1) {
		    	active.next().addClass('disabled');
		    	var url = "<?php echo base_url('eligibility'); ?>";
		    	$('.lumix-detail-error').html('<div class="alert alert-warning icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa f-close"></i></button>Alert! &nbsp;&nbsp; Current gear does not match to the membership criteria. Please check the criteria <a href="'+url+'" target="_blank">here</a></div>');
		    	setTimeout(function(){
                    $( ".lumix-detail-error" ).remove();
                }, 20000);
		    }
		    else {
		        active.next().removeClass('disabled');
		        nextTab(active);
		        $('html, body').animate({
			        scrollTop: $('.page_title_section').offset().top
			    }, 800);
			}
	    }
    });
    $(".prev-step").click(function (e) {
        var active = $('.nav-tabs li.active');
        prevTab(active);
        $('html, body').animate({
	        scrollTop: $('.page_title_section').offset().top
	    }, 800);
    });

	/*****************/
	var max_fields = 10;
	var wrapper = $(".multi_filed");
	var add_button = $(".addproduct");
	var x = 1, y = 0;

    $(add_button).click(function(e) {
        e.preventDefault();

        if (x < max_fields) {
            x++; y++;
            var products = <?php echo json_encode( $products ) ?>;
            var camera_arr = [], lens_arr = [];
			$.each(products, function(key,value) {
			  	if( value.type == 'Camera') {
			  		var camera = '<option value="'+value.id+'">'+value.name+'</option>';
			  		camera_arr.push(camera);
			  	}
			  	if( value.type == 'Lens') {
			  		var lens = '<option value="'+value.id+'">'+value.name+'</option>';
					lens_arr.push(lens);
			  	}
			});

            $(wrapper).append('<div class="multi_lumix next-referral"><div class="col-md-4"><div class="form-group"><select class="form-control lumixcamera" name="lumixcam['+y+']" data-id="'+x+'" id="lumixcamera_'+x+'"><option value="">Please Select (Camera or Lens)*</option><option value="Camera">Camera</option><option value="Lens">Lens</option></select></div></div><div class="col-md-4"><div class="form-group"><select class="form-control lumixeligi" name="lumixeligi['+y+']" id="lumixeligi_'+x+'"> <optgroup label="Camera"><option value="">Select eligibility product*</option>'+camera_arr+'</optgroup><optgroup label="Lens"><option value="">Select eligibility product*</option>'+lens_arr+'</optgroup></select></div></div><div class="col-md-3"><div class="form-group"><input type="text" name="lumixserial['+y+']" class="form-control lumixserial" id="lumixserial_'+x+'" placeholder="Serial number*"></div></div><div class="col-md-1"><a href="#" class="btn btn-danger remove_button" title="Remove" data-toggle="tooltip"><i class="fa fa-minus" ></a></i></div></div>');

            //$('#lumixpurchase_'+x+'').mask("9999-99-99");

			$('#lumixcamera_'+x+'').each(function() {
				$(this).rules("add",
				{
					required: true,
					messages: {
						required: "Please select camera/lens field",
					}
				});
			});
			$('#lumixeligi_'+x+'').each(function() {
				$(this).rules("add",
				{
					required: true,
					messages: {
						required: "Please select eligibility field",
					}
				});
			});
			$('#lumixserial_'+x+'').each(function() {
				$(this).rules("add",
				{
					required: true,
					messages: {
						required: "Please enter serial number",
					}
				});
			});
			// $('#lumixpurchase_'+x+'').each(function() {
			// 	$(this).rules("add",
			// 	{
			// 		required: true,
			// 		messages: {
			// 			required: "Please enter purchase date",
			// 		}
			// 	});
			// });

			$(".lumixcamera").change(function () {
				var cam_id = $(this).data('id');
				var optGroups = $('#lumixeligi_'+cam_id+' > optgroup');
				if(this.value == '') {
					$('#lumixeligi_'+cam_id+'').html(optGroups);
				}
				else {
					$('#lumixeligi_'+cam_id+'').html(optGroups.filter('[label="'+this.value+'"]'));
				}
			});
        }
        else {
            $(wrapper).append('<div class="multi_lumix next-referral text-center" style="color: #e60012">A max of 10 items can be added at application stage. More items can be added within the membership dashboard later.</div>');
        }

        $('[data-toggle="tooltip"]').tooltip();
    });

    $(wrapper).on("click", ".remove_button", function(e) {
        e.preventDefault();
        $(this).parent('div').parent('div').parent('div').remove();
        x--;
    })

	/********** my lumix category nand subcategory ***********/
	var optgroups = $('#lumixeligi_1 > optgroup');
	$("#lumixcamera_1").change(function() {
		if(this.value == '') {
			$('#lumixeligi_1').html(optgroups);
		}
		else {
			$('#lumixeligi_1').html(optgroups.filter('[label="'+this.value+'"]'));
		}
	});

});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
</script>
