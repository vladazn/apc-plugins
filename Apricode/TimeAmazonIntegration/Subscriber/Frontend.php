<?php

namespace TimeAmazonIntegration\Subscriber;
use \Enlight\Event\SubscriberInterface;
use \Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query;
use TimeAmazonIntegration\Components\Orders;
use TimeAmazonIntegration\Components\ApiClient;
use TimeAmazonIntegration\Components\ShopwareOrder;
use Shopware\Models\Order\Order;




class Frontend implements SubscriberInterface {

    private $container;
    private $urlBuilder = NULL;
	private $dataTransformer = NULL;
    private $mErrors = array();

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public static function getSubscribedEvents() {
        return array(
          // 'Enlight_Controller_Action_PreDispatch_Frontend' => 'onFront'
        );
    }


    public function onFront(\Enlight_Event_EventArgs $args)
    {

        // $this->postEsd();exit;
        // Shopware()->Events()->notify('Shopware_CronJob_ApcAmazonSync');
        // Shopware()->Events()->notify('Shopware_CronJob_ApcAmazonStatusSync');
    }

}
