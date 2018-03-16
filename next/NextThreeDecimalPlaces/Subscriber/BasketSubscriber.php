<?php

namespace NextThreeDecimalPlaces\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use NextThreeDecimalPlaces\Core\sBasket;

class BasketSubscriber implements SubscriberInterface
{
    private $pluginDir = null;

    public function __construct($pluginBaseDirectory)
    {
        $this->pluginDir = $pluginBaseDirectory;
		$this->basket = new sBasket();
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'sBasket::sInsertDiscount::replace' => 'sInsertDiscount',
            'sBasket::sInsertSurcharge::replace' => 'sInsertSurcharge',
            'sBasket::sInsertSurchargePercent::replace' => 'sInsertSurchargePercent',
            'sBasket::sGetBasketData::replace' => 'sGetBasketData',
            'sBasket::sAddVoucher::replace' => 'sAddVoucher',
            'sBasket::sGetAmount::replace' => 'sGetAmount',
        ];
    }
	
	public function sGetAmount(\Enlight_Hook_HookArgs $args) {
		$args->setReturn($this->basket->sGetAmount());
	}
	
	public function sGetBasketData(\Enlight_Hook_HookArgs $args) {
		$args->setReturn($this->basket->sGetBasketData());
	}
	
	public function sInsertSurcharge(\Enlight_Hook_HookArgs $args) {
		$args->setReturn($this->basket->sInsertSurcharge());
	}
	
	public function sInsertSurchargePercent(\Enlight_Hook_HookArgs $args) {
		$args->setReturn($this->basket->sInsertSurchargePercent());
	}
	
	public function sInsertDiscount(\Enlight_Hook_HookArgs $args) {
		$args->setReturn($this->basket->sInsertDiscount());
	}
	
	public function sAddVoucher(\Enlight_Hook_HookArgs $args) {
		$args->setReturn($this->basket->sAddVoucher());
	}
}
