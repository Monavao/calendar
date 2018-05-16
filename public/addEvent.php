<?php

require '../src/Init.php';

use Calendar\Date\{Event, Events, InputValidator};
use App\Validator;

$data = [
	'date' => $_GET['date'] ?? date('Y-m-d')
];

$validator = new Validator($data);

if(!$validator->validate('date', 'date'))
{
	$data['date'] = date('Y-m-d');
}

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$data = $_POST;
	$errors = [];
	$validator = new InputValidator();
	$errors = $validator->validates($_POST);

	if(empty($errors))
	{
		$events = new Events(getPDO());
		$event = $events->data(new Event(), $data);
		$events->create($event);

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