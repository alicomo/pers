<?php

/**
 * AdminTask components.
 *
 * @package    sfRedminishAdminPlugin
 * @subpackage adminTask
 * @author     Sébastien Eustace <sebastien.eustace@gmail.com>
 * @version    $Revision$
 */

// Necessary due to a bug in the Symfony autoloader
require_once(dirname(__FILE__).'/../lib/BaseAdminTaskComponents.class.php');

class AdminTaskComponents extends BaseAdminTaskComponents
{
  // See how this extends BaseAdminTaskComponents? You can replace it with
  // your own version by adding a modules/adminTask/actions/components.class.php
  // to your own application and extending BaseAdminTaskComponents there as well.
}