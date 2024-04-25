-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: librairie_lejeune
-- ------------------------------------------------------
-- Server version	8.0.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cadeaux`
--

DROP TABLE IF EXISTS `cadeaux`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cadeaux` (
  `idCadeau` int NOT NULL AUTO_INCREMENT,
  `image_url` varchar(250) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `feature` varchar(100) DEFAULT NULL,
  `content` mediumtext,
  `price` decimal(5,2) NOT NULL,
  `active` tinyint unsigned DEFAULT '1',
  `idCategory` int NOT NULL DEFAULT '3',
  PRIMARY KEY (`idCadeau`),
  UNIQUE KEY `idCadeau_UNIQUE` (`idCadeau`),
  UNIQUE KEY `idCategory_UNIQUE` (`idCategory`)
) ENGINE=InnoDB AUTO_INCREMENT=30002 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cadeaux`
--

LOCK TABLES `cadeaux` WRITE;
/*!40000 ALTER TABLE `cadeaux` DISABLE KEYS */;
INSERT INTO `cadeaux` VALUES (30001,'assetsimagesgiftsweek-end-insolite.jpg','Bongo FR Week-end Insolite ','Bongo',' Quoi de plus efficace pour échapper à la routine qu’une échappée pleine d’originalité ? Grâce à ce coffret cadeau Bongo Séjour insolite, deux âmes en quête d’évasion pourront profiter d’une nuit avec petit-déjeuner, à vivre dans le cadre surprenant d’une cabane, d’une roulotte, d’un bateau ou encore d’un hôtel à thème. Idéal pour déconnecter en duo ! ',99.90,1,3);
/*!40000 ALTER TABLE `cadeaux` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livres`
--

DROP TABLE IF EXISTS `livres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `livres` (
  `idLivre` int NOT NULL AUTO_INCREMENT,
  `image_url` varchar(250) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `writer` varchar(45) DEFAULT NULL,
  `feature` varchar(100) DEFAULT NULL,
  `content` longtext,
  `price` decimal(5,2) NOT NULL,
  `active` tinyint unsigned DEFAULT '1',
  `idCategory` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`idLivre`),
  UNIQUE KEY `idLivre_UNIQUE` (`idLivre`)
) ENGINE=InnoDB AUTO_INCREMENT=10013 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livres`
--

LOCK TABLES `livres` WRITE;
/*!40000 ALTER TABLE `livres` DISABLE KEYS */;
INSERT INTO `livres` VALUES (10001,'assets/images/uploads/beautiful-sinner.jpg','Beautiful Sinner','Anita Rigings','Livre broch&eacute; | Fran&ccedil;ais','&lt;p&gt;Une plong&amp;eacute;e au coeur des t&amp;eacute;n&amp;egrave;bres, aux c&amp;ocirc;t&amp;eacute;s d&#039;un homme &amp;agrave; l&#039;&amp;acirc;me tach&amp;eacute;e de sang. &amp;Agrave; 18 ans, Eden Santoro n&#039;a pas peur des monstres : elle aime Alhan, le plus dangereux d&#039;entre eux. &amp;Agrave; 20 ans, tout a chang&amp;eacute; : elle fuit d&amp;eacute;sormais Alhan et ce qu&#039;il repr&amp;eacute;sente, le danger, les douleurs du pass&amp;eacute;, leur passion d&amp;eacute;truite... Mais, tapi dans l&#039;ombre, son ancien amant r&amp;ocirc;de toujours, et il ne lui laisse pas le choix : elle doit replonger dans sa Colombie natale, dans l&#039;univers sombre des trafics d&#039;armes, dans les yeux si perturbants du monstre qu&#039;elle a aim&amp;eacute;. Forc&amp;eacute;e de cohabiter avec lui, Eden va d&amp;eacute;couvrir que les myst&amp;egrave;res qui l&#039;entourent sont plus inqui&amp;eacute;tants que jamais. Et si, plut&amp;ocirc;t que de fuir les t&amp;eacute;n&amp;egrave;bres, elle d&amp;eacute;cidait cette fois de danser avec elles ?&lt;/p&gt;',17.90,1,1),(10002,'assets/images/uploads/borderline.jpg','Borderline. Vol. 1','Joyce Kitten','Livre broch&eacute; | Fran&ccedil;ais','&lt;p&gt;L&#039;universit&amp;eacute; Johns Hopkins devait &amp;ecirc;tre l&#039;aboutissement de mes longues ann&amp;eacute;es d&#039;&amp;eacute;tudes de m&amp;eacute;decine. Cette fac prestigieuse m&#039;ouvrait enfin ses portes. Les &amp;eacute;toiles s&#039;alignaient, les fant&amp;ocirc;mes de mon pass&amp;eacute; s&#039;effa&amp;ccedil;aient, le futur s&#039;&amp;eacute;claircissait. Jusqu&#039;&amp;agrave; ma rencontre avec Ezrah Milton. Jusqu&#039;&amp;agrave; ce que nos regards se croisent pour se promettre mille et une souffrances. J&#039;ai devin&amp;eacute; dans ses pupilles d&amp;eacute;moniaques quel sort il me r&amp;eacute;servait. En quelques secondes, il m&#039;a &amp;eacute;lue comme prochaine victime de sa perversion. J&#039;ai discern&amp;eacute; le pr&amp;eacute;dateur tapi derri&amp;egrave;re l&#039;homme, mais lui, a-t-il remarqu&amp;eacute; le loup d&amp;eacute;guis&amp;eacute; en agneau ? Oh non, Ezrah, il n&#039;y a aucune proie ici, aucun maillon faible. Il est dit que l&#039;on attire ceux &amp;agrave; qui nous ressemblons. Laisse-moi te prouver &amp;agrave; quel point cet adage est vrai.&lt;/p&gt;',18.10,1,1),(10003,'assets/images/uploads/captive.jpg','Captive. Vol. 1','Sarah Rivens','Livre broch&eacute; | Fran&ccedil;ais','&lt;p&gt;Au sein des r&amp;eacute;seaux criminels. L&amp;agrave; o&amp;ugrave; r&amp;egrave;gnent puissance, meurtre et pouvoir, il y avait elles. Les captives, Dangereuses, malignes, et mortelles, elles sont les ombres des plus grands r&amp;eacute;seaux, les repr&amp;eacute;sentantes de leurs chefs, aussi appel&amp;eacute;s possesseurs. Depuis son adolescence. Ella est une captive contre son gr&amp;eacute;. John, son possesseur, pr&amp;eacute;f&amp;egrave;re utiliser son corps plut&amp;ocirc;t que ses talents, plongeant sa vie dans un cauchemar &amp;eacute;veill&amp;eacute;. Jusqu&#039;au jour o&amp;ugrave; il lui annonce qu&#039;elle va travailler pour quelqu&#039;un d&#039;autre... Si Ella pensait qu&#039;il ne pouvait y avoir pire que John, elle r&amp;eacute;alise tr&amp;egrave;s vite que son nouveau possesseur joue dans une tout autre cat&amp;eacute;gorie. Ce certain &amp;laquo; Ash &amp;raquo;, leader charismatique du r&amp;eacute;seau des Scott, refuse la pr&amp;eacute;sence d&#039;une captive &amp;agrave; ses c&amp;ocirc;t&amp;eacute;s. Pour une raison obscure, il voue une haine visc&amp;eacute;rale &amp;agrave; ces femmes. Un jeu dangereux s&#039;installe alors entre eux, car Asher entend bien faire payer Ella, mais celle-ci ne compte pas c&amp;eacute;der... &amp;laquo; Ne joue pas avec le diable, mon ange, ne t&#039;aventure pas dans ce que tu regretteras. &amp;raquo;&lt;/p&gt;',20.10,1,1),(10004,'assets/images/uploads/la-femme-de-menage.jpg','La femme de m&eacute;nage','Freida McFadden','Livre broch&eacute; | Fran&ccedil;ais','&lt;p&gt;&amp;laquo; Je me rassure : les Winchester ne savent pas qui je suis vraiment. Ils ne savent pas de quoi je suis capable. &amp;raquo; Chaque jour, Millie fait le m&amp;eacute;nage dans la belle maison des Winchester, une riche famille new-yorkaise. Elle r&amp;eacute;cup&amp;egrave;re aussi leur fille &amp;agrave; l&#039;&amp;eacute;cole et pr&amp;eacute;pare les repas avant d&#039;aller se coucher dans sa chambre, au grenier. Pour la jeune femme, ce nouveau travail est une chance inesp&amp;eacute;r&amp;eacute;e. L&#039;occasion de repartir de z&amp;eacute;ro. Mais, sous des dehors respectables, sa patronne se montre de plus en plus instable et toxique. Et puis il y a aussi cette rumeur d&amp;eacute;rangeante qui court dans le quartier : madame Winchester aurait tent&amp;eacute; de noyer sa fille il y a quelques ann&amp;eacute;es. Heureusement, le gentil et s&amp;eacute;duisant monsieur Winchester est l&amp;agrave; pour rendre la situation supportable. Mais le danger se tapit parfois sous des apparences trompeuses. Et lorsque Millie d&amp;eacute;couvre que la porte de sa chambre mansard&amp;eacute;e ne ferme que de l&#039;ext&amp;eacute;rieur, il est peut-&amp;ecirc;tre d&amp;eacute;j&amp;agrave; trop tard...&lt;/p&gt;',20.05,1,1),(10005,'assets/images/uploads/mon-coeur-a-demenage.jpg','Mon coeur a d&eacute;m&eacute;nag&eacute;','Michel Bussi','Livre broch&eacute; | Fran&ccedil;ais','&lt;p&gt;La mort d&#039;une m&amp;egrave;re La qu&amp;ecirc;te d&#039;une fille Une vengeance implacable &quot; Papa a tu&amp;eacute; maman. &quot; Rouen, avril 1983. Oph&amp;eacute;lie a - presque - tout vu, du haut de ses sept ans. Mais son p&amp;egrave;re n&#039;est pas le seul coupable. Un autre homme aurait pu sauver sa m&amp;egrave;re. D&amp;egrave;s lors, Oph&amp;eacute;lie n&#039;aura plus qu&#039;un but : retrouver les t&amp;eacute;moins, rassembler les pi&amp;egrave;ces du puzzle qui la m&amp;egrave;neront jusqu&#039;&amp;agrave; la v&amp;eacute;rit&amp;eacute;. Et, patiemment, accomplir sa vengeance...&lt;br&gt;&lt;br&gt;Enfant plac&amp;eacute;e en foyer, coll&amp;eacute;gienne rebelle, &amp;eacute;tudiante &amp;eacute;voluant sous une fausse identit&amp;eacute;, chaque &amp;eacute;tape de la vie d&#039;Oph&amp;eacute;lie sera marqu&amp;eacute;e par sa qu&amp;ecirc;te obsessionnelle et bouleversante. Dans une intrigue qui m&amp;ecirc;le roman d&#039;amour et d&#039;amiti&amp;eacute;s, r&amp;eacute;cit initiatique et manipulations, Michel Bussi dessine aussi une fresque sociale in&amp;eacute;dite des ann&amp;eacute;es 1990.&lt;/p&gt;',22.90,1,1),(10006,'assets/images/uploads/lakestone.jpg','Lakestone. Vol. 1','Sarah Rivens','Livre broch&eacute; | Fran&ccedil;ais','&lt;p&gt;Dans la tranquillit&amp;eacute; trompeuse de la ville d&#039;Ewing aux &amp;Eacute;tats-Unis, Iris, confin&amp;eacute;e &amp;agrave; la biblioth&amp;egrave;que, est plong&amp;eacute;e dans ses r&amp;eacute;visions. &amp;Agrave; des kilom&amp;egrave;tres de l&amp;agrave;, un mercenaire affronte le froid tranchant de la nuit, aussi glaciale que le cadavre qu&#039;il vient d&#039;enterrer. Ils n&#039;ont rien en commun, pourtant tous deux ont le m&amp;ecirc;me objectif : amasser assez d&#039;argent. Iris, pour payer ses frais de scolarit&amp;eacute; &amp;agrave; l&#039;universit&amp;eacute;, le mercenaire, pour mener &amp;agrave; bien sa mission. Mission dont elle est la cible. D&amp;eacute;sormais, l&#039;existence d&#039;iris est li&amp;eacute;e &amp;agrave; celle de cet homme, une connexion qui &amp;eacute;veille en lui curiosit&amp;eacute; et d&amp;eacute;sir. Arrach&amp;eacute;e &amp;agrave; la vie qu&#039;elle a toujours connue, la jeune &amp;eacute;tudiante se retrouve &amp;agrave; la merci du mercenaire dont l&#039;impulsivit&amp;eacute; a forg&amp;eacute; la r&amp;eacute;putation, celui qui a &amp;eacute;t&amp;eacute; fa&amp;ccedil;onn&amp;eacute; pour tuer... Celui qu&#039;on appelait Lakestone.&lt;/p&gt;',20.10,1,1),(10007,'assets/images/uploads/la-rose-de-minuit.jpg','La rose de minuit','Lucinda Riley','Livre broch&eacute; | Fran&ccedil;ais','&lt;p&gt;Quand la c&amp;eacute;l&amp;egrave;bre actrice Rebecca Bradley passe les portes en fer forg&amp;eacute; d&#039;Astbury Hall, le domaine anglais qui sert de lieu de tournage &amp;agrave; son prochain film, elle est subjugu&amp;eacute;e par cette propri&amp;eacute;t&amp;eacute; sortie d&#039;une autre &amp;eacute;poque. Loin des paparazzis et du glamour d&#039;Hollywood, elle &amp;eacute;prouve imm&amp;eacute;diatement une curieuse s&amp;eacute;r&amp;eacute;nit&amp;eacute;. Mais le jour o&amp;ugrave; elle d&amp;eacute;couvre sa troublante ressemblance avec lady Violet, la grand-m&amp;egrave;re de l&#039;actuel propri&amp;eacute;taire des lieux, elle d&amp;eacute;cide d&#039;en savoir plus sur le pass&amp;eacute; de cette &amp;eacute;trange famille. Aid&amp;eacute;e par un jeune homme originaire de Bombay &amp;agrave; la recherche d&#039;informations sur son a&amp;iuml;eule, qui aurait v&amp;eacute;cu &amp;agrave; Astbury Hall, Rebecca perce peu &amp;agrave; peu les secrets qu&#039;abritent les vieilles pierres du manoir. Seulement, les ombres qui hantent la dynastie des Astbury pourraient bouleverser bien des destin&amp;eacute;es... Une &amp;eacute;tourdissante fresque multig&amp;eacute;n&amp;eacute;rationnelle, qui nous fait voyager des splendides demeures de la campagne anglaise aux palais des maharadjahs du d&amp;eacute;but du XXe si&amp;egrave;cle.&lt;/p&gt;',23.90,1,1),(10008,'assets/images/uploads/la-vie-heureuse.jpg','La vie heureuse','Ken Follett','Livre broch&eacute; | Fran&ccedil;ais','&lt;p&gt;Jamais aucune &amp;eacute;poque n&#039;a autant &amp;eacute;t&amp;eacute; marqu&amp;eacute;e par le d&amp;eacute;sir de changer de vie. Nous voulons tous, &amp;agrave; un moment de notre existence, &amp;ecirc;tre un autre&lt;/p&gt;',19.00,1,1),(10009,'assets/images/uploads/les-armes-de-la-lumiere.jpg','Les armes de la lumi&egrave;re','Sarah Rivens','Livre broch&eacute; | Fran&ccedil;ais','&lt;p&gt;En cette fin de XVIIIe si&amp;egrave;cle, l&#039;Angleterre est dirig&amp;eacute;e par un gouvernement conservateur qui r&amp;eacute;prime toute tentative de r&amp;eacute;volte. De l&#039;autre c&amp;ocirc;t&amp;eacute; de la Manche, Napol&amp;eacute;on Bonaparte accro&amp;icirc;t inexorablement son pouvoir. Alors que la guerre est aux portes de l&#039;Europe, la vie des habitants de Kingsbridge est sur le point de basculer. Sal, fileuse t&amp;eacute;m&amp;eacute;raire, est t&amp;eacute;moin d&#039;un accident tragique qui va bouleverser sa vie. Le courageux Amos, drapier, qui a h&amp;eacute;rit&amp;eacute; pr&amp;eacute;matur&amp;eacute;ment du n&amp;eacute;goce de son p&amp;egrave;re, va devoir affronter le terrible Hornbeam pour rembourser ses dettes. Il sera aid&amp;eacute; de Spade, tisserand novateur, et encourag&amp;eacute; par la douce Elsie qui se bat pour financer une &amp;eacute;cole o&amp;ugrave; les enfants pauvres pourront apprendre &amp;agrave; lire et &amp;agrave; &amp;eacute;crire. Entre destins contrari&amp;eacute;s, jalousies meurtri&amp;egrave;res, justice arbitraire, guerre sanglante et r&amp;eacute;volution industrielle, Ken Follett d&amp;eacute;peint avec une virtuosit&amp;eacute; in&amp;eacute;gal&amp;eacute;e une g&amp;eacute;n&amp;eacute;ration qui incarne la lutte pour un avenir libre de toute oppression.&lt;/p&gt;',25.90,1,1),(10010,'assets/images/uploads/les-yeux-de-mona.jpg','Les yeux de Mona','Thomas Schlesser','Livre broch&eacute; | Fran&ccedil;ais','&lt;p&gt;Cinquante-deux semaines : c&#039;est le temps qu&#039;il reste &amp;agrave; Mona pour d&amp;eacute;couvrir toute la beaut&amp;eacute; du monde. C&#039;est le temps que s&#039;est donn&amp;eacute; son grand-p&amp;egrave;re, un homme &amp;eacute;rudit et fantasque, pour l&#039;initier, chaque mercredi apr&amp;egrave;s l&#039;&amp;eacute;cole, &amp;agrave; une &amp;oelig;uvre d&#039;art, avant qu&#039;elle ne perde, peut-&amp;ecirc;tre pour toujours, l&#039;usage de ses yeux. Ensemble, ils vont sillonner le Louvre, Orsay et Beaubourg. Ensemble, ils vont s&#039;&amp;eacute;merveiller, s&#039;&amp;eacute;mouvoir, s&#039;interroger, happ&amp;eacute;s par le spectacle d&#039;un tableau ou d&#039;une sculpture. Empruntant les regards de Botticelli, Vermeer, Goya, Courbet, Claudel, Kahlo ou Basquiat, Mona d&amp;eacute;couvre le pouvoir de l&#039;art et apprend le don, le doute, la m&amp;eacute;lancolie ou la r&amp;eacute;volte, un pr&amp;eacute;cieux tr&amp;eacute;sor que son grand-p&amp;egrave;re souhaite inscrire en elle &amp;agrave; jamais. Retrouvez les 52 chefs-d&#039;&amp;oelig;uvre &amp;agrave; l&#039;int&amp;eacute;rieur de la jaquette d&amp;eacute;pliable.&lt;/p&gt;',23.00,1,1),(10011,'assets/images/uploads/navoue jamais-jamais.jpg','N&#039;avoue jamais','Lisa Gardner','Livre broch&eacute; | Fran&ccedil;ais','&lt;p&gt;Un homme est abattu de trois coups de feu &amp;agrave; son domicile. Lorsque la police arrive sur place, elle d&amp;eacute;couvre sa femme, enceinte de cinq mois, l&#039;arme &amp;agrave; la main. Celle-ci n&#039;est pas une inconnue pour l&#039;enqu&amp;ecirc;trice D.D. Warren : accus&amp;eacute;e d&#039;avoir tu&amp;eacute; son p&amp;egrave;re d&#039;un coup de fusil &amp;agrave; l&#039;&amp;acirc;ge de seize ans, Evie a finalement &amp;eacute;t&amp;eacute; innocent&amp;eacute;e, la justice ayant conclu &amp;agrave; un accident. Simple co&amp;iuml;ncidence ? La principale suspecte est-elle coupable ou victime de son pass&amp;eacute; ? Ma&amp;icirc;tresse en mati&amp;egrave;re de suspense psychologique, Lisa Gardner signe l&#039;un de ses thrillers les plus ambitieux sur la famille et ses inavouables secrets.&lt;/p&gt;',10.00,0,1),(10012,'','Reminders of him','Colleen Hoover','Livre broch&eacute; | Fran&ccedil;ais','&lt;p&gt;Apr&amp;egrave;s avoir pass&amp;eacute; cinq ans en prison &amp;agrave; la suite d&#039;une tragique erreur, Kenna Rowan retourne dans la ville du drame avec la ferme intention de retrouver sa fille. Malgr&amp;eacute; les efforts qu&#039;elle d&amp;eacute;ploie pour refaire sa vie, tout le monde la rejette sauf Ledger Ward, propri&amp;eacute;taire d&#039;un bar local. Tous deux s&#039;attachent peu &amp;agrave; peu mais Kenna doit absoudre les erreurs du pass&amp;eacute; pour reconstruire son avenir.&lt;/p&gt;',18.60,0,1);
/*!40000 ALTER TABLE `livres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `papeteries`
--

DROP TABLE IF EXISTS `papeteries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `papeteries` (
  `idPapeterie` int NOT NULL AUTO_INCREMENT,
  `image_url` varchar(250) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `feature` varchar(100) DEFAULT NULL,
  `content` mediumtext,
  `price` decimal(5,2) NOT NULL,
  `active` tinyint unsigned DEFAULT '1',
  `idCategory` int NOT NULL DEFAULT '2',
  PRIMARY KEY (`idPapeterie`),
  UNIQUE KEY `idPapeterie_UNIQUE` (`idPapeterie`),
  UNIQUE KEY `idCategory_UNIQUE` (`idCategory`)
) ENGINE=InnoDB AUTO_INCREMENT=20002 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `papeteries`
--

LOCK TABLES `papeteries` WRITE;
/*!40000 ALTER TABLE `papeteries` DISABLE KEYS */;
INSERT INTO `papeteries` VALUES (20001,'assets\\images\\stationeries\\stabilo-crayons.jpg','Stabilo crayons de couleurs Aquacolor Arty étui carton 24 pces','Stabilo Aquacolor','STABILOaquacolor® ARTY étui carton 24 pcs. STABILOaquacolor est un crayon de couleur entièrement aquarellable de haute qualité.Issu du savoir-faire be...',20.40,1,2);
/*!40000 ALTER TABLE `papeteries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_category` (
  `idCategory` int NOT NULL,
  `nameOfCategory` varchar(45) NOT NULL,
  PRIMARY KEY (`idCategory`),
  UNIQUE KEY `idProductCategory_UNIQUE` (`idCategory`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` VALUES (1,'Livre'),(2,'Papeterie'),(3,'Cadeau');
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `passwd` varchar(250) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `idUser_UNIQUE` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'lejeune@mail.com','130580'),(2,'pierre@mail.com','100578');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-24 12:33:16
