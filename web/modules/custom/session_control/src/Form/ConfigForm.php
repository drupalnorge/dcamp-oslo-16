<?php

namespace Drupal\session_control\Form;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigForm.
 *
 * @package Drupal\session_control\Form
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'session_control.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('session_control.settings');
    $form['session_deadline'] = [
      '#type' => 'datetime',
      '#title' => $this->t('Deadline for submissions'),
      '#default_value' => DrupalDateTime::createFromTimestamp($config->get('session_deadline')),
    ];
    $form['sessions_enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable session submissions'),
      '#default_value' => $config->get('sessions_enabled'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    /** @var DrupalDateTime $timestamp */
    $timestamp = $form_state->getValue('session_deadline');

    $this->config('session_control.settings')
      ->set('session_deadline', $timestamp->format('U'))
      ->set('sessions_enabled', $form_state->getValue('sessions_enabled'))
      ->save();
  }

}
