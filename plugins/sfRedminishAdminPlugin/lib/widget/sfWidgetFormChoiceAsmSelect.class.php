<?php

class sfWidgetFormChoiceAsmSelect extends sfWidgetForm
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * choices:            An array of possible choices (required)
   *  * source:             url, array of data or javascript function (required)
   *  * template:           The HTML template to use to render this widget
   *                        The available placeholders are:
   *                          * class
   *                          * autocomplete
   *                          * list
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options,$attributes);	
    $this->addOption('choices');

    $this->addOption('model', null);
    $this->addOption('list_options',array());
    $this->addOption('help','Search here...');
    $this->addOption('config', '{ }');
    $this->addOption('add_empty', false);
    $this->addOption('method', '__toString');
    $this->addOption('key_method', 'getPrimaryKey');
    $this->addOption('order_by', null);
    $this->addOption('query', null);
    $this->addOption('table_method', null);

    $this->addOption('template',<<<EOF
<div class="%class%">
	%asm%
    <div class="%class%_list asm_select" id="%id%_list">
		%list%
	</div>
</div>
EOF
);
  }

  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if (is_null($value))
    {
      $value = array();
    }
    
    $choices = $this->getOption('choices') ? $this->getOption('choices') : $this->getChoices();
    if ($choices instanceof sfCallable)
    {
      $choices = $choices->call();
    }

    $associatedWidget = new sfWidgetFormChoice(array_merge($this->getOption('list_options'),array('choices' => $choices, 'multiple' => true, 'expanded' => false)));
	
    return strtr($this->getOption('template'),array(
	'%class%' => 'asm-select', 
	'%id%' => $this->generateId($name), 
	'%list%' => $associatedWidget->render($name,$value), 
	'%asm%' => sprintf(<<<EOF
	<script type="text/javascript">
	  jQuery(document).ready(function() {
			
	    $(document).ready(function() {
            $("#%s").asmSelect({
                animate: true
            });
        }); 
					
      });			
</script>
EOF
 ,
	$this->generateId($name)
      )
    ));
  }
  
  /**
   * Returns the choices associated to the model.
   *
   * @return array An array of choices
   */
  public function getChoices()
  {
    $choices = array();
    if (false !== $this->getOption('add_empty'))
    {
      $choices[''] = true === $this->getOption('add_empty') ? '' : $this->translate($this->getOption('add_empty'));
    }

    if (null === $this->getOption('table_method'))
    {
      $query = null === $this->getOption('query') ? Doctrine_Core::getTable($this->getOption('model'))->createQuery() : $this->getOption('query');
      if ($order = $this->getOption('order_by'))
      {
        $query->addOrderBy($order[0] . ' ' . $order[1]);
      }
      $objects = $query->execute();
    }
    else
    {
      $tableMethod = $this->getOption('table_method');
      $results = Doctrine_Core::getTable($this->getOption('model'))->$tableMethod();

      if ($results instanceof Doctrine_Query)
      {
        $objects = $results->execute();
      }
      else if ($results instanceof Doctrine_Collection)
      {
        $objects = $results;
      }
      else if ($results instanceof Doctrine_Record)
      {
        $objects = new Doctrine_Collection($this->getOption('model'));
        $objects[] = $results;
      }
      else
      {
        $objects = array();
      }
    }

    $method = $this->getOption('method');
    $keyMethod = $this->getOption('key_method');

    foreach ($objects as $object)
    {
      $choices[$object->$keyMethod()] = $object->$method();
    }

    return $choices;
  }

  public function getJavascripts()
  {
    return array('/sfRedminishAdminPlugin/js/jquery/jquery.asmselect.js');
  }

  /**
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  public function getStylesheets()
  {
    return array('/sfRedminishAdminPlugin/css/jquery/jquery.asmselect.css' => 'all');
  }
}
