<?php
/* ********************************************************************** */
/* *                           DB FUNCTIONS                             * */
/* *                           ------------                             * */
/* *    FONCTIONS RELATIVES AUX INTERACTIONS AVEC LA BASE DE DONNEES    * */
/* ********************************************************************** */

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
            Récupérer tous les articles de la table articles
*------------------------------------------------------------------**/
/**
 * Récupérer tous les articles de la table articles
 * 
 * @param object $conn 
 * @param string $active (0, 1 ou %)
 * @return array $resultat
 */
function getAllArticlesDB($conn, $active = '%') {
    try {
        // Récupérer des données de notre table articles
        $req = $conn->prepare("SELECT * FROM articles WHERE active LIKE :active ORDER BY id DESC");
        $req->bindParam(':active', $active);
        $req->execute();
    
        // Retourne un tableau associatif pour chaque entrée de la table articles avec le nom des colonnes comme clé
        $resultat = $req->fetchall(PDO::FETCH_ASSOC);

        // Fermeture connexion
        $req = null;
        $conn = null;

        return $resultat;

    } catch (PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getAllArticlesDB() function";            
        return $st;  
    }
}

/**
 * Récupérer tous les livres de la table articles
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

/**
 * Récupérer tous les papeteries de la table articles
 * 
 * @param object $conn 
 * @param string $active (0, 1 ou %)
 * @return array $resultat
 */
function getAllPapeteriesDB($conn, $active = '%') {
    try {
        // Récupérer des données de notre table articles
        $req = $conn->prepare("SELECT * FROM papeteries WHERE active LIKE :active ORDER BY idPapeterie DESC");
        $req->bindParam(':active', $active);
        $req->execute();
    
        // Retourne un tableau associatif pour chaque entrée de la table articles avec le nom des colonnes comme clé
        $resultat = $req->fetchall(PDO::FETCH_ASSOC);

        // Fermeture connexion
        $req = null;
        $conn = null;

        return $resultat;

    } catch (PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getAllPapeteriesDB() function";            
        return $st;  
    }
}

/**
 * Récupérer tous les cadeaux de la table articles
 * 
 * @param object $conn 
 * @param string $active (0, 1 ou %)
 * @return array $resultat
 */
function getAllCadeauxDB($conn, $active = '%') {
    try {
        // Récupérer des données de notre table articles
        $req = $conn->prepare("SELECT * FROM cadeaux WHERE active LIKE :active ORDER BY idCadeau DESC");
        $req->bindParam(':active', $active);
        $req->execute();
    
        // Retourne un tableau associatif pour chaque entrée de la table articles avec le nom des colonnes comme clé
        $resultat = $req->fetchall(PDO::FETCH_ASSOC);

        // Fermeture connexion
        $req = null;
        $conn = null;

        return $resultat;

    } catch (PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getAllCadeauxDB() function";            
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
function getArticleByIDDB($conn, $id) {
    try {
        // Récupérer des données de notre table articles
        $req = $conn->prepare("SELECT * FROM articles WHERE id = :id");
        $req->bindParam(':id', $id);
        $req->execute();
    
        // Retourne un tableau associatif pour chaque entrée de la table articles avec le nom des colonnes comme clé
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        // Fermeture connexion
        $req = null;
        $conn = null;

        return $resultat;

    } catch (PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getArticleByIDDB() function";            
        return $st;  
    }
}

/**
 * Récupérer un livre en fonction de son ID
 * 
 * @param object $conn 
 * @return array $resultat
 */
function getLivreByIDDB($conn, $idLivre) {
    try {
        // Récupérer des données de notre table articles
        $req = $conn->prepare("SELECT * FROM livres WHERE idLivre = :idLivre");
        $req->bindParam(':idLivre', $idLivre);
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

/**
 * Récupérer un papeterie en fonction de son ID
 * 
 * @param object $conn 
 * @return array $resultat
 */
function getPapeterieByIDDB($conn, $idPapeterie) {
    try {
        // Récupérer des données de notre table articles
        $req = $conn->prepare("SELECT * FROM papeteries WHERE idPapeterie = :idPapeterie");
        $req->bindParam(':idLivre', $idPapeterie);
        $req->execute();
    
        // Retourne un tableau associatif pour chaque entrée de la table articles avec le nom des colonnes comme clé
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        // Fermeture connexion
        $req = null;
        $conn = null;

        return $resultat;

    } catch (PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getPapeterieByIDDB() function";            
        return $st;  
    }
}

/**
 * Récupérer un cadeau en fonction de son ID
 * 
 * @param object $conn 
 * @return array $resultat
 */
function getCadeauByIDDB($conn, $idCadeau) {
    try {
        // Récupérer des données de notre table articles
        $req = $conn->prepare("SELECT * FROM cadeaux WHERE idCadeau = :idCadeau");
        $req->bindParam(':idLivre', $idCadeau);
        $req->execute();
    
        // Retourne un tableau associatif pour chaque entrée de la table articles avec le nom des colonnes comme clé
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        // Fermeture connexion
        $req = null;
        $conn = null;

        return $resultat;

    } catch (PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getCadeauByIDDB() function";            
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
function addArticleDB($conn, $datas) {
    try{
        // Préparation des données avant insertion dans la base de données
            $title = filterInputs($datas['title']);
            $content = nl2br(filterInputs($datas['content']));

            // Si on reçoit une valeur pour le status de publication de l'article
            if(isset($datas['published_article']) && !empty($datas['published_article']))
                $active = $datas['published_article'];
            else
                $active = 0;

        // Insertion des données dans la table articles
            $req = $conn->prepare("INSERT INTO articles (title, content, active) VALUES (:title, :content, :active)");
            $req->bindParam(':title', $title);
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

/**
 * Ajout d'un livre dans la base de données
 * 
 * @param mixed $conn 
 * @return true 
 */
function addLivreDB($conn, $datas) {
    try{
        // Préparation des données avant insertion dans la base de données
            $title = filterInputs($datas['title']);
            $content = nl2br(filterInputs($datas['content']));

            // Si on reçoit une valeur pour le status de publication de l'article
            if(isset($datas['published_article']) && !empty($datas['published_article']))
                $active = $datas['published_article'];
            else
                $active = 0;

        // Insertion des données dans la table articles
            $req = $conn->prepare("INSERT INTO livres (title, content, active) VALUES (:title, :content, :active)");
            $req->bindParam(':title', $title);
            $req->bindParam(':content', $content);
            $req->bindParam(':active', $active);
            $req->execute();

        // Fermeture connexion
            $req = null;
            $conn = null;

        return true;

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : addLivreDB() function";            
        return $st;  
    }       
}

/**
 * Ajout d'un livre dans la base de données
 * 
 * @param mixed $conn 
 * @return true 
 */
function addPapeterieDB($conn, $datas) {
    try{
        // Préparation des données avant insertion dans la base de données
            $title = filterInputs($datas['title']);
            $content = nl2br(filterInputs($datas['content']));

            // Si on reçoit une valeur pour le status de publication de l'article
            if(isset($datas['published_article']) && !empty($datas['published_article']))
                $active = $datas['published_article'];
            else
                $active = 0;

        // Insertion des données dans la table articles
            $req = $conn->prepare("INSERT INTO papeteries (title, content, active) VALUES (:title, :content, :active)");
            $req->bindParam(':title', $title);
            $req->bindParam(':content', $content);
            $req->bindParam(':active', $active);
            $req->execute();

        // Fermeture connexion
            $req = null;
            $conn = null;

        return true;

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : addPapeterieDB() function";            
        return $st;  
    }       
}

/**
 * Ajout d'un livre dans la base de données
 * 
 * @param mixed $conn 
 * @return true 
 */
function addCadeauDB($conn, $datas) {
    try{
        // Préparation des données avant insertion dans la base de données
            $title = filterInputs($datas['title']);
            $content = nl2br(filterInputs($datas['content']));

            // Si on reçoit une valeur pour le status de publication de l'article
            if(isset($datas['published_article']) && !empty($datas['published_article']))
                $active = $datas['published_article'];
            else
                $active = 0;

        // Insertion des données dans la table articles
            $req = $conn->prepare("INSERT INTO cadeaux (title, content, active) VALUES (:title, :content, :active)");
            $req->bindParam(':title', $title);
            $req->bindParam(':content', $content);
            $req->bindParam(':active', $active);
            $req->execute();

        // Fermeture connexion
            $req = null;
            $conn = null;

        return true;

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : addCadeauDB() function";            
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
function updateArticleDB($conn, $datas) {
    try{
        //DEBUG// disp_ar($datas, 'DATAS', 'VD');
        // Préparation des données avant insertion dans la base de données
            $title = filterInputs($datas['title']);

            $content = nl2br($datas['content']);
            $content = preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br \/>/", "$1", $content);        
            $content = htmlentities($content);
            
            $id = filterInputs($datas['id']);

            // Si on reçoit une valeur pour le status de publication de l'article
            if(isset($datas['published_article']) && !empty($datas['published_article']))
                $active = $datas['published_article'];
            else
                $active = 0;

        // Insertion des données dans la table articles
        $req = $conn->prepare("UPDATE articles SET title = :title, content = :content, active = :active WHERE id = :id");
        $req->bindParam(':title', $title);
        $req->bindParam(':content', $content);
        $req->bindParam(':active', $active);
        $req->bindParam(':id', $id);
        $req->execute();

        // Fermeture connexion
        $req = null;
        $conn = null;

        return true;

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : updateArticleDB() function";            
        return $st;  
    } 
}   

/**
 * Modification d'un livre dans la base de données
 * 
 * @param mixed $conn 
 * @param array $datas 
 * @return true 
 */
function updateLivreDB($conn, $datas) {
    try{
        //DEBUG// disp_ar($datas, 'DATAS', 'VD');
        // Préparation des données avant insertion dans la base de données
            $image_url = filterInputs($datas['image_url']);
            $title = filterInputs($datas['title']);
            $writer = filterInputs($datas['writer']);
            $feature = filterInputs($datas['feature']);
            $price = filterInputs($datas['price']);
            $idCategory = filterInputs($datas['idCategory']);

            $content = nl2br($datas['content']);
            $content = preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br \/>/", "$1", $content);        
            $content = htmlentities($content);

            
            $idLivre = filterInputs($datas['idLivre']);

            // Si on reçoit une valeur pour le status de publication de l'article
            if(isset($datas['published_article']) && !empty($datas['published_article']))
                $active = $datas['published_article'];
            else
                $active = 0;

        // Insertion des données dans la table articles
        $req = $conn->prepare("UPDATE livres SET image_url = :image_url, title = :title, writer = :writer, feature = :feature, content = :content, price = :price, active = :active, idCategory = :idCategory WHERE idLivre = :idLivre");
        $req->bindParam(':image_url', $image_url);
        $req->bindParam(':title', $title);
        $req->bindParam(':writer', $writer);
        $req->bindParam(':feature', $feature);
        $req->bindParam(':price', $price);
        $req->bindParam(':content', $content);
        $req->bindParam(':active', $active);
        $req->bindParam(':idCategory', $idCategory);
        $req->bindParam(':idLivre', $idLivre);
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

/**
 * Modification d'un papeterie dans la base de données
 * 
 * @param mixed $conn 
 * @param array $datas 
 * @return true 
 */
function updatePapeterieDB($conn, $datas) {
    try{
        //DEBUG// disp_ar($datas, 'DATAS', 'VD');
        // Préparation des données avant insertion dans la base de données
            $image_url = filterInputs($datas['image_url']);
            $title = filterInputs($datas['title']);
            $writer = filterInputs($datas['writer']);
            $feature = filterInputs($datas['feature']);
            $price = filterInputs($datas['price']);
            $idCategory = filterInputs($datas['idCategory']);

            $content = nl2br($datas['content']);
            $content = preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br \/>/", "$1", $content);        
            $content = htmlentities($content);

            
            $idPapeterie = filterInputs($datas['idPapeterie']);

            // Si on reçoit une valeur pour le status de publication de l'article
            if(isset($datas['published_article']) && !empty($datas['published_article']))
                $active = $datas['published_article'];
            else
                $active = 0;

        // Insertion des données dans la table articles
        $req = $conn->prepare("UPDATE papeteries SET image_url = :image_url, title = :title, writer = :writer, feature = :feature, content = :content, price = :price, active = :active, idCategory = :idCategory WHERE id = :id");
        $req->bindParam(':image_url', $image_url);
        $req->bindParam(':title', $title);
        $req->bindParam(':writer', $writer);
        $req->bindParam(':feature', $feature);
        $req->bindParam(':price', $price);
        $req->bindParam(':content', $content);
        $req->bindParam(':active', $active);
        $req->bindParam(':idCategory', $idCategory);
        $req->bindParam(':idPapeterie', $idPapeterie);
        $req->execute();

        // Fermeture connexion
        $req = null;
        $conn = null;

        return true;

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : updatePapeterieDB() function";            
        return $st;  
    } 
}

/**
 * Modification d'un cadeau dans la base de données
 * 
 * @param mixed $conn 
 * @param array $datas 
 * @return true 
 */
function updateCadeauDB($conn, $datas) {
    try{
        //DEBUG// disp_ar($datas, 'DATAS', 'VD');
        // Préparation des données avant insertion dans la base de données
            $image_url = filterInputs($datas['image_url']);
            $title = filterInputs($datas['title']);
            $writer = filterInputs($datas['writer']);
            $feature = filterInputs($datas['feature']);
            $price = filterInputs($datas['price']);
            $idCategory = filterInputs($datas['idCategory']);

            $content = nl2br($datas['content']);
            $content = preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br \/>/", "$1", $content);        
            $content = htmlentities($content);

            
            $idCadeau = filterInputs($datas['idCadeau']);

            // Si on reçoit une valeur pour le status de publication de l'article
            if(isset($datas['published_article']) && !empty($datas['published_article']))
                $active = $datas['published_article'];
            else
                $active = 0;

        // Insertion des données dans la table articles
        $req = $conn->prepare("UPDATE cadeaux SET image_url = :image_url, title = :title, writer = :writer, feature = :feature, content = :content, price = :price, active = :active, idCategory = :idCategory WHERE id = :id");
        $req->bindParam(':image_url', $image_url);
        $req->bindParam(':title', $title);
        $req->bindParam(':writer', $writer);
        $req->bindParam(':feature', $feature);
        $req->bindParam(':price', $price);
        $req->bindParam(':content', $content);
        $req->bindParam(':active', $active);
        $req->bindParam(':idCategory', $idCategory);
        $req->bindParam(':idCadeau', $idCadeau);
        $req->execute();

        // Fermeture connexion
        $req = null;
        $conn = null;

        return true;

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : updateCadeauDB() function";            
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
function deleteArticleDB($conn, $id) {
    try{
        // Préparation des données avant insertion dans la base de données
        $id = filterInputs($id);

        // Insertion des données dans la table articles
        $req = $conn->prepare("DELETE FROM articles WHERE id = :id");
        $req->bindParam(':id', $id);
        $req->execute();

        // Fermeture connexion
        $req = null;
        $conn = null;

        return true;

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : deleteArticleDB() function";            
        return $st;     
    }       

}   

/**
 * Suppression d'un livre dans la base de données
 * 
 * @param mixed $conn 
 * @return true 
 */
function deleteLivreDB($conn, $idLivre) {
    try{
        // Préparation des données avant insertion dans la base de données
        $idLivre = filterInputs($idLivre);

        // Insertion des données dans la table articles
        $req = $conn->prepare("DELETE FROM livres WHERE idLivre = :idLivre");
        $req->bindParam(':idLivre', $idLivre);
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

/**
 * Suppression d'un papeterie dans la base de données
 * 
 * @param mixed $conn 
 * @return true 
 */
function deletePapeterieDB($conn, $idPapeterie) {
    try{
        // Préparation des données avant insertion dans la base de données
        $idPapeterie = filterInputs($idPapeterie);

        // Insertion des données dans la table articles
        $req = $conn->prepare("DELETE FROM papeteries WHERE idPapeterie = :idPapeterie");
        $req->bindParam(':id', $idPapeterie);
        $req->execute();

        // Fermeture connexion
        $req = null;
        $conn = null;

        return true;

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : deletePapeterieDB() function";            
        return $st;     
    }       

}   

/**
 * Suppression d'un cadeau dans la base de données
 * 
 * @param mixed $conn 
 * @return true 
 */
function deleteCadeauDB($conn, $idCadeau) {
    try{
        // Préparation des données avant insertion dans la base de données
        $idCadeau = filterInputs($idCadeau);

        // Insertion des données dans la table articles
        $req = $conn->prepare("DELETE FROM cadeaux WHERE idCadeau = :idCadeau");
        $req->bindParam(':idCadeau', $idCadeau);
        $req->execute();

        // Fermeture connexion
        $req = null;
        $conn = null;

        return true;

    }catch(PDOException $e) {
        (DEBUG)? $st = 'Error : ' . $e->getMessage() : $st = "Error in : deleteCadeauDB() function";            
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

/**-----------------------------------------------------------------
        Function to retrieve category names from the database
*------------------------------------------------------------------**/

// Function to retrieve category names from the database
function getCategoryNamesFromDB($conn) {
    $categories = array();

    // Assuming your SQL query to fetch category names
    $query = "SELECT idCategory, nameOfCategory FROM product_category";
    $stmt = $conn->query($query);

    // Check if the query executed successfully
    if ($stmt) {
        // Fetch associative array of category names
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = $row;
        }
    }

    return $categories;
}