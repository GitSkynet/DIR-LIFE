<?php
  
/**
 * @file
 * Contains \Drupal\contacto\Form\InverteixDLifeForm.
 */
  
namespace Drupal\contacto\Form;
  
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

 
class InverteixDLifeForm extends ContactoBase {
    
  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'inverteix_dlife_form';
  }
    
  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['nombre'] = array(
      '#type' => 'textfield',
      '#maxlength' => 255,
      '#placeholder' => t('Nombre'),
      '#attributes' => array('class' => array('form-group col-lg-6 col-xs-12'), 'style' => array('background: rgba(255,255,255,0.12)')),
      '#suffix' => '<div class="nombre-valid-message"></div>',
      '#obligatorio' => TRUE,  
    );
    
    $form['apellidos'] = array(
      '#type' => 'textfield',
      '#maxlength' => 255,
      '#placeholder' => t('Apellidos'),
      '#attributes' => array('class' => array('form-group col-lg-6 col-xs-12'), 'style' => array('background: rgba(255,255,255,0.12)')),
      '#suffix' => '<div class="apellidos-valid-message"></div>',
      '#obligatorio' => TRUE,  
    );
    
    $form['email'] = array(
      '#type' => 'email',
      '#maxlength' => 255,
      '#placeholder' => t('Email'),
      '#attributes' => array('class' => array('form-group col-lg-6 col-xs-12'), 'style' => array('background: rgba(255,255,255,0.12)')),
      '#suffix' => '<div class="email-valid-message"></div>',
      '#obligatorio' => TRUE,  
        
    );    

    $form['telefono'] = array(
      '#type' => 'tel',
      '#maxlength' => 255,
      '#placeholder' => t('TelÃ©fono'),
      '#obligatorio' => TRUE,
      '#attributes' => array('class' => array('form-group col-lg-6 col-xs-12'), 'style' => array('background: rgba(255,255,255,0.12)')),
      '#suffix' => '<div class="telefono-valid-message"></div>' 
    );
	
    $form['club'] = array (
      '#type' => 'select',
      '#options' => self::getAllCentresDropDown(),
      '#placeholder' => $this->t('Choice your Center'),
      '#empty_value' => "",
      '#empty_option' => $this->t('Choice your Center'),
      '#obligatorio' => TRUE,
      '#attributes' => array('class' => array('form-group col-lg-6 col-xs-12')),
      '#suffix' => '<div class="club-valid-message"></div>' 
    );
 
    
    $form['condiciones'] = array(
      '#type' => 'checkbox',
      '#title' => t("He leÃ­do y acepto las condiciones de <a target='_blank' href='/themes/custom/yogaone/AvisLegal/inverteix_calvet.pdf'>ProtecciÃ³n de Datos</a>"),
      '#return_value' => 1,
      '#default_value' => 0,
      '#obligatorio' => TRUE, 
    );
    
   $form['enviar-form'] = array(
      '#type' => 'button',
      '#value' => $this->t('Send'),
      '#button_type' => 'primary',
      '#ajax' => [
        'callback' => array($this, 'validateFormAjaxInverteix'),
        'event' => 'click',
        'progress' => array(
        'type' => 'throbber',
        'message' => t('Validate form...'),
        ),
      ],
    );
    
   $form['#cache']['max-age'] = 0;
   
   return $form;
  }
    
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) { 
    /*if (strlen($form_state->getValue('nombre')) == NULL || strlen($form_state->getValue('nombre')) < 3) {
        $form_state->setErrorByName('nombre', $this->t('Your name is required'));
      }

      if (strlen($form_state->getValue('apellidos')) == NULL) {
        $form_state->setErrorByName('apellidos', $this->t('Your surnames are required'));
      }

      if (!filter_var($form_state->getValue('email'), FILTER_VALIDATE_EMAIL)) {

        $form_state->setErrorByName('email', $this->t('This is not a .com email address.'));
      }*/

      
  }
    
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
      
//      $insert = db_insert('formularios')
//        -> fields(array(
//                        'tipo_formulario' => '2',
//                        'nombre_form' => $form_state->getValue('nombre'),
//                        'apellidos_form' => $form_state->getValue('apellidos'),
//                        'email_form' => $form_state->getValue('email'),
//                        'club_form' => $form_state->getValue('club_dir'),
//                        'fecha_registro' => date("Y-m-d H:i:s"),
//                        'ip' => self::get_ip_address()
//         ))
//        ->execute();
//      
//      if(!$insert){
//            drupal_set_message($this->t('Error no se ha podido guardar la informacion'));
//      }
//
//      
//       return new \Symfony\Component\HttpFoundation\RedirectResponse(\Drupal::url('contacto_thankyou'));
  }
  
  public function getAllCentresDropDown(){
      
      
        $query_result = db_query("SELECT * FROM {centros} WHERE cen_id IN ('01','02','03','04','05','06','07','08','09','10','11','13','14','15','16','17','21','25','28','41','53','67') ORDER BY cen_nombre")->fetchAllAssoc('cen_id');
        $result = array(); 
        foreach($query_result as $key=>$r){
            $result[$r->cen_id]=$r->cen_nombre;
        }
        
        return $result;
  }
  
  private function get_ip_address() {
        return  \Drupal::request()->getClientIp();
    }
    
}