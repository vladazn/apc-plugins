<?php
use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr\Join;
use Shopware\Components\CSRFWhitelistAware;
use ApcSubscription\Models\SubscriptionDetails;

/*
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Shopware_Controllers_Backend_ApcLabels extends Enlight_Controller_Action implements CSRFWhitelistAware {

    private $component = null;
    private $db = null;

    public function preDispatch() {
        $this->get('template')->addTemplateDir(__DIR__ . '/../../Resources/views/');
    }

    public function init() {
        $this->component = Shopware()->Container()->get('apc_nicelabel.label_component');
        $this->db = Shopware()->Db();
    }

    public function postDispatch() {
        $csrfToken = $this->container->get('BackendSession')->offsetGet('X-CSRF-Token');
        $this->View()->assign([ 'csrfToken' => $csrfToken ]);
    }

    public function indexAction() {
        $orderStatus = $this->getStatusList('state');
        $paymentStatus = $this->getStatusList('payment');
        $this->View()->assign('orderStatus', $orderStatus);
        $this->View()->assign('paymentStatus', $paymentStatus);
    }
   
    public function updateAction(){

        $params = $this->Request()->getParam('nicelablel');

        $articles = $this->component->getArticleInitData($params['order_status'], $params['payment_status'], $params['date_from'], $params['date_to']);
        $this->component->clearTable();

        foreach($articles as $article){
            $this->component->insertArticleInfo($article);
        }


    }

    private function getStatusList($state){
        $sql = 'SELECT `id`, `description` FROM `s_core_states` WHERE `group` = ?;';
        return $this->db->fetchAll($sql,$state);
    }

    public function getWhitelistedCSRFActions() {
        return ['index', 'update'];
    }
}
