[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

[?php include_partial('<?php echo $this->getModuleName() ?>/header', array('configuration' => $configuration)) ?]

<div id="sf_admin_container">

  <div id="header">
      [?php if ($mainTitle = sfConfig::get('app_sfRedminishAdminPlugin_title')) : ?]
      <h1><a href="[?php echo url_for('@homepage') ?]" title="[?php echo __('Go to homepage') ?]" class="main_title">[?php echo __($mainTitle) ?]</a></h1>
      [?php else: ?]
      <h1>[?php echo <?php echo $this->getI18NString('new.title') ?> ?]</h1>
      [?php endif; ?]
    
    [?php include_partial('<?php echo $this->getModuleName() ?>/menu', array('module_name' => '<?php echo $this->getModuleName() ?>')) ?]
  
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_header', array('pager' => $pager)) ?]
  </div>

  <div id="main">
  
    <div id="sidebar">
    [?php include_partial('<?php echo $this->getModuleName() ?>/tasks') ?]
    </div>

  <div id="content">
  
   [?php include_partial('<?php echo $this->getModuleName() ?>/breadcrumb', array('module_name' => '<?php echo $this->getModuleName() ?>','action_name' => $this->getActionName())) ?]
   
  <h2>[?php echo <?php echo $this->getI18NString('list.title') ?> ?]</h2>
  
  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]
  
  <?php if ($this->configuration->hasFilterForm()): ?>
  [?php include_partial('<?php echo $this->getModuleName() ?>/filters', array('form' => $filters, 'configuration' => $configuration)) ?]
  <?php endif; ?>
  
<?php if ($this->configuration->getValue('list.batch_actions')): ?>
    <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'batch')) ?]" method="post">
<?php endif; ?>
    [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?]

    [?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]
    
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_actions', array('helper' => $helper)) ?]
<?php if ($this->configuration->getValue('list.batch_actions')): ?>
    </form>
<?php endif; ?>
  </div>
  </div>

  <div id="sf_admin_footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_footer', array('pager' => $pager)) ?]
  </div>
</div>
