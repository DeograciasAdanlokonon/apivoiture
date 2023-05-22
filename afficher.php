<table>
<tbody>
    <?php
        class Database
        {
            // //LOCALHOST DATA
            private static $dbHost = "localhost";
            private static $dbName = "api";
            private static $dbUser = "root";
            private static $dbPassword ="";

            private static $connection = null;

            public static function connect()
            {
                try 
                {
                    self::$connection = new PDO("mysql:host=" .self::$dbHost.";dbname=" .self::$dbName, self::$dbUser, self::$dbPassword);

                    //echo "Connexion réussie";
                } 
                catch (PDOException $e) 
                {
                    echo 'Echec de connexion à la base de données:' .$e->getMessage();
                }
                return self::$connection;
            }

            public static function disconnect()
            {
                self::$connection = null;
            }
        }
        
    Database::connect();

    $db = Database::connect();

    $statement = $db->query('SELECT voiture.id, voiture.voiture, voiture.marque, voiture.categorie FROM voiture ORDER BY voiture.id DESC');
    while($voiture = $statement->fetch()) 
    {
        echo '<tr>';
        echo '<td>'. $voiture['id'] . '</td>';
        echo '<td>'. $voiture['voiture'] . '</td>';
        echo '<td>'. $voiture['marque'] . '</td>';
        echo '<td>'. $voiture['categorie'] . '</td>';
        echo '<td width=300>';
        echo '<a class="btn btn-default" href="view.php?id='.$voiture['id'].'"><span class="glyphicon glyphicon-eye-open"></span> Voir</a>';
        echo ' ';
        echo '<a class="btn btn-primary" href="update.php?id='.$voiture['id'].'"><span class="glyphicon glyphicon-pencil"></span> Modifier</a>';
        echo ' ';
        echo '<a class="btn btn-danger" href="delete.php?id='.$voiture['id'].'"><span class="glyphicon glyphicon-remove"></span> Supprimer</a>';
        echo '</td>';
        echo '</tr>';
    }
    Database::disconnect();
    ?>
</tbody>
</table>