<?php

/**
 * AdminTask actions.
 *
 * @package    sfRedminishAdminPlugin
 * @subpackage adminTask
 * @author     Sébastien Eustace <sebastien.eustace@gmail.com>
 * @version    $Revision$
 */

// Necessary due to a bug in the Symfony autoloader
require_once(dirname(__FILE__).'/../lib/BaseAdminTaskActions.class.php');

class AdminTaskActions extends BaseAdminTaskActions
{
  // See how this extends BaseAdminTaskActions? You can replace it with
  // your own version by adding a modules/adminTask/actions/actions.class.php
  // to your own application and extending BaseAdminTaskActions there as well.
}
