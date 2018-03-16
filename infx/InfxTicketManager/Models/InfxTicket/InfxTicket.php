<?php

namespace ShopwarePlugins\InfxTicketManager\Models\InfxTicket;

use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="infx_tickets")
 * @ORM\Entity
 */
class InfxTicket extends ModelEntity 
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
     *
     * @var integer $orderId
     * @ORM\Column(name="order_id", type="integer",  nullable=false)
     */
    private $orderId;

     /**
     *
     * @var integer $orderDetailId
     * @ORM\Column(name="orderDetailId", type="integer",  nullable=false)
     */
    private $orderDetailId;
    
    /**
     * @var string $ordernumber
     * @ORM\Column(name="ordernumber", type="string", nullable=false)
     */
    private $ordernumber;
    
    /**
     * @var string $orderTime
     *
     * @ORM\Column(name="orderTime", type="datetime",  nullable=false)
     */
    private $orderTime;
    
    /**
     * @var string $articleordernumber
     *
     * @ORM\Column(name="articleordernumber", type="string", nullable=false)
     */
    private $articleordernumber;

    /**
     * OWNING SIDE
     *
     * @var \Shopware\Models\Customer\Customer $customerNumber
     * @ORM\ManyToOne(targetEntity="\Shopware\Models\Customer\Customer", inversedBy="customer")
     * @ORM\JoinColumn(name="customer_number", referencedColumnName="customernumber")
     */
    protected $customerNumber;
    
    /**
     * @var integer $amountCounter
     *
     * @ORM\Column(name="amountCounter", type="integer",  nullable=false)
     */
    private $amountCounter;
    
    /**
     * @var string $ticketCode
     *
     * @ORM\Column(name="ticketCode", type="string", nullable=false)
     */
    private $ticketCode;    
    
    /**
     * @var string $stampTime
     *
     * @ORM\Column(name="stampTime", type="datetime",  nullable=true)
     */
    private $stampTime;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
    * @param int $id
    */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * @return int
     */
    public function getOrderDetailId()
    {
        return $this->orderDetailId;
    }

    /**
     * @param int $orderDetailId
     */
    public function setOrderDetailId($orderDetailId)
    {
        $this->orderDetailId = $orderDetailId;
    }
    
    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string $ordernumber
     */
    public function getOrdernumber()
    {
        return $this->ordernumber;
    }

    /**
     * @param string $ordernumber
     */
    public function setOrdernumber($ordernumber)
    {
        $this->ordernumber = $ordernumber;
    }

    /**
     * @return string
     */
    public function getArticleordernumber()
    {
        return $this->articleordernumber;
    }

    /**
     * @param string $articleordernumber
     */
    public function setArticleordernumber($articleordernumber)
    {
        $this->articleordernumber = $articleordernumber;
    }

    /**
     * @return string
     */
    public function getCustomerNumber()
    {
        return $this->customerNumber;
    }

    /**
     * @param string $customerNumber
     */
    public function setCustomerNumber($customerNumber)
    {
        $this->customerNumber = $customerNumber;
    }
    
    /**
     * @return string
     */
    public function getAmountCounter()
    {
        return $this->amountCounter;
    }

    /**
     * @param string $amountCounter
     */
    public function setAmountCounter($amountCounter)
    {
        $this->amountCounter = $amountCounter;
    }

    /**
     * @return string
     */
    public function getOrderTime()
    {
        return $this->orderTime;
    }

    /**
     * @param string $orderTime
     */
    public function setOrderTime($orderTime)
    {
        $this->orderTime = $orderTime;
    }

    /**
     * @return string
     */
    public function getInfxTicketCode()
    {
        return $this->ticketCode;
    }

    /**
     * @param string $ticketCode
     */
    public function setInfxTicketCode($ticketCode)
    {
        $this->ticketCode = $ticketCode;
    }
    
    /**
     * @return string
     */
    public function getStampTime()
    {
        return $this->stampTime;
    }

    /**
     * @param string $stampTime
     */
    public function setStampTime($stampTime)
    {
        $this->stampTime = $stampTime;
    }
    
}
