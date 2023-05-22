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

   //initialize variable
   if ($_SERVER['REQUEST_METHOD'] == "POST") 
   {
        $categorie = securisation($_POST['categorie']);
        $marque = securisation($_POST['marque']);
        $voiture = securisation($_POST['voiture']);
    
        //connect to bdd
        $bdd = Database::connect();

        //Recherche de la cateogorie
        $reqcategorie = $bdd->prepare("SELECT * FROM categorie WHERE categorie = ?");
        $reqcategorie->execute(array($categorie));
        $CategorieExist = $reqcategorie->rowCount();

        if ($CategorieExist==0) 
        {
            //Insert categorie
            $insert_cat = $bdd ->prepare("INSERT INTO categorie(categorie) VALUES(:categorie)");
            //Data insertion
            $insert_cat->bindParam(':categorie', $categorie);
            $insert_cat ->execute();
        }


        //Insertion marque//
        //Recherche de la marque 
        $reqmarque = $bdd->prepare("SELECT * FROM marque WHERE marque = ?");
        $reqmarque->execute(array($marque));
        $MarqueExist = $reqmarque->rowCount();

        $CategorieInfo = $reqcategorie->fetch(); //Recherche de l'Id de categorie 
        $categorieId=$CategorieInfo['id'];
        if ($MarqueExist==0) 
        {
            
            //insert marque
            $insert_marque = $bdd ->prepare("INSERT INTO marque(marque,categorie_id) VALUES(?,?)");
            $insert_marque ->execute(array($marque,$categorieId));
        }
        
        //Insertion voiture//
        $insert_voiture = $bdd ->prepare("INSERT INTO voiture(voiture,marque,categorie) VALUES(?,?,?)");
        $insert_voiture ->execute(array($voiture,$marque,$categorie));

        //Disconnect database
        Database::disconnect();
        header("Location: car.html");
        $isSuccess=true;

   }
   

   //Data securing
   function securisation($donnee)
	{
		$donnee = trim($donnee);
		$donnee = stripslashes($donnee);
		$donnee = strip_tags($donnee);
		$donnee = htmlspecialchars($donnee);
		return $donnee;
	}

?>