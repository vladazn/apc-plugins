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
class Shopware_Controllers_Backend_ApcDelivery extends Enlight_Controller_Action implements CSRFWhitelistAware {

    private $component = null;
    private $db = null;

    public function preDispatch() {
        $this->get('template')->addTemplateDir(__DIR__ . '/../../Resources/views/');
    }

    public function init() {
        $this->component = Shopware()->Container()->get('apc_route_delivery.zip_component');
        $this->db = Shopware()->Db();
    }

    public function postDispatch() {
        $csrfToken = $this->container->get('BackendSession')->offsetGet('X-CSRF-Token');
        $this->View()->assign([ 'csrfToken' => $csrfToken ]);
    }

    public function indexAction() {

        $this->handleIndexRequest($this->Request());

        $sql = 'SELECT * FROM `apc_routes` WHERE `active` = ?;';
        $this->View()->assign('activeRoutes',$this->db->fetchAll($sql,1));
        $this->View()->assign('inactiveRoutes',$this->db->fetchAll($sql,0));
    }

    public function routeAction() {

        $routeId = $this->handleRouteRequest($this->Request());

        $route = $this->db->fetchRow('SELECT * FROM `apc_routes` WHERE `id` = ?;',$routeId);
        $dates = Shopware()->Db()->fetchCol('SELECT `date` FROM `apc_routes_dates` WHERE `route_id` = ?',$routeId);
        $zip = $this->component->prepareZipList($routeId);
        $this->View()->assign('route',$route);
        $this->View()->assign('dates',$dates);
        $this->View()->assign('zip',$zip);
    }

    public function ordersAction() {
        $routeId = $this->Request()->getParam('routeId');

        $orders = $this->component->getRouteOrders($routeId);

        foreach($orders as $order){
            $total[$order['product']] += (int)$order['quantity'];
        }
        $this->View()->assign('orders',$orders);
        $this->View()->assign('totals',$total);
    }

    private function handleIndexRequest($request){
        $activate = $request->getParam('activate');
        $deactivate = $request->getParam('deactivate');
        $new = $request->getParam('newroute');
        $updateSql = 'UPDATE `apc_routes` SET `active` = ? WHERE `id` = ?;';
        if($activate){
            $this->db->query($updateSql,[1,$activate]);
            $this->component->reassignOrders($activate);
        }
        if($deactivate){
            $this->db->query($updateSql,[0,$deactivate]);
            $this->component->reassignOrders($deactivate);
        }
        if($new){
            $this->component->createRoute($new);
        }
    }

    private function handleRouteRequest($request){
        $routeId = $this->Request()->getParam('routeId');
        $changes = $this->Request()->getParam('changes');
        $zipCodes = $this->Request()->getParam('zip');
        if($changes){
            $changes['routeId'] = $routeId;
            $this->component->updateRouteInfo($changes);
        }
        if($zipCodes){
            $this->component->updateRouteZip($routeId, $zipCodes);
        }

        return $routeId;
    }

    public function getWhitelistedCSRFActions() {
        return ['index','route','orders'];
    }
}
