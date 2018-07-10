<?php
use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr\Join;
use Shopware\Components\CSRFWhitelistAware;
/*
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Shopware_Controllers_Backend_ApcCalendar extends Enlight_Controller_Action implements CSRFWhitelistAware {
    private $component = null;
    private $db = null;

    public function preDispatch() {
        $this->get('template')->addTemplateDir(__DIR__ . '/../../Resources/views/');
    }

    public function init() {
        $this->db = Shopware()->Db();
    }

    public function postDispatch() {
        $csrfToken = $this->container->get('BackendSession')->offsetGet('X-CSRF-Token');
        $this->View()->assign([ 'csrfToken' => $csrfToken ]);
    }

    public function indexAction() {
        $year = $this->Request()->getParam('year',date('Y'));
        $month = $this->Request()->getParam('month',date('n'));
        $next = [
            'text' => date('M Y', strtotime($year.'-'.$month.'-01 +1 month')),
            'link' => [
                'year' => date('Y', strtotime($year.'-'.$month.'-01 +1 month')),
                'month' => date('n', strtotime($year.'-'.$month.'-01 +1 month'))
            ]
        ];
        $prev = [
            'text' => date('M Y', strtotime($year.'-'.$month.'-01 -1 month')),
            'link' => [
                'year' => date('Y', strtotime($year.'-'.$month.'-01 -1 month')),
                'month' => date('n', strtotime($year.'-'.$month.'-01 -1 month'))
            ]
        ];
        $currentMonth = date('M Y', strtotime($year.'-'.$month.'-01'));
        $sql = 'SELECT `date`, `title`, `time` FROM `apc_calendar_seminars` WHERE MONTH(`date`) = :month AND YEAR(`date`) = :year ;';
        $eventsRaw = $this->db->fetchAll($sql,['month' => $month, 'year' => $year]);
        foreach($eventsRaw as $event){
            $events[date('j', strtotime($event['date']))][] = [
                'title' => $event['title'],
                'time' => $event['time'],
                ];
        }
        $startWeekday = date('N', strtotime($year.'-'.$month.'-01'));
        $daysInPrevMonth = date('t', strtotime($year.'-'.$month.'-01 -1 month'));
        $daysInMonth = date('t', strtotime($year.'-'.$month.'-01'));

        $this->View()->assign([
            'year' => $year,
            'month' => $month,
            'currentMonth' => $currentMonth,
            'next' => $next,
            'prev' => $prev,
            'events' => $events,
            'startWeekday' => $startWeekday,
            'daysInPrevMonth' => $daysInPrevMonth,
            'daysInMonth' => $daysInMonth,
            'articles' => $this->getArticles()
        ]);
    }

    public function dayAction(){
        $this->handleDayActions($this->Request());
        $year = $this->Request()->getParam('year');
        $month = $this->Request()->getParam('month');
        $day = $this->Request()->getParam('day');
        $sql = 'SELECT `title`, `article_id`, `id`, `time` FROM `apc_calendar_seminars` WHERE `date` = ?;';
        $events = $this->db->fetchAll($sql,$year.'-'.$month.'-'.$day);
        $this->View()->assign([
            'events' => $events,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'date' => date('M d, Y', strtotime($year.'-'.$month.'-'.$day)),
            'articles' => $this->getArticles()
        ]);
    }

    public function quickAddAction(){
        $create = $this->Request()->getParam('create');
        $data = [
            'title' => $create['title'],
            'articleId' => $create['articleId'],
            'eventDate' => $create['year'].'-'.$create['month'].'-'.$create['day'],
            'eventTime' => $create['time'],
        ];
        $this->addEvent($data);
        return $this->redirect(['module' => 'backend', 'controller' => 'ApcCalendar', 'action' => 'index', 'year' => $create['year'], 'month' => $create['month']]);
    }

    private function getArticles(){
        $categoryId = Shopware()->Config()->get('apc_calendar_category');
        $sql = 'SELECT `s_articles`.`id`, `s_articles`.`name` FROM `s_articles`
                LEFT JOIN `s_articles_categories` ON `s_articles_categories`.`articleID` = `s_articles`.`id`
                WHERE `s_articles_categories`.`categoryID` = ?;';
        $articles = $this->db->fetchAll($sql,$categoryId,PDO::FETCH_KEY_PAIR);
        return $articles;
    }

    public function handleDayActions($request){
        $remove = $this->Request()->getParam('remove');
        $create = $this->Request()->getParam('create');
        if($remove){
            $this->removeEvent($remove['id']);
        }
        if($create['title'] && $create['articleId']){
            $this->addEvent($create);
        }

    }

    private function removeEvent($id){
        $sql = 'DELETE FROM `apc_calendar_seminars` WHERE `id` = ?;';
        $this->db->query($sql,$id);
    }

    private function addEvent($data){
        $sql = 'INSERT INTO `apc_calendar_seminars` SET
            `title` = :title,
            `article_id` = :articleId,
            `date` = :eventDate,
            `time` = :eventTime
        ;';
        $this->db->query($sql,$data);
    }

    public function getWhitelistedCSRFActions() {
        return ['index','day', 'quickAdd'];
    }
}
