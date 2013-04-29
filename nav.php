<?php
require_once 'facebook-php-sdk/src/facebook.php';
$config = array(
	'appId'  => '519404198096257',
	'secret' => '586e0fb7210204eb364143c2cf6de381',
	);

$facebook = new Facebook($config);
$user = $facebook->getUser();
$loginUrl = $facebook->getLoginUrl(array(
	"scope" => "read_mailbox"
	)
);
?>
<h1>
	Facebook message count
</h1>
<div class="navbar navbar-inverse">
	<div class="navbar-inner">
		<div class="container">
			<div class="nav-collapse collapse">
				<ul class="nav" style="float:right;">
					<?php if ($user): ?>
					<li>
						<img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
					</li>
					<li>
						<a href="logout.php">
							Logout
						</a>
					</li>
				<?php else: ?>
				<li>
					<a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
				</li>
			<?php endif ?>
		</ul>
	</div><!--/.nav-collapse -->
</div>
</div>
</div>