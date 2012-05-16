<div id="top-menu">
    <?php if ($sf_user->isAuthenticated() && method_exists($sf_user->getRawValue(), 'getGuardUser')) : ?>
    <div id="account">
        <ul>
            <li>
                <a href="<?php echo url_for('@sf_guard_user_edit?id=' . $sf_user->getGuardUser()->getId()) ?>" class="my-account"><?php echo __('My account') ?></a>
            </li>
            <li>
                <a href="<?php echo url_for('@logout') ?>" class="logout"><?php echo __('Logout') ?></a>
            </li>
        </ul>
    </div>
    <div id="loggedas">
        Connecté en tant que <a href="<?php echo url_for('@sf_guard_user_edit?id=' . $sf_user->getGuardUser()->getId()) ?>"><?php echo $sf_user->getUsername() ?></a>
    </div>
    <?php endif; ?>

    <ul>
        <li>
            <a href="<?php echo url_for('@homepage') ?>" title="<?php echo __('Go to homepage') ?>" class="home"><?php echo __('Home') ?></a>
        </li>
    </ul>
</div>