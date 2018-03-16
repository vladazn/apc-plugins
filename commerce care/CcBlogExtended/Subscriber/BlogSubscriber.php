<?php

namespace CcBlogExtended\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\Plugin\ConfigReader;

class BlogSubscriber implements SubscriberInterface {
    
    private $bootstrap = null;
        
    private $categoryRepository = null;
    
    private $repository = null;
    
    private $pluginDirectory;
    
    private $config;
    
    public function __construct($pluginName, $pluginDirectory, ConfigReader $configReader) {
        $this->pluginDirectory = $pluginDirectory;
        $this->config = $configReader->getByPluginName($pluginName);
    }

    public static function getSubscribedEvents() {
        return array( 
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Blog' => 'onPostDispatchBlog',
            'Theme_Inheritance_Template_Directories_Collected' => 'onCollectTemplateDir'
        );
    }
    
    public function onCollectTemplateDir(\Enlight_Event_EventArgs $args) {
         $dirs = $args->getReturn();
         $dirs[] =  $this->pluginDirectory . '/Resources/views';
         $args->setReturn($dirs);
    }
    
    public function onPostDispatchBlog(\Enlight_Controller_ActionEventArgs $args) {
        $controller = $args->get('subject');
        $request = $controller->Request();
        $response = $controller->Response();
        $view = $controller->View();
        if (!$request->isDispatched() || $response->isException() || !$view->hasTemplate() ) {
            return;
        }
      
        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');
        
        $actionName = strtolower($request->getActionName());
       
        if($actionName != 'detail') {
            return;
        }
        
        $blogArticleId = $request->getParam('blogArticle');
        
        $categoryId = (int) $request->getParam('sCategory');
        
        $blogs = $this->getLatestBlogs($categoryId,$blogArticleId);
        
        $view->assign('sBlogArticles',$blogs);
        $view->assign('CcBlogExtendedPluginConfig',$this->config);
    }
    
    
    private function getLatestBlogs($categoryId,$blogArticleId) {

        //get all blog articles
        $query = $this->getCategoryRepository()->getBlogCategoriesByParentQuery($categoryId);
        $blogCategories = $query->getArrayResult();
        $blogCategoryIds = $this->getBlogCategoryListIds($blogCategories);
        $blogCategoryIds[] = $categoryId;
        
        $filter = array(
            array(
               'property'   => 'id',
               'expression' => '!=',
               'value'      => $blogArticleId
            )
        );
        
        $blogArticlesLimit = $this->config['blog_entries_quantity'];
        
        $blogArticlesQuery = $this->getRepository()->getListQuery($blogCategoryIds, $sLimitStart, $blogArticlesLimit, $filter);
        
        $blogArticlesQuery->setHydrationMode(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

        $paginator = Shopware()->Models()->createPaginator($blogArticlesQuery);

        //returns the blog article data
        $blogArticles = $paginator->getIterator()->getArrayCopy();

        $mediaIds = array_map(function ($blogArticle) {
            if (isset($blogArticle['media']) && $blogArticle['media'][0]['mediaId']) {
                return $blogArticle['media'][0]['mediaId'];
            }
        }, $blogArticles);

        $context = Shopware()->Container()->get('shopware_storefront.context_service')->getShopContext();
        
        $medias = Shopware()->Container()->get('shopware_storefront.media_service')->getList($mediaIds, $context);

        foreach ($blogArticles as $key => $blogArticle) {

            //adding thumbnails to the blog article
            if (empty($blogArticle['media'][0]['mediaId'])) {
                continue;
            }

            $mediaId = $blogArticle['media'][0]['mediaId'];

            if (!isset($medias[$mediaId])) {
                continue;
            }

            /** @var $media \Shopware\Bundle\StoreFrontBundle\Struct\Media */
            $media = $medias[$mediaId];
            $media = Shopware()->Container()->get('legacy_struct_converter')->convertMediaStruct($media);

            $blogArticles[$key]['media'] = $media;
        }
        
        return $blogArticles;
    }
    
    /**
     * Helper Method to get access to the blog repository.
     *
     * @return Shopware\Models\Blog\Repository
     */
    public function getRepository()
    {
        if ($this->repository === null) {
            $this->repository = Shopware()->Models()->getRepository('Shopware\Models\Blog\Blog');
        }

        return $this->repository;
    }
    
    /**
     * Helper method returns the blog category ids for the list query.
     *
     * @param $blogCategories
     *
     * @return array
     */
    private function getBlogCategoryListIds($blogCategories)
    {
        $ids = [];
        foreach ($blogCategories as $blogCategory) {
            $ids[] = $blogCategory['id'];
        }

        return $ids;
    }
    
    /**
     * Helper Method to get access to the category repository.
     *
     * @return Shopware\Models\Category\Repository
     */
    public function getCategoryRepository()
    {
        if ($this->categoryRepository === null) {
            $this->categoryRepository = Shopware()->Models()->getRepository('Shopware\Models\Category\Category');
        }

        return $this->categoryRepository;
    }
}