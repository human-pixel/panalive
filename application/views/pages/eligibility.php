<section class="banner__section">
	<div class="banner benefits__banner">
		<header class="masthead">
		  <div class="container h-100">
		    </div>
		</header>
	</div>
</section>
<section class="eligibility__section padding-top-botom">
	<div class="container">
		<div class="eligibility__service">
			<div class="col-sm-12">
				<h2><strong>ELIGIBILITY REQUIREMENTS</strong>
				<hr class="hr"></h2>
				<p>To be accepted into the LUMIX Professional Services program, there is a minimum eligible gear requirement that must be met. Applicants are required to own at a minimum either the S Series, OR the G Series minimum eligible gear requirements outlined below.</p>
				<div class="membershipLevel">
					<div class="table-responsive membershipLevel__div">
						<table class="table">
							<thead>
							  <tr>
								<th style="width:50%;"></th>
								<th>SILVER</th>
								<th>PLATINUM</th>
							  </tr>
							</thead>
							<tbody>
							  <tr>
								<td>S Series</td>
								<td><?php echo $sscc_array; echo ($sscc_array == 1) ? ' body' : ' bodys'; ?> + <?php echo $sscl_array; echo ($sscl_array == 1) ? ' lens' : ' lenses'; ?></td>
								<td><?php echo $spcc_array; echo ($spcc_array == 1) ? ' body' : ' bodys'; ?> + <?php echo $spcl_array; echo ($spcl_array == 1) ? ' lens' : ' lenses'; ?></td>
							  </tr>
							  <tr>
								<td>G Series</td>
								<td><?php echo $gscc_array; echo ($gscc_array == 1) ? ' body' : ' bodys'; ?> + <?php echo $gscl_array; echo ($gscl_array == 1) ? ' lens' : ' lenses'; ?></td>
								<td><?php echo $gpcc_array; echo ($gpcc_array == 1) ? ' body' : ' bodys'; ?> + <?php echo $gpcl_array; echo ($gpcl_array == 1) ? ' lens' : ' lenses'; ?></td>
							  </tr>
							</tbody>
						</table>
					</div>
				</div>
				<p>Current as at <?php echo date('M Y'); ?>.</p>
			</div>
		</div>
	</div>
</section>
<section class="lumix_series_section">
	<div class="container">
		<div class="lumix_s_series">
			<div class="col-sm-12">
				<h2>ELIGIBLE PRODUCTS<hr class="hr"></h2>
				<h4><strong>LUMIX S SERIES</strong></h4>
				<p>See the current eligible LUMIX S Series cameras and lenses, below.</p>
			</div>
			<div class="lumixSSerirs_category owl-carousel owl-theme">
                <div class="item text-center lumixItemSCameras">
                    <img src="http://pana.test/ci//assets/images/eligibility/s-series.png">
                    <div class="caption">
                        <a href="#" target="_blank">S1R (DC-S1R)</a>
                    </div>
                </div>
            </div>
        </div>
            <div class="lumixSCategoriesNavigation">
                <a class="SCprev"><i class="fa fa-angle-left"></i></a>
                <a class="SCnext"><i class="fa fa-angle-right"></i></a>
            </div>
			<div id="lumixSSerirs_slider" class="owl-carousel owl-theme">
				<?php foreach ($products as $key => $product) : ?>
					<?php if($product['series'] == 'S' && $product['type'] == 'Lens') : ?>
					  	<div class="item text-center lumixItemSLens">
							<img src="<?php echo base_url() ?>/assets/images/eligibility/<?php echo $product['image'];?>">
							<div class="caption">
								<a  href="#" <?php if($product['ext_url'] != '') {echo "href=".$product['ext_url'].""; }?> target="_blank"><?php echo $product['name'];?></a>
							</div>
					  	</div>
					<?php endif; ?>
				<?php endforeach; ?>

			</div>
			<div class="customNavigation">
				<a class="prev"><i class="fa fa-angle-left"></i></a>
				<a class="next"><i class="fa fa-angle-right"></i></a>
			</div>
		</div>
		<div class="lumix_g_series">
			<div class="col-sm-12">
				<h4><strong>LUMIX G SERIES</strong></h4>
				<p>See the current eligible LUMIX G Series cameras and lenses, below.</p>
			</div>
			<div class="lumixGSerirs_category owl-carousel owl-theme">
				<?php foreach ($products as $key => $product) : ?>
					<?php if($product['series'] == 'G' && $product['type'] == 'Camera') : ?>
                        <div class="item text-center lumixItemGCameras">
                            <img src="<?php echo base_url() ?>/assets/images/eligibility/<?php echo $product['image'];?>">
                            <div class="caption">
                                <a  href="#" <?php if($product['ext_url'] != '') {echo "href=".$product['ext_url'].""; }?> target="_blank"><?php echo $product['name'];?></a>
                            </div>
                        </div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
            <div class="lumixGCategoriesNavigation">
                <a class="GCprev"><i class="fa fa-angle-left"></i></a>
                <a class="GCnext"><i class="fa fa-angle-right"></i></a>
            </div>
			<div id="lumixGSerirs_slider" class="owl-carousel owl-theme">
				<?php foreach ($products as $key => $product) : ?>
					<?php if($product['series'] == 'G' && $product['type'] == 'Lens') : ?>
					  	<div class="item text-center lumixItemGLens">
							<img src="ci/assets/images/eligibility/g-series-6.png">
							<div class="caption">
								<a  href="#" <?php if($product['ext_url'] != '') {echo "href=".$product['ext_url'].""; }?> target="_blank"><?php echo $product['name'];?></a>
							</div>
					  	</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<div class="lumixGSerirsNavigation">
				<a class="Gprev"><i class="fa fa-angle-left"></i></a>
				<a class="Gnext"><i class="fa fa-angle-right"></i></a>
			</div>
		</div>
	</div>
</section>
<section class="more__indo__div">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				<div class="light__gray_bg">
					<h2><strong>LPS Benefits</strong></h2>
					<a class="btn secondary-button" href="<?php echo base_url(); ?>benefits">MORE INFO</a>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12">
				<div class="light__gray_bg">
					<h2><strong>Ready to Get Started?</strong></h2>
					<a class="btn primary-button" href="<?php echo base_url(); ?>users/register">APPLY NOW</a>
				</div>
			</div>
		</div>
	</div>
</section>
