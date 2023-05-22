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


  if ($_POST) 
  {
    //connect to bdd
    $bdd = Database::connect();

    $categorie = CheckInput($_POST['categorie']);
    $marque = checkInput($_POST['marque']);
    $voiture = CheckInput($_POST['voiture']);

    //Modifying voiture//
    $statement = $bdd->prepare("UPDATE voiture set voiture = ?, marque = ?, categorie = ? WHERE id = ?");
    $statement->execute(array($voiture,$marque,$categorie,$id));

    header("Location: afficher.php");
    //Deconnect Database
    Database::disconnect();
            
  }
  else 
  {
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM voiture where id = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $voiture = $item['voiture'];
    $marque = $item['marque'];
    $categorie = $item['categorie'];
  
    Database::disconnect();
  }



function checkInput($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>


