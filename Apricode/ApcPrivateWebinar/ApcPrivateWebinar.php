<?php
namespace ApcPrivateWebinar;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Models\Mail\Mail;

class ApcPrivateWebinar extends Plugin{

    public function install(InstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        $this->generateAttributes($service);
        $this->createEmailTemplate();
    }

    public function activate(ActivateContext $activateContext)
    {
        // $activateContext->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    public function uninstall(UninstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        $this->removeAttributes($service);
    }

    private function createEmailTemplate() {

        $mailModel = Shopware()->Models()->getRepository(Mail::class)->findOneBy(['name'=>'apcPRIVATEWEBINARCONFIRM']);

        if ($mailModel) {
            return;
        }

        $params = [
	        "name" => 'apcPRIVATEWEBINARCONFIRM',
	        "fromName" => "{config name=shopName}",
	        "fromMail" => "{config name=mail}",
	        "subject" => 'Private Webinar was approved',
	        "content" => 'Hello, Your private webinar request was approved, You can see the available options in your account "Private Webinars" page.',
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



    private function generateAttributes($service){
       $service->update('s_articles_attributes', 'apc_private_webinar_active', 'boolean', [
           'label' => 'Is Private Webinar',
           "displayInBackend" => true,
           "custom" => true,
       ]);
       $service->update('s_articles_attributes', 'apc_private_webinar_user_notified', 'boolean', [
           'label' => 'user notified',
           "displayInBackend" => false,
           "custom" => true,
       ]);
       $service->update('s_articles_attributes', 'apc_private_webinar_email', 'string', [
           'label' => 'Customer Email',
           "displayInBackend" => true,
           "custom" => true,
       ]);

   }

   private function removeAttributes($service){
       $service->delete('s_articles_attributes', 'apc_private_webinar_active');
       $service->delete('s_articles_attributes', 'apc_private_webinar_user_notified');
       $service->delete('s_articles_attributes', 'apc_private_webinar_email');
   }
}
