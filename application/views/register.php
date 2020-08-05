<main role="main" class="flex-shrink-0">
<div class="container">
    <div class="row">
        <div class="offset-md-3 col-md-6 text-center formdiv">
            <h1>Event Management System</h1>
            <h2>Login</h2>
            <!-- Login Form -->
			<?php echo form_open('user/register', 'name=loginform'); ?>
				<?php
					$msgErr = $this->session->flashdata('msg');
					if($msgErr !=''){
						echo '<p class="inputErr">'.$msgErr.'</p>';
					}
				?>
				<input type="text" value="<?php echo set_value('name')?>" id="name" class="fadeIn second <?php echo (form_error('name') != '')? 'is_valid':'' ?>" name="name" placeholder="Enter your name">
				<p class="inputErr"><?php echo strip_tags(form_error('name'))?></p>

				<input type="text" value="<?php echo set_value('company')?>" id="company" class="fadeIn second <?php echo (form_error('company') != '')? 'is_valid':'' ?>" name="company" placeholder="Enter your company name">
				<p class="inputErr"><?php echo strip_tags(form_error('company'))?></p>

				<input type="text" value="<?php echo set_value('email')?>" id="email" class="fadeIn second <?php echo (form_error('email') != '')? 'is_valid':'' ?>" name="email" placeholder="Enter your email id">
				<p class="inputErr"><?php echo strip_tags(form_error('email'))?></p>

                <input type="number" value="<?php echo set_value('mobile')?>" id="mobile" class="fadeIn second <?php echo (form_error('mobile') != '')? 'is_valid':'' ?>" name="mobile" placeholder="Enter your mobile no">
				<p class="inputErr"><?php echo strip_tags(form_error('mobile'))?></p>

				<input type="password" id="password" class="fadeIn third <?php echo (form_error('password') != '')? 'is_valid':'' ?>" name="password" placeholder="Enter your password">
				<p class="inputErr"><?php echo strip_tags(form_error('password'))?></p>

				<button type="submit" class="fadeIn fourth submitbutton" >Submit</button>
			<?php echo form_close(); ?>
        </div>
    </div>
</div>
</main>

