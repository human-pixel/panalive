<style>
div#resp-success-text,
div#resp-error-text {
    display: none;
}
div#resp-success-text{
    max-width: 100%;
    padding: 8px 10px;
    border: 1px solid #3498db;
    color: #3498db;
    border-radius: 3px;
}

span.help-inline {
    display: flex;
}
div#resp-error-text,
span.help-inline {
    max-width: 100%;
    padding: 5px 10px;
    border: 1px solid #e60013;
    color: #e60013;
    margin-top: 10px;
    border-radius: 3px;
}
.loading {
    height: 0;
    width: 0;
    padding: 15px;
    border: 6px solid #ccc;
    border-right-color: #888;
    border-radius: 22px;
    -webkit-animation: rotate 1s infinite linear;
    /* left, top and position just for the demo! */
    position: absolute;
    left: 50%;
    top: 0;
}
@-webkit-keyframes rotate {
    /* 100% keyframe for  clockwise.
     use 0% instead for anticlockwise */
    100% {
        -webkit-transform: rotate(360deg);
    }
}
</style>
<!-- Stripe JavaScript library -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    //set your publishable key
    Stripe.setPublishableKey('pk_test_VFvyZyUQ7gg4wE13ZjnE07al');

    //callback to handle the response from stripe
    function stripeResponseHandler(status, response) {
        if (response.error) {
            //display the errors on the form
            $('#payment-errors').addClass('alert alert-danger');
            $("#payment-errors").html(response.error.message);
        } else {
            var form$ = $("#applyNowForm");
            //get token id
            var token = response['id'];
            //insert the token into the form
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            //submit form to the server
            form$.get(0).submit();
        }
    }
    $(document).ready(function() {
        //on form submit
        $("#applyNowForm").submit(function(event) {
            //create single-use token to charge the user
            Stripe.createToken({
                number: $('#card_num').val(),
                cvc: $('#card-cvc').val(),
                exp_month: $('#card-expiry-month').val(),
                exp_year: $('#card-expiry-year').val()
            }, stripeResponseHandler);

            //submit from callback
            return false;
        });

        $(".loading").css("display", "none");
    });

    function applycouponCode() {
        var coupon_code = $("#coupon_code").val();
        var original_price = $("#original_price").val();
        var today = new Date();
        var day = today.getDate();
        // var day = (today.getDate() + 1);

        var month = today.getMonth();
        var date = ((''+day).length<2 ? '0' : '') + day + '-' + ((''+month).length<2 ? '0' : '') + month + '-' +today.getFullYear();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var apply_code_date = date+' '+time;

        var offer = <?php echo json_encode($offer);?>;
        // console.log(offer);
        if(typeof(offer.discount_type) != "undefined" && offer.discount_type == 2) {
            var discount_price = offer.discount;
            var pay_price = (original_price - discount_price);
        }
        else{
            var discount_price = ((offer.discount*original_price)/100);
            var pay_price = (original_price - discount_price);
        }

        if(coupon_code != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>membership/apply-coupon-code",
                method: 'POST',
                data: {coupon_code, apply_code_date, discount_price, pay_price},
                success: function(resp){
                    // console.log(resp);
                    var resp_data = JSON.parse(resp);
                    if(resp_data.success) {

                        $("input#coupon_code").css("display", "none");
                        $(".loading").css("display", "block");

                        setTimeout(function(){
                            $( ".loading" ).remove();
                        }, 3000);

                        setTimeout(function(){
                            $('#resp-success-text').text(resp_data.success).css("display", "flex").fadeIn(3000);
                            $(".btn-skew").replaceWith("<a class='btn btn-info btn-skew' style='color:#fff'>Membership Price $"+resp_data.data.pay_price+"</a>").fadeIn(3000);
                        }, 3000);
                    }
                    if(resp_data.error) {
                        $('#resp-error-text').text(resp_data.error).css("display", "flex").fadeIn(3000);
                        setTimeout(function(){
                            $( "#resp-error-text" ).remove();
                        }, 5000);
                    }
                }
            });
        }
    }
</script>
<section class="banner__section">
	<div class="banner apply__banner">
		<header class="masthead">
		  	<div class="container h-100"></div>
		</header>
	</div>
</section>
<div class="container">
	<section class="page_title_section">
		<div class="heading">
			<h2><strong>APPLY FOR LUMIX PROFESSIONAL SERVICES</strong><hr class="hr"></h2>
			<p>There will be some intro text here.</p>
		</div>
	</section>
	<!-------- start muti step form ---------->
	<div class="mutistep__form__div">
		<section class="personal-detail-section-1">
			<div class="personaldetail-page-navigation steps-nav">
				<ul class="nav nav-tabs" role="tablist">
					<li class="active none_before">
					  	<a href="#lumixproduct" role="tab" data-toggle="tab" aria-expanded="true" title="My Lumix"> <strong>My Lumix</strong></a>
				  	</li>
				  	<li class="disabled">
					  	<a href="#personalInfo" role="tab" data-toggle="tab" aria-expanded="false" title="My Detail"> <strong>My Detail</strong></a>
				  	</li>
				  	<li class="disabled last-tab">
				  		<a href="#review" role="tab" data-toggle="tab" aria-expanded="false" title="Review"> <strong>Review</strong></a>
				  	</li>
				   	<li class="disabled select-membership">
					  	<a href="#selectmembership" role="tab" data-toggle="tab" aria-expanded="false" title="Select Membership"><strong>Select Membership</strong></a>
				  	</li>
				  	<li class="disabled">
				  		<a href="#payment" role="tab" data-toggle="tab" aria-expanded="false" title="Payments"> <strong>Payments</strong></a>
				  	</li>
				</ul>
			</div>
		</section>
		<?php echo form_open('users/renew-membership/'.$memberid, 'id="applyNowForm"'); ?>
			<div class="tab-content">
				<div class="tab-pane fade active in" id="lumixproduct">
					<div class="lumixproduct-section2">
						<div class="personal-infoWidth">
							<div class="bg-light-blue">
								<div class="personal-info-sign-in-form">
									<div class="lumix-detail-error"></div>
									<?php if(validation_errors() != null) { ?>
									<div class="alert alert-danger icons-alert">
				                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-close"></i></button>
				                        <?php echo validation_errors(); ?>
				                    </div>
				                    <?php } ?>
				                    <?php if($this->session->flashdata('warning')) { ?>
									<div class="alert alert-warning icons-alert">
				                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="fa f-close"></i></button>
				                        <?php echo $this->session->flashdata('warning'); ?>
				                    </div>
				                    <?php } ?>
									<div class="sign-in-headeing">
										<h3><strong>MY LUMIX</strong></h3>
									</div>
									<div class="personalInfoForm fgdfgdgdgd">
										<div class="row multi_filed_wrapper">
											<div class="multi_filed">
												<?php $i = 1; foreach ($mylumix as $key => $value) { ?>
												<div class="multi_lumix">
													<div class="col-md-4">
														<div class="form-group">
															<select class="form-control lumixcamera" name="lumixcam[<?php echo $key; ?>]" id="lumixcamera_<?php echo $i; ?>">
															<option value="">Please Select (Camera or Lens)*</option>
															<option value="Camera" <?php if(isset($value['type']) && $value['type'] == 'Camera' ) {echo 'selected';} ?>>Camera</option>
															<option value="Lens" <?php if(isset($value['type']) && $value['type'] == 'Lens' ) {echo 'selected';} ?>>Lens</option>
															</select>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<select class="form-control lumixeligi" name="lumixeligi[<?php echo $key; ?>]" id="lumixeligi_<?php echo $i; ?>">
																<optgroup label="Camera">
																	<option value="">Select eligibility product*</option>
																	<?php foreach ($products as $product) :
																	if($product['type'] == 'Camera') :
																	?>
																	<option value="<?php echo $product['id']; ?>" <?php if(isset($value['name']) && $value['name'] == $product['name'] ) {echo 'selected';} ?>><?php echo $product['name']; ?></option>
																	<?php endif; endforeach; ?>
																</optgroup>
																<optgroup label="Lens">
																	<option value="">Select eligibility product*</option>
																	<?php foreach ($products as $product) :
																	if($product['type'] == 'Lens') : ?>
																	<option value="<?php echo $product['id']; ?>" <?php if(isset($value['name']) && $value['name'] == $product['name'] ) {echo 'selected';} ?>><?php echo $product['name']; ?></option>
																	<?php endif; endforeach; ?>
																</optgroup>
															</select>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<input type="text" name="lumixserial[<?php echo $key; ?>]" class="form-control lumixserial" id="lumixserial_<?php echo $i; ?>" value="<?php echo isset($value['serial_num']) ? set_value("lumixserial[".$key."]", $value['serial_num']) : set_value("lumixserial[".$key."]"); ?>" placeholder="Serial number*">
														</div>
													</div>
<!--													<div class="col-md-3">-->
<!--														<div class="form-group">-->
<!--															<input type="text" name="purchase_date[--><?php //echo $key; ?><!--]" class="form-control lumixpurchase" id="lumixpurchase_--><?php //echo $i; ?><!--" value="--><?php //echo isset($value['purchase_date']) ? set_value("purchase_date[".$key."]", $value['purchase_date']) : set_value("purchase_date[".$key."]"); ?><!--" placeholder="Purchase Date* YYYY-MM-DD">-->
<!--														</div>-->
<!--													</div>-->
												</div>
												<?php $i++; } ?>
											</div>
											<div class="col-sm-12">
												<div class="add_product">
													<p><a class="addproduct">Add product +</a></p>
												</div>
											</div>
											<div class="nextsave_btn">
												<ul>
													<li><div class="nextbutton"><div class="form-group"><button type="button" class="button primary info__btn next-step" style="">NEXT<i class="fa fa-angle-right" style="padding-left:10px;"></i></button></div></div></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end lumix product section -->
				<div class="tab-pane fade" id="personalInfo">
					<div class="personal-info-section2">
						<div class="personal-infoWidth">
							<div class="bg-light-blue">
								<div class="personal-info-sign-in-form">
									<div class="sign-in-headeing">
										<h3><strong>MY DETAILS - PERSONAL</strong></h3>
									</div>
									<div class="personalInfoForm">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<select class="form-control" name="salutation" id="sel1" placeholder="Please Select">
													  	<option value="">Please Select*</option>
														<option value="mr" <?php if(isset($member['title']) && $member['title'] == 'mr' ) {echo 'selected';} ?>>Mr.</option>
														<option value="ms" <?php if(isset($member['title']) && $member['title'] == 'ms' ) {echo 'selected';} ?>>Ms.</option>
														<option value="mrs" <?php if(isset($member['title']) && $member['title'] == 'mrs' ) {echo 'selected';} ?>>Mrs.</option>
													</select>
													<?php echo form_error('salutation'); ?>
												</div>
												<div class="form-group">
													<input type="text" name="fname" class="form-control" id="fname" value="<?php echo isset($member['first_name']) ? set_value("fname", $member['first_name']) : set_value("fname"); ?>" placeholder="First Name*">
												</div>
												<div class="form-group">
													<input type="text" name="lname" class="form-control" id="lname" value="<?php echo isset($member['last_name']) ? set_value("lname", $member['last_name']) : set_value("lname"); ?>" placeholder="Last Name*">
												</div>
												<div class="form-group">
													<input type="email" name="email" class="form-control" id="email" value="<?php echo isset($member['email']) ? set_value("email", $member['email']) : set_value("email"); ?>" placeholder="Email Address*">
												</div>
												<div class="form-group">
													<input type="email" name="confirmemail" class="form-control" id="c_email" value="<?php echo isset($member['email']) ? set_value("confirmemail", $member['email']) : set_value("confirmemail"); ?>" placeholder="Confirm Email*">
												</div>
												<div class="form-group">
													<input type="text" name="mobile" class="form-control" id="mob_no" value="<?php echo isset($member['mobile']) ? set_value("mobile", $member['mobile']) : set_value("mobile"); ?>" placeholder="Mobile Number*">
												</div>
												<div class="form-group">
													<label class="checkbox-form">Are you 18 years of age or old? *
													 <input type="checkbox" name="age" id="age" value="1" <?php if(isset($member['age']) && $member['age'] == 1 ) {echo 'checked';} ?>>
													 <?php echo form_error('dob'); ?>
													  <span class="checkmark"></span>
													</label>
												</div>
												<div class="signin-form-button"></div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<select class="form-control" name="state" id="state_id">
														<option value="">Select State*</option>
														<?php foreach ($states as $state) : ?>
															<option value="<?php echo $state['id'];?>" <?php if(isset($member['state_id']) && $member['state_id'] == $state['id'] ) {echo 'selected';} ?>><?php echo $state['name'];?></option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<input type="text" name="address" class="form-control" id="address" value="<?php echo isset($member['address']) ? set_value("address", $member['address']) : set_value("address"); ?>" placeholder="Address*">
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<input type="text" name="suburb" class="form-control" id="suburb" value="<?php echo isset($member['suburb']) ? set_value("suburb", $member['suburb']) : set_value("suburb"); ?>" placeholder="Suburb*">
															<?php echo form_error('suburb'); ?>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<input type="text" name="postcode" class="form-control" id="pcode" value="<?php echo isset($member['postcode']) ? set_value("postcode", $member['postcode']) : set_value("postcode"); ?>" placeholder="Post Code*
															<?php echo form_error('postcode'); ?>">
														</div>
													</div>
												</div>
												<div class="form-group">
													<input type="text" name="website" class="form-control" id="website" <?php echo isset($member['website']) ? set_value("website", $member['website']) : set_value("website"); ?> placeholder="Website">
												</div>
												<div class="form-group">
												  	<input type="text" name="fb" class="form-control" id="fb" <?php echo isset($member['facebook']) ? set_value("fb", $member['facebook']) : set_value("fb"); ?> placeholder="Facebook">
												</div>
												<div class="form-group">
													<input type="text" name="insta" class="form-control" id="insta" <?php echo isset($member['instagram']) ? set_value("insta", $member['instagram']) : set_value("insta"); ?> placeholder="Instagram">
												</div>
												<div class="form-group">
												  	<input type="text" name="youtube" class="form-control" id="youtube" <?php echo isset($member['youtube']) ? set_value("youtube", $member['youtube']) : set_value("youtube"); ?> placeholder="YouTube">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="previous_btn">
													<div class="form-group"><button type="button" class="button secondary-button info__btn prev-step"><i class="fa fa-angle-left" style="padding-right:10px;"></i>Back</button></div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="nextsave_btn">
													<ul>
														<li><div class="nextbutton"><div class="form-group"><button type="button" class="button primary info__btn next-step" style="">NEXT<i class="fa fa-angle-right" style="padding-left:10px;"></i></button></div></div></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="review">
					<div class="confirmation-section2">
						<div class="personal-infoWidth">
							<div class="bg-light-blue">
								<div class="personal-info-sign-in-form">
									<div class="sign-in-headeing">
										<h3><strong>CONFIRM YOUR DETAIL</strong></h3>
									</div>
									<div class="personalInfoForm">
										<div class="confirmdetailinfo"></div>
										<div class="row">
											<div class="col-sm-6">
												<div class="previous_btn">
													<div class="form-group"><button type="button" class="button secondary-button info__btn prev-step"><i class="fa fa-angle-left" style="padding-right:10px;"></i>Back</button></div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="nextsave_btn">
													<ul>
														<li><div class="nextbutton"><div class="form-group"><button type="button" class="button primary info__btn next-step" style="">NEXT<i class="fa fa-angle-right" style="padding-left:10px;"></i></button></div></div></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- end personal info section -->
				<div class="tab-pane fade" id="selectmembership">
					<div class="personal-info-section2">
						<div class="membership-infoWidth">
							<div class="bg-light-blue">
								<div class="personal-info-sign-in-form">
									<div class="sign-in-headeing">
										<h3><strong>MEMBERSHIP LEVEL</strong></h3>
										<p>You’re almost there! Based on the eligible gear you've entered, you qualify for the below membership level/s. Please confirm your LUMIX Professional Services membership level to continue.</p>
									</div>
									<div class="personalInfoForm">
										<div class="row">
											<div class="col-sm-12">
												<div class="membership__content">
													<div class="panel-group" id="accordion"></div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="previous_btn">
													<div class="form-group"><button type="button" class="button secondary-button info__btn prev-step"><i class="fa fa-angle-left" style="padding-right:10px;"></i>Back</button></div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="nextsave_btn">
													<ul>
														<li><div class="nextbutton"><div class="form-group"><button type="button" class="button primary info__btn next-step" style="">NEXT<i class="fa fa-angle-right" style="padding-left:10px;"></i></button></div></div></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end confirmation info section -->
				<div class="tab-pane fade" id="payment">
					<div class="personal-info-section2">
						<div class="payment-infoWidth">
							<div class="bg-light-blue">
								<div class="personal-info-sign-in-form">
									<div id="payment-errors"></div>
									<div class="sign-in-headeing">
										<h3><strong>PAYMENT</strong></h3>
										<div id="membership"><p style="color:#e60012">You have not selected any of the membership. Please go back and select.</p></div>
										<p>NOTE: Membership payment will only be processed upon successful application to LUMIX Professional Services. Visa and Mastercard accepted.</p>
									</div>
									<div class="personalInfoForm">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<input type="number" name="card_num" id="card_num" class="form-control" placeholder="Card Number" autocomplete="off" value="<?php echo set_value('card_num'); ?>" required>
												</div>
												<div class="form-group">
													<input type="text" name="exp_month" maxlength="2" class="form-control" id="card-expiry-month" placeholder="MM" value="<?php echo set_value('exp_month'); ?>" required>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<input type="text" name="exp_year" class="form-control" maxlength="4" id="card-expiry-year" placeholder="YYYY" required="" value="<?php echo set_value('exp_year'); ?>">
												</div>
												<div class="form-group">
													<input type="text" name="cvc" id="card-cvc" maxlength="3" class="form-control" autocomplete="off" placeholder="CVC" value="<?php echo set_value('cvc'); ?>" required>
												</div>
											</div>
										</div>
										<div class="row">
			                                <?php if(empty($coupon)) : ?>
			                                <div class="col-sm-12">
			                                    <div class="form-group">
			                                        <div class="loading"></div>
			                                        <div id="resp-success-text"></div>
			                                        <input type="text" name="coupon_code" class="form-control" id="coupon_code" value="" placeholder="Coupon Code">
			                                        <div id="resp-error-text"></div>
			                                    </div>
			                                </div>
			                            </div>
			                            <div class="row">
			                            	<div class="form-group">
				                                <div class="col-sm-2">
				                                    <button type="button" class="btn btn-primary waves-effect waves-light discount_coupon_btn" onClick="applycouponCode()">Apply</button>
				                                </div>
				                                <?php endif; ?>
				                                <div class="col-sm-2">
				                                    <?php if(!empty($coupon)) : ?>
				                                    <a class="btn btn-info btn-skew" style="color:#fff">Membership Price $<?php echo $coupon['pay_price']; ?></a>
				                                    <?php else : ?>
				                                    <a class="btn btn-info btn-skew" style="color:#fff"></a>
				                                    <?php endif; ?>
				                                    <input type="hidden" id="original_price" value="">
				                                </div>
				                            </div>
			                            </div>
										<div class="row">
											<div class="col-sm-6">
												<div class="previous_btn">
													<div class="form-group"><button type="button" class="button secondary-button info__btn prev-step"><i class="fa fa-angle-left" style="padding-right:10px;"></i>Back</button></div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="nextsave_btn">
													<ul>
														<li><div class="nextbutton"><div class="form-group"><button type="submit" class="button primary info__btn submit">SUBMIT<i class="fa fa-angle-right" style="padding-left:10px;"></i></button></div></div></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php echo form_close(); ?>
		<!-------- end muti step form ---------->
		<!-------- start more info ---------->
		<section class="more__indo__div padding-top-botom">
			<div class="row">
				<div class="col-sm-6">
					<div class="light__gray_bg">
						<h2><strong>Am I Eligible?</strong></h2>
						<a class="btn secondary-button" href="<?php echo base_url(); ?>eligibility">MORE INFO</a>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="light__gray_bg">
						<h2><strong>LPS Benefits</strong></h2>
						<a class="btn secondary-button" href="<?php echo base_url(); ?>benefits">MORE INFO</a>
					</div>
				</div>
			</div>
		</section>
	</div>
<!-------- end more info---------->
</div>
