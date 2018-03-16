<?php

class Shopware_Controllers_Widgets_GcCategoryController extends Enlight_Controller_Action {

   public function indexAction(){
       
       $id = $this->Request()->getParam('categoryId');
       
       $sql = "SELECT `description` FROM `s_categories` WHERE `id` = ? ;";
       
       $categoryName = Shopware()->Db()->fetchOne($sql,$id);
       
       $this->View()->assign('categoryName',$categoryName);
       
   }

}

?>