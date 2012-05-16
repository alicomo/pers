  public function executeUpdate(sfWebRequest $request)
  {
    $this-><?php echo $this->getSingularName() ?> = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this-><?php echo $this->getSingularName() ?>);

    $this->processForm($request, $this->form);

	if ($request->isXmlHttpRequest()) {
		return $this->renderPartial('form', array('<?php echo $this->getSingularName() ?>' => $this-><?php echo $this->getSingularName() ?>,
												  'form' => $this->form));
	}
	
    $this->setTemplate('edit');
  }
