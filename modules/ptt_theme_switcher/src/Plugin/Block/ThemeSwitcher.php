<?php

namespace Drupal\ptt_theme_switcher\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\ptt_theme_switcher\Form\ThemeSwitcher as ThemeSwitcherForm;

/**
 * Provides a 'ThemeSwitcher' block.
 *
 * @Block(
 *  id = "ptt_theme_switcher_block",
 *  admin_label = @Translation("ThemeSwitcher Block"),
 * )
 *
 * @package Drupal\ptt_theme_switcher\Plugin\Block
 */
class ThemeSwitcher extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * Form Builder service.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * ThemeSwitcher constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
   *   The form builder service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxyInterface $current_user, FormBuilderInterface $form_builder) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $current_user;
    $this->formBuilder = $form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('form_builder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [$this->formBuilder->getForm(ThemeSwitcherForm::class)];
  }

  /**
   * @inheritDoc
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ["user"]);
  }

  /**
   * @inheritDoc
   */
  public function getCacheTags() {
    return Cache::mergeTags(parent::getCacheTags(), ["user:{$this->currentUser->id()}"]);
  }

}
