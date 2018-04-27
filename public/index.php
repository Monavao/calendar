<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<title>Calendar</title>
</head>
<body>
	<nav class="navbar navbar-dark bg-primary nb-3">
		<a href="index.php" class="navbar-brand">Calendar</a>
	</nav>

	<?php
		require '../src/Date/Month.php';

		/*try
		{
			$month = new Calendar\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
		}
		catch(\Exception $e)
		{
			$month = new Calendar\Date\Month();
		}*/

		$month = new Calendar\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
		$day = $month->getFirstDay()->modify('last monday');
	?>
	
	<h1><?= $month->toString(); ?></h1>

	<table class="calendar calendar-<?= $month->getWeeks() ?>weeks">
		<?php for($i = 0; $i < $month->getWeeks(); $i++): ?>
		<tr>
			<td>Lundi<br><?= $day->format('d'); ?></td>
			<td>Mardi</td>
			<td>Mercredi</td>
			<td>Jeudi</td>
			<td>Vendredi</td>
			<td>Samedi</td>
			<td>Dimanche</td>
		</tr>
		<?php endfor; ?>
	</table>
</body>
</html>