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
class LaraXConfig {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const POST_STATUS_DISABLED = 0;
    const POST_STATUS_PUBLISHED = 1;
    const POST_STATUS_DRAFT = 2;

    const MESSAGE_TYPE_INFO = 'info';
    const MESSAGE_TYPE_SUCCESS = 'success';
    const MESSAGE_TYPE_WARNING = 'warning';
    const MESSAGE_TYPE_ERROR = 'error';

    const LIMIT_DEFAULT = 10;
    const PAGE_DEFAULT = 1;

    public static function postStatus() {
        return [
            LaraXConfig::POST_STATUS_DISABLED => trans('laraX.post.disabled'),
            LaraXConfig::POST_STATUS_PUBLISHED => trans('laraX.post.published'),
            LaraXConfig::POST_STATUS_DRAFT => trans('laraX.post.draft'),
        ];
    }

    public static function messageType() {
        return [
            LaraXConfig::MESSAGE_TYPE_INFO,
            LaraXConfig::MESSAGE_TYPE_SUCCESS,
            LaraXConfig::MESSAGE_TYPE_WARNING,
            LaraXConfig::MESSAGE_TYPE_ERROR,
        ];
    }

    public static function userStatus() {
        return [
            LaraXConfig::STATUS_ACTIVE => trans('laraX.user.enabled'),
            LaraXConfig::STATUS_INACTIVE => trans('laraX.user.disabled'),
        ];
    }
}