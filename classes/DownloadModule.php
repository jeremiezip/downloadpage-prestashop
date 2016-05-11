<?php

class DownloadModule extends ObjectModel {


    public $description;
    public $date_add;
    public $url;
    public $active;
    public $nom_fichier;
    public $type_fichier;
    public $lang;



	/**
	 * @see ObjectModel::$definition
     * @todo Bon type de validate
	 */

	public static $definition = array(
		'table' => 'download_module',
		'primary' => 'id_download_module',
		'fields' => array(
	            'description' =>                array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128),
	            'url' =>                array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128),
	            'type_fichier' =>                array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128),
	            'nom_fichier' =>                array('type' => self::TYPE_STRING, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128),
	            'lang'  =>                  array('type' => self::TYPE_INT, 'required' => true),
	            'date_add' =>       array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
	            'active' =>            array('type' => self::TYPE_BOOL,'validate' => 'isBool', 'required' => true),
	        ),
	);

    public static function getDownload($id_lang){
        return Db::getInstance()->executeS('SELECT * FROM '._DB_PREFIX_.'download_module
                                            WHERE lang ='.$id_lang.'');
    }

    public static function getAllRefProduct()
    {
        return Db::getInstance()->executeS('
        SELECT DISTINCT p.`id_product`, p.`reference`
        FROM `'._DB_PREFIX_.'product` p
        INNER JOIN `'._DB_PREFIX_.'product_attachment` pa ON p.`id_product` = pa.`id_product`
        WHERE p.active = 1');

    }

}
