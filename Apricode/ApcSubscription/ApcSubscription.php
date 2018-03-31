<?php

namespace ApcSubscription;

use Doctrine\ORM\Tools\SchemaTool;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Model\ModelManager;
use ApcSubscription\Models\SubscriptionDetails;


class ApcSubscription extends Plugin
{


    public function install(InstallContext $context){


        $this->createDatabase();

        $service = $this->container->get('shopware_attribute.crud_service');

        $this->generateAttributes($service);


    }

    public function activate(ActivateContext $activateContext)
    {
        $activateContext->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    public function uninstall(UninstallContext $context)
    {

         if (!$context->keepUserData()) {
             $this->removeDatabase();
         }

         $service = $this->container->get('shopware_attribute.crud_service');

         $this->removeAttributes($service);


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
            $modelManager->getClassMetadata(SubscriptionDetails::class)
        ];
    }

    private function generateAttributes($service){
         $service->update('s_articles_attributes', 'attr1', 'Free-text-1', [
             'displayInBackend' => false,
             'position' => '101'
         ]);
         $service->update('s_articles_attributes', 'attr2', 'Free-text-2', [
             'displayInBackend' => false,
             'position' => '102'
         ]);
         $service->update('s_articles_attributes', 'attr3', 'Free-text-3', [
             'displayInBackend' => false,
             'position' => '103'
         ]);

        $service->update('s_articles_attributes', 'duration_1', 'integer', [
            'label' => 'Duration of the subscription 1',
            'displayInBackend' => true,
            'custom' => true,
            'position' => '2',
        ]);
        $service->update('s_articles_attributes', 'duration_type_1', 'combobox', [
            'label' => 'Duration Type 1',
            'displayInBackend' => true,
            'arrayStore' => [
                ['key' => '1', 'value' => 'Days'],
                ['key' => '2', 'value' => 'Weeks'],
                ['key' => '3', 'value' => 'Months'],
                ['key' => '4', 'value' => 'Years']
            ],
            'custom' => true,
            'position' => '3',
        ]);
        $service->update('s_articles_attributes', 'cycle_1', 'integer', [
            'label' => 'Cycle 1',
            'supportText' => 'Order is created every',
            'displayInBackend' => true,
            'custom' => true,
            'position' => '4',
        ]);
        $service->update('s_articles_attributes', 'cycle_type_1', 'combobox', [
            'label' => 'Cycle Type 1',
            'displayInBackend' => true,
            'arrayStore' => [
                ['key' => '1', 'value' => 'Days'],
                ['key' => '2', 'value' => 'Weeks'],
                ['key' => '3', 'value' => 'Months'],
                ['key' => '4', 'value' => 'Years']
            ],
            'custom' => true,
            'position' => '5',
        ]);
         $service->update('s_articles_attributes', 'create_day', 'combobox', [
             'label' => 'Order Creation Day',
             'helpText' => 'Subscription orders are always created on that weekday',
             'displayInBackend' => true,
             'arrayStore' => [
                 ['key' => 'monday', 'value' => 'Monday'],
                 ['key' => 'tuesday', 'value' => 'Tuesday'],
                 ['key' => 'wednesday', 'value' => 'Wednesday'],
                 ['key' => 'thursday', 'value' => 'Thursday'],
                 ['key' => 'friday', 'value' => 'Friday'],
                 ['key' => 'saturday', 'value' => 'Saturday'],
                 ['key' => 'sunday', 'value' => 'Sunday']
             ],
             'custom' => true,
             'position' => '6',
         ]);
        $service->update('s_articles_attributes', 'active_1', 'boolean', [
            'label' => 'Activate Order Interval 1',
            'displayInBackend' => true,
            'custom' => true,
            'position' => '1',
        ]);

        //Order interval 2 fields

        $service->update('s_articles_attributes', 'duration_2', 'integer', [
            'label' => 'Duration of the subscription',
            'displayInBackend' => true,
            'custom' => true,
            'position' => '8',
        ]);
        $service->update('s_articles_attributes', 'duration_type_2', 'combobox', [
            'label' => 'Duration Type 2',
            'displayInBackend' => true,
            'arrayStore' => [
                ['key' => '1', 'value' => 'Days'],
                ['key' => '2', 'value' => 'Weeks'],
                ['key' => '3', 'value' => 'Months'],
                ['key' => '4', 'value' => 'Years']
            ],
            'custom' => true,
            'position' => '9',
        ]);
        $service->update('s_articles_attributes', 'cycle_2', 'integer', [
            'label' => 'Cycle 2',
            'supportText' => 'Order is created every',
            'displayInBackend' => true,
            'custom' => true,
            'position' => '10',
        ]);
        $service->update('s_articles_attributes', 'cycle_type_2', 'combobox', [
            'label' => 'Cycle Type 2',
            'displayInBackend' => true,
            'arrayStore' => [
                ['key' => '1', 'value' => 'Days'],
                ['key' => '2', 'value' => 'Weeks'],
                ['key' => '3', 'value' => 'Months'],
                ['key' => '4', 'value' => 'Years']
            ],
            'custom' => true,
            'position' => '11',

        ]);
        $service->update('s_articles_attributes', 'active_2', 'boolean', [
            'label' => 'Activate Order Interval 2',
            'displayInBackend' => true,
            'custom' => true,
            'position' => '7',
        ]);

        $service->update('s_articles_attributes', 'is_subscription', 'boolean', [
            'label' => 'Subscription',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 0,
        ]);

       $service->update('s_order_attributes','index_number','string',[
            'displayInBackend' => false,
            'custom' => 'true'
       ]);

       $service->update('s_order_attributes','parent_order_number','string',[
           'displayInBackend' => true,
           'label' => 'Parent Order Number',
           'custom' => true
       ]);

       $service->update('s_order_attributes','order_days','string',[
           'displayInBackend' => true,
           'label' => 'Order Days',
           'custom' => true
       ]);

    }

    private function removeAttributes($service){

       $service->delete('s_articles_attributes', 'duration_1');
       $service->delete('s_articles_attributes', 'duration_2');
       $service->delete('s_articles_attributes', 'duration_type_1');
       $service->delete('s_articles_attributes', 'duration_type_2');
       $service->delete('s_articles_attributes', 'cycle_1');
       $service->delete('s_articles_attributes', 'cycle_2');
       $service->delete('s_articles_attributes', 'cycle_type_1');
       $service->delete('s_articles_attributes', 'cycle_type_2');
       $service->delete('s_articles_attributes', 'active_1');
       $service->delete('s_articles_attributes', 'active_2');
       $service->delete('s_articles_attributes', 'create_day');
       $service->delete('s_articles_attributes', 'is_subscription');
       $service->delete('s_order_attributes', 'index_number');
       $service->delete('s_order_attributes', 'parent_order_number');
       $service->delete('s_order_attributes', 'order_days');
    }
}
