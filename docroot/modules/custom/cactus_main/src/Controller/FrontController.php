<?php

namespace Drupal\cactus_main\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class FrontController.
 *
 * @package Drupal\cactus_main\Controller
 */
class FrontController extends ControllerBase {

  /**
   * Front page.
   *
   * @return array
   *   Empty markup.
   */
  public function index() {
    return [
      '#markup' => '',
    ];
  }

}
