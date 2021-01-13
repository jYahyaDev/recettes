<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recette</title>
  <meta name="description" content="que personne ne fasse la blaque avec la pod'castor 🦫">
</head>
<body><pre><?php

  // séparer ses identifiants et les protéger, une bonne habitude à prendre
  include "connect.php";

  try {

    // instancie un objet $connexion à partir de la classe PDO
    $connexion = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PASS, DB_OPTIONS);

    // Requête de sélection 01
    $requete = "SELECT * FROM `recettes`";
    $prepare = $connexion->prepare($requete);
    $prepare->execute();
    $resultat = $prepare->fetchAll();
    print_r([$requete, $resultat]); // debug & vérification */ 

    // Requête d'insertion
    $requete = "INSERT INTO `recettes`(`recette_titre`,`recette_contenu`)
                VALUES (:recette_titre, :recette_contenu);";
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
      ":recette_titre" => "COUSCOUS",
      ":recette_contenu" => "Semoule et secret"
    ));
    $resultat = $prepare->rowCount(); // rowCount() nécessite PDO::MYSQL_ATTR_FOUND_ROWS => true
    $lastInsertedEpisodeId = $connexion->lastInsertId(); // on récupère l'id automatiquement créé par SQL
    print_r([$requete, $resultat, $lastInsertedEpisodeId]); // debug & vérificatio  
 
    // Requête de modification
    $lastInsertedEpisodeId = 3; 
    $requete = "UPDATE `recettes`
                SET `recette_titre` = :recette_titre
                WHERE `recette_id` =  :recette_id";
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
      ":recette_titre" => "😺 COUSCOUS",
      ":recette_id"=>  $lastInsertedEpisodeId
    ));
    $resultat = $prepare->rowCount();
    print_r([$requete, $resultat]); // debug & vérification  
 
   // Requête de suppression

    $requete = "DELETE FROM `recettes`
                WHERE ((`recette_id` = :recette_id));";
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array($lastInsertedEpisodeId)); // on lui passe l'id tout juste créé
    $resultat = $prepare->rowCount();
    print_r([$requete, $resultat, $lastInsertedEpisodeId]); // debug & vérification */  


    
    //Ajout entrée levain 

    $requete = "INSERT INTO `hashtags`(`hashtag_nom`)
                VALUES (:hashtag_nom);";
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(
      ":hashtag_nom" => "levain",

    ));
    $resultat = $prepare->rowCount(); // rowCount() nécessite PDO::MYSQL_ATTR_FOUND_ROWS => true
    $lastInsertedEpisodeId = $connexion->lastInsertId(); // on récupère l'id automatiquement créé par SQL
    print_r([$requete, $resultat, $lastInsertedEpisodeId]); // debug & vérificatio  */ 

    //Créer une requête qui lie le hashtag "levain" à la recette du "pain au levain".
    //id hastag levain = 4 
    // pain au levain = recette_id = 1


   $requete = "INSERT INTO `assoc_hashtags_recettes`(`assoc_hr_hashtag_id`, `assoc_hr_recette_id`) VALUE(:assoc_hr_hashtag_id,:assoc_hr_recette_id)";
    $prepare = $connexion->prepare($requete);
    $prepare->execute(array(":assoc_hr_hashtag_id"=>4,//id levain
                            ":assoc_hr_recette_id"=>1));//id recette */



    print_r([$resultat]); 
  } catch (PDOException $e) {

    // en cas d'erreur, on récup et on affiche, grâce à notre try/catch
    exit("❌🙀💀 OOPS :\n" . $e->getMessage());

  }

?></pre></body>
</html>