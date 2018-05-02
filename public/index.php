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
		$start = $month->getFirstDay()->modify('last monday');
	?>

	<div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
		<h1><?= $month->toString(); ?></h1>
		<div>
			<a href="index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
			<a href="index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
		</div>
	</div>
	
	<table class="calendar calendar-<?= $month->getWeeks() ?>weeks">
		<?php for($i = 0; $i < $month->getWeeks(); $i++): ?>
		<tr>
			<?php 
				foreach($month->days as $k => $day):
				$date = (clone $start)->modify("+" . $k + ($i * 7) . "days")
			?>
			<td>
				<?php if($i === 0): ?>
					<div class="weekday">
						<?= $day; ?>
					</div>
				<?php endif; ?>
				<div class="<?= $month->inMonth($date) ? 'day' : 'outOfMonth'; ?>">
					<?= $date->format('d'); ?>
				</div>
			</td>	
			<?php endforeach; ?>
		</tr>
		<?php endfor; ?>
	</table>
</body>
</html>