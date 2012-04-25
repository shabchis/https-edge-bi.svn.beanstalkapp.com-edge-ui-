<html>

<title>Error</title>
<head>

  <link rel="stylesheet" href="assets/css/errors.css" type="text/css" media="screen" />

</head>
<?php if (IS_AJAX): ?>


	<div id="content">
	<h1>Edge.BI Error</h1>
	<h2><?php echo $heading; ?></h2>
		<?php echo $message; ?>
	</div>

<?php else: ?>		




		<head>
 
  <link rel="stylesheet" href="assets/css/errors.css" type="text/css" media="screen" />

</head>

  <div id="main">
	<div id="content">
		<h1>Edge.BI Error</h1>
		<h2><?php echo $heading; ?></h2>
		<?php echo $message; ?>
	</div>
	</div>
</body>
</html>

<?php endif; ?>