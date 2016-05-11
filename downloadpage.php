<?php 

require_once(dirname(__FILE__).'/classes/DownloadModule.php');
  

if (!defined('_PS_VERSION_'))
  exit;


class DownloadPage extends Module
{

    public function __construct()
    {

        // Construction du module   

        $this->name = 'downloadpage'; // nom du module qui doit être le nom du dossier du module
        $this->tab = 'front_office_features'; // Dans quelle tabulation le module sera affiché
        $this->version = '1.0.0';
        $this->author = 'Jeremie Zipfel';

        $this->need_instance = 0; // 1 : le module est chargé sur la page "Modules" et permet d'afficher un message d'alerte si nécessaire
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);  // Versions de PS Compatibles
        $this->bootstrap = true; // Chargement de bootstrap ou non


        parent::__construct();


        $this->displayName = $this->l('Module page téléchargement'); // Nom du module
        $this->description = $this->l('Ajoute une page téléchargement en front, avec un système d\'administration backoffice'); // Description du module

        $this->confirmUninstall = $this->l('Voulez-vous vraiment désinstaller le module Page Téléchargement ?'); // Message d'alerte en cas de désinstallation

        // Vous pouvez ajouter une icone PNG en 32x32px que vous appelerez logo.png

    }

    public function install()
    {
        if (!parent::install() ||
            !$this->installSql() ||
            !$this->registerHook('ActionAdminControllerSetMedia') ||
            !$this->installTab(0,'AdminDownloadPage' ,$this->l('Téléchargements généraux')) ||
            !$this->installTab('AdminDownloadPage','AdminDownloadPageTable' ,$this->l('Liste des téléchargements')) 
        )
        {return false;}

        else{

            // Creation du lien vers le blog, MERCI ALEXIS MESNARD POUR L'ASTUCE 
            require_once (_PS_ROOT_DIR_.'/modules/blocktopmenu/menutoplinks.class.php');
            $link=$this->context->link->getModuleLink('downloadpage', 'display', array());

                foreach (Language::getLanguages(true) as $lang){
                    $links[$lang['id_lang']]=$link;
                    $labels[$lang['id_lang']]=$this->l('Download');
                }

            MenuTopLinks::add($links, $labels, 0, 1);
            // A defaut d'obtenir directement l'id ...
            $menulinks = MenuTopLinks::gets($this->context->language->id, null, $this->context->shop->id);
            $menulink = end($menulinks);

            // Assignation du lien au top menu
            $menuItems = Configuration::get('MOD_BLOCKTOPMENU_ITEMS');
            $menuItems_arr = explode(',', $menuItems);
            $menuItems_arr[]= 'LNK'.$menulink['id_linksmenutop'];
            $menuItems = implode(',', $menuItems_arr);
            Configuration::updateValue('MOD_BLOCKTOPMENU_ITEMS', $menuItems);

            // Creation des options du module
            Configuration::updateValue('MB_ID_TOPMENU', $menulink['id_linksmenutop']);

            }

         return true;
    }

    public function uninstall() 
    {
        if(!parent::uninstall() ||
            !$this->uninstallSql() ||
            !$this->uninstallTab('AdminDownloadPage') ||
            !$this->uninstallTab('AdminDownloadPageTable')
        ) 
    {return false;}
        else {
            //suppression link  MERCI ALEXIS MESNARD POUR L'ASTUCE 
            $id_link = Configuration::get('MB_ID_TOPMENU');
            require_once (_PS_ROOT_DIR_.'/modules/blocktopmenu/menutoplinks.class.php');
            MenuTopLinks::remove($id_link, $this->context->shop->id);

            // Suppression du lien du menu
            $menuItems = Configuration::get('MOD_BLOCKTOPMENU_ITEMS');
            $menuItems_arr = explode(',', $menuItems);
            $key = array_search('LNK'.$id_link, $menuItems_arr);
            if($key){
                unset($menuItems_arr[$key]);
                $menuItems = implode(',', $menuItems_arr);
                Configuration::updateValue('MOD_BLOCKTOPMENU_ITEMS', $menuItems);
            }
            // Suppression des options du module
            Configuration::deleteByName('MB_ID_TOPMENU');
        }
        return true;

    }

    private function installSql()
    {
        include(dirname(__FILE__).'/sql/install.php');
        $result = true;
        foreach ($sql_requests as $request){
            if (!empty($request))
            $result &= Db::getInstance()->execute(trim($request));

        }

        return $result;
    }

    private function uninstallSql()
    {
        include(dirname(__FILE__).'/sql/uninstall.php');

        $result = true;

        foreach ($sql_requests as $request){
            if (!empty($request))
            $result &= Db::getInstance()->execute(trim($request));
        }

        return $result;
    }

    private function installTab($parent, $class_name, $name)
    {

        $tab = new Tab();
        $tab->id_parent = (int)Tab::getIdFromClassName($parent);
        $tab->class_name = $class_name;
        $tab->module = $this->name;

        $tab->name = array();

        foreach (Language::getLanguages(true) as $lang){
            $tab->name[$lang['id_lang']] = $name;
        }

        return $tab->save();
    }

    private function uninstallTab($class_name)
    {
        $idTab = (int)Tab::getIdFromClassName($class_name);
        $tab = new Tab($idTab);
        return $tab->delete();
    }   


    public function hookActionAdminControllerSetMedia()
    {
        $this->context->controller->addCSS(($this->_path).'views/css/downloadpage.css', 'all');
    }




 

}