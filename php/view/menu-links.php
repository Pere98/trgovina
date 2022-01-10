<p>[
<a href="<?= BASE_URL . "izdelek" ?>">All izdelki</a> |  


<?php if (User::isLoggedIn()): ?>
	| <a href="<?= BASE_URL . "logout" ?>">Logout (<?= User::getUsername() ?>)</a>
        
        
        <?php require_once("model/UserDB.php"); ?>

    <?php $mojID = UserDB::getID() ?>

        
        
        
        | | <a href="<?= BASE_URL . "user/edit?id=" . $mojID ?>">Edit user</a>
        <?php if (User::isAdmin()): ?>
<a href="<?= BASE_URL . "izdelek/add" ?>">Add izdelek</a>
| | <a href="<?= BASE_URL . "prodajalec/add" ?>">Add prodajalec</a>
| | <a href="<?= BASE_URL . "prodajalec/edit?id=" . 2 ?>">Edit Prodajalec</a>

<?php endif; ?> 

        <?php if (User::isProdajalec()): ?>
| | <a href="<?= BASE_URL . "user/add" ?>">Add user</a> 
| | <a href="<?= BASE_URL . "prodajalec/edit?id=" . 3 ?>">Edit Stranka</a>
<?php endif; ?> 
        
        
        
<?php else: ?>
        | <a href="<?= BASE_URL . "user/add" ?>">Add user</a>  
	| | <a href="<?= BASE_URL . "login" ?>">Login</a>
<?php endif; ?>

]</p>


