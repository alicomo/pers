<?php if (isset($this->params['css']) && ($this->params['css'] !== false)): ?> 
[?php use_stylesheet('<?php echo $this->params['css'] ?>', 'first') ?] 
<?php elseif(!isset($this->params['css'])): ?> 
[?php use_stylesheet('<?php echo sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin').'/css/default.css' ?>', 'first') ?]
[?php use_stylesheet('<?php echo sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin').'/css/jquery/jquery-ui-1.8.2.css' ?>', 'last') ?]
[?php use_stylesheet('<?php echo sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin').'/css/adjustments.css' ?>', 'last') ?]
<?php endif; ?>

<?php if (isset($this->params['js']) && ($this->params['js'] !== false)): ?> 
[?php use_javascript('<?php echo $this->params['js'] ?>', 'first') ?] 
<?php elseif(!isset($this->params['js'])): ?> 
[?php use_javascript('<?php echo sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin').'/js/jquery/jquery-1.4.2.min.js' ?>', 'first') ?]
[?php use_javascript('<?php echo sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin').'/js/jquery/jquery-ui-1.8.2.min.js' ?>', 'last') ?]
[?php use_javascript('<?php echo sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin').'/js/jquery/jquery.localscroll-1.2.7-min.js' ?>', 'last') ?]
[?php use_javascript('<?php echo sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin').'/js/jquery/jquery.scrollTo-1.4.2-min.js' ?>', 'last') ?]
[?php use_javascript('<?php echo sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin').'/js/jquery/autoresize.jquery.min.js' ?>', 'last') ?]
[?php use_javascript('<?php echo sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin').'/js/generator.js' ?>', 'last') ?]
<?php endif; ?>