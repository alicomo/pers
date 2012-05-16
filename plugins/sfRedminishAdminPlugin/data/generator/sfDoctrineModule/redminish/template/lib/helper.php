[?php

/**
 * <?php echo $this->getModuleName() ?> module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage <?php echo $this->getModuleName()."\n" ?>
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: helper.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class Base<?php echo ucfirst($this->getModuleName()) ?>GeneratorHelper extends sfModelGeneratorHelper
{
  public function getUrlForAction($action)
  {
    return 'list' == $action ? '<?php echo $this->params['route_prefix'] ?>' : '<?php echo $this->params['route_prefix'] ?>_'.$action;
  }
  
  public function linkToNew($params)
  {
    if (!key_exists('icon', $params)) $params['icon'] = 'add';
    $params['params']['class'] = 'icon icon-add';
    return link_to(__($params['label'] , array(), 'sf_admin'), '@'.$this->getUrlForAction('new'), $params['params']).'</li>';
  }
  
  public function linkToDelete($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }

    $params['params']['class'] = 'icon icon-del ' . 'sf_admin_action_' . $params['class_suffix'];
    return link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('delete'), $object, array('class' => $params['params']['class'],'method' => 'delete', 'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm'])).'</li>';
  }
  
  public function linkToEdit($object, $params)
  {
    $params['params']['class'] = 'icon icon-edit ' . 'sf_admin_action_' . $params['class_suffix'];;
    return link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('edit'), $object, $params['params']);
  }
  
  public function linkToList($params)
  {
    $params['params']['class'] = 'icon icon-cancel';
    return link_to(__($params['label'], array(), 'sf_admin'), '@'.$this->getUrlForAction('list'),$params['params']);
  }

  public function linkToSave($object, $params)
  {
    return '<button type="submit">'. __($params['label'], array(), 'sf_admin').'</button>';
  }

  public function linkToSaveAndAdd($object, $params)
  {
    if (!$object->isNew())
    {
      return '';
    }

    return '<button type="submit" name="_save_and_add">'. __($params['label'], array(), 'sf_admin').'</button>';
  }
}
