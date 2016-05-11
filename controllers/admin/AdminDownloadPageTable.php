<?php

class AdminDownloadPageTableController extends ModuleAdminController 
{

    public function __construct()
    {
            
        $this->bootstrap = true;    
            
        $this->table = 'download_module';
        $this->className = 'DownloadModule';
        $this->lang = false;
        $this->noLink = true;
        $this->context = Context::getContext();

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?')
                )
            );      


        parent::__construct();
        
    }

    public function renderList()
    {
        $this->addRowAction('edit');

        /* @TODO supprimer l'image quand on clique sur delete*/
        $this->addRowAction('delete');
        
        $this->addRowAction('details');

            $this->fields_list = array(
            'id_download_module' => array(
                'title' => $this->l('ID téléchargement'),
                'type' => 'int',
            ),
            'nom_fichier' => array(
                'title' => $this->l('Nom du fichier'),
                'align' => 'center',
                'type' => 'text',
            ),  
            'description' => array(
                'title' => $this->l('Description du fichier'),
                'align' => 'center',
                'type' => 'text',
            ),  
            'lang_iso' => array(
                'title' => $this->l('Langue'),
                'align' => 'center',
                'type' => 'text',
            ),  
            'date_add' => array(
                'title' => $this->l('Date d\'ajout'),
                'align' => 'center',
                'type' => 'datetime',
            ),    
        );

        $this->list_no_link = false;

            $this->_select .= 'CONCAT(l.iso_code) lang_iso';
            $this->_join .= ' INNER JOIN '._DB_PREFIX_.'lang l ON (a.lang = l.id_lang)';

        $lists = parent::renderList();

        parent::initToolbar();

        return $lists;
    }


    public function renderForm()
    {
        global $cookie;

        /* POUR LE CHOIX DE LA LANGUE */
        $languages = Language::getLanguages(true);

        $options = array();
        foreach($languages as $language) {
            $options[] = array(
                    "lang" => (int)$language['id_lang'],
                    "name" => strtoupper($language['iso_code'])
            );
        }

        $this->fields_form = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('Ajouter un téléchargement'),
                'image' => '../img/admin/add.gif'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Nom fichier :'),
                    'name' => 'nom_fichier',
                    'required' => true,
                    'size' => 128
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Description :'),
                    'name' => 'description',
                    'required' => true,
                    'size' => 128
                ),
                array(
                    'type' => 'file_lang',
                    'label' => $this->l('Upload fichier'),
                    'name' => 'telechargement',
                    'desc' => $this->l('Télécharger un fichier pdf, ou une image au format png/jpeg'),
                    'required' => true
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'type_fichier',
                    'required' => true,
                ),
                array(
                    'type' => 'text',
                    'name' => 'url',
                    'required' => true,

                ),
                array(
                  'type' => 'select',                              // This is a <select> tag.
                  'label' => $this->l('Choix de langue :'),         // The <label> for this <select> tag.
                  'name' => 'lang',                     // The content of the 'id' attribute of the <select> tag.
                  'required' => true,                              // If set to true, this option must be set.
                  'options' => array(
                    'query' => $options,                           // $options contains the data itself.
                    'id' => 'lang',                           // The value of the 'id' key must be the same as the key for 'value' attribute of the <option> tag in each $options sub-array.
                    'name' => 'name'                               // The value of the 'name' key must be the same as the key for the text content of the <option> tag in each $options sub-array.
                  )
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Affiché'),
                    'name' => 'active',
                    'required' => true,
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'button'
            )
        );
        if (!($obj = $this->loadObject(true))) {
            return;
        }


        return parent::renderForm();
    }


    public function postProcess(){
        if(Tools::isSubmit('nom_fichier')){
            //je recupere les langues

                if(isset($_FILES['telechargement'])                   
                    && isset($_FILES['telechargement']['tmp_name'])
                    && !empty($_FILES['telechargement']['tmp_name'])){

                        $fichier = $_FILES['telechargement'];
                        //Pour récupérer l'extension
                        $extensions = array('.png', '.jpg', '.jpeg', '.pdf');
                        $extension = strrchr($fichier['name'], '.');
                        //taille du fichier 
                        $taille = filesize($fichier['tmp_name']);

                        //si dans le tableau
                        if(!in_array($extension, $extensions)){
                            $this->errors[] = Tools::displayError('Mauvais format de fichier !');
                        }
                        if($taille>4000000){
                            $this->errors[] = Tools::displayError('Le fichier dépasse la taille de fichier!');
                        }
                        if(!isset($errors)){
                        
                        $file_name = Tools::getValue('nom_fichier').'_'.md5($fichier['name']).'_1'.$extension;

                          if(move_uploaded_file($fichier['tmp_name'], _PS_ROOT_DIR_.'/modules/downloadpage/upload/'.$file_name)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                         {
                            //on rentre l'URL et le type de fichier
                            $_POST["url"] = $file_name;
                            $_POST["type_fichier"] = $fichier['type'];
                         }  
                         else{
                            d('erreur upload fichier');
                         }

                    }
                }
            
        }
        return parent::postProcess();

    }

}

