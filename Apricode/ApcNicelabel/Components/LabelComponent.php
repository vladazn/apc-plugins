<?php
namespace ApcNicelabel\Components;

use Shopware\Components\Api\Resource\Article;

class LabelComponent{

    private $pluginDir = null;
    private $db = null;

    public function __construct($pluginBaseDirectory){
        $this->pluginDir = $pluginBaseDirectory;
        $this->db = Shopware()->Db();
    }

    public function getArticleInitData($orderStatus = null, $paymentStatus = null, $dateFrom = null, $dateTo = null){
        $sql = 'SELECT `s_order_details`.`articleordernumber`, `s_order_details`.`quantity`, `s_order_details`.`name` FROM `s_order_details`
                    LEFT JOIN `s_order` ON `s_order_details`.`orderID` = `s_order`.`id`
                    WHERE `s_order`.`id` > 0';

        if($dateFrom){
            $sql .= ' AND `s_order`.`ordertime` >= :dateFrom ';
            $params['dateFrom'] = date('Y-m-d H:i:s', strtotime($dateFrom));
        }

        if($dateTo){
            $sql .= ' AND `s_order`.`ordertime` <= :dateTo ';
            $params['dateTo'] = date('Y-m-d H:i:s', strtotime($dateTo));
        }

        if($orderStatus > -10){
            $sql .= ' AND `s_order`.`status` = :orderStatus ';
            $params['orderStatus'] = $orderStatus;
        }

        if($paymentStatus > -10){
            $sql .= ' AND `s_order`.`status` = :paymentStatus ';
            $params['paymentStatus'] = $paymentStatus;
        }

        $articleData = $this->db->fetchAll($sql,$params);

        foreach($articleData as $article){
            $articles[$article['articleordernumber']]['ordernumber'] = $article['articleordernumber'];
            $articles[$article['articleordernumber']]['name'] = $article['name'];
            $articles[$article['articleordernumber']]['quantity'] += $article['quantity'];
        }

        return $articles;

    }

    public function clearTable(){
        $this->db->query('DELETE FROM `apc_nicelabels`');
    }

    public function insertArticleInfo($article){
        $orderNumber = $article['ordernumber'];
        $articleData = $this->getProperties($orderNumber);

        //initial data
        $params['articleOrders'] = $article['quantity'];
        $params['articleId'] = $orderNumber;
        $params['articleName'] = $article['name'];

        //attributes
        list($params['articleSubtitle'], $params['articleLabels']) = $this->getAttributes($articleData);
        if(empty($params['articleLabels'])){
            $params['articleLabels'] = 0;
        }
        //connections
        $params['articleZutaten'] = $this->getIngredients($articleData['propertyValues']);
        $params['articleAllergene'] = $this->getAlergenes($articleData['propertyValues']);
        $params['articleCategories'] = $this->getCategories($articleData['propertyValues']);

        //other
        $params['labelsTotal'] = $params['articleOrders'] * $params['articleLabels'];

        $sql = 'INSERT INTO `apc_nicelabels`
                SET `article_orders` = :articleOrders,
                `article_id` = :articleId,
                `article_subtitle` = :articleSubtitle,
                `article_labels` = :articleLabels,
                `article_zutaten` = :articleZutaten,
                `article_allergene` = :articleAllergene,
                `article_categories` = :articleCategories,
                `article_name` = :articleName,
                `total_labels` = :labelsTotal
                ;';
        $this->db->query($sql,$params);
    }

    private function getIngredients($propertyValues){
        $ingredients = '';
        foreach($propertyValues as $value){
            if($value['optionId'] == 6){
                $ingredients .= $value['value'].', ';
            }
        }
        return substr($ingredients, 0, -2);
    }

    private function getAlergenes($propertyValues){
        $allergenes = '';
        foreach($propertyValues as $value){
            if($value['optionId'] == 7){
                $allergenes .= $this->getFullAlergeneLabelById($value['id']).', ';
            }
        }
        return substr($allergenes, 0, -2);
    }

    private function getFullAlergeneLabelById($id){
        $sql = 'SELECT `apc_property_long` FROM `s_filter_values_attributes` WHERE `valueID` = ?;';
        return $this->db->fetchOne($sql,$id);
    }

    private function getCategories($propertyValues){
        $categories = '';
        foreach($propertyValues as $value){
            if($value['optionId'] == 4){
                $categories .= $value['value'].', ';
            }
        }
        return substr($categories, 0, -2);
    }

    private function getProperties($orderNumber){
        $id = $this->db->fetchOne('SELECT `articleID` FROM `s_articles_details` WHERE `ordernumber` = ?', $orderNumber);
        $articleData = $this->getArticleData($id);
        return $articleData;
    }

    private function getAttributes($articleData){
        $attr = $articleData['mainDetail']['attribute'];
        return [$attr['apcSubtitle'],$attr['apcLabels']];
    }

    private function getArticleData($id){

        $builder = Shopware()->Models()->createQueryBuilder();

        $builder->select([
            'article',
            'mainDetail',
            'mainDetailPrices',
            'tax',
            'propertyValues',
            'configuratorOptions',
            'supplier',
            'priceCustomGroup',
            'mainDetailAttribute',
            'propertyGroup',
            'customerGroups',
        ])
            ->from(\Shopware\Models\Article\Article::class, 'article')
            ->leftJoin('article.mainDetail', 'mainDetail')
            ->leftJoin('mainDetail.prices', 'mainDetailPrices')
            ->leftJoin('mainDetailPrices.customerGroup', 'priceCustomGroup')
            ->leftJoin('article.tax', 'tax')
            ->leftJoin('article.propertyValues', 'propertyValues')
            ->leftJoin('article.supplier', 'supplier')
            ->leftJoin('mainDetail.attribute', 'mainDetailAttribute')
            ->leftJoin('mainDetail.configuratorOptions', 'configuratorOptions')
            ->leftJoin('article.propertyGroup', 'propertyGroup')
            ->leftJoin('article.customerGroups', 'customerGroups')
            ->where('article.id = ?1')
            ->setParameter(1, $id);

        $article = $builder->getQuery()->getOneOrNullResult(2);

        return $article;
    }
}
