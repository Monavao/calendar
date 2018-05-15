<?php

require '../src/Init.php';

use Calendar\Date\{Event, Events};

$data = [];
$error = [];

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$data = $_POST;
	$errors = [];
	$validator = new Calendar\Date\InputValidator();
	$errors = $validator->validates($_POST);

	if(empty($errors))
	{
		$event = new Event();
		$event->setName($data['name']);
		$event->setDescription($data['description']);
		$event->setStart(Datetime::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['start'])->format("Y-m-d H:i:s"));
		$event->setEnd(Datetime::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['end'])->format("Y-m-d H:i:s"));

		$events = new Events(getPDO());
		$events->create($event);
		// dd($event);
		header('Location: ./index.php?success=1');
		exit();
	}
}

render('header', ['title' => 'Ajouter un évènement']);

?>

<?php if(!empty($errors)): ?>
	<div class="alert alert-danger">
		Certains champs ne sont pas remplis correctement
	</div>
<?php endif; ?>

<div class="container">
	<h1>Ajouter un évènement</h1>
	<form action="" method="post" class="form">
		<?php render('calendar/form', ['data' => $data, 'errors' => $errors]); ?>
		<div class="form-group">
			<button class="btn btn-primary">Ajouter</button>
		</div>
	</form>
</div>

<?php render('footer'); ?>