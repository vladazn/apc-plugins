<?php
namespace ApcArticleReserve\Models;
use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="apc_reserve")
 */
class ApcReserve extends ModelEntity
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
     * @var string $basketId
     *
     * @ORM\Column(name="basket_id", type="string", nullable=true)
     */
    private $basketId;
    /**
     * @var string $ordernumber
     *
     * @ORM\Column(name="ordernumber", type="string", nullable=true)
     */
    private $ordernumber;
    /**
     * @var string $quantity
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;
    /**
     * @var string $expirationDate
     *
     * @ORM\Column(name="expirationdate", type="datetime", nullable=true)
     */
    private $expirationDate;
    /**
     * @var string $expirationDate
     *
     * @ORM\Column(name="session", type="string", nullable=true)
     */
    private $session;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
