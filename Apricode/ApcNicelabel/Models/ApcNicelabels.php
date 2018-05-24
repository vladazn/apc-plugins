<?php
namespace ApcNicelabel\Models;
use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="apc_nicelabels")
 */

class ApcNicelabels extends ModelEntity
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
     * @var string $articleId
     *
     * @ORM\Column(name="article_id", type="string", nullable=true)
     */
    private $articleId;

    /**
     * @var string $articleName
     *
     * @ORM\Column(name="article_name", type="string", nullable=true)
     */
    private $articleName;

    /**
     * @var string $articleSubtitle
     *
     * @ORM\Column(name="article_subtitle", type="string", nullable=true)
     */
    private $articleSubtitle;

    /**
     * @var string $articleZutaten
     *
     * @ORM\Column(name="article_zutaten", type="string", nullable=true)
     */
    private $articleZutaten;

    /**
     * @var string $articleAllergene
     *
     * @ORM\Column(name="article_allergene", type="string", nullable=true)
     */
    private $articleAllergene;

    /**
     * @var string $articleCategories
     *
     * @ORM\Column(name="article_categories", type="string", nullable=true)
     */
    private $articleCategories;

    /**
     * @var integer $articleLabels
     *
     * @ORM\Column(name="article_labels", type="integer", nullable=true)
     */
    private $articleLabels = 0;

    /**
     * @var integer $articleOrders
     *
     * @ORM\Column(name="article_orders", type="integer", nullable=true)
     */
    private $articleOrders;

    /**
     * @var integer $totalLabels
     *
     * @ORM\Column(name="total_labels", type="integer", nullable=true)
     */
    private $totalLabels;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}
