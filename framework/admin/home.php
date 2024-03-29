<style>

	.eeui-home-wrap {
		padding:35px 0;
		display:flex;
		flex-direction: column;
	}

	.eeui-home-wrap .header-wrap {
		background:#222;
		display:flex;
		justify-content: space-between;
		color:white;
		align-items:center;
		padding:25px;
		border-radius:4px;
	}

	.content-wrap {
		padding:25px;
		margin-top:15px;
	}

	.content-wrap p,
	.content-wrap li,
	.content-wrap a {
		font-size:16px;
	}

	.content-wrap h2 {
		margin-top:45px;
	}

</style>

<div class="eeui-home-wrap">

	<div class="header-wrap">
		<a href="https://editorenhancer.com" target="_blank">
			<span style="color:white;">By</span> <img src="https://editorenhancer.com/wp-content/uploads/sites/34/logo.png" alt="Editor Enhancer Logo">
		</a>
		Version <?php echo $this->version; ?>
	</div>

	<div class="content-wrap">
		<?php require_once 'tabs.php'; ?>
		<h1>Welcome to Grid Controls by Editor Enhancer!</h1>
		<p>Great things await! This plugin adds the much needed CSS Grid controls to most basic components in Oxygen Builder. There are no settings to worry about, so you can get started straight away! Here's how:</p>
		<ol>
			<li><strong>Activate your license key.</strong> You'll find it when you <a href="https://editorenhancer.com/login" target="_blank">log in to your account</a>.</li>
			<li>Check out the <a href="https://editorenhancer.com/products/grid-controls/#section-249-6340" target="_blank">Best Practices step-by-step instructions to starting with Grid Controls</a></li>
			<li><strong>Load up Oxygen!</strong> Let the experience begin.</li>
		</ol>

		<h2>Resources</h2>
		<a href="https://editorenhancer.com/newsletter-signup">Sign up for the Editor Enhancer newsletter to hear about betas and upcoming features</a><br><br>
		<a href="https://www.facebook.com/groups/editorenhancer/" target="_blank">Join the official Editor Enhancer user group on Facebook</a><br><br>
		<a href="https://trello.com/b/JFxiPTa5" target="_blank">Follow requests and bug reports on Trello</a><br><br>
	</div>
</div>
