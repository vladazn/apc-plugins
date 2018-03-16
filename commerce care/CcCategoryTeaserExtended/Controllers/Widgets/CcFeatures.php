<?php

use Shopware\Bundle\StoreFrontBundle\Struct\Category;

class Shopware_Controllers_Widgets_CcFeatures extends \Enlight_Controller_Action {  
    
    public function getSubcategoriesAction() {
        $categoryID = $this->Request()->getParam('sCategory');
        $subs = $this->getSubcategories($categoryID);
        $this->View()->subcategories = $subs;
    }
    
    private function getSubcategories($categoryID) {
                
        $ids = $this->getCategoryIdsOfDepth($categoryID, 4);
        $context = $this->container->get('shopware_storefront.context_service')->getShopContext();
        $categories = $this->container->get('shopware_storefront.category_service')->getList($ids, $context);
        $categoriesArray = $this->convertCategories($categories);
        $categoryTree = $this->getCategoriesOfParent($categoryID, $categoriesArray);
        
        return $categoryTree;
    }
    
    private function getCategoriesOfParent($parentId, $categories){
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
    
     private function convertCategories($categories){
        $converter = $this->container->get('legacy_struct_converter');

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
    
    private function getCategoryIdsOfDepth($parentId, $depth = 1){
        $query = $this->container->get('dbal_connection')->createQueryBuilder();
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
    
    
}
