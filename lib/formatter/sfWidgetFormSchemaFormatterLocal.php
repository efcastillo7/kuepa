<?php
/**
 * Description of sfWidgetFormSchemaFormatterRadio
 *
 * @author pabloks
 */
class sfWidgetFormSchemaFormatterLocal extends sfWidgetFormSchemaFormatter
{
    protected
      // $rowFormat                 = '<div class="form-item"><div class="form-label">%label%:</div><div class="form-field %row_class%">%field%</div>%error%%help%%hidden_fields%</div>',
      $rowFormat       = "<div class='form-group %row_class%'>
            %label%\n
      		%error%\n
            %field%%help%\n%hidden_fields%
          </div>",
      $helpFormat                = '<span class="help">%help%</span>',
      $errorRowFormat            = '<span class="form-errors">Errors:</span><div>%errors%</div>',
      $errorListFormatInARow     = '<ul class="form-errors-list">%errors%</ul>',
      $errorRowFormatInARow      = '<li>%error%</li>',
      $namedErrorRowFormatInARow = '<span class="form-error-def">%name%: %error%</span>',
      $decoratorFormat           = '<div id="form-container">%content%</div>',
      $requiredCss               = 'form-required';

    protected $_validatorSchema;

      public function __construct(sfWidgetFormSchema $widgetSchema, sfValidatorSchema $validatoSchema) {
          parent::__construct($widgetSchema);
          $this->_validatorSchema = $validatoSchema;
      }



  public function formatRow($label, $field, $errors = array(), $help = '', $hiddenFields = null)
  {
      $row = parent::formatRow(
          $label,
          $field,
          $errors,
          $help,
          $hiddenFields);

      return strtr($row, array(
        '%row_class%' => (count($errors) > 0) ? 'form-error' : '',
      ));
  }

  public function generateLabel($name, $attributes = array()) {

      $fields = $this->_validatorSchema->getFields();
      if($fields[$name] != null) {
         $field = $fields[$name];
         if($field->hasOption('required') && $field->getOption('required')) {
              if(isset ($attributes['class'])){
                $attributes['class'] .= ' ' . $this->requiredCss;
              }else{
                  $attributes['class'] = $this->requiredCss;
              }
         }
      }

      return parent::generateLabel($name, $attributes);
  }
}

