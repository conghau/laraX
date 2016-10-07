<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 07/10/2016
 * Time: 15:19
 */

namespace App\Http\Foundation;

use TCH\TCHConfig;

/**
 * Custom Flash Messages
 *
 * Class FlashMessage
 * @package App\Http\Foundation
 */
trait FlashMessage {

  /**
   * LaraX Messages
   * @var array
   */
  private $laraXMessages = [];

  /**
   * Set flash message
   *
   * @param string $type
   * @param string $messages
   * @return int
   */
  protected function setFlashMessages($type = TCHConfig::MESSAGE_TYPE_SUCCESS , $messages = '') {
    if (!array_key_exists($type, $this->laraXMessages)) {
      $this->laraXMessages[$type] = [];
    }
    if (is_array($messages)) {
      foreach ($messages as $key => $value) {
        array_push($this->laraXMessages[$type], $value);
      }
      return array_push($this->laraXMessages[$type], $value);
    }
  }

  /**
   * Get flash messages
   *
   * @return array
   */
  protected function getFlashMessages() {
    return $this->laraXMessages;
  }

  /**
   * Show flash message
   */
  protected function showFlashMessages() {
    foreach (TCHConfig::messageType() as $type) {
      session()->flash($type.'Messages', laraX_get_value($this->laraXMessages, $type, []));
    }
  }
}