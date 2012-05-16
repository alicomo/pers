<?php

/**
 * BaseAdminTask actions.
 *
 * @package    sfRedminishAdminPlugin
 * @subpackage adminTask
 * @author     Sébastien Eustace <sebastien.eustace@gmail.com>
 * @version    $Revision$
 */

class BaseAdminTaskActions extends sfActions
{
  public function executeDbBackup(sfWebRequest $request)
  {
    $this->task = 'sfDatabaseBackupTask';
    
    $this->options = array();
    
    $this->options['hostname'] = $request->getHost();
    
    return $this->runTask();
  }
  
  public function executeClearCache(sfWebRequest $request)
  {
    $this->task = 'sfCacheClearTask';
    
    $this->options = array();
    
    $this->options['type'] = 'all';
    
    return $this->runTask();
  }
    
  
  protected function runTask()
  {
    $taskExecuter = new sfTaskExecuter($this->task, array(), $this->options, $this->getContext());
    
    try {
      return $this->renderText($taskExecuter->execute());
    } catch (Exception $e) {
      return $this->renderText('Error : ' . $e->getMessage());
    }
    
    return sfView::NONE;
  }
}