<?php
namespace TimeAmazonIntegration\Models;
use Shopware\Components\Model\ModelEntity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="apc_amazon_users")
 */
class ApcAmazonUsers extends ModelEntity
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    private $title;
    /**
     * @var string $awsKey
     *
     * @ORM\Column(name="aws_key", type="string", nullable=false)
     */
    private $awsKey;
    /**
     * @var string $secretKey
     *
     * @ORM\Column(name="secret_key", type="string", nullable=false)
     */
    private $secretKey;
    /**
     * @var string $MWSAuthToken
     *
     * @ORM\Column(name="mws_auth_token", type="string", nullable=false)
     */
    private $MWSAuthToken;
    /**
     * @var string $sellerId
     *
     * @ORM\Column(name="seller_id", type="string", nullable=false)
     */
    private $sellerId;
    /**
     * @var string $taxRate
     *
     * @ORM\Column(name="tax_rate", type="string", nullable=false)
     */
    private $taxRate;
    /**
     * @var string $marketpalceNa
     *
     * @ORM\Column(name="marketpalce_na", type="string", nullable=true)
     */
    private $marketpalceNa;
    /**
     * @var string $marketpalceEu
     *
     * @ORM\Column(name="marketpalce_eu", type="string", nullable=true)
     */
    private $marketpalceEu;
    /**
     * @var string $marketpalceIn
     *
     * @ORM\Column(name="marketpalce_in", type="string", nullable=true)
     */
    private $marketpalceIn;
    /**
     * @var string $marketpalceCn
     *
     * @ORM\Column(name="marketpalce_cn", type="string", nullable=true)
     */
    private $marketpalceCn;
    /**
     * @var string $marketpalceJp
     *
     * @ORM\Column(name="marketpalce_jp", type="string", nullable=true)
     */
    private $marketpalceJp;
    /**
     * @var string $marketpalceAu
     *
     * @ORM\Column(name="marketpalce_au", type="string", nullable=true)
     */
    private $marketpalceAu;
    /**
     * @var string $shopId
     *
     * @ORM\Column(name="shop_id", type="string", nullable=false)
     */
    private $shopId;
    /**
     * @var string $customShipping
     *
     * @ORM\Column(name="custom_shipping", type="string", nullable=false)
     */
    private $customShipping;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
