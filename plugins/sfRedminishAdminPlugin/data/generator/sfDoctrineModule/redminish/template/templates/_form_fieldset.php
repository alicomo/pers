[?php
    $fieldsNumber = 0;
    foreach ($fields as $name => $field) {
        if (isset($form[$name])) {
            $fieldsNumber++;
        }
    }
?]
[?php if ($fieldsNumber > 0) : ?]
<fieldset id="sf_fieldset_[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]" class="generated_fieldset">
  [?php if ('NONE' != $fieldset): ?]
   [?php $errors = 0; foreach ($fields as $name => $field): ?]
   [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && method_exists($field, 'isReal') && $field->isReal())) continue ?]
     [?php if (isset($form[$name]) && $form[$name] instanceof sfFormFieldSchema) : ?]
       [?php foreach ($form[$name] as $subName => $subField) : ?]
         [?php if ($form[$name][$subName]->hasError()) $errors++ ?]
       [?php endforeach ?]
     [?php else : ?]
       [?php if (isset($form[$name]) && $form[$name]->hasError()) $errors++ ?]
     [?php endif; ?]
   [?php endforeach; ?]
    <h3[?php if ($errors > 0) : ?] class="error"[?php endif; ?]>[?php echo __($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</h3>
    [?php if ($errors > 0) : ?]
    <p class="error">[?php
        echo format_number_choice(
                '[1]1 error|(1,+Inf]%count% errors',
                array('%count%' => $errors),
                $errors
             )
        ?]</p>
    [?php endif; ?]
  [?php endif; ?]

  <div class="fieldset_content[?php if (sfConfig::get('app_sfRedminishAdminPlugin_form_stay_opened')) : ?] opened[?php endif; ?]">
  [?php foreach ($fields as $name => $field): ?]
    [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && method_exists($field, 'isReal') && $field->isReal())) continue ?]
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_field', array(
      'name'       => $name,
      'attributes' => get_class($field) == 'sfFormField' ? $field->getWidget()->getAttributes() : $field->getConfig('attributes', array()),
      'label'      => get_class($field) == 'sfFormField' ? $field->getWidget()->getLabel(): $field->getConfig('label'),
      'help'       => get_class($field) == 'sfFormField' ? $field->renderHelp(): $field->getConfig('help'),
      'form'       => $form,
      'field'      => $field,
      'class'      => get_class($field) == 'sfFormField' ? $attributes['type'] : 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_form_field_'.$name,
      'parent'     => isset($parent) ? $parent : null,
    )) ?]
  [?php endforeach; ?]
  </div>
</fieldset>
[?php endif; ?]
