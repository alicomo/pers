<div class="graph">
    <h4><?php echo __(sfInflector::humanize(sfInflector::underscore($name)))?></h4>
    
    <div id="graph_<?php echo sfInflector::underscore($name) ?>" rel="<?php echo $name ?>">
    <p><img src="/sfRedminishAdminPlugin/images/ajax-loader.gif" alt="<?php echo __('Loading') ?>" class="loading" /><strong><?php echo __('Loading') ?></strong></p>
    </div>
</div>