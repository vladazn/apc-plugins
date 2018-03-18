<?php
namespace InfxExitPopup\Models;
use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="infx_emarketing_voucher_codes_attributes")
 */
class InfxEmarketingVoucherCodesAttributes extends ModelEntity
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
     * @ORM\Column(name="voucher_code_id", type="integer", nullable=false)
     */
    private $voucherCodeId;

    /**
     * @var string $name
     *
     * @ORM\Column(name="reserved", type="integer", nullable=true)
     */
    private $reserved = 0;

    /**
     * @var string $name
     *
     * @ORM\Column(name="recipient", type="string", nullable=true)
     */
    private $recipient;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
