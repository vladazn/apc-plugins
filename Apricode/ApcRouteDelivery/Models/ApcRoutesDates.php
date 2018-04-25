<?php
namespace ApcRouteDelivery\Models;
use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="apc_routes_dates")
 */
class ApcRoutesDates extends ModelEntity
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
     * @var integer $date
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var integer $routeId
     *
     * @ORM\Column(name="route_id", type="integer", nullable=true)
     */
    private $routeId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
