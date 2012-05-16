<?php use_helper('I18N', 'Date') ?>
<?php if ($analytics = sfConfig::get('app_sfRedminishAdminPlugin_analytics')) : ?>
<?php use_javascript(sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin') . '/js/jquery/jqplot/jquery.jqplot.min.js', 'last') ?>
<?php use_javascript(sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin') . '/js/jquery/jqplot/plugins/jqplot.dateAxisRenderer.min.js', 'last') ?>
<?php use_javascript(sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin') . '/js/jquery/jqplot/plugins/jqplot.highlighter.min.js', 'last') ?>
<?php use_javascript(sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin') . '/js/jquery/jqplot/plugins/jqplot.cursor.min.js', 'last') ?>
<?php use_stylesheet(sfConfig::get('app_sf_redminish_admin_plugin_web_dir', '/sfRedminishAdminPlugin') . '/css/jquery/jqplot/jquery.jqplot.css', 'last') ?>
<?php endif; ?>
<?php include_partial('dashboard/assets') ?>

<?php include_partial('dashboard/header') ?>

<div id="dashboard-container">

  <div id="header">
    <?php if ($mainTitle = sfConfig::get('app_sfRedminishAdminPlugin_title')) : ?>
    <h1><a href="<?php echo url_for('@homepage') ?>" title="<?php echo __('Go to homepage') ?>" class="main_title"><?php echo __($mainTitle) ?></a></h1>
    <?php else: ?>
    <h1><?php echo __('Dashboard') ?></h1>
    <?php endif; ?>
    
    <?php include_partial('dashboard/menu', array('module_name' => 'dashboard')) ?>
  </div>

  <div id="main">
  
    <div id="sidebar">
        <?php if ($tasks = sfConfig::get('app_sfRedminishAdminPlugin_tasks')) : ?>
        <h3><?php echo __('Tasks') ?></h3>
        <ul id="menu-tasks">
           <?php foreach ($tasks as $task => $options) : ?>
           <li class="icon<?php if (isset($options['icon'])) : ?> icon-<?php echo $options['icon'] ?><?php endif; ?>">
             <a href="<?php echo url_for('adminTask/' . $options['action']) ?>" title="<?php echo __($options['name']) ?>"><?php echo __($options['name']) ?></a>
           </li>
           <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

  <div id="content">
  
   <?php include_partial('dashboard/breadcrumb', array('module_name' => 'dashboard','action_name' => 'index')) ?>
   
  <h2><?php echo __('Dashboard') ?></h2>
  
  <?php if ($analytics = sfConfig::get('app_sfRedminishAdminPlugin_analytics')) : ?>
  <div id="graphs" class="box">
  <h3><?php echo __('Graphs') ?></h3>
  <?php if (isset($analytics['graphs'])) : ?>
  <?php foreach ($analytics['graphs'] as $name => $data) : ?>
  <?php include_component(
            'dashboard',
            'graph',
            array(
                'name'     => $name,
                'data'     => $data['data'],
                'period'   => $data['period'],
                'grid'     => isset($data['grid']) ? $data['grid'] : null,
                'params'   => isset($data['params']) ? $data['params'] : null,
                'profile'  => $analytics['profile'],
                'email'    => $analytics['email'],
                'password' => $analytics['password']
            )
        )
  ?>
  <?php endforeach; ?>
  <?php endif; ?>
  </div>
  <?php endif; ?>
  
  <?php if ( ! empty($left)) : ?>
  <div class="splitcontentleft">
  <?php foreach ($left as $name => $options) : ?>
  <?php include_component(
            'dashboard',
            'box',
            array(
                'name'   => $name,
                'model'  => $options['model'],
                'method' => isset($options['method']) ? $options['method'] : null,
                'limit'  => $options['limit'],
                'route'  => $options['route'],
                'global' => isset($options['global']) ? $options['global'] : null
            )
        )
  ?>
  <?php endforeach; ?>
  </div>
  <?php endif; ?>
  
  <?php if ( ! empty($right)) : ?>
  <div class="splitcontentright">
  <?php foreach ($right as $name => $options) : ?>
  <?php include_component(
            'dashboard',
            'box',
            array(
                'name'   => $name,
                'model'  => $options['model'],
                'method' => isset($options['method']) ? $options['method'] : null,
                'limit'  => $options['limit'],
                'route'  => $options['route'],
                'global' => isset($options['global']) ? $options['global'] : null
            )
        )
  ?>
  <?php endforeach; ?>
  </div>
  <?php endif; ?>