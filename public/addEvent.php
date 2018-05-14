<?php

require '../src/Init.php';

render('header', ['title' => 'Ajouter un évènement']);
render('footer');

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$validator = new Calendar\Date\InputValidator();
	$errors = $validator->validates($_POST);

	if(empty($errors))
	{

	}
}

?>

<div class="container">
	<h1>Ajouter un évènement</h1>
	<form action="" method="post" class="form">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="name">Titre</label>
					<input id="name" type="text" name="name" class="form-control" required>
					<?php if($errors['name']): ?>
						<p><?= $errors['name']; ?></p>
					<?php endif; ?>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group">
					<label for="date">Date</label>
					<input id="date" type="date" name="date" class="form-control" required>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="start">Début</label>
					<input id="name" type="time" name="start" class="form-control" placeholder="HH:MM" required>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group">
					<label for="end">Fin</label>
					<input id="end" type="time" name="end" class="form-control" required>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="description">Description</label>
			<textarea name="description" id="description" class="form-control"></textarea>
		</div>

		<div class="form-group">
			<button class="btn btn-primary">Ajouter</button>
		</div>
	</form>
</div>

<?php render('footer'); ?>