<?php

/**
 * sfRedminishAdminPlugin configuration.
 * 
 * @package     sfRedminishAdminPlugin
 * @subpackage  config
 * @author      Sébastien Eustace <sebastien.eustace@gmail.com>
 */
class sfRedminishAdminPluginConfiguration extends sfPluginConfiguration
{
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
      if (!sfConfig::get('app_sfRedminishAdminPlugin')) {
          throw new sfException('Missing options for sfRedminishAdminPlugin');
      }
  }
}
