 <section class="banner__section">
	<div class="banner thankyou__banner">
		<header class="masthead">
		  	<div class="container h-100"></div>
		</header>
	</div>
</section>
<div class="container">
	<?php if ($this->session->flashdata('success') != ''): ?>
		<div class="thankyou-infoWidth">
			<div class="bg-light-blue">
				<div class="personal-info-sign-in-form">
					<div class="sign-in-headeing">
						<h3><strong>THANK YOU</strong></h3>
					</div>
					<div class="thankyou__msg ">
						<p>Your application to LUMIX Professional Services has been submitted successfully. You will be notified within 48hrs via your submitted email address whether your application has been successful.</p>
						<p></p>We hope to be welcoming you into the community soon.</p>
						<p></p>
                        <br><br><br>
                        The LUMIX Australia team</p>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>

<!-- <section class="page_title_section">
        <div class="heading text-center" style="height:100vh;">
        	<?php/* if ($this->session->flashdata('success') != ''):
			    echo "<h4 class='alert'>";
			    echo $this->session->flashdata('success');
				echo "</h4>";
			endif; */?>
        </div>
    </section>-->
