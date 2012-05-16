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
  
  </div>

<div id="main">

  <div id="sidebar">
        [?php include_partial('<?php echo $this->getModuleName() ?>/tasks') ?]
        [?php include_partial('<?php echo $this->getModuleName() ?>/quick_access', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
    </div>

  <div id="content">
  
  [?php include_partial('<?php echo $this->getModuleName() ?>/breadcrumb', array('module_name' => '<?php echo $this->getModuleName() ?>','action_name' => $this->getActionName(), 'title' => <?php echo $this->getI18NString('new.title') ?>)) ?]

  <h2>[?php echo <?php echo $this->getI18NString('new.title') ?> ?]</h2>
  
  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

  <div id="sf_admin_header">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_header', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
  </div>

  <div id="sf_admin_content">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
  </div>

  <div id="sf_admin_footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_footer', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?]
  </div>
  </div>
</div>
</div>
