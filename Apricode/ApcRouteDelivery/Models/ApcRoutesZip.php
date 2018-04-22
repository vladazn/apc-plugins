<?php
namespace ApcRouteDelivery\Models;
use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="apc_routes_zip")
 */
class ApcRoutesZip extends ModelEntity
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
     * @var integer $zip
     *
     * @ORM\Column(name="zip", type="string", nullable=true)
     */
    private $zip;

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
