<?php

/**
 * Dashboard actions.
 *
 * @package    sfRedminishAdminPlugin
 * @subpackage dashboard
 * @author     Sébastien Eustace <sebastien.eustace@gmail.com>
 * @version    $Revision$
 */

// Necessary due to a bug in the Symfony autoloader
require_once(dirname(__FILE__).'/../lib/BaseDashboardActions.class.php');

class DashboardActions extends BaseDashboardActions
{
  // See how this extends BaseDashboardActions? You can replace it with
  // your own version by adding a modules/dashboard/actions/actions.class.php
  // to your own application and extending BaseDashboardActions there as well.
}
