<?php
/* ********************************************************************** */
/* *                           DB FUNCTIONS                             * */
/* *                           ------------                             * */
/* *    FONCTIONS RELATIVES AUX INTERACTIONS AVEC LA BASE DE DONNEES    * */
/* ********************************************************************** */
// Include your database connection file


/**-----------------------------------------------------------------
                    Connexion à la base de données
*------------------------------------------------------------------**/
 /**
 * Connexion à la base de données
 * 
 * @param string $serverName
 * @param string $userName
 * @param string $userPwd
 * @param string $dbName
 * 
 * @return object $conn
 */
function connectDB($serverName, $userName, $userPwd, $dbName) {
    try {
        // Création d'une connexion à la base de données
        $conn = new PDO("mysql:host=$serverName;dbname=$dbName;charset=utf8", $userName, $userPwd);

        // Définition du mode d'erreur de PDO sur Exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $conn;

    } catch (PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error : Database connexion";            
        return $st; 
    }
}

/**-----------------------------------------------------------------
            Récupérer tous les articles de la table articles
*------------------------------------------------------------------**/
/**
 * Récupérer tous les articles de la table articles
 * 
 * @param object $conn 
 * @param string $active (0, 1 ou %)
 * @return array $resultat
 */
function getAllLivresDB($conn, $active = '%') {
    try {
        // Récupérer des données de notre table articles
        $req = $conn->prepare("SELECT * FROM livres WHERE active LIKE :active ORDER BY idLivre DESC");
        $req->bindParam(':active', $active);
        $req->execute();
    
        // Retourne un tableau associatif pour chaque entrée de la table articles avec le nom des colonnes comme clé
        $resultat = $req->fetchall(PDO::FETCH_ASSOC);

        // Fermeture connexion
        $req = null;
        $conn = null;

        return $resultat;

    } catch (PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getAllLivresDB() function";            
        return $st;  
    }
}

/**-----------------------------------------------------------------
            Récupérer un article en fonction de son ID
*------------------------------------------------------------------**/
/**
 * Récupérer un article en fonction de son ID
 * 
 * @param object $conn 
 * @return array $resultat
 */
function getLivreByIDDB($conn, $id) {
    try {
        // Récupérer des données de notre table articles
        $req = $conn->prepare("SELECT * FROM livres WHERE idLivre = :idLivre");
        $req->bindParam(':idLivre', $id);
        $req->execute();
    
        // Retourne un tableau associatif pour chaque entrée de la table articles avec le nom des colonnes comme clé
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        // Fermeture connexion
        $req = null;
        $conn = null;

        return $resultat;

    } catch (PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getLivreByIDDB() function";            
        return $st;  
    }
}


/**-----------------------------------------------------------------
                Ajout d'un article dans la base de données
*------------------------------------------------------------------**/
/**
 * Ajout d'un article dans la base de données
 * 
 * @param mixed $conn 
 * @return true 
 */
function addLivreDB($conn, $datas) {
    try{
        // Préparation des données avant insertion dans la base de données
            $title = filterInputs($datas['titleLivre']);
            $content = nl2br(filterInputs($datas['content']));

            // Si on reçoit une valeur pour le status de publication de l'article
            if(isset($datas['published_article']) && !empty($datas['published_article']))
                $active = $datas['published_article'];
            else
                $active = 0;

        // Insertion des données dans la table articles
            $req = $conn->prepare("INSERT INTO livres (titleLivre, content, active) VALUES (:titleLivre, :content, :active)");
            $req->bindParam(':titleLivre', $title);
            $req->bindParam(':content', $content);
            $req->bindParam(':active', $active);
            $req->execute();

        // Fermeture connexion
            $req = null;
            $conn = null;

        return true;

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : addArticleDB() function";            
        return $st;  
    }       
}


/**-----------------------------------------------------------------
           Modification d'un article dans la base de données
*------------------------------------------------------------------**/
/**
 * Modification d'un article dans la base de données
 * 
 * @param mixed $conn 
 * @param array $datas 
 * @return true 
 */
function updateLivreDB($conn, $datas) {
    try{
        //DEBUG// disp_ar($datas, 'DATAS', 'VD');
        // Préparation des données avant insertion dans la base de données
            $title = filterInputs($datas['titleLivre']);

            $content = nl2br($datas['content']);
            $content = preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br \/>/", "$1", $content);        
            $content = htmlentities($content);
            
            $id = filterInputs($datas['idLivre']);

            // Si on reçoit une valeur pour le status de publication de l'article
            if(isset($datas['published_article']) && !empty($datas['published_article']))
                $active = $datas['published_article'];
            else
                $active = 0;

        // Insertion des données dans la table articles
        $req = $conn->prepare("UPDATE livres SET titleLivre = :titleLivre, content = :content, active = :active WHERE idLivre = :idLivre");
        $req->bindParam(':titleLivre', $title);
        $req->bindParam(':content', $content);
        $req->bindParam(':active', $active);
        $req->bindParam(':idLivre', $id);
        $req->execute();

        // Fermeture connexion
        $req = null;
        $conn = null;

        return true;

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : updateLivreDB() function";            
        return $st;  
    } 
}   

/**-----------------------------------------------------------------
           Suppression d'un article dans la base de données
*------------------------------------------------------------------**/
/**
 * Suppression d'un article dans la base de données
 * 
 * @param mixed $conn 
 * @return true 
 */
function deleteLivreDB($conn, $id) {
    try{
        // Préparation des données avant insertion dans la base de données
        $id = filterInputs($id);

        // Insertion des données dans la table articles
        $req = $conn->prepare("DELETE FROM livres WHERE idLivre = :idLivre");
        $req->bindParam(':idLivre', $id);
        $req->execute();

        // Fermeture connexion
        $req = null;
        $conn = null;

        return true;

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : deleteLivreDB() function";            
        return $st;     
    }       

}   


/**-----------------------------------------------------------------
                Identification d'un utilisateur
*------------------------------------------------------------------**/
/**
 * Identification d'un utilisateur
 * 
 * @param mixed $conn 
 * @param mixed $datas 
 * @return mixed 
 */
function userIdentificationDB($conn, $datas) {
    try{
        $user = null;

        // Préparation des données avant insertion dans la base de données
        $login = filterInputs($datas['login']);
        $pwd = filterInputs($datas['pwd']);

        // Sélection des données dans la table users
        $req = $conn->prepare("SELECT * FROM users WHERE email = :login AND passwd = :pwd");
        $req->bindParam(':login', $login);
        $req->bindParam(':pwd', $pwd);
        $req->execute();

        // Génère un résultat si il y a correspondance
        $user = $req->fetch(PDO::FETCH_ASSOC);

        // Fermeture connexion
        $req = null;
        $conn = null;

        if((isset($user['email']) && $user['email'] === $login) && (isset($user['passwd']) && $user['passwd'] === $pwd)){
            // On supprime le mot de passe de l'objet $user
            $user['passwd'] = null; 
            return $user;
        }else
            return false;
        

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : userIdentificationDB() function";            
        return $st;      
    }       
}


/**-----------------------------------------------------------------
        Identification d'un utilisateur avec mot de passe hashé
*------------------------------------------------------------------**/
/**
 * Identification d'un utilisateur avec mot de passe hashé
 * 
 * @param mixed $conn 
 * @param mixed $datas 
 * @return mixed 
 */
function userIdentificationWithHashPwdDB($conn, $datas) {
    try{
        $user = null;
        $isConnected = false;
       
        // Préparation des données avant insertion dans la base de données
        $login = filterInputs($datas['login']);
        $pwd = filterInputs($datas['pwd']);
        
        // Sélection des données dans la table users
        $req = $conn->prepare("SELECT * FROM users WHERE email = :login");
        $req->bindParam(':login', $login);        
        $req->execute();

         // Génère un résultat avec les données de l'utilisateur
        $user = $req->fetch(PDO::FETCH_ASSOC);    
        //DEBUG// disp_ar($user, 'USER', 'VD');     
        if(!empty($user['email']))
            $isConnected = password_verify($pwd, $user['passwd']);
        
        //DEBUG// echo 'PWD : '.$pwd.'<br>';disp_ar($isConnected, 'IS CONNECTED', 'VD'); 

        // Fermeture connexion
        $req = null;
        $conn = null;

        if($isConnected){
            // On supprime le mot de passe de l'objet $user
            $user['passwd'] = null; 
            return $user;
        }else
            return false;
        

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : userIdentificationDB() function";            
        return $st;      
    }       
}