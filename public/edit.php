<?php

require '../src/Init.php';

use Calendar\Date\{Events, InputValidator};

$pdo = getPDO();
$events = new Events($pdo);
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
	if($_POST['delete'])
	{
		$events->delete($event);

		header('Location: ./index.php?success=2');
		exit();
	}

	$data = $_POST;
	$validator = new InputValidator();
	$errors = $validator->validates($data);

	if(empty($errors))
	{
		$events->data($event, $data);
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
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<button class="btn btn-primary">Editer</button>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<button class="btn btn-danger" value="delete" name="delete">Supprimer</button>
				</div>
			</div>
		</div>
	</form>
</div>

<?php render('footer'); ?>