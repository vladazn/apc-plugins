<?php

namespace NextThreeDecimalPlaces\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;

class DecimalSubscriber implements SubscriberInterface
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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontendDispatch',
            'Enlight_Controller_Action_PreDispatch_Frontend' => 'onFrontendPreDispatch'
        ];
    }
	
	
	public function onFrontendPreDispatch(\Enlight_Event_EventArgs $args) {
		$template = Shopware()->Container()->get('template');
		$dirs = $template->getPluginsDir();
		array_unshift($dirs, $this->pluginDir . '/Resources/smarty/plugins'); 
        $template->setPluginsDir($dirs);
	}
	
    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
    public function onFrontendDispatch(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();

        $view = $controller->View();

        $articles = $view->sArticles;
        $singleArticle = $view->sArticle;
        if(!empty($articles)){

            foreach($articles as &$article){
                $article['price'] = $article['price_numeric'];
                $article['pseudoprice'] = $article['pseudoprice_numeric'];

                foreach($article['prices'] as &$prices){
                    $prices['price'] = $prices['price_numeric'];
                    $prices['pseudoprice'] = $prices['pseudoprice_numeric'];
                }
            }


            $view->sArticles = $articles;
            return;
        }
        if(!empty($singleArticle)){

            $singleArticle['price'] = $singleArticle['price_numeric'];
            $singleArticle['pseudoprice'] = $singleArticle['pseudoprice_numeric'];

            $view->sArticle = $singleArticle;
            return;
        }
    }


}
