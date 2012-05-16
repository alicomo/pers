    [?php if (sfConfig::get('app_sfRedminishAdminPlugin_menu')) : ?]
    <div id="main-menu">
        <ul>
            [?php $userPermissions = method_exists('myUser', 'getGuardUser') ? $sf_user->getAllPermissionNames()->getRawValue() : true; foreach (sfConfig::get('app_sfRedminishAdminPlugin_menu') as $module => $params) : ?]
            [?php //if ((isset($params['credentials']) && method_exists('myUser', 'getGuardUser') && $params['credentials'] == array_intersect($params['credentials'], $userPermissions)) || ! isset($params['credentials']) || true === $userPermissions) : ?]
            [?php if (isset($params['submenu'])) : ?]
            <li>
                [?php if (isset($params['name']) && isset($params['route'])) : ?]
                <a href="[?php echo url_for('@' . $params['route'])?]" title=""[?php if ($module == $module_name || in_array($module_name, array_keys($params['submenu']))) : ?] class="selected"[?php endif; ?]>[?php echo __($params['name']) ?]</a>
                [?php else : ?]
                <a href="#" title=""[?php if ($module == $module_name || in_array($module_name, array_keys($params['submenu']))) : ?] class="selected"[?php endif; ?]>[?php echo __($params['name']) ?]</a>
                [?php endif; ?]
                <ul class="submenu">
                    [?php foreach ($params['submenu'] as $submodule => $subparams) : ?]
                    [?php //if ((isset($subparams['credentials']) && method_exists('myUser', 'getGuardUser') && $subparams['credentials'] == array_intersect($subparams['credentials'], $userPermissions)) || ! isset($subparams['credentials']) || true === $userPermissions) : ?]
                    <li><a href="[?php echo url_for('@' . $subparams['route'])?]" title=""[?php if ($submodule == $module_name) : ?] class="selected"[?php endif; ?]>[?php echo __($subparams['name']) ?]</a></li>
                    [?php //endif; ?]
                    [?php endforeach; ?]
                </ul>
            </li>
            [?php else : ?]
            <li><a href="[?php echo url_for('@' . $params['route'])?]" title=""[?php if ($module == $module_name) : ?] class="selected"[?php endif; ?]>[?php echo __($params['name']) ?]</a></li>
            [?php endif; ?]
            [?php //endif; ?]
            [?php endforeach; ?]
        </ul>
    </div>
    [?php endif; ?]