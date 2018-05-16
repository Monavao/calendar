<?php

require '../src/Init.php';

use Calendar\Date\{Events, Month};

$pdo = getPDO();
$events = new Events($pdo);
$month = new Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$start = $month->getFirstDay();
$start = $start->format('N') === '1' ? $start : $month->getFirstDay()->modify('last monday');
$weeks = $month->getWeeks();
$end = (clone $start)->modify('+' . (6 + ((7 * $weeks) - 1)) . 'days');
$events = $events->getEventsByDay($start, $end);

require '../views/header.php';

?>

<?php if(isset($_GET['success']) && $_GET['success'] === '1'): ?>

<div class="container">
	<div class="alert alert-success">
		L'évènement a bien été ajouté au calendrier!
	</div>
</div>

<?php elseif(isset($_GET['success']) && $_GET['success'] === '2'): ?>
	<div class="container">
		<div class="alert alert-danger">
			L'évènement a bien été supprimé du calendrier!
		</div>
	</div>
<?php endif; ?>

<div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
	<h1><?= $month->toString(); ?></h1>
	<div>
		<a href="index.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
		<a href="index.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
	</div>
</div>

<table class="calendar calendar-<?= $weeks; ?>weeks">
	<?php for($i = 0; $i < $weeks; $i++): ?>
	<tr>
		<?php 
			foreach($month->days as $k => $day):
			$date = (clone $start)->modify('+'. ($k + ($i * 7)) . "days");
			$eventsOfDay = $events[$date->format('Y-m-d')] ?? [];
		?>
		<td>
			<?php if($i === 0): ?>
				<div class="weekday">
					<?= $day; ?>
				</div>
			<?php endif; ?>
			<a href="addEvent.php?date=<?= $date->format('Y-m-d'); ?>" class="<?= $month->inMonth($date) ? 'day' : 'outOfMonth'; ?>">
				<b><?= $date->format('d'); ?></b>
			</a>
			<?php foreach($eventsOfDay as $event): ?>
				<div>
					<a href="./edit.php?id=<?= $event['id'] ?>"><?= $event['name']; ?></a>
					<br>
					Début: <?= (new Datetime($event['start']))->format('H:i'); ?>
					<br>
					Fin: <?= (new Datetime($event['end']))->format('H:i'); ?>
				</div>
			<?php endforeach; ?>
		</td>	
		<?php endforeach; ?>
	</tr>
	<?php endfor; ?>
</table>

<a href="addEvent.php" class="button">+</a>

<?php render('footer'); ?>