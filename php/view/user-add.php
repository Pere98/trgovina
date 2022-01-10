<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Add new user</title>

<h1>Add new user</h1>

<?php include("view/menu-links.php"); ?>

<form action="<?= BASE_URL . "user/add" ?>" method="post">
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
            <p>
        <label>Naslov: <span class="important"><?= $errors["naslov"] ?></span><br />
		<textarea name="naslov" rows="1" cols="10"><?= $izdelek["naslov"] ?></textarea></label>
	</p>
        
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="g-recaptcha" data-sitekey="6LfRzQAeAAAAACBv89ciq86fWRxENPOjcp3sYZ5p"></div>
    <p><button>Insert</button></p>
</form>
