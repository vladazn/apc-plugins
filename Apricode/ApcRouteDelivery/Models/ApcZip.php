<?php
namespace ApcRouteDelivery\Models;
use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="apc_zip")
 */
class ApcZip extends ModelEntity
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
     * @var string $zip
     *
     * @ORM\Column(name="zip", type="string", nullable=true)
     */
    private $zip;

    /**
     * @var string $place
     *
     * @ORM\Column(name="place", type="string", nullable=true)
     */
    private $place;

    /**
     * @var string $state
     *
     * @ORM\Column(name="state", type="string", nullable=true)
     */
    private $state;

    /**
     * @var string $stateAbbr
     *
     * @ORM\Column(name="state_abbr", type="string", nullable=true)
     */
    private $stateAbbr;

    /**
    * @var string $city
    *
    * @ORM\Column(name="city", type="string", nullable=true)
    */
    private $city;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
