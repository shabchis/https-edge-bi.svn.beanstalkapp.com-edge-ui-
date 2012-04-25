<div id="content">
	<h1>Edge.BI Error</h1>
	<h2>A PHP Error was encountered</h2>
	
	<p>Severity: <?php echo $severity; ?></p>
	<p>Message:  <?php echo $message; ?></p>
	<p>Filename: <?php echo $filepath; ?></p>
	<p>Line Number: <?php echo $line; ?></p>

</div>
 <link rel="stylesheet" href="assets/css/errors.css" type="text/css" media="screen" />
<!--[if IE]>
	<link rel="stylesheet" href="assets/css/ie_errors.css" type="text/css" media="screen" />
		<![endif]-->
<?php exit(); ?>	
