<div class="box">
    <h3><?php echo __($name) ?></h3>
    <?php if (count($results) > 0) : ?>
    <ul>
        <?php foreach ($results as $result) : ?>
        <li>
        <a href="<?php echo url_for(array('sf_route' => $route, 'sf_subject' => $result)) ?>"><?php echo $result ?></a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php if ( ! empty($global)) : ?>
    <p><a href="<?php echo url_for('@' . $global['route']) ?>" title="<?php echo __($global['text']) ?>"><?php echo __($global['text']) ?></a></p>
    <?php endif; ?>
    <?php else : ?>
    <p><?php echo __('No results') ?></p>
    <?php endif; ?>
</div>