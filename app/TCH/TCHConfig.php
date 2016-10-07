<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 07/10/2016
 * Time: 14:16
 */

namespace TCH;

/**
 * Class TCHConfig
 * @package TCH
 */
class TCHConfig {

  const STATUS_ACTIVE = 1;
  const STATUS_INACTIVE = 0;

  const POST_STATUS_DISABLED = 0;
  const POST_STATUS_PUBLISHED = 1;
  const POST_STATUS_DRAFT = 2;

  const MESSAGE_TYPE_INFO = 'info';
  const MESSAGE_TYPE_SUCCESS = 'success';
  const MESSAGE_TYPE_WARNING = 'warning';
  const MESSAGE_TYPE_ERROR = 'error';

  public static function postStatus() {
    return [
      TCHConfig::POST_STATUS_DISABLED => trans('laraX.post.disabled'),
      TCHConfig::POST_STATUS_PUBLISHED => trans('laraX.post.published'),
      TCHConfig::POST_STATUS_DRAFT => trans('laraX.post.draft'),
    ];
  }

  public static function messageType() {
    return [
      TCHConfig::MESSAGE_TYPE_INFO,
      TCHConfig::MESSAGE_TYPE_SUCCESS,
      TCHConfig::MESSAGE_TYPE_WARNING,
      TCHConfig::MESSAGE_TYPE_ERROR,
    ];
  }
}