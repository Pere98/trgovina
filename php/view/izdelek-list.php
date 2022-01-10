<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
<meta charset="UTF-8" />
<title>Spletna Trgovina</title>

<h1>Vsi izdelki</h1>

<?php include("view/menu-links.php"); ?>
<?php require_once("model/OcenaDB.php"); ?>




<ul>

    <?php foreach ($izdelek as $izd): ?>
     <form action="<?= BASE_URL . "cart" ?>" method="post">
            <input type="hidden" name="do" value="add_into_cart" />
            <input type="hidden" name="id" value="<?= $izd["id"] ?>" />
        <li><b><?= $izd["ime"] ?></b>: <?= $izd["opis"] ?>, <?= $izd["cena"] ?>

        <?php if ($loggedIn): ?>
        	<a href="<?= BASE_URL . "izdelek/edit?id=" . $izd["id"] ?>">edit</a>
        <?php endif; ?>
                | |  <button name=$izd["id"] type="submit">V košarico </button>
                
                
                
                

        </li>
        </form>
    
    
                    <?php
               
            $ocena = OceneDB::getPovprecna($izd["id"]);
            //var_dump($ocena["AVG(ocena)"]);
            if ($ocena["AVG(ocena)"] == null) {
                $ocena_str = "Ta izdelek še ni bil ocenjen";
            }else {
                $ocena_str = $ocena["AVG(ocena)"];
            }
            ?>
            <div class="ocena">Povprečna ocena: <?php echo $ocena_str; ?> </div>
            
            
                            <form action="<?= BASE_URL . 'izdelek/ocena' ?>"  method="post">
                    <input type="number" name="ocena" value="5" min="1" max="5" />
                    <input type="hidden" name="iid" value="<?= $izd["id"] ?>" />
                    <button type="submit">Oceni</button>
                            </form>
    <?php endforeach; ?>
    
    
    
    
    
    
    
    
    <?php if (User::isLoggedIn()): ?>
    
     <div class="cart">
        <h3>Košarica</h3>
        <p>
            <?php
            if(isset($_SESSION["cart"])) {
                //var_dump($_SESSION["cart"]);
                
                $vsota = 0;
                
                while ($x = current($_SESSION["cart"])) {
                    
                    foreach ($izdelek as $izd):
                        if($izd["id"] == key($_SESSION["cart"])){    
                            echo $izd["ime"];
                            $vsota = $vsota + $x * $izd["cena"];
                            $trenutna = $izd["id"];
                            //break;
                        
                    
                    echo '<form action="' . BASE_URL . "cart" . '" method="post">';
                        echo '<input type="number" name="kolicina" value="' . $x . '" min="0" />';
                        echo '<input type="hidden" name="do" value="updt" />';
                       
                        echo '<button type="submit">Posodobi</button>';
                    echo '</form>';
                        }
                        
endforeach;
                next($_SESSION["cart"]);
                }
                
                if($vsota == 0){
                    unset($_SESSION["cart"]);
                    echo "Košarica je prazna";
                }
                else{
                    echo "<p>";
                    echo "Skupaj: <b>" . number_format($vsota,2) . " EUR</b>";
                    echo "</p>";
                }
            }else {
                echo "Košarica je prazna";
            }
            ?>
        <p>
            <form action="<?= BASE_URL . "cart" ?>" method="post">
                <input type="hidden" name="do" value="purge_cart">
                <button type="submit">Izprazni košarico</button>
            </form>
            <?php
            
                echo '<a href="' . BASE_URL . 'predracun' . '">Zaključi nakup</a>';
            
            ?>
        </p>
    </div>

    
    
    <?php endif ?>
    

    
    
    
    
    

</ul>

