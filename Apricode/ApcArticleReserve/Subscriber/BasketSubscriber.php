<?php

namespace ApcArticleReserve\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Shopware\Components\Model\ModelManager;

class BasketSubscriber implements SubscriberInterface
{

    private $pluginDir = null;

    private $component = null;

    public function __construct($pluginBaseDirectory){
        $this->pluginDir = $pluginBaseDirectory;
        $this->component = Shopware()->Container()->get('apc_article_reserve.reservation_component');
    }
   /**
    * @return array
    */
    public static function getSubscribedEvents(){
        return [
			'Shopware_Modules_Basket_AddArticle_Added' => 'onArticleAdded',
            'sBasket::sUpdateArticle::replace' => 'onArticleUpdate',
            'sBasket::sCheckBasketQuantities::replace' => 'onBasketQuantityCheck',
            'sBasket::sDeleteArticle::before' => 'onBasketItemDelete',
            'Shopware_Controllers_Frontend_Checkout::getInstockInfo::replace' => 'onBasketGetInStock',
            'sOrder::sSaveOrder::after' => 'onSaveOrder',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onPostDispatchFrontend',
            'Enlight_Controller_Action_PostDispatchSecure_Widgets' => 'onPostDispatchFrontend',
            'product_stock_was_changed' => 'onOrderStockChange',
            'Shopware_Modules_Admin_Regenerate_Session_Id' => 'onRegenerateSessionId',
            'Shopware_Modules_Basket_GetBasket_FilterSQL' => 'onGetBasketFilterSql',
            'Shopware_CronJob_ApcReserveCronjob' => 'onReservedPluginCron'
        ];
    }

	public function onGetBasketFilterSql(\Enlight_Event_EventArgs $args) {
		$sql = "
			SELECT
				s_order_basket.*,
				COALESCE (NULLIF(ad.packunit, ''), mad.packunit) AS packunit,
				a.main_detail_id AS mainDetailId,
				ad.id AS articleDetailId,
				ad.minpurchase,
				a.taxID,
				ad.instock + apc.quantity AS instock,
				ad.suppliernumber,
				ad.maxpurchase,
				ad.purchasesteps,
				ad.purchaseunit,
				COALESCE (ad.unitID, mad.unitID) AS unitID,
				ad.laststock,
				ad.shippingtime,
				ad.releasedate,
				ad.releasedate AS sReleaseDate,
				COALESCE (ad.ean, mad.ean) AS ean,
				ad.stockmin,
				s_order_basket_attributes.attribute1 as ob_attr1,
				s_order_basket_attributes.attribute2 as ob_attr2,
				s_order_basket_attributes.attribute3 as ob_attr3,
				s_order_basket_attributes.attribute4 as ob_attr4,
				s_order_basket_attributes.attribute5 as ob_attr5,
				s_order_basket_attributes.attribute6 as ob_attr6
			FROM s_order_basket
			LEFT JOIN s_articles_details AS ad ON ad.ordernumber = s_order_basket.ordernumber
			LEFT JOIN s_articles a ON (a.id = ad.articleID)
			LEFT JOIN s_articles_details AS mad ON mad.id = a.main_detail_id
			LEFT JOIN s_order_basket_attributes ON s_order_basket.id = s_order_basket_attributes.basketID
			LEFT JOIN apc_reserve apc ON apc.basket_id = s_order_basket.id
			WHERE sessionID=?
			ORDER BY id ASC, datum DESC
			";

		return $sql;
	}

	public function onRegenerateSessionId(\Enlight_Event_EventArgs $args) {
		$oldSessionId = $args->get('oldSessionId');
		$newSessionId = $args->get('newSessionId');

		$sql = "UPDATE `apc_reserve`
				SET
				`session` = :newSessionId
				WHERE
				`session` = :oldSessionId
		;";

		Shopware()->Db()->query($sql,['oldSessionId' => $oldSessionId, 'newSessionId' => $newSessionId]);
	}

	public function onOrderStockChange(\Enlight_Event_EventArgs $args) {
		Shopware()->Db()->executeUpdate('
            UPDATE s_articles_details
            SET
			instock = instock + :quantity
            WHERE ordernumber = :number',
            [':quantity' => $args->getQuantity(), ':number' => $args->getNumber()]
        );
	}

    public function onPostDispatchFrontend(\Enlight_Event_EventArgs $args){
        $args->getSubject()->View()->addTemplateDir($this->pluginDir . '/Resources/views/');
    }

	public function onArticleAdded(\Enlight_Event_EventArgs $args) {
		$basketItemId = $args->getId();
        $sql = 'SELECT `ordernumber`, `quantity` FROM `s_order_basket` WHERE `id` = ?';
        $data = Shopware()->Db()->fetchRow($sql,$basketItemId);
        $sql = 'INSERT INTO `apc_reserve` SET
                        `basket_id` = ?,
                        `ordernumber` = ?,
                        `quantity` = ?,
                        `session` = ? ;
        ';
        $sessionId = Shopware()->Session()->get('sessionId');
        Shopware()->Db()->query($sql,[$basketItemId,$data['ordernumber'],$data['quantity'],$sessionId]);
        $this->component->decreaseQuantity($data['ordernumber'],$data['quantity']);
        Shopware()->Front()->Request()->setParam('sQuantity',0);
        Shopware()->Events()->notify('Shopware_Plugins_HttpCache_ClearCache');
	}

    public function onArticleUpdate(\Enlight_Event_EventArgs $args){
		list($id, $quantity) = $args->getArgs();

		$sql = "SELECT `quantity`, `ordernumber` FROM `apc_reserve` WHERE `basket_id` = ? ;";

        $data = Shopware()->Db()->fetchRow($sql,$id);

        $oldQuantity = $data['quantity'];
        $ordernumber = $data['ordernumber'];

		$oldQuantity = (int) $oldQuantity;

		$sql = "SELECT `instock` FROM `s_articles_details` WHERE `ordernumber` = ? ;";

		$inStock = Shopware()->Db()->fetchOne($sql,$ordernumber);
		$params = Shopware()->Front()->Request()->getParams();

		$requestedQuantity = $params['sQuantity']?$params['sQuantity']:0;
		if($requestedQuantity > $inStock) {
			$requestedQuantity = $inStock;
		}

		$finalQuantity = $oldQuantity + $requestedQuantity;
        $actionName = Shopware()->Front()->Request()->getActionName();
        if($actionName == 'ajaxAddArticleCart'){
            $args->getSubject()->executeParent($args->getMethod(),[$id, $finalQuantity]);
            $sql = 'UPDATE `apc_reserve` SET `quantity` = ? WHERE `basket_id` = ? ;';
            Shopware()->Db()->query($sql,[$finalQuantity,$id]);
            $this->component->decreaseQuantity($ordernumber,$requestedQuantity);
        }elseif($actionName == 'changeQuantity'){
			$requestedQuantity = $params['sQuantity']?$params['sQuantity']:0;
			if($requestedQuantity > $inStock + $oldQuantity) {
				$requestedQuantity = $inStock + $oldQuantity;
			}
            $args->getSubject()->executeParent($args->getMethod(),[$id, $requestedQuantity]);
            $sql = 'UPDATE `apc_reserve` SET `quantity` = ? WHERE `basket_id` = ? ;';
            Shopware()->Db()->query($sql,[$requestedQuantity,$id]);
            $quantDif = $requestedQuantity - $oldQuantity;
            $this->component->decreaseQuantity($ordernumber,$quantDif);
        }else{
            $args->getSubject()->executeParent($args->getMethod(),[$id, $oldQuantity]);
        }

    }

    public function onBasketItemDelete(\Enlight_Hook_HookArgs $args){
        $params = $args->getArgs();
        $id = $params[0];
		$sessionId = Shopware()->Session()->get('sessionId');

        $sql = 'SELECT * FROM `apc_reserve` WHERE `basket_id` = ? AND `session` = ? ;';
        $data = Shopware()->Db()->fetchRow($sql,[$id, $sessionId]);

        if(!empty($data)){
            $this->component->removeReservation($data);
        }
    }


    public function onBasketGetInStock(\Enlight_Hook_HookArgs $args){
        list($orderNumber, $quantity) = $args->getArgs();

        if (empty($orderNumber)){
            $args->setReturn(Shopware()->Snippets()->getNamespace('frontend')->get('CheckoutSelectVariant',
                'Please select an option to place the required product in the cart', true));
        }else{
            $quantity = max(1, (int) $quantity);
            $inStock = $args->getSubject()->getAvailableStock($orderNumber);
            $inStock['quantity'] += $quantity;
            $reservedQuantity = $this->component->getUserBasketQuantity($orderNumber);
            $inStock['instock'] += $reservedQuantity;
            if (empty($inStock['articleID'])) {
                $args->setReturn(Shopware()->Snippets()->getNamespace('frontend')->get('CheckoutArticleNotFound',
                    'Product could not be found.', true));
            }
            if (!empty($inStock['laststock']) || !empty(Shopware()->Config()->InstockInfo)) {
                if ($inStock['instock'] <= 0 && !empty($inStock['laststock'])) {
                    $args->setReturn(Shopware()->Snippets()->getNamespace('frontend')->get('CheckoutArticleNoStock',
                        'Unfortunately we can not deliver the desired product in sufficient quantity', true));
                } elseif ($inStock['instock'] < $inStock['quantity']) {
                    $result = 'Unfortunately we can not deliver the desired product in sufficient quantity. (#0 of #1 in stock).';
                    $result = Shopware()->Snippets()->getNamespace('frontend')->get('CheckoutArticleLessStock', $result,
                        true);
                    $args->setReturn(str_replace(['#0', '#1'], [$inStock['instock'], $inStock['quantity']], $result));
                }
            }else{
                $args->setReturn(null);
            }
        }
    }

    public function onBasketQuantityCheck(\Enlight_Hook_HookArgs $args){
        $result = Shopware()->Db()->fetchAll(
            'SELECT (d.instock - b.quantity + apc.quantity) as diffStock, b.ordernumber,
                d.laststock, IF(a.active=1, d.active, 0) as active
            FROM s_order_basket b
            LEFT JOIN s_articles_details d
              ON d.ordernumber = b.ordernumber
              AND d.articleID = b.articleID
            LEFT JOIN s_articles a
              ON a.id = d.articleID
            LEFT JOIN apc_reserve apc
                ON d.ordernumber = apc.ordernumber
            WHERE b.sessionID = ?
              AND b.modus = 0
            GROUP BY b.ordernumber',
            [Shopware()->Session()->get('sessionId')]
        );
        $hideBasket = false;
        foreach ($result as $article) {
            if (empty($article['active'])
              || (!empty($article['laststock']) && $article['diffStock'] < 0)
            ) {
                $hideBasket = true;
                $articles[$article['ordernumber']]['OutOfStock'] = true;
            } else {
                $articles[$article['ordernumber']]['OutOfStock'] = false;
            }
        }
        $return = ['hideBasket' => $hideBasket, 'articles' => $articles];

        $args->setReturn($return);
    }

    public function onSaveOrder(\Enlight_Hook_HookArgs $args){
        $orderNumber = $args->getReturn();
        if(empty($orderNumber)) {
			return;
		}

        $sql = 'DELETE * FROM `apc_reserve` WHERE `session` = ?;';
        Shopware()->Db()->fetchAll($sql,Shopware()->Session()->get('sessionId'));
    }

    public function onReservedPluginCron(\Shopware_Components_Cron_CronJob $job){
       $this->component->checkExpiration();
   }

}
