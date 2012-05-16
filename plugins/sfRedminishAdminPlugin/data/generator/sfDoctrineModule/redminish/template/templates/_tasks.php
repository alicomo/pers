        [?php if ($tasks = sfConfig::get('app_sfRedminishAdminPlugin_tasks')) : ?]
        <h3>[?php echo __('Tasks') ?]</h3>
        <ul id="menu-tasks">
           [?php foreach ($tasks as $task => $options) : ?]
           <li class="icon[?php if (isset($options['icon'])) : ?] icon-[?php echo $options['icon'] ?][?php endif; ?]">
             <a href="[?php echo url_for('adminTask/' . $options['action']) ?]" title="[?php echo __($options['name']) ?]">[?php echo __($options['name']) ?]</a>
           </li>
           [?php endforeach; ?]
        </ul>
        [?php endif; ?]