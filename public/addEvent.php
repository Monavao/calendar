<?php

require '../src/Init.php';

render('header', ['title' => 'Ajouter un évènement']);
$data = [];

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$data = $_POST;
	$error = [];
	$validator = new Calendar\Date\InputValidator();
	$errors = $validator->validates($_POST);

	if(!empty($errors))
	{
		dd($errors);
	}
}

?>

<?php if(!empty($errors)): ?>
	<div class="alert alert-danger">
		Certains champs ne sont pas remplis correctement
	</div>
<?php endif; ?>

<div class="container">
	<h1>Ajouter un évènement</h1>
	<form action="" method="post" class="form">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="name">Titre</label>
					<input id="name" type="text" name="name" class="form-control" value="<?= clean($data['name']) ?? ''; ?>" required>
					<?php if(isset($errors['name'])): ?>
						<p><?= $errors['name']; ?></p>
					<?php endif; ?>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group">
					<label for="date">Date</label>
					<input id="date" type="date" name="date" class="form-control" value="<?= clean($data['date']) ?? ''; ?>" required>
					<?php if(isset($errors['date'])): ?>
						<p><?= $errors['date']; ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="start">Début</label>
					<input id="start" type="time" name="start" class="form-control" placeholder="HH:MM" value="<?= clean($data['start']) ?? ''; ?>" required>
					<?php if(isset($errors['start'])): ?>
						<p><?= $errors['start']; ?></p>
					<?php endif; ?>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="form-group">
					<label for="end">Fin</label>
					<input id="end" type="time" name="end" class="form-control" value="<?= clean($data['end']) ?? ''; ?>" required>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="description">Description</label>
			<textarea name="description" id="description" class="form-control"><?= clean($data['description']) ?? ''; ?></textarea>
		</div>

		<div class="form-group">
			<button class="btn btn-primary">Ajouter</button>
		</div>
	</form>
</div>

<?php render('footer'); ?>