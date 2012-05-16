<?php $menu = sfConfig::get('app_sfRedminishAdminPlugin_menu') ?>
<div class="breadcrumb">
    <?php if ($module_name != 'dashboard') : ?>
    <a href="<?php echo url_for('@dashboard') ?>" title="<?php echo __('Go to dashboard') ?>"><?php echo __('Dashboard', array(), 'sf_admin') ?></a>
    <?php if(isset($menu[$module_name])) : ?>
    <?php if ($action_name == 'index') : ?>
    &raquo; <?php echo __($menu[$module_name]['name']) ?>
    <?php else : ?>
    &raquo; <a href="<?php echo url_for('@' . $menu[$module_name]['route']) ?>" title="<?php echo __('Go to dashboard') ?>"><?php echo __($menu[$module_name]['name']) ?></a>
    &raquo; <?php echo $title ?>
    <?php endif; ?>
    <?php else : ?>
    <?php foreach($menu as $module => $params) : ?>
    <?php if (isset($params['submenu'])) : ?>
    <?php foreach($params['submenu'] as $submodule => $subparams) : ?>
    <?php if ($submodule == $module_name) : ?>
    <?php if (isset($params['route'])) : ?>
    &raquo; <a href="<?php echo url_for('@' . $params['route']) ?>" title="<?php echo __('Go to dashboard') ?>"><?php echo __($params['name']) ?></a>
    <?php else : ?>
    &raquo; <a href="#" title="<?php echo __('Go to dashboard') ?>"><?php echo __($params['name']) ?></a>
    <?php endif; ?>
    <?php if ($action_name == 'index') : ?>
    &raquo; <?php echo __($subparams['name']) ?>
    <?php else : ?>
    &raquo; <a href="<?php echo url_for('@' . $subparams['route']) ?>" title="<?php echo __('Go to dashboard') ?>"><?php echo __($subparams['name']) ?></a>
    &raquo; <?php echo $title ?>
    <?php endif; ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php endif; ?>
    <?php endif; ?>
</div>