<?php

namespace Drupal\ptt_theme_switcher\Theme;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;
use Drupal\user\UserDataInterface;
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
   * UserData service.
   *
   * @var \Drupal\user\UserDataInterface
   */
  protected $userData;

  /**
   * ThemeSwitcherNegotiator constructor.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user.
   * @param \Drupal\user\UserDataInterface $user_data
   *   The user data service.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack.
   */
  public function __construct(AccountInterface $current_user, UserDataInterface $user_data, RequestStack $request_stack) {
    $this->currentUser = $current_user;
    $this->userData = $user_data;
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
    $currentRequest = $this->requestStack->getCurrentRequest();
    if ($currentRequest && $currentRequest->getSession()->has('theme')) {
      return $currentRequest->getSession()->get('theme');
    }
    elseif ($this->currentUser->isAuthenticated()) {
      return $this->userData->get('ptt_theme_switcher', $this->currentUser->id(), 'theme');
    }
    return NULL;
  }

}
