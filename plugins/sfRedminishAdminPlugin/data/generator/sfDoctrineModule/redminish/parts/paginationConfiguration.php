  public function getPagerClass()
  {
    return '<?php echo isset($this->config['list']['pager_class']) ? $this->config['list']['pager_class'] : 'sfDoctrinePager' ?>';
<?php unset($this->config['list']['pager_class']) ?>
  }

  public function getPagerMaxPerPage()
  {
    if ($maxPerPage = sfContext::getInstance()->getUser()->getAttribute('max_per_page')) {
      return $maxPerPage;
    }

    $maxPerPage = <?php echo isset($this->config['list']['max_per_page']) ? (integer) $this->config['list']['max_per_page'] : 30 ?>;
    <?php unset($this->config['list']['max_per_page']) ?>

    sfContext::getInstance()->getUser()->setAttribute('max_per_page', $maxPerPage);
  
    return $maxPerPage;
  }
