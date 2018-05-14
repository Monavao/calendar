<?php
	require '../src/Date/Events.php';
	require '../src/Init.php';

	$pdo = getPDO();
	$details = new Calendar\Date\Events($pdo);

	if(!isset($_GET['id']))
	{
		header('location: ./404.php');
	}

	try
	{
		$details = $details->find($_GET['id']);
	}
	catch(\Exception $e)
	{
		require './404.php';
		exit();
	}

	dd($details);

	render('header', ['title' => $details->getName()]);
?>

<h1><?= clean($details->getName()); ?></h1>

<ul>
	<li>Date de début: <?= $details->getStart()->format('d-m-Y H:m'); ?></li>
	<li>Date de fin: <?= $details->getEnd()->format('d-m-Y H:m'); ?></li>
	<li>Description:<br><?= clean($details->getDescription()); ?></li>
</ul>

<?php
	require '../views/footer.php';
?>