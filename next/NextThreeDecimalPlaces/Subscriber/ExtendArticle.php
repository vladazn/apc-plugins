<?php

namespace NextThreeDecimalPlaces\Subscriber;

use Enlight\Event\SubscriberInterface;

class ExtendArticle implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDirectory;

    /**
     * @param $pluginDirectory
     */
    public function __construct($pluginDirectory)
    {
        $this->pluginDirectory = $pluginDirectory;
    }
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Backend_Article' => 'onArticlePostDispatch',
            'Enlight_Controller_Action_PostDispatchSecure_Backend_ArticleList' => 'onArticleListPostDispatch',
			'SwagMultiEdit_Product_DqlHelper_getColumnsForProductListing_filterColumns'  => 'onFilterColumns'
        ];
    }

	public function onFilterColumns(\Enlight_Event_EventArgs $args) {
		$result = $args->getReturn();
		$result['PricePrice']['selectClause'] = 'ROUND(s_articles_prices.price*(100+s_core_tax.tax)/100,3)';
		$args->setReturn($result);
	}

	public function onArticleListPostDispatch(\Enlight_Event_EventArgs $args) {
		/** @var \Shopware_Controllers_Backend_Customer $controller */
        $controller = $args->getSubject();

        $view = $controller->View();
        $request = $controller->Request();

        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');

        if ($request->getActionName() == 'load') {
            $view->extendsTemplate('backend/next_three_decimal_places/view/main/grid.js');
        }
	}

    public function onArticlePostDispatch(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Backend_Customer $controller */
        $controller = $args->getSubject();

        $view = $controller->View();
        $request = $controller->Request();

        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');

        if ($request->getActionName() == 'load') {
            $view->extendsTemplate('backend/next_three_decimal_places/view/detail/prices.js');
            $view->extendsTemplate('backend/next_three_decimal_places/view/variant/list.js');
        }

    }
}
