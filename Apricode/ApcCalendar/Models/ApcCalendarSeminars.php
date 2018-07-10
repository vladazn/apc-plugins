<?php
namespace ApcCalendar\Models;
use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="apc_calendar_seminars")
 */
class ApcCalendarSeminars extends ModelEntity
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
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private $title;
    /**
     * @var string $active
     *
     * @ORM\Column(name="article_id", type="integer", nullable=true)
     */
    private $articleId;

    /**
     * @var string $date
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;
    
    /**
     * @var string $time
     *
     * @ORM\Column(name="time", type="string", nullable=true)
     */
    private $time;
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
