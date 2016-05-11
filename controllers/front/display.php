<?php
class downloadpagedisplayModuleFrontController extends ModuleFrontController
{

    /**
     * Assign template vars related to page content
     * @see FrontController::initContent()
     */
	public function initContent()
	{
		// PAR DEFAUT DESACTIVER COLONNE DE GAUCHE ET DE DROITE
  		$this->display_column_left = false;
  		$this->display_column_right = false;

		  parent::initContent();

      // VIEW LISTE DOWNLOAD GENERAUX
      $this->viewDownloadList();
      // DISPLAY IF AJAX
      if (Tools::getValue('id_product')){
        $this->ajaxDownloadProduct();
      }
      /*select ref product pour al liste */
      $products = DownloadModule:: getAllRefProduct();

     /* display des téléchargements généraux */
      $this->context->smarty->assign(array('products' => $products));     
      // VIEW GENERAL FRONT
      $this->setTemplate('downloadpage_front.tpl');      
	}

  public function setMedia(){
    parent::setMedia();
    $this->addJS(_MODULE_DIR_.'downloadpage/views/js/downloadpage.js', 'all');
    $this->addCSS(_MODULE_DIR_.'downloadpage/views/css/downloadpage.css', 'all');
  }

  public function viewDownloadList(){

    $downloads = DownloadModule::getDownload((int)$this->context->language->id,(int)$this->context->shop->id);
    $chemin_img = $this->context->link->getModuleLink('downloadpage', 'display');


    /* display des téléchargements généraux */
    $this->context->smarty->assign(array('downloads' => $downloads,
                                    'chemin_img' => $chemin_img));
  }

  public function ajaxDownloadProduct(){
    $product = new Product(Tools::getValue('id_product'), false, (int)$this->context->language->id,(int)$this->context->shop->id);

      $this->context->smarty->assign(array(   'attachments' => (($product->cache_has_attachments) ? $product->getAttachments((int)$this->context->language->id) : array()),
        'ajax' => 1
    ));

    echo ($this->context->smarty->fetch(_PS_MODULE_DIR_ .'downloadpage/views/templates/front/downloadpage_product.tpl'));

  }

}