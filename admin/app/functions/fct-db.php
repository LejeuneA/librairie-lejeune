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
function connectDB($serverName, $userName, $userPwd, $dbName)
{
    try {
        // Création d'une connexion à la base de données
        $conn = new PDO("mysql:host=$serverName;dbname=$dbName;charset=utf8", $userName, $userPwd);

        // Définition du mode d'erreur de PDO sur Exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error : Database connexion";
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
function userIdentificationDB($conn, $datas)
{
    try {
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

        if ((isset($user['email']) && $user['email'] === $login) && (isset($user['passwd']) && $user['passwd'] === $pwd)) {
            // On supprime le mot de passe de l'objet $user
            $user['passwd'] = null;
            return $user;
        } else
            return false;
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : userIdentificationDB() function";
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
function getAllArticlesDB($conn, $active = '%')
{
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
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getAllArticlesDB() function";
        return $st;
    }
}

/**
 * Récupérer tous les livres de la table articles
 * 
 * @param object $conn 
 * @param int $limit (Nombre d'éléments à récupérer)
 * @param string $active (0, 1 ou %)
 * @return array|false $resultat ou false en cas d'erreur
 */
function getAllLivresDB($conn, $limit = null, $active = '%')
{
    try {
        // Préparation de la requête SQL
        $sql = "SELECT * FROM livres WHERE active LIKE :active ORDER BY idLivre DESC";
        
        // Si un nombre limite est spécifié, ajoute une clause LIMIT à la requête
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }

        // Préparation de la requête
        $req = $conn->prepare($sql);
        $req->bindParam(':active', $active);

        // Si un nombre limite est spécifié, bind le paramètre à la requête
        if ($limit !== null) {
            $req->bindParam(':limit', $limit, PDO::PARAM_INT);
        }

        // Exécution de la requête
        $req->execute();

        // Récupération des résultats
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);

        // Fermeture de la connexion
        $req = null;
        $conn = null;

        // Retourne les résultats
        return $resultat;
    } catch (PDOException $e) {
        // Gestion des erreurs
        if (DEBUG) {
            return 'Error : ' . $e->getMessage();
        } else {
            return "Error in : getAllLivresDB() function";
        }
    }
}

/**
 * Récupérer tous les papeteries de la table articles
 * 
 * @param object $conn 
 * @param int $limit (Nombre d'éléments à récupérer)
 * @param string $active (0, 1 ou %)
 * @return array|false $resultat ou false en cas d'erreur
 */
function getAllPapeteriesDB($conn, $limit = null, $active = '%')
{
    try {
        // Préparation de la requête SQL
        $sql = "SELECT * FROM papeteries WHERE active LIKE :active ORDER BY idPapeterie DESC";
        
        // Si un nombre limite est spécifié, ajoute une clause LIMIT à la requête
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }

        // Préparation de la requête
        $req = $conn->prepare($sql);
        $req->bindParam(':active', $active);

        // Si un nombre limite est spécifié, bind le paramètre à la requête
        if ($limit !== null) {
            $req->bindParam(':limit', $limit, PDO::PARAM_INT);
        }

        // Exécution de la requête
        $req->execute();

        // Récupération des résultats
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);

        // Fermeture de la connexion
        $req = null;
        $conn = null;

        // Retourne les résultats
        return $resultat;
    } catch (PDOException $e) {
        // Gestion des erreurs
        if (DEBUG) {
            return 'Error : ' . $e->getMessage();
        } else {
            return "Error in : getAllPapeteriesDB() function";
        }
    }
}

/**
 * Récupérer tous les cadeaux de la table articles
 * 
 * @param object $conn 
 * @param int $limit (Nombre d'éléments à récupérer)
 * @param string $active (0, 1 ou %)
 * @return array|false $resultat ou false en cas d'erreur
 */
function getAllCadeauxDB($conn, $limit = null, $active = '%')
{
    try {
        // Préparation de la requête SQL
        $sql = "SELECT * FROM cadeaux WHERE active LIKE :active ORDER BY idCadeau DESC";
        
        // Si un nombre limite est spécifié, ajoute une clause LIMIT à la requête
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }

        // Préparation de la requête
        $req = $conn->prepare($sql);
        $req->bindParam(':active', $active);

        // Si un nombre limite est spécifié, bind le paramètre à la requête
        if ($limit !== null) {
            $req->bindParam(':limit', $limit, PDO::PARAM_INT);
        }

        // Exécution de la requête
        $req->execute();

        // Récupération des résultats
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);

        // Fermeture de la connexion
        $req = null;
        $conn = null;

        // Retourne les résultats
        return $resultat;
    } catch (PDOException $e) {
        // Gestion des erreurs
        if (DEBUG) {
            return 'Error : ' . $e->getMessage();
        } else {
            return "Error in : getAllCadeauxDB() function";
        }
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
function getArticleByIDDB($conn, $id)
{
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
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getArticleByIDDB() function";
        return $st;
    }
}

/**
 * Récupérer un livre en fonction de son ID
 * 
 * @param object $conn 
 * @return array $resultat
 */
function getLivreByIDDB($conn, $idLivre)
{
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
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getLivreByIDDB() function";
        return $st;
    }
}

/**
 * Récupérer un papeterie en fonction de son ID
 * 
 * @param object $conn 
 * @return array $resultat
 */
function getPapeterieByIDDB($conn, $idPapeterie)
{
    try {
        // Récupérer des données de notre table articles
        $req = $conn->prepare("SELECT * FROM papeteries WHERE idPapeterie = :idPapeterie");
        $req->bindParam(':idPapeterie', $idPapeterie);
        $req->execute();

        // Retourne un tableau associatif pour chaque entrée de la table articles avec le nom des colonnes comme clé
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        // Fermeture connexion
        $req = null;
        $conn = null;

        return $resultat;
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getPapeterieByIDDB() function";
        return $st;
    }
}

/**
 * Récupérer un cadeau en fonction de son ID
 * 
 * @param object $conn 
 * @return array $resultat
 */
function getCadeauByIDDB($conn, $idCadeau)
{
    try {
        // Récupérer des données de notre table articles
        $req = $conn->prepare("SELECT * FROM cadeaux WHERE idCadeau = :idCadeau");
        $req->bindParam(':idCadeau', $idCadeau);
        $req->execute();

        // Retourne un tableau associatif pour chaque entrée de la table articles avec le nom des colonnes comme clé
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        // Fermeture connexion
        $req = null;
        $conn = null;

        return $resultat;
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : getCadeauByIDDB() function";
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
function addArticleDB($conn, $datas)
{
    try {
        // Préparation des données avant insertion dans la base de données
        $title = filterInputs($datas['title']);
        $content = nl2br(filterInputs($datas['content']));

        // Si on reçoit une valeur pour le status de publication de l'article
        if (isset($datas['published_article']) && !empty($datas['published_article']))
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
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : addArticleDB() function";
        return $st;
    }
}

/**
 * Ajout d'un livre dans la base de données
 * 
 * @param mixed $conn 
 * @return true 
 */
function addLivreDB($conn, $datas)
{
    try {
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

        // Si on reçoit une valeur pour le status de publication de l'article
        if (isset($datas['published_article']) && !empty($datas['published_article'])) {
            $active = $datas['published_article'];
        } else {
            $active = 0;
        }

        // Insertion des données dans la table articles
        $req = $conn->prepare("INSERT INTO livres (image_url, title, writer, feature, content, price, active, idCategory) VALUES (:image_url, :title, :writer, :feature, :content, :price, :active, :idCategory)");
        $req->bindParam(':image_url', $image_url);
        $req->bindParam(':title', $title);
        $req->bindParam(':writer', $writer);
        $req->bindParam(':feature', $feature);
        $req->bindParam(':price', $price);
        $req->bindParam(':content', $content);
        $req->bindParam(':active', $active);
        $req->bindParam(':idCategory', $idCategory);
        $req->execute();

        // Fermeture connexion
        $req = null;
        $conn = null;

        return true;
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : addLivreDB() function";
        return $st;
    }
}

/**
 * Ajout d'une papeterie dans la base de données
 * 
 * @param mixed $conn 
 * @return boolean 
 */
function addPapeterieDB($conn, $datas)
{
    try {
        // Préparation des données avant insertion dans la base de données
        $image_url = filterInputs($datas['image_url']);
        $title = filterInputs($datas['title']);
        $feature = filterInputs($datas['feature']);
        $price = filterInputs($datas['price']);
        $idCategory = filterInputs($datas['idCategory']);

        $content = nl2br($datas['content']);
        $content = preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br \/>/", "$1", $content);
        $content = htmlentities($content);

        // Si on reçoit une valeur pour le status de publication de l'article
        if (isset($datas['published_article']) && !empty($datas['published_article'])) {
            $active = $datas['published_article'];
        } else {
            $active = 0;
        }

        // Insertion des données dans la table papeteries
        $req = $conn->prepare("INSERT INTO papeteries (image_url, title, feature, content, price, active, idCategory) VALUES (:image_url, :title, :feature, :content, :price, :active, :idCategory)");
        $req->bindParam(':image_url', $image_url);
        $req->bindParam(':title', $title);
        $req->bindParam(':feature', $feature);
        $req->bindParam(':price', $price);
        $req->bindParam(':content', $content);
        $req->bindParam(':active', $active);
        $req->bindParam(':idCategory', $idCategory);
        $req->execute();

        // Return true on success
        return true;
    } catch (PDOException $e) {
        // Log error or return false
        return false;
    }
}

/**
 * Ajout d'un cadeau dans la base de données
 * 
 * @param mixed $conn 
 * @return boolean 
 */
function addCadeauDB($conn, $datas)
{
    try {
        // Préparation des données avant insertion dans la base de données
        $image_url = filterInputs($datas['image_url']);
        $title = filterInputs($datas['title']);
        $feature = filterInputs($datas['feature']);
        $price = filterInputs($datas['price']);
        $idCategory = filterInputs($datas['idCategory']);

        $content = nl2br($datas['content']);
        $content = preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br \/>/", "$1", $content);
        $content = htmlentities($content);

        // Si on reçoit une valeur pour le status de publication de l'article
        if (isset($datas['published_article']) && !empty($datas['published_article'])) {
            $active = $datas['published_article'];
        } else {
            $active = 0;
        }

        // Insertion des données dans la table papeteries
        $req = $conn->prepare("INSERT INTO cadeaux (image_url, title, feature, content, price, active, idCategory) VALUES (:image_url, :title, :feature, :content, :price, :active, :idCategory)");
        $req->bindParam(':image_url', $image_url);
        $req->bindParam(':title', $title);
        $req->bindParam(':feature', $feature);
        $req->bindParam(':price', $price);
        $req->bindParam(':content', $content);
        $req->bindParam(':active', $active);
        $req->bindParam(':idCategory', $idCategory);
        $req->execute();

        // Return true on success
        return true;
    } catch (PDOException $e) {
        // Log error or return false
        return false;
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
function updateArticleDB($conn, $datas)
{
    try {
        //DEBUG// disp_ar($datas, 'DATAS', 'VD');
        // Préparation des données avant insertion dans la base de données
        $title = filterInputs($datas['title']);

        $content = nl2br($datas['content']);
        $content = preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br \/>/", "$1", $content);
        $content = htmlentities($content);

        $id = filterInputs($datas['id']);

        // Si on reçoit une valeur pour le status de publication de l'article
        if (isset($datas['published_article']) && !empty($datas['published_article']))
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
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : updateArticleDB() function";
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
function updateLivreDB($conn, $datas)
{
    try {
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
        if (isset($datas['published_article']) && !empty($datas['published_article']))
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
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : updateLivreDB() function";
        return $st;
    }
}

/**
 * Modification d'un papeterie dans la base de données
 * 
 * @param PDO $conn The database connection
 * @param array $datas The data to update
 * @return bool|string Returns true on success, or an error message on failure
 */
function updatePapeterieDB($conn, $datas)
{
    try {
        // Sanitize input data
        $image_url = filterInputs($datas['image_url']);
        $title = filterInputs($datas['title']);
        $feature = filterInputs($datas['feature']);
        $price = filterInputs($datas['price']);
        $idCategory = filterInputs($datas['idCategory']);
        $idPapeterie = filterInputs($datas['idPapeterie']);

        // Sanitize and format content
        $content = nl2br($datas['content']);
        $content = preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br \/>/", "$1", $content);
        $content = htmlentities($content);

        // Determine the active status
        $active = isset($datas['published_article']) ? $datas['published_article'] : 0;

        // Prepare and execute the update query
        $stmt = $conn->prepare("UPDATE papeteries SET image_url = :image_url, title = :title, feature = :feature, content = :content, price = :price, active = :active, idCategory = :idCategory WHERE idPapeterie = :idPapeterie");
        $stmt->bindParam(':image_url', $image_url);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':feature', $feature);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':idCategory', $idCategory);
        $stmt->bindParam(':idPapeterie', $idPapeterie);
        $stmt->execute();

        // Close the statement
        $stmt = null;

        return true; // Return true on success
    } catch (PDOException $e) {
        // Log or handle the error
        return 'Error: ' . $e->getMessage(); // Return the error message
    }
}

/**
 * Modification d'un cadeau dans la base de données
 * 
 * @param mixed $conn 
 * @param array $datas 
 * @return true 
 */
function updateCadeauDB($conn, $datas)
{
    try {
        //DEBUG// disp_ar($datas, 'DATAS', 'VD');
        // Préparation des données avant insertion dans la base de données
        $image_url = filterInputs($datas['image_url']);
        $title = filterInputs($datas['title']);
        $feature = filterInputs($datas['feature']);
        $price = filterInputs($datas['price']);
        $idCategory = filterInputs($datas['idCategory']);

        $content = nl2br($datas['content']);
        $content = preg_replace("/(<[a-zA-Z0-9=\"\/\ ]+>)<br \/>/", "$1", $content);
        $content = htmlentities($content);


        $idCadeau = filterInputs($datas['idCadeau']);

        // Si on reçoit une valeur pour le status de publication de l'article
        if (isset($datas['published_article']) && !empty($datas['published_article']))
            $active = $datas['published_article'];
        else
            $active = 0;

        // Insertion des données dans la table articles
        $req = $conn->prepare("UPDATE cadeaux SET image_url = :image_url, title = :title, feature = :feature, content = :content, price = :price, active = :active, idCategory = :idCategory WHERE idCadeau = :idCadeau");
        $req->bindParam(':image_url', $image_url);
        $req->bindParam(':title', $title);
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
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : updateCadeauDB() function";
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
function deleteArticleDB($conn, $id)
{
    try {
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
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : deleteArticleDB() function";
        return $st;
    }
}

/**
 * Suppression d'un livre dans la base de données
 * 
 * @param mixed $conn 
 * @return true 
 */
function deleteLivreDB($conn, $idLivre)
{
    try {
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
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : deleteLivreDB() function";
        return $st;
    }
}

/**
 * Suppression d'un papeterie dans la base de données
 * 
 * @param mixed $conn 
 * @return true 
 */
function deletePapeterieDB($conn, $idPapeterie)
{
    try {
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
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : deletePapeterieDB() function";
        return $st;
    }
}

/**
 * Suppression d'un cadeau dans la base de données
 * 
 * @param mixed $conn 
 * @return true 
 */
function deleteCadeauDB($conn, $idCadeau)
{
    try {
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
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : deleteCadeauDB() function";
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
function userIdentificationWithHashPwdDB($conn, $datas)
{
    try {
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
        if (!empty($user['email']))
            $isConnected = password_verify($pwd, $user['passwd']);

        //DEBUG// echo 'PWD : '.$pwd.'<br>';disp_ar($isConnected, 'IS CONNECTED', 'VD'); 

        // Fermeture connexion
        $req = null;
        $conn = null;

        if ($isConnected) {
            // On supprime le mot de passe de l'objet $user
            $user['passwd'] = null;
            return $user;
        } else
            return false;
    } catch (PDOException $e) {
        (DEBUG) ? $st = 'Error : ' . $e->getMessage() : $st = "Error in : userIdentificationDB() function";
        return $st;
    }
}

/**-----------------------------------------------------------------
        Function to fetch all categories from the database using PDO
 *------------------------------------------------------------------**/
// Function to retrieve all categories from the database using PDO
function getAllCategoriesDB($pdo) {
    // Initialize an array to store the categories
    $categories = [];

    try {
        // Prepare the SQL query to select all categories
        $query = "SELECT * FROM product_category";

        // Prepare the statement
        $statement = $pdo->prepare($query);

        // Execute the statement
        $statement->execute();

        // Fetch all categories as an associative array
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }

    // Return the categories
    return $categories;
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

