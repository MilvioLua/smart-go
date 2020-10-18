
<div class="pt-login-c">

	<?php if(site_register): ?>
	<div class="pt-login pt-signup">
		<form id="pt-send-signup">
			<div class="pt-logo"><span><i class="fas fa-fire"></i></span><b>Puerto Survey</b></div>
			<div class="pt-login-form">
					<div class="pt-form-i">
						<span class="pt-icon"><i class="far fa-user"></i></span>
						<input type="text" name="reg_name" placeholder="<?=$lang['signup']['username']?>">
					</div>

					<div class="pt-form-i">
						<span class="pt-icon"><i class="fas fa-key"></i></span>
						<input type="password" name="reg_pass" placeholder="<?=$lang['signup']['password']?>">
					</div>
					<div class="pt-form-i">
						<span class="pt-icon"><i class="far fa-envelope"></i></span>
						<input type="text" name="reg_email" placeholder="<?=$lang['signup']['email']?>">
					</div>

				<div class="pt-login-footer">
						<button type="submit" class="pt-btn"><?=$lang['signup']['button']?></button>
				</div>
				<?php if(site_register && (login_facebook || login_twitter || login_google)): ?>
				<div class="pt-social-login">
					<b>OR login using social media</b>
					<?php if(login_facebook): ?>
					<a class="facebook" href="<?=$facebookLoginUrl?>"><i class="fab fa-facebook"></i></a>
					<?php endif; ?>
					<?php if(login_twitter): ?>
					<a class="twitter" href="<?=$twitterLoginUrl?>"><i class="fab fa-twitter"></i></a>
					<?php endif; ?>
					<?php if(login_google): ?>
					<a class="google" href="<?=$googleLoginUrl?>"><i class="fab fa-google"></i></a>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
			<div class="pt-footer">
				<?=$lang['signup']['footer']?> <a href="#" class="clickme2"><?=$lang['signup']['footer_l']?></a>
			</div>
		</form>
	</div>
	<?php endif; ?>

<div class="pt-login pt-signin">
	<form id="pt-send-signin">
		<div class="pt-logo"><span><i class="fas fa-fire"></i></span><b>Puerto Survey</b></div>
		<div class="pt-login-form">
			<div class="pt-form-i">
				<span class="pt-icon"><i class="far fa-user"></i></span>
				<input type="text" name="sign_name" placeholder="<?=$lang['login']['username']?>">
			</div>
			<div class="pt-form-i">
				<span class="pt-icon"><i class="fas fa-key"></i></span>
				<input type="password" name="sign_pass" placeholder="<?=$lang['login']['password']?>">
			</div>
			<div class="pt-login-footer">
				<div class="form-row">
					<div class="col">
						<div class="form-group">
							<input type="checkbox" name="login_type" value="1" id="s1" class="choice">
							<label for="s1"><?=$lang['login']['keep']?></label>
						</div>
					</div>
					<div class="col">
						<button type="submit" class="pt-btn"><?=$lang['login']['button']?></button>
					</div>
				</div>
			</div>
			<?php if(site_register && (login_facebook || login_twitter || login_google)): ?>
			<div class="pt-social-login">
				<b>OR login using social media</b>
				<?php if(login_facebook): ?>
				<a class="facebook" href="<?=$facebookLoginUrl?>"><i class="fab fa-facebook"></i></a>
				<?php endif; ?>
				<?php if(login_twitter): ?>
				<a class="twitter" href="<?=$twitterLoginUrl?>"><i class="fab fa-twitter"></i></a>
				<?php endif; ?>
				<?php if(login_google): ?>
				<a class="google" href="<?=$googleLoginUrl?>"><i class="fab fa-google"></i></a>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php if(site_register): ?>
		<div class="pt-footer">
			<?=$lang['login']['footer']?> <a href="#" class="clickme"><?=$lang['login']['footer_l']?></a>
		</div>
		<?php endif; ?>
	</form>
</div>



</div>
<?php
include __DIR__."/scripts.php";
?>
