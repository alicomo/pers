[?php if (isset($form[$name])) : ?]
[?php $formElement = isset($parent) ? $parent[$name] : $form[$name] ?]
[?php if ( ! $field instanceof sfFormField && $field->isPartial()): ?]
  [?php include_partial('<?php echo $this->getModuleName() ?>/'.$name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php elseif ( ! $field instanceof sfFormField && get_class($field) != 'sfFormField' && $field->isComponent()): ?]
  [?php include_component('<?php echo $this->getModuleName() ?>', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php elseif ($formElement instanceof sfFormFieldSchema): ?]
  [?php foreach ($formElement as $subName => $subField) : ?]
  [?php if ($formElement[$subName] instanceof sfFormFieldSchema) : ?]
  [?php echo $formElement[$subName]->renderLabel() ?]
  <div class="content">
  [?php endif; ?]
  [?php $options = $subField->getWidget()->getOptions();?]
  [?php if( ! $subField->isHidden()) : ?]
  [?php include_partial('<?php echo $this->getModuleName() ?>/form_field', array(
      'name'       => $subName,
      'attributes' => get_class($subField) == 'sfFormField' ? $subField->getWidget()->getAttributes() : $field->getConfig('attributes', array()),
      'label'      => get_class($subField) == 'sfFormField' ? $subField->getWidget()->getLabel(): $field->getConfig('label'),
      'help'       => get_class($subField) == 'sfFormField' ? $subField->renderHelp(): $field->getConfig('help'),
      'form'       => $form,
      'field'      => $subField,
      'class'      => isset($options['type'])
                     ? 'sf_admin_form_row sf_admin_'.strtolower($options['type']).' sf_admin_form_field_'.$name
                     : $class,
      'parent'     => $formElement)) ?]
  [?php endif; ?]
  [?php if ($formElement[$subName] instanceof sfFormFieldSchema) : ?]
  </div>
  [?php endif; ?]
  [?php endforeach; ?]
  <div>
  [?php echo $formElement->renderHiddenFields() ?]
  </div>
[?php else: ?]
  <div class="[?php echo $class ?][?php $formElement->hasError() and print ' errors' ?]">
    <div>
      [?php
        try { 
          $validator = $form->getValidator($name);
          $testValidator =  ! $validator instanceof sfValidatorPass && true === $validator->getOption('required');
        } catch (Exception $e) {
          $testValidator = false;
        }
      ?]
      [?php if($testValidator) : ?]
      <label for="[?php echo $formElement->renderId() ?]">[?php echo __($formElement->renderLabelName()) ?] *</label>
      [?php else : ?]
      [?php echo $formElement->renderLabel($label) ?]
      [?php endif; ?]
      <div class="content">
          [?php if ($formElement->hasError()) : ?]
          [?php
              if ($attributes instanceof sfOutputEscaper) {
                  $attributes = $attributes->getRawValue();
              }
              if (isset($attributes['class'])) {
                  $attributes['class'] .= ' field-error';
              } else {
                  $attributes['class'] = 'field-error';
              }
           ?]
          [?php endif; ?]
          [?php echo $formElement->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?]
      </div>

      [?php if ($help): ?]
        <div class="help">[?php echo __($help, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</div>
      [?php elseif ($help = $formElement->renderHelp()): ?]
        <div class="help">[?php echo preg_replace('~<br( /)?>~', '', $help) ?]</div>
      [?php endif; ?]
      
      [?php if ($formElement->hasError()) : ?]
        <div class="flash error single">[?php echo __($formElement->getError()) ?]</div>
      [?php endif; ?]
    </div>
  </div>
[?php endif; ?]
[?php endif; ?]
