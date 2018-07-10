<?php
class Shopware_Controllers_Widgets_ApcCalendar extends \Enlight_Controller_Action {


    public function indexAction() {
        $year = $this->Request()->getParam('year',date('Y'));
        $month = $this->Request()->getParam('month',date('n'));
        $currentMonth = strtoupper(date('F', strtotime($year.'-'.$month.'-01')));
        $sql = 'SELECT `date`, `title`, `article_id`, `time` FROM `apc_calendar_seminars` WHERE MONTH(`date`) = :month AND YEAR(`date`) = :year AND `date` > NOW() ORDER BY `date` LIMIT 3;';
        $eventsRaw = Shopware()->Db()->fetchAll($sql,['month' => $month, 'year' => $year]);
        $count = 1;
        $sArticle = Shopware()->Modules()->Articles();
        foreach($eventsRaw as $event){
            $events[] = [
                'title' => $event['title'],
                'date' => date('F d, Y', strtotime($event['date'])),
                'time' => $event['time'],
                'article' => $sArticle->sGetArticleById($event['article_id'])
            ];
            $count++;
        }

        $this->View()->assign([
            'currentMonth' => $currentMonth,
            'events' => $events,
        ]);
	}

    private function getArticles(){
        $sql = 'SELECT `s_articles`.`id`, `s_articles`.`name` FROM `s_articles`
                LEFT JOIN `s_articles_categories` ON `s_articles_categories`.`articleID` = `s_articles`.`id`
                WHERE `s_articles_categories`.`categoryID` = 7;';
        $articleRaw = Shopware()->Db()->fetchAll($sql);
        foreach($articleRaw as $article){
            $articles[$article['id']]['name'] = $article['name'];
            $articles[$article['id']]['link'] = Shopware()->Front()->Router()->assemble(['sViewport' => 'detail', 'sArticle' => $article['id']]);
        }
        return $articles;
    }
}
