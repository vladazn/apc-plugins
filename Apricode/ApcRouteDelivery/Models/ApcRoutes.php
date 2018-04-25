<?php
namespace ApcRouteDelivery\Models;
use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="apc_routes")
 */
class ApcRoutes extends ModelEntity
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    private $name;

    /**
     * @var string $active
     *
     * @ORM\Column(name="active", type="integer", nullable=true)
     */
    private $active;

    /**
     * @var string $oldDate
     *
     * @ORM\Column(name="old_date", type="date", nullable=true)
     */
    private $oldDate;

    /**
     * @var string $newDate
     *
     * @ORM\Column(name="new_date", type="date", nullable=true)
     */
    private $newDate;




    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
