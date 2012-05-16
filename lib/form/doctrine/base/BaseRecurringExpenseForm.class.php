<?php

/**
 * RecurringExpense form base class.
 *
 * @method RecurringExpense getObject() Returns the current form's model object
 *
 * @package    pers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRecurringExpenseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'date_of_payment' => new sfWidgetFormDate(),
      'name'            => new sfWidgetFormInputText(),
      'description'     => new sfWidgetFormTextarea(),
      'amount'          => new sfWidgetFormInputText(),
      'recurring_type'  => new sfWidgetFormChoice(array('choices' => array('daily' => 'daily', 'weekly' => 'weekly', 'monthly' => 'monthly', 'bi-monthly' => 'bi-monthly', 'quarterly' => 'quarterly', 'half-yearly' => 'half-yearly', 'annually' => 'annually', 'bi-annually' => 'bi-annually'))),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'deleted_at'      => new sfWidgetFormDateTime(),
      'created_by'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'date_of_payment' => new sfValidatorDate(),
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'description'     => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'amount'          => new sfValidatorNumber(),
      'recurring_type'  => new sfValidatorChoice(array('choices' => array(0 => 'daily', 1 => 'weekly', 2 => 'monthly', 3 => 'bi-monthly', 4 => 'quarterly', 5 => 'half-yearly', 6 => 'annually', 7 => 'bi-annually'), 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'deleted_at'      => new sfValidatorDateTime(array('required' => false)),
      'created_by'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('recurring_expense[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RecurringExpense';
  }

}
