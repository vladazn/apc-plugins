<?php
use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr\Join;
use Shopware\Components\CSRFWhitelistAware;
/*
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Shopware_Controllers_Backend_ApcAmazon extends Enlight_Controller_Action implements CSRFWhitelistAware {


    private $component = null;
    private $db = null;
    public function preDispatch() {
        $this->get('template')->addTemplateDir(__DIR__ . '/../../Resources/views/');
    }

    public function init() {
        $this->db = Shopware()->Db();
    }

    public function postDispatch() {
        $sql = 'SELECT `id`, `name` FROM `s_core_shops`;';
        $this->View()->assign([ 'shops' => $this->db->fetchAll($sql)]);
        $sql = 'SELECT `id`, `name` FROM `s_premium_dispatch`;';
        $this->View()->assign([ 'shippings' => $this->db->fetchAll($sql)]);

        $csrfToken = $this->container->get('BackendSession')->offsetGet('X-CSRF-Token');
        $this->View()->assign([ 'csrfToken' => $csrfToken ]);
    }

    public function indexAction() {

        $this->handleIndexRequest($this->Request());
        $sql = 'SELECT * FROM `apc_amazon_users`;';
        $this->View()->assign('users',$this->db->fetchAll($sql,1));
    }
    public function checkForOrderStatus(){
        $sql = 'SELECT COUNT(*) FROM `s_core_states` WHERE `name` = "apc_amazon_fba";';
        $count = $this->db->fetchOne($sql);
        if($count != 1){
            $sql = 'INSERT INTO `s_core_states` SET
                    `id` = 99,
                    `name` = "apc_amazon_fba",
                    `description` = "Shipped by Amazon",
                    `position` = 13,
                    `group` = "state",
                    `mail` = 0
                ';
            $this->db->query($sql);
        }
        $sql = 'SELECT COUNT(*) FROM `s_core_paymentmeans` WHERE `name` = "apc_amazon";';
        $count = $this->db->fetchOne($sql);
        if($count != 1){
            $sql = "INSERT INTO `s_core_paymentmeans` ( `name`, `description`, `template`, `class`, `table`, `hide`, `additionaldescription`, `debit_percent`, `surcharge`, `surchargestring`, `position`, `active`, `esdactive`, `embediframe`, `hideprospect`, `action`, `pluginID`, `source`, `mobile_inactive`) VALUES ( 'apc_amazon', 'Amazon Order', '', '', '', '0', '', '0', '0', '', '0', '0', '0', '', '0', NULL, '0', '1', '0');";
            $this->db->query($sql);
        }
        $sql = 'SELECT COUNT(*) FROM `s_core_customergroups` WHERE `groupkey` = "APCAC";';
        $count = $this->db->fetchOne($sql);
        if($count != 1){
            $sql = "INSERT INTO `s_core_customergroups` ( `groupkey`, `description`, `tax`, `taxinput`, `mode`, `discount`, `minimumorder`, `minimumordersurcharge`) VALUES ( 'APCAC', 'Amazon Customer', '0', '0', '0', '0', '0', '0');";
            $this->db->query($sql);
        }

        $sql = 'SELECT COUNT(*) FROM `s_premium_dispatch` WHERE `name` = "Amazon FBA";';
        $count = $this->db->fetchOne($sql);
        if($count != 1){
            $sql = "INSERT INTO `s_premium_dispatch` ( `name`, `type`, `description`, `comment`, `active`, `position`, `calculation`, `surcharge_calculation`, `tax_calculation`, `shippingfree`, `multishopID`, `customergroupID`, `bind_shippingfree`, `bind_time_from`, `bind_time_to`, `bind_instock`, `bind_laststock`, `bind_weekday_from`, `bind_weekday_to`, `bind_weight_from`, `bind_weight_to`, `bind_price_from`, `bind_price_to`, `bind_sql`, `status_link`, `calculation_sql`) VALUES ( 'Amazon FBA', '0', '', '', '1', '0', '3', '0', '0', NULL, NULL, NULL, '0', NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL);";
            $this->db->query($sql);
        }
    }

    public function userAction() {
        if($this->Request()->isPost()){
            $this->handleUserRequest($this->Request());
        }
        $userId = $this->Request()->getParam('id');
        $sql = 'SELECT * FROM `apc_amazon_users` WHERE `id` = ?;';
        $userData = $this->db->fetchRow($sql,$userId);
        if(empty($userData)){
            return;
        }
        $userData['marketpalce_na'] = explode (',',$userData['marketpalce_na']);
        $userData['marketpalce_eu'] = explode (',',$userData['marketpalce_eu']);
        $userData['marketpalce_in'] = explode (',',$userData['marketpalce_in']);
        $userData['marketpalce_cn'] = explode (',',$userData['marketpalce_cn']);
        $userData['marketpalce_jp'] = explode (',',$userData['marketpalce_jp']);
        $userData['marketpalce_au'] = explode (',',$userData['marketpalce_au']);
        $this->View()->assign('user',$userData);
    }

    private function handleIndexRequest($request){
        $routeInfo = $request->getParam('create');
        // var_dump($routeInfo);exit;
        $remove = $request->getParam('remove');
        if($routeInfo){
            try{
                $routeInfo['marketpalce_na'] = implode(',',$routeInfo['marketpalce_na']);
                $routeInfo['marketpalce_eu'] = implode(',',$routeInfo['marketpalce_eu']);
                $routeInfo['marketpalce_in'] = implode(',',$routeInfo['marketpalce_in']);
                $routeInfo['marketpalce_cn'] = implode(',',$routeInfo['marketpalce_cn']);
                $routeInfo['marketpalce_jp'] = implode(',',$routeInfo['marketpalce_jp']);
                $routeInfo['marketpalce_au'] = implode(',',$routeInfo['marketpalce_au']);
                $sql = 'INSERT INTO `apc_amazon_users` SET
                `title` = :title,
                `aws_key` = :aws_key,
                `secret_key` = :secret_key,
                `mws_auth_token` = :mws_auth_token,
                `seller_id` = :seller_id,
                `tax_rate` = :tax_rate,
                `shop_id` = :shop_id,
                `custom_shipping` = :custom_shipping,
                `marketpalce_na` = :marketpalce_na,
                `marketpalce_eu` = :marketpalce_eu,
                `marketpalce_in` = :marketpalce_in,
                `marketpalce_cn` = :marketpalce_cn,
                `marketpalce_jp` = :marketpalce_jp,
                `marketpalce_au` = :marketpalce_au
                ;';
                $this->db->query($sql,$routeInfo);
                $this->checkForOrderStatus();
            }catch(\Exception $e){
                var_dump($e->getMessage());exit;
            }
        }
        if($remove){
            $sql = 'DELETE FROM `apc_amazon_users` WHERE `id` = ?;';
            $this->db->query($sql,$remove);
        }
        return;
    }
    private function handleUserRequest($request){
        $routeInfo = $request->getParam('update');
        $id = $request->getParam('id');
        $routeInfo['id'] = $id;
        if(!$id){
            return;
        }
        $routeInfo['marketpalce_na'] = implode(',',$routeInfo['marketpalce_na']);
        $routeInfo['marketpalce_eu'] = implode(',',$routeInfo['marketpalce_eu']);
        $routeInfo['marketpalce_in'] = implode(',',$routeInfo['marketpalce_in']);
        $routeInfo['marketpalce_cn'] = implode(',',$routeInfo['marketpalce_cn']);
        $routeInfo['marketpalce_jp'] = implode(',',$routeInfo['marketpalce_jp']);
        $routeInfo['marketpalce_au'] = implode(',',$routeInfo['marketpalce_au']);
        $sql = 'UPDATE `apc_amazon_users` SET
                    `title` = :title,
                    `aws_key` = :aws_key,
                    `secret_key` = :secret_key,
                    `mws_auth_token` = :mws_auth_token,
                    `seller_id` = :seller_id,
                    `tax_rate` = :tax_rate,
                    `shop_id` = :shop_id,
                    `custom_shipping` = :custom_shipping,
                    `marketpalce_na` = :marketpalce_na,
                    `marketpalce_eu` = :marketpalce_eu,
                    `marketpalce_in` = :marketpalce_in,
                    `marketpalce_cn` = :marketpalce_cn,
                    `marketpalce_jp` = :marketpalce_jp,
                    `marketpalce_au` = :marketpalce_au
                    WHERE `id` = :id
                    ;';
        $this->db->query($sql,$routeInfo);
    }

    public function getWhitelistedCSRFActions() {
        return ['index','user'];
    }
}
