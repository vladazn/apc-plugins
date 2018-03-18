<?php

namespace InfxExitPopup;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Doctrine\ORM\Tools\SchemaTool;
use Shopware\Components\Model\ModelManager;
use InfxExitPopup\Models\InfxEmarketingVoucherCodesAttributes;
use Shopware\Models\Mail\Mail;

class InfxExitPopup extends Plugin
{

	public function install(InstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->update('s_emarketing_vouchers_attributes', 'infx_exit_voucher', 'boolean', [
            'label' => 'Use this voucher for Exit Popup',
            'displayInBackend' => true,
            'position' => 100,
            'custom' => true,
        ]);
		$this->createEmailTemplate();
		$this->createDatabase();
    }

	public function activate(ActivateContext $activateContext)
   	{
	   	$activateContext->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
   	}

   	public function deactivate(DeactivateContext $deactivateContext)
   	{
	   	$deactivateContext->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
   	}

	public function uninstall(UninstallContext $context)
    {
        $service = $this->container->get('shopware_attribute.crud_service');
        $service->delete('s_emarketing_vouchers_attributes', 'infx_exit_voucher');
		$this->removeDatabase();
    }


	private function createEmailTemplate() {

        $mailModel = Shopware()->Models()->getRepository(Mail::class)->findOneBy(['name'=>'infxVOUCHER']);

        if ($mailModel) {
            return;
        }

        $params = [
	        "name" => 'infxVOUCHER',
	        "fromName" => "{config name=shopName}",
	        "fromMail" => "{config name=mail}",
	        "subject" => 'Your voucher at {config name=shopName}',
	        "content" => '\r\n\r\nHello,\r\n\r\nThank you for your order. You can use the following Voucher Code: {$voucher} ',
	        "isHtml" => false,
	        "attachment" => "",
	        "type" => "",
	        "context" => "",
	        "contextPath" => "",
	        "parentId" => 0,
	        "index" => 0,
	        "depth" => 0,
	        "expanded" => false,
	        "expandable" => true,
	        "checked" => null,
	        "leaf" => false,
	        "cls" => "",
	        "iconCls" => "",
	        "icon" => "",
	        "root" => false,
	        "isLast" => false,
	        "isFirst" => false,
	        "allowDrop" => true,
	        "allowDrag" => true,
	        "loaded" => false,
	        "loading" => false,
	        "href" => "",
	        "hrefTarget" => "",
	        "qtip" => "",
	        "qtitle" => "",
			'attribute' => "",
	        "children" => null
		];

        $mail = new Mail();
        $mail->fromArray($params);

        Shopware()->Models()->persist($mail);
        Shopware()->Models()->flush();
    }

	private function createDatabase()
  	{
	  	$modelManager = $this->container->get('models');
	  	$tool = new SchemaTool($modelManager);
	  	$classes = $this->getClasses($modelManager);
	  	$tool->updateSchema($classes, true);
  	}
  	private function removeDatabase()
  	{
	  	$modelManager = $this->container->get('models');
	  	$tool = new SchemaTool($modelManager);
	  	$classes = $this->getClasses($modelManager);
	  	$tool->dropSchema($classes);
  	}

	/**
    * @param ModelManager $modelManager
    * @return array
    */
   	private function getClasses(ModelManager $modelManager)
   	{
       	return [
           	$modelManager->getClassMetadata(InfxEmarketingVoucherCodesAttributes::class)
       	];
   	}

}
