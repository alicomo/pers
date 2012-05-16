    <p class="pagination">
        [?php if ($pager->getPage() > 1): ?]
        <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getPreviousPage() ?]">
            &laquo; [?php echo __('Previous page', array(), 'sf_admin') ?]
        </a>
        [?php endif; ?]
        
        [?php if (count($pager->getLinks()) > 1) : ?]
        [?php foreach ($pager->getLinks() as $page): ?]
        [?php if ($page == $pager->getPage()): ?]
          [?php echo $page ?]
        [?php else: ?]
          <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $page ?]">[?php echo $page ?]</a>
        [?php endif; ?]
        [?php endforeach; ?]
        
        [?php if ($pager->getPage() < $pager->getLastPage()): ?]
        <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getNextPage() ?]">
            [?php echo __('Next page', array(), 'sf_admin') ?] &raquo;
        </a>
        [?php endif; ?]
        [?php endif; ?]
        
        [?php
        $first = ($pager->getPage() * $pager->getMaxPerPage() - $pager->getMaxPerPage() + 1);
        $last = $first + $pager->getMaxPerPage() - 1;
        ?]
        [?php
        echo __('(%1%-%2%/%3%)',
          array(
            '%1%' => $first,
            '%2%' => ($last > $pager->getNbResults()) ? $pager->getNbResults() : $last,
            '%3%' => $pager->getNbResults()
          )
        )
        ?]
        
        | [?php echo __('Per Page') ?] :
        [?php
        $pageCounts = array('10', '30', '50', '100');
        foreach($pageCounts as $key => $perPage) :
        ?]
        [?php if ($sf_user->getAttribute('max_per_page') == $perPage) : ?]
        [?php echo $perPage ?][?php if($key != count($pageCounts) - 1) : ?], [?php endif; ?]
        [?php else : ?]
        <a href="[?php echo preg_replace('~/action\?~', '?', url_for('<?php echo $this->getModuleName() ?>/changeMaxPerPage?max_per_page=' . $perPage)) ?]">[?php echo $perPage ?]</a>[?php if($key != count($pageCounts) - 1) : ?], [?php endif; ?]
        [?php endif; ?]
        [?php endforeach; ?]
    </p>
