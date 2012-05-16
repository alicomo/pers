<?php

/**
 * BaseDashboard actions.
 *
 * @package    sfRedminishAdminPlugin
 * @subpackage dashboard
 * @author     Sébastien Eustace <sebastien.eustace@gmail.com>
 * @version    $Revision$
 */

class BaseDashboardActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $this->dashboard = sfConfig::get('app_sfRedminishAdminPlugin_dashboard');
        
        if ( ! $this->dashboard) {
            return sfView::SUCCESS;
        }
        
        $this->left = isset($this->dashboard['left']) ? $this->dashboard['left'] : array();
        $this->right = isset($this->dashboard['right']) ? $this->dashboard['right'] : array();
    }
    
    public function executeGraph(sfWebRequest $request)
    {
    	$this->forward404If( ! $request->isXmlHttpRequest() || ! $this->name = $request->getPostParameter('name'));
    	
    	$this->analytics = sfConfig::get('app_sfRedminishAdminPlugin_analytics');
    	
    	$this->graphData = $this->analytics['graphs'][$this->name];
    	
    	$this->makeGaApiRequest();
    	$this->getGraphOptions();
    	
    	$data = array('tabularData'  => $this->tabularData,
    	              'graphOptions' => $this->options);
    	
    	$this->getResponse()->setHttpHeader('Content-type', 'application/json');
        $this->getResponse()->setContent(json_encode($data));
      
        return sfView::NONE;
    }
    
    public function makeGaApiRequest()
    {
        $ga = new gapi($this->analytics['email'], $this->analytics['password']);
        
        switch ($this->graphData['period']) {
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
        
        if (is_array($this->graphData['data']) && count($this->graphData['data']) > 1) {
            $getData = $this->graphData['data'];
            
            $ga->requestReportData($this->analytics['profile'],
                                       array('date'),
                                       $getData,
                                       null,
                                       null,
                                       $startTime,
                                       $endTime);
                                       
            $this->tabularData = array();
            
            foreach ($this->graphData['data'] as $key => $data) {
                $results = array();
                foreach($ga->getResults() as $result) {
                    $results[(string) $result] = $result;
                }
                ksort($results);
                
                if ($key == 0) {
                    $xyaxe = array();
                    foreach($results as $result) {
                        $xyaxe[] = array(preg_replace('~^(\d{4})(\d{2})(\d{2})$~', '\\1-\\2-\\3', $result), $result->{'get' . sfInflector::classify($data)}());
                    }
                    $this->tabularData[] = $xyaxe;
                } else {
                    $xyaxe = array();
                    foreach($results as $result) {
                        $xyaxe[] = array(preg_replace('~^(\d{4})(\d{2})(\d{2})$~', '\\1-\\2-\\3', $result), $result->{'get' . sfInflector::classify($data)}());
                    }
                    $this->tabularData[] = $xyaxe;
                }
            }
        } else {
            $getData = array($this->graphData['data']);
            
            $ga->requestReportData($this->analytics['profile'],
                                   array('date'),
                                   $getData,
                                   null,
                                   null,
                                   $startTime,
                                   $endTime);
            
            $this->tabularData = array();
            $results = array();
            foreach($ga->getResults() as $result) {
                $results[(string) $result] = $result;
            }
            ksort($results);
            foreach($results as $result) {
                $this->tabularData[] = array(preg_replace('~^(\d{4})(\d{2})(\d{2})$~', '\\1-\\2-\\3', $result) , $result->{'get' . sfInflector::classify($this->graphData['data'])}());
            }
            $this->tabularData = array($this->tabularData);
        }
    }
    
    public function getGraphOptions()
    {
        if (is_array($this->graphData['data']) && count($this->graphData['data']) > 1) {
        	$this->options = array('series'      => array(array('lines' => array('show' => true))),
        	                       'axesDefaults' => array('useSeriesColor' => true,
                                                           'pad' => 1),
        	                       'axes'        => array('xaxis' => array('label'     => 'Date',
        	                                                               'autoscale' => true,
        	                                                               'renderer'  => '$.jqplot.DateAxisRenderer'),),
        	                       'highlighter' => array('sizeAdjust' => 7.5),
        	                       'cursor'      => array('show' => false));
        	
        	foreach ($this->graphData['data'] as $key => $data) {
        	    $this->options['series'][] = array('lines' => array('show' => true));
        	    $y = $key != 0 ? $key + 1 : '';
        	    
        	    if ($y != '') {
        	        $this->options['series'][$key]['yaxis'] = 'y' . $y . 'axis';
        	    }
        	    
        	    $this->options['axes']['y' . $y . 'axis'] = array('label'     => sfInflector::humanize(sfInflector::underscore($data)),
                                                                  'autoscale' => true);
        	    
        	    if (isset($this->graphData['params'])) {
        	        if (isset($this->graphData['params'][$data])) {
        	            $this->options['series'][$key] = array_merge($this->options['series'][$key], $this->graphData['params'][$data]);
        	        } else {
        	            $this->options['series'][$key] = array_merge($this->options['series'][$key], $this->graphData['params']);
        	        }
        	    }
        	}
        } else {
            $this->options = array('series'      => array(array('lines' => array('show' => true))),
                                   'axesDefaults' => array('useSeriesColor' => true,
                                                           'pad' => 1),
                                   'axes'        => array('xaxis' => array('label'     => 'Date',
                                                                           'autoscale' => true,
                                                                           'renderer'  => '$.jqplot.DateAxisRenderer'),
                                                          'yaxis' => array('label'     => sfInflector::humanize(sfInflector::underscore($this->name)),
                                                                         'autoscale' => true),),
                                   'highlighter' => array('sizeAdjust' => 7.5),
                                   'cursor'      => array('show' => false));
            
            if (isset($this->graphData['params'])) {
                $this->options['series'][0] = array_merge($this->options['series'][0], $this->graphData['params']);
            }
        }
    }
}