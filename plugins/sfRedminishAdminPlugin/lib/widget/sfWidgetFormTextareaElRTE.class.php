<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormTextareaTinyMCE represents a Tiny MCE widget.
 *
 * You must include the Tiny MCE JavaScript file by yourself.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormTextareaTinyMCE.class.php 17192 2009-04-10 07:58:29Z fabien $
 */
class sfWidgetFormTextareaElRTE extends sfWidgetFormTextarea
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * theme:  The Tiny MCE theme
   *  * width:  Width
   *  * height: Height
   *  * config: The javascript configuration
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('lang', sfConfig::get('app_default_culture', 'en'));
    //$this->addOption('width');
    $this->addOption('height', 450);
    $this->addOption('allowSource', true);
    $this->addOption('toolbar', 'complete');
    $this->addRequiredOption('elfinder_url');
  }

  /**
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
    $textarea = parent::render($name, $value, $attributes, $errors);

    $js = sprintf(<<<EOF
<script type="text/javascript" charset="utf-8">
    $().ready(function() {
        var opts = {
            'doctype'      : '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
            'lang'         : '%s',   // set your language
            'styleWithCSS' : true,
            'allowSource'  : %s,
            'height'       : %s,
            'toolbar'      : '%s',
            'absoluteURLs' : false,
            'cssfiles'     : ['/sfRedminishAdminPlugin/css/jquery/elrte/elrte-inner.css'],
            'fmOpen' : function(callback) {
                    $('<div id="%s-elfinder" />').elfinder({
                        url : '%s',
                        lang : 'en',
                        dialog : { width : 900, modal : true, title : 'elFinder - file manager for web' },
                        closeOnEditorCallback : true,
                        editorCallback : callback
                    })
                }
            
        };
        // create editor
        $('#%s').unbind('.dynSiz').elrte(opts);
        
    });
</script>
EOF
    ,
      $this->getOption('lang'),
      $this->getOption('allowSource'),
      $this->getOption('height'),
      $this->getOption('toolbar'),
      $this->generateId($name),
      $this->getOption('elfinder_url'),
      $this->generateId($name)
    );

    return $textarea.$js;
  }
  
  /*public function getJavascripts()
  {
    return array('/sfRedminishAdminPlugin/js/jquery/elrte/elrte.min.js');
  }*/

  /**
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  /*public function getStylesheets()
  {
    return array('/sfRedminishAdminPlugin/css/jquery/elrte/elrte.full.css' => 'all',
                 '/sfRedminishAdminPlugin/css/jquery/elrte/elrte-inner.css' => 'all');
  }*/
}
