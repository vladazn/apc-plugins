<?php
namespace TimeAmazonIntegration\Models;
use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="apc_amazon_log")
 */
class ApcAmazonLog extends ModelEntity
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
     * @var string $date
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string $response
     *
     * @ORM\Column(name="response", type="string", nullable=true)
     */
    private $response;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
