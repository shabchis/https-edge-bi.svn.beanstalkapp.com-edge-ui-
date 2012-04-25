<?php header("HTTP/1.1 404 Not Found"); ?>

<?php if (IS_AJAX): ?>
<link rel="stylesheet" href="assets/css/errors.css" type="text/css" media="screen" />
	
	<div id="content">
		<h1>Edge.BI Error</h1>
		<h2><?php echo $heading; ?></h2>
		<?php echo $message; ?>
	</div>

<?php else: ?>
<link rel="stylesheet" href="assets/css/errors.css" type="text/css" media="screen" />

  <body>
  <div id="main">
	<div id="content">
	<h1>Edge.BI Error</h1>
<h2><?php echo $heading; ?></h2>
	<p><?php echo $message; ?></p>
		</div>
		</div>
		</body>
	<?php endif; ?>	
