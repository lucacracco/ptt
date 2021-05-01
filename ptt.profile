<?php

/**
 * @file
 * Enables modules and site configuration for a ptt site installation.
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_FORM_ID_alter() for install_configure_form().
 *
 * Allows the profile to alter the site configuration form.
 */
function ptt_form_install_configure_form_alter(&$form, FormStateInterface $form_state) {
  $form['site_information']['site_name']['#default_value'] = 'Blog Personal';
  $form['site_information']['site_name']['#value'] = 'Blog Personal';
}