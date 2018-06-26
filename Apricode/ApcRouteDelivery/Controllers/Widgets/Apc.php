<?php
class Shopware_Controllers_Widgets_Apc  extends \Enlight_Controller_Action
{
    public function checkZipAction()
    {
        $zip = $this->Request()->getParam('zip');
        $sql = 'SELECT COUNT(*) FROM `apc_routes_zip` WHERE `zip` = ?;';
        $count = Shopware()->Db()->fetchOne($sql,$zip);
        try{

            if($count > 0){
                return $this->sendJsonResponse(['success' => 'true']);
            }else{
                return $this->sendJsonResponse(['success' => 'false']);
            }
        }catch(\Exception $e){
            var_dump($e->getMessage());exit;
        }
    }

    private function sendJsonResponse($data){
        $this->Request()->setHeader('Content-Type', 'application/json');
        $this->Front()->Plugins()->ViewRenderer()->setNoRender();
        $this->Response()->setBody(json_encode(
            $data
        ));
    }
}
