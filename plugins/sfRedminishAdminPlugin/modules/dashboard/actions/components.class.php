<?php

/**
 * Dashboard components.
 *
 * @package    sfRedminishAdminPlugin
 * @subpackage dashboard
 * @author     Sébastien Eustace <sebastien.eustace@gmail.com>
 * @version    $Revision$
 */

// Necessary due to a bug in the Symfony autoloader
require_once(dirname(__FILE__).'/../lib/BaseDashboardComponents.class.php');

class DashboardComponents extends BaseDashboardComponents
{
  // See how this extends BaseDashboardComponents? You can replace it with
  // your own version by adding a modules/dashboard/actions/components.class.php
  // to your own application and extending BaseDashboardComponents there as well.
}