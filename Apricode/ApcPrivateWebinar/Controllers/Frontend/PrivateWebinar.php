<?php
class Shopware_Controllers_Frontend_PrivateWebinar extends Enlight_Controller_Action
{
    public function indexAction(){
        $sql = 'SELECT `s_articles_details`.`articleID` FROM `s_articles_details`
                    LEFT JOIN `s_articles_attributes` ON `s_articles_attributes`.`articledetailsID` = `s_articles_details`.`id`
                    WHERE `s_articles_attributes`.`apc_private_webinar_email` = ?;';
        $email = Shopware()->Session()->get('sUserMail');
        $data = Shopware()->Db()->fetchCol($sql, $email);

        $sArticle = Shopware()->Modules()->Articles();
        foreach($data as $articleId){
            $articles[] = $sArticle->sGetArticleById($articleId);
        }

        $this->View()->assign([
            'productBoxLayout' => 'list',
            'articles' => $articles,
            'formId' => Shopware()->Config()->get('apc_private_webinar_form')
        ]);

    }
}
