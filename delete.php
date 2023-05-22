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
 
    if(!empty($_GET['id'])) 
    {
        $id = checkInput($_GET['id']);
    }

    $db = Database::connect();
    $statement = $db->prepare("DELETE FROM voiture WHERE id = ?");
    $statement->execute(array($id));
    Database::disconnect();
    header("Location: afficher.php"); 
    

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>