<?php

/**
 * BaseDashboard components.
 *
 * @package    sfRedminishAdminPlugin
 * @subpackage dashboard
 * @author     Sébastien Eustace <sebastien.eustace@gmail.com>
 * @version    $Revision$
 */

class BaseDashboardComponents extends sfComponents
{
    public function executeBox()
    {
        if ( ! empty($this->method)) {
            $q = Doctrine::getTable($this->model)->{'' . $this->method}();
        } else {
            $q = Doctrine::getTable($this->model)->createQuery();
        }
        
        if ( ! empty($this->limit)) {
            $q->limit($this->limit);
        }
        
        $this->results = $q->execute();
    }
    
    public function executeGraph()
    {
        $ga = new gapi($this->email, $this->password);
        
        switch ($this->period) {
            case 'month':
                $startTime = date('Y-m-d',strtotime('-1 month', strtotime(date('Y-m-d', time()))));
                $endTime = date('Y-m-d', time());
            break;
            
            case 'week':
                $startTime = date('Y-m-d',strtotime('-1 week', strtotime(date('Y-m-d', time()))));
                $endTime = date('Y-m-d', time());
            break;
            
            default:
                $startTime = date('Y-m-d', time());
                $endTime = null;
            break;
        }
        
        if ($this->data == 'visits') {
            $ga->requestReportData($this->profile,
                                   array('date'),
                                   array('visits'),
                                   null,
                                   null,
                                   $startTime,
                                   $endTime);
        } else if ($this->data == 'page_views') {
            $ga->requestReportData($this->profile,
                                   array('date'),
                                   array('pageviews'),
                                   null,
                                   null,
                                   $startTime,
                                   $endTime);
        }
        
        $this->tabularData = '[';
        $results = array();
        foreach($ga->getResults() as $result) {
            $results[(string) $result] = $result;
        }
        ksort($results);
        foreach($results as $result) {
            $this->tabularData .= '["' . preg_replace('~^(\d{4})(\d{2})(\d{2})$~', '\\1-\\2-\\3', $result) . '",' . $result->{'get' . sfInflector::classify($this->data)}() . '],';
        }
        $this->tabularData = substr($this->tabularData, 0, -1) . ']';
    }
}