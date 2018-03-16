<?php

namespace CcTeaserElement\ComponentHandler;

use Shopware\Bundle\EmotionBundle\ComponentHandler\ComponentHandlerInterface;
use Shopware\Bundle\EmotionBundle\Struct\Collection\PrepareDataCollection;
use Shopware\Bundle\EmotionBundle\Struct\Collection\ResolvedDataCollection;
use Shopware\Bundle\EmotionBundle\Struct\Element;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\Category;

class TeaserComponentHandler implements ComponentHandlerInterface
{
    public function supports(Element $element)
    {
        return $element->getComponent()->getTemplate() === 'emotion_teaser';
    }

    public function prepare(PrepareDataCollection $collection, Element $element, ShopContextInterface $context)
    {
        
    }

    public function handle(ResolvedDataCollection $collection, Element $element, ShopContextInterface $context)
    {
        $categoryId = $element->getConfig()->get('category_id');
        $category = Shopware()->Modules()->Categories()->sGetCategoryContent($categoryId);
        $sub = $this->getCategoryData($categoryId);
        $category['sub'] = $sub;
        $element->getData()->set('category', $category);
    }
    
    private function getCategoryData($category) {
               
        $context = Shopware()->Container()->get('shopware_storefront.context_service')->getShopContext();
    
        $ids = $this->getCategoryIdsOfDepth($category, 2);
        
        $categories = Shopware()->Container()->get('shopware_storefront.category_service')->getList($ids, $context);
        
        $categoriesArray = $this->convertCategories($categories);
        
        $categoryTree = $this->getCategoriesOfParent($category, $categoriesArray);
        
        return $categoryTree;       
    }
    
    /**
     * @param int   $parentId
     * @param array $categories
     *
     * @return array
     */
    private function getCategoriesOfParent($parentId, $categories)
    {
        $result = [];

        foreach ($categories as $index => $category) {
            if ($category['parentId'] != $parentId) {
                continue;
            }
            $children = $this->getCategoriesOfParent($category['id'], $categories);
            $category['sub'] = $children;
            $category['activeCategories'] = count($children);
            $result[] = $category;
        }

        return $result;
    }
    
    /**
     * @param int $parentId
     * @param int $depth
     *
     * @throws Exception
     *
     * @return int[]
     */
    private function getCategoryIdsOfDepth($parentId, $depth)
    {
        $query = Shopware()->Container()->get('dbal_connection')->createQueryBuilder();
        $query->select('DISTINCT category.id')
            ->from('s_categories', 'category')
            ->where('category.path LIKE :path')
            ->andWhere('category.active = 1')
            ->andWhere('ROUND(LENGTH(path) - LENGTH(REPLACE (path, "|", "")) - 1) <= :depth')
            ->orderBy('category.position')
            ->setParameter(':depth', $depth)
            ->setParameter(':path', '%|' . $parentId . '|%');

        /** @var $statement PDOStatement */
        $statement = $query->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }
      
    /**
     * @param Category[] $categories
     *
     * @return array
     */
    private function convertCategories($categories)
    {
        $converter = Shopware()->Container()->get('legacy_struct_converter');

        return array_map(function (Category $category) use ($converter) {
            $data = $converter->convertCategoryStruct($category);

            $data['flag'] = false;
            if ($category->getMedia()) {
                $data['media']['path'] = $category->getMedia()->getFile();
            }
            if (!empty($category->getExternalLink())) {
                $data['link'] = $category->getExternalLink();
            }

            return $data;
        }, $categories);
    }
}