<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Edit User</title>

<h1>Edit User</h1>

<?php include("view/menu-links.php"); ?>

<form action="<?= BASE_URL . "user/edit" ?>" method="post">
	<input type="hidden" name="id" value="<?= $izdelek["id"] ?>" />
    <p>
        <label>Username: <span class="important"><?= $errors["username"] ?></span><br />
		<textarea name="username" rows="1" cols="10"><?= $izdelek["username"] ?></textarea></label>
	</p>
    <p>
        <label>Password: <span class="important"><?= $errors["password"] ?></span><br />
		<textarea name="password" rows="1" cols="10"><?= $izdelek["password"] ?></textarea></label>
	</p>
    <p>
        <label>Ime: <span class="important"><?= $errors["ime"] ?></span><br />
		<textarea name="ime" rows="1" cols="10"><?= $izdelek["ime"] ?></textarea></label>
	</p>
            <p>
        <label>Priimek: <span class="important"><?= $errors["priimek"] ?></span><br />
		<textarea name="priimek" rows="1" cols="10"><?= $izdelek["priimek"] ?></textarea></label>
	</p>
            <p>
        <label>Email: <span class="important"><?= $errors["email"] ?></span><br />
		<textarea name="email" rows="1" cols="10"><?= $izdelek["email"] ?></textarea></label>
	</p>
    <p><button>Edit</button></p>
</form>
