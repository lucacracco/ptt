<?php

namespace Drupal\ptt_theme_switcher\Form;

use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ThemeSwitcher.
 *
 * @package Drupal\ptt_theme_switcher\Form
 */
class ThemeSwitcher extends FormBase {

  /**
   * Current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * ThemeHandler service.
   *
   * @var ThemeHandlerInterface
   */
  protected $themeHandler;

  /**
   * Theme Manager service.
   *
   * @var \Drupal\Core\Theme\ThemeManagerInterface
   */
  protected $themeManager;

  /**
   * UserData service.
   *
   * @var \Drupal\user\UserDataInterface
   */
  protected $userData;

  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->userData = $container->get('user.data');
    $instance->currentUser = $container->get('current_user');
    $instance->themeManager = $container->get('theme.manager');
    $instance->themeHandler = $container->get('theme_handler');
    return $instance;
  }

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'ptt_theme_switcher';
  }

  /**
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('This form can select the default theme to use.'),
    ];

    $form['theme'] = [
      '#type' => 'select',
      '#title' => $this->t('Favorite Theme'),
      '#options' => $this->switchThemeOptions(),
      '#default_value' => $this->themeManager->getActiveTheme()->getName(),
      '#empty_option' => $this->t('-select-'),
      '#description' => $this->t('Select the default theme to use'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Apply'),
    ];

    return $form;
  }

  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $theme_selected = $form_state->getValue('theme');
    if ($this->currentUser->isAuthenticated()) {
      $this->userData->set('ptt_theme_switcher', $this->currentUser->id(), 'theme', $theme_selected);
    }
    else {
      \Drupal::request()->getSession()->set('theme', $theme_selected);
    }
  }

  /**
   * Returns a list of enabled themes.
   *
   * @return array
   */
  protected function switchThemeOptions() {
    $options = [];
    $themes = $this->themeHandler->listInfo();
    foreach ($themes as $theme_name => $theme) {
      if (!empty($theme->info['hidden'])) {
        continue;
      }
      if (\Drupal::service('access_check.theme')->checkAccess($theme_name)) {
        $options[$theme_name] = $theme->info['name'];
      }
    }
    return $options;
  }

}