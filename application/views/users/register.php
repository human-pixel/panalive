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
    });
</script>
<section class="banner__section">
	<div class="banner apply__banner">
		<header class="masthead">
		  	<div class="container h-100"></div>
		</header>
	</div>
</section>
<section class="apply__section padding-top-botom">
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
				  	<li class="">
					  	<a href="#personalInfo" role="tab" data-toggle="tab" aria-expanded="false" title="My Detail"> <strong>My Detail</strong></a>
				  	</li>
				  	<li class="disabled last-tab">
				  		<a href="#review" role="tab" data-toggle="tab" aria-expanded="false" title="Review"> <strong>Review</strong></a>
				  	</li>
				   	<li class="select-membership">
					  	<a href="#selectmembership" role="tab" data-toggle="tab" aria-expanded="false" title="Select Membership"><strong>Select Membership</strong></a>
				  	</li>
				  	<li class="">
				  		<a href="#payment" role="tab" data-toggle="tab" aria-expanded="false" title="Payments"> <strong>Payments</strong></a>
				  	</li>
				</ul>
			</div>
            <div class="eligible-message"></div>
		</section>
		<?php echo form_open('users/register', 'id="applyNowForm"'); ?>
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
									<div class="personalInfoForm ">
										<div class="row multi_filed_wrapper">
											<div class="multi_filed">
												<div class="multi_lumix">
													<div class="col-md-4">
														<div class="form-group">
														  	<select class="form-control lumixcamera" name="lumixcam[0]" id="lumixcamera_1">
															  	<option value="">Please Select (Camera or Lens)*</option>
																<option value="Camera" <?php if(set_value('lumixcam[0]') == "Camera"){echo "selected";}?>>Camera</option>
																<option value="Lens" <?php if(set_value('lumixcam[0]') == "Lens"){echo "selected";}?>>Lens</option>
														  	</select>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
														  	<select class="form-control lumixeligi" name="lumixeligi[0]" id="lumixeligi_1">
																<optgroup label="Camera">
																<option value="">Select eligibility product*</option>
																<?php foreach ($products as $product) :
																	if($product['type'] == 'Camera') :
																	?>
																	<option value="<?php echo $product['id']; ?>" <?php if(set_value('lumixeligi[0]')){echo "selected";}?>><?php echo $product['name']; ?></option>
																<?php endif; endforeach; ?>
																</optgroup>
																<optgroup label="Lens">
																<option value="">Select eligibility product*</option>
																<?php foreach ($products as $product) :
																	if($product['type'] == 'Lens') : ?>
																	<option value="<?php echo $product['id']; ?>" <?php if(set_value('lumixeligi[0]')){echo "selected";}?>><?php echo $product['name']; ?></option>
																<?php endif; endforeach; ?>
																</optgroup>
														  	</select>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<input type="text" name="lumixserial[0]" class="form-control lumixserial" id="lumixserial_1" value="<?php echo set_value('lumixserial[0]');?>" placeholder="Serial number*">
														</div>
													</div>
<!--													<div class="col-md-3">-->
<!--														<div class="form-group">-->
<!--															<input type="text" name="purchase_date[0]" class="form-control lumixpurchase" id="lumixpurchase_1" value="--><?php //echo set_value('purchase_date[0]'); ?><!--" placeholder="Purchase Date* DD-MM-YYYY">-->
<!--														</div>-->
<!--													</div>-->
												</div>
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

													<select style="width: 100%" class="form-control" name="salutation" id="sel1" placeholder="Please Select">
													  	<option value="">Please Select*</option>
														<option value="mr" <?php if(set_value('salutation') == "mr"){echo "selected";}?>>Mr.</option>
														<option value="ms" <?php if(set_value('salutation') == "ms"){echo "selected";}?>>Ms.</option>
														<option value="mrs" <?php if(set_value('salutation') == "mrs"){echo "selected";}?>>Mrs.</option>
													</select>
													<?php echo form_error('salutation'); ?>
												</div>
												<div class="form-group">
													<input type="text" name="fname" class="form-control" id="fname" value="<?php echo set_value('fname'); ?>" placeholder="First Name*">
													<?php echo form_error('fname'); ?>
												</div>
												<div class="form-group">
													<input type="text" name="lname" class="form-control" id="lname" value="<?php echo set_value('lname'); ?>" placeholder="Last Name*">
													<?php echo form_error('lname'); ?>
												</div>
												<div class="form-group">
													<input type="email" name="email" class="form-control" id="email" value="<?php echo set_value('email'); ?>" placeholder="Email Address*">
													<?php echo form_error('email'); ?>
												</div>
												<div class="form-group">
													<input type="email" name="confirmemail" class="form-control" id="c_email" value="<?php echo set_value('confirmemail'); ?>" placeholder="Confirm Email*">
													<?php echo form_error('confirmemail'); ?>
												</div>
												<div class="form-group">
													<input type="text" name="mobile" class="form-control" id="mob_no" value="<?php echo set_value('mobile'); ?>" placeholder="Mobile Number*">
													<?php echo form_error('mobile'); ?>
												</div>
												<div class="form-group">
													<label class="checkbox-form">Are you 18 years of age or older? *
													 <input type="checkbox" name="age" id="age" value="1" <?php if(set_value('age')){echo "checked";}?>>
													 <?php echo form_error('dob'); ?>
													  <span class="checkmark"></span>
													</label>
												</div>
												<div class="signin-form-button"></div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
                                                        <select style="width: 100%" class="form-control" name="state" id="state_id">
														<option value="">Select State*</option>
														<?php foreach ($states as $state) : ?>
															<option value="<?php echo $state['id'];?>" <?php if(set_value('state')){echo "selected";}?>><?php echo $state['name'];?></option>
														<?php endforeach; ?>
														<?php echo form_error('state');?>
													</select>
												</div>
												<div class="form-group">
													<input type="text" name="address" class="form-control" id="address" value="<?php echo set_value('address'); ?>" placeholder="Address*">
													<?php echo form_error('address'); ?>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<input type="text" name="suburb" class="form-control" id="suburb" value="<?php echo set_value('suburb'); ?>" placeholder="Suburb*">
															<?php echo form_error('suburb'); ?>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<input type="text" name="postcode" class="form-control" id="pcode" value="<?php echo set_value('postcode'); ?>" placeholder="Post Code*
															<?php echo form_error('postcode'); ?>">
														</div>
													</div>
												</div>
												<div class="form-group">
													<input type="text" name="website" class="form-control" id="website" value="<?php echo set_value('website'); ?>" placeholder="Website">
												</div>
												<div class="form-group">
												  	<input type="text" name="fb" class="form-control" id="fb" value="<?php echo set_value('fb'); ?>" placeholder="Facebook">
												</div>
												<div class="form-group">
													<input type="text" name="insta" class="form-control" id="insta" value="<?php echo set_value('insta'); ?>" placeholder="Instagram">
												</div>
												<div class="form-group">
												  	<input type="text" name="youtube" class="form-control" id="youtube" value="<?php echo set_value('youtube'); ?>" placeholder="YouTube">
												</div>
											</div>
										</div>
										<div class="nextprevious">
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
										<div class="nextprevious">
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
										<div class="nextprevious">
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
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="checkbox-form">I agree to the LUMIX Professional Services <a target="_blank" href="<?php echo base_url('users/terms-of-use') ?>" class="terms-of-use-url">Terms of Use</a>
													 	<input type="checkbox" name="termsOfUse" id="terms-of-use" value="1" <?php if(set_value('termsOfUse')){echo "checked";}?>>
                                                    	<?php echo form_error('termsOfUse'); ?>
													  	<span class="checkmark"></span>
													</label>
                                                </div>
                                            </div>
										</div>
										<div class="nextprevious">
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
</section>
