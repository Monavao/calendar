<?php

require '../src/Init.php';

$pdo = getPDO();
$events = new Calendar\Date\Events($pdo);
$errors = [];

if(!isset($_GET['id']))
{
	header('location: ./404.php');
}

try
{
	$event = $events->find($_GET['id']);
}
catch(\Exception $e)
{
	require './404.php';
	exit();
}

$data = [
	'name' => $event->getName(),
	'date' => $event->getStart()->format('Y-m-d'),
	'start' => $event->getStart()->format('H:i'),
	'end' => $event->getEnd()->format('H:i'),
	'description' => $event->getDescription()
];

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$data = $_POST;
	$validator = new Calendar\Date\InputValidator();
	$errors = $validator->validates($data);

	if(empty($errors))
	{
		$event->setName($data['name']);
		$event->setDescription($data['description']);
		$event->setStart(Datetime::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['start'])->format("Y-m-d H:i:s"));
		$event->setEnd(Datetime::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['end'])->format("Y-m-d H:i:s"));

		$events->update($event);

		header('Location: ./index.php?success=1');
		exit();
	}
}

render('header', ['title' => $event->getName()]);

?>

<div class="container">
	<h1>Editer <?= clean($event->getName()); ?></h1>
	<form action="" method="post" class="form">
		<?php render('calendar/form', ['data' => $data, 'errors' => $errors]); ?>
		<div class="form-group">
			<button class="btn btn-primary">Editer</button>
		</div>
	</form>
</div>

<?php render('footer'); ?>