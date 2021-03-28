<?php

namespace Drupal\xatkit\Form;

/**
 * @file
 * Contains \Drupal\xatkit\Form\XatKitAdminForm.
 */


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManager;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * MealPlanner form Class.
 */
class XatKitAdminForm extends ConfigFormBase {

  /**
   * Entity manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Construct method.
   */
  public function __construct(EntityTypeManager $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Create method.
   */
  public static function create(ContainerInterface $container) {
    // SET DEPENDENCY INJECTION.
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Gets the configuration names that will be editable.
   */
  protected function getEditableConfigNames() {
    return [
      'xatkit.settings',
    ];
  }

  /**
   * Main buil function.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('xatkit.settings');
    $form = parent::buildForm($form, $form_state);


    $form['server_conf'] = [
      '#type'        => 'fieldset',
      '#title'       => $this->t('Configure your bot connexion'),
      '#collapsible' => TRUE,
      '#collapsed'   => FALSE,
    ];
    $form['server_conf']['xatkitServer'] = [
      '#type' => 'textfield',
      '#title' => $this->t('URL of the Xatkit Server'),
      '#description' => $this->t('Do NOT change unless you have deployed your own server'),
      '#default_value' => $config->get('xatkit.serverUrl'),
      '#required' => TRUE,
    ];
    $form['server_conf']['type'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Is yout bot deployed locally?'),
      '#default_value' => $config->get('xatkit.type'),
      '#attributes' => [
        'id' => 'type',
      ],
    ];

    $form['server_conf']['customPort'] = [
      '#title' => $this->t('Custom local port'),
      '#description' => $this->t('Only if you have specified a custom local port to deploy your bot'),
      '#type' => 'textfield',
      '#size' => '60',
      '#default_value' => $config->get('xatkit.customPort'),
      '#placeholder' => 'Default: localhost:5001',
      '#default_value' => '5001',
      '#attributes' => [
        'id' => 'custom-port',
      ],
      '#states' => [
        //show this textfield only if the radio 'other' is selected above
        'visible' => [
          //don't mistake :input for the type of field. You'll always use
          //:input here, no matter whether your source is a select, radio or checkbox element.
          ':input[name="type"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['bot_conf'] = [
      '#type'        => 'fieldset',
      '#title'       => $this->t('Configure the aspect of your bot'),
      '#collapsible' => TRUE,
      '#collapsed'   => FALSE,
    ];
    $form['bot_conf']['windowTitle'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title of the chat window'),
      '#description' => $this->t('Set the title of your chat window'),
      '#default_value' => $config->get('xatkit.windowTitle'),
      '#required' => FALSE,
    ];
    $form['bot_conf']['windowSubtitle'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Subtitle of the chat window'),
      '#default_value' => $config->get('xatkit.windowSubtitle'),
      '#required' => FALSE,
    ];
    $form['bot_conf']['alternativeLogo'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Alternative Logo'),
      '#description' => $this->t('Ideal size 46x46'),
      '#default_value' => $config->get('xatkit.altLogo'),
      '#upload_location' => 'public://xatkit/',
      '#required' => FALSE,
    ];
    $form['bot_conf']['customColor'] = [
      '#type' => 'color',
      '#title' => $this->t('Window customn color'),
      '#description' => $this->t('Pick de color of bot window'),
      '#default_value' => $config->get('xatkit.color'),
      '#required' => FALSE,
    ];
    $form['bot_conf']['left'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Should the widget be at the left?'),
      '#default_value' => $config->get('xatkit.rtl'),
    ];
    $form['bot_conf']['languageSelect'] = [
      '#type' => 'language_select',
      '#title' => $this->t('Language'),
      '#description' => $this->t('Language the bot should use to speak with your visitors'),
      '#default_value' => $config->get('xatkit.language'),
      '#required' => FALSE,
    ];

    return $form;
  }

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'xatkit_form';
  }

  /**
   * Example data to check if the provided settings are okay.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    // We check the /status endpoint of the service.
    $baseUrl = $form_state->getValue('xatkitServer');
    if (strpos($baseUrl, 'http') !== 0) {
      $form_state->setErrorByName('xatkitServer', $this->t('Please, specify http protocol'));
    }
    $pos = strpos($baseUrl, '/chat-handler');
    if ($pos != FALSE) {
      $baseUrl = substr($baseUrl, 0, $pos);
    }
    $client = new Client([
      'headers' => [],
    ]);
    try {
      $response = $client->request('GET',
        $baseUrl . '/status', [
          ['http_errors' => FALSE],
        ]);
      if ($response->getStatusCode() == '200') {
        // Bot is on!.
      }
      else {
        $form_state->setErrorByName('xatkitServer', $this->t('It seems there is a problem with server URL'));
      };
    }
    catch (RequestException $e) {
      $form_state->setErrorByName('xatkitServer', $this->t('Server URL is not correct, please fit it'));
    }
  }

  /**
   * Example data to check if the provided settings are okay.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    //kint($form_state);
    $config = $this->config('xatkit.settings');
    $config->set('xatkit.serverUrl', $form_state->getValue('xatkitServer'))
      ->set('xatkit.type', $form_state->getValue('type'))
      ->set('xatkit.customPort', $form_state->getValue('customPort'))
      ->set('xatkit.windowTitle', $form_state->getValue('windowTitle'))
      ->set('xatkit.windowSubtitle', $form_state->getValue('windowSubtitle'))
      ->set('xatkit.color', $form_state->getValue('customColor'))
      ->set('xatkit.rtl', $form_state->getValue('left'))
      ->set('xatkit.language', $form_state->getValue('languageSelect'));
    // Saving logo if uploaded.
    if (!empty($form_state->getValue('alternativeLogo'))) {
      $fid = reset($form_state->getValue('alternativeLogo'));
      $file = $this->entityTypeManager->getStorage('file')->load($fid);
      $file->setPermanent();
      $file->save();
      $config->set('xatkit.altLogo', $form_state->getValue('alternativeLogo'));
    }
    else {
      $config->set('xatkit.altLogo', FALSE);
    }
    $config->save();

    drupal_flush_all_caches();
    return parent::submitForm($form, $form_state);
  }

  /**
   * Returns value of specific form element.
   */
  private function getValue($form_state, $prop_name) {
    return trim($form_state->getValue($prop_name));
  }

}
