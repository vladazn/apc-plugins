<?php

namespace ApcSubscription\Models;

use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="s_plugin_subscription_details")
 */
class SubscriptionDetails extends ModelEntity
{
    /**
     * Primary Key - autoincrement value
     *
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer $orderId
     *
     * @ORM\Column(name="order_id", type="integer", nullable=true)
     */
    private $orderId;

    /**
     * @var integer $detailId
     *
     * @ORM\Column(name="detail_id", type="integer", nullable=true)
     */
    private $detailId;

    /**
     * @var integer $userId
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var integer $active1
     *
     * @ORM\Column(name="active_1", type="integer", nullable=true)
     */
    private $active1;

    /**
     * @var integer $duration1
     *
     * @ORM\Column(name="duration_1", type="integer", nullable=true)
     */
    private $duration1;

    /**
     * @var integer $durationType1
     *
     * @ORM\Column(name="duration_type_1", type="integer", nullable=true)
     */
    private $durationType1;

    /**
     * @var integer $cycle1
     *
     * @ORM\Column(name="cycle_1", type="integer", nullable=true)
     */
    private $cycle1;

    /**
     * @var integer $cycleType1
     *
     * @ORM\Column(name="cycle_type_1", type="integer", nullable=true)
     */
    private $cycleType1;

    /**
     * @var integer $active2
     *
     * @ORM\Column(name="active_2", type="integer", nullable=true)
     */
    private $active2;

    /**
     * @var integer $duration2
     *
     * @ORM\Column(name="duration_2", type="integer", nullable=true)
     */
    private $duration2;

    /**
     * @var integer $durationType2
     *
     * @ORM\Column(name="duration_type_2", type="integer", nullable=true)
     */
    private $durationType2;

    /**
     * @var integer $cycle2
     *
     * @ORM\Column(name="cycle_2", type="integer", nullable=true)
     */
    private $cycle2;

    /**
     * @var integer $cycleType2
     *
     * @ORM\Column(name="cycle_type_2", type="integer", nullable=true)
     */
    private $cycleType2;

    /**
     * @var date $nextOrderDate
     *
     * @ORM\Column(name="next_order_date", type="date", nullable=true)
     */
    private $nextOrderDate;

    /**
     * @var date $pausedUntill
     *
     * @ORM\Column(name="paused_untill", type="date", nullable=true)
     */
    private $pausedUntill = '0000-00-00';


    /**
     * @var integer $ordersCount
     *
     * @ORM\Column(name="orders_count", type="integer", nullable=true)
     */
    private $ordersCount;

    /**
     * @var integer $parentId
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parentId;

    /**
     * @var integer $completed
     *
     * @ORM\Column(name="completed", type="integer", nullable=true)
     */
    private $completed;



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}
