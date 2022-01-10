<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Edit Izdelek</title>

<h1>Edit Izdelek</h1>

<?php include("view/menu-links.php"); ?>

<form action="<?= BASE_URL . "izdelek/edit" ?>" method="post">
	<input type="hidden" name="id" value="<?= $izdelek["id"] ?>" />
        <label>Ime: <span class="important"><?= $errors["ime"] ?></span><br />
		<textarea name="ime" rows="1" cols="10"><?= $izdelek["ime"] ?></textarea></label>
	</p>
            <p>
        <label>Opis: <span class="important"><?= $errors["opis"] ?></span><br />
		<textarea name="opis" rows="10" cols="40"><?= $izdelek["opis"] ?></textarea></label>
	</p>
            <p>
        <label>Lastnik: <span class="important"><?= $errors["lastnik"] ?></span><br />
		<textarea name="lastnik" rows="1" cols="20"><?= $izdelek["lastnik"] ?></textarea></label>
            </p>
                <p>
        <label>Cena: <span class="important"><?= $errors["cena"] ?></span><br />
		<textarea name="cena" rows="1" cols="20"><?= $izdelek["cena"] ?></textarea></label>
	</p>
    <p><button>Edit</button></p>
</form>

<form action="<?= BASE_URL . "izdelek/delete" ?>" method="get">
    <input type="hidden" name="id" value="<?= $izdelek["id"] ?>"  />
    <label>Delete? <input type="checkbox" name="delete_confirmation" title="Are you sure you want to delete this entry?" required /></label>
    <button class="important">Delete record</button>
</form>
