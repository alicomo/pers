        [?php if (count($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit')) > 0) : ?]
        <h3>[?php echo __('Quick Access') ?]</h3>
        <ul id="quick-access">
           [?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?]
           [?php if ('NONE' != $fieldset): ?]
           <li>
             <a href="#sf_fieldset_[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]" title="[?php echo __('See section: ') . __($fieldset) ?]" >[?php echo __($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</a>
           </li>
           [?php endif; ?]
           [?php endforeach; ?]
        </ul>
        [?php endif; ?]