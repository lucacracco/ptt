<?php

namespace Drupal\ptt_theme_switcher\Theme;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ThemeSwitcherNegotiator.
 *
 * @package Drupal\ptt_theme_switcher\Theme
 */
class ThemeSwitcherNegotiator implements ThemeNegotiatorInterface {

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * ThemeSwitcherNegotiator constructor.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   */
  public function __construct(AccountInterface $current_user, RequestStack $request_stack) {
    $this->currentUser = $current_user;
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match) {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function determineActiveTheme(RouteMatchInterface $route_match) {
    // TODO: implement.
    return 'ptt_purecss';
  }

}
