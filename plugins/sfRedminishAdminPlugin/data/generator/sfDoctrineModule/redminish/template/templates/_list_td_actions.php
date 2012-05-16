<td class="sf_admin_td_actions">
  <p class="buttons">
<?php foreach ($this->configuration->getValue('list.object_actions') as $name => $params): ?>
<?php if ('_delete' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->linkToDelete($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>

<?php elseif ('_edit' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->linkToEdit($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>

<?php else: ?>
    <?php
        $params['params']['class'] = 'sf_admin_action_' . $params['class_suffix'];
        if (isset($params['icon'])) {
            $params['params']['class'] .= ' icon icon-' . $params['icon'];
        }
        echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>
<?php endif; ?>
<?php endforeach; ?>
  </p>
</td>
