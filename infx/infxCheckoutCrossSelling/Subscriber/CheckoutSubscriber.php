<?php

namespace infxCheckoutCrossSelling\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;

class CheckoutSubscriber implements SubscriberInterface
{
    private $pluginDir = null;

    public function __construct($pluginBaseDirectory)
    {
        $this->pluginDir = $pluginBaseDirectory;
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onCheckoutAddArticle',
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
    public function onCheckoutAddArticle(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();


        $actionName = $request->getActionName();
        if($actionName == 'ajax_add_article'){
            $view = $controller->View();
            $view->addTemplateDir($this->pluginDir.'/Resources/views/');
            $id = $view->sArticle['articleID'];

            $articleData = Shopware()->Modules()->Articles()->sGetArticleById($id);

            if(empty($articleData['sRelatedArticles'])){
                return;
            }



            $view->accessoryArticles = $articleData['sRelatedArticles'];
            return;
      }

      if($actionName == 'finish'){
          $view = $controller->View();
          $view->addTemplateDir($this->pluginDir.'/Resources/views/');
          $basket = $view->sBasket;
          $accessoryArticles = [];
          $sArticles = Shopware()->Modules()->Articles();
          foreach($basket['content'] as $article){
              $articleData = $sArticles->sGetArticleById($article['articleID']);
              $accessoryArticles = array_merge($accessoryArticles, $articleData['sRelatedArticles']);
              $accessoryArticles = array_intersect_key($accessoryArticles, array_unique(array_map('serialize', $accessoryArticles)));
          }
          if(empty($accessoryArticles)){
              return;
          }
          $view->accessoryArticles = $accessoryArticles;

      }

    }


}
