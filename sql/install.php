<?php 

$sql_requests = array();

// CREATION DE LA TABLE CATEGORY_ARTICLE

$sql_requests[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'download_module`(
					id_download_module INT(10) NOT NULL AUTO_INCREMENT,
					date_add DATETIME NOT NULL,
					lang INT(10) NOT NULL,
					nom_fichier VARCHAR(128) NOT NULL,					
					description VARCHAR(128) NOT NULL,
					type_fichier VARCHAR(128) NOT NULL,
			  		url VARCHAR(128) NOT NULL,
					active VARCHAR(10) NOT NULL,
				    PRIMARY KEY (`id_download_module`)
					)
   					ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';
