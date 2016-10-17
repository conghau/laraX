<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 17/10/2016
 * Time: 17:55
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Class FileController
 *
 * @package App\Http\Controllers\Admin
 */
class FileController extends BaseAdminController {
    public function __construct() {
        parent::__construct('files');
    }

    public function getFileManager(Request $request, $userId = 0) {
        $csrf = TRUE;

        $url = $this->adminPath . '/files/connector';
        if ($userId > 0) {
            $url .= '/' . $userId;
        }

        $url = asset($url);

        return view('admin.files.file-manager', compact('csrf', 'url'));
    }

    public function anyConnector($userId = 0) {
        $roots = Config::get('elfinder.roots', []);

        if (empty($roots)) {
            $dirs = (array)Config::get('elfinder.dir', []);

            if (!is_dir($dirs[0])) {
                mkdir($dirs[0], 0777, TRUE);
            }

            if ($userId > 0) {
                if (!is_dir($dirs[0] . DIRECTORY_SEPARATOR . md5($userId))) {
                    mkdir($dirs[0] . DIRECTORY_SEPARATOR . md5($userId), 0777, TRUE);
                }
            }

            foreach ($dirs as $dir) {
                $path = $dir;
                if ($userId > 0) {
                    $path = $dir . DIRECTORY_SEPARATOR . md5($userId);
                }
                $roots[] = [
                    'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                    'path' => public_path($path), // path to files (REQUIRED)
                    'tmpPath' => public_path($path),
                    'URL' => url($path), // URL to files (REQUIRED)
                    'accessControl' => Config::get('elfinder.access'), // filter callback (OPTIONAL),
                    'autoload' => TRUE,
                    'uploadDeny' => array('all'), // All Mimetypes not allowed to upload
                    'uploadAllow' => array('image', 'text/plain'), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder' => array('deny', 'allow'), // allowed Mimetype `image` and `text/plain` only
                ];
            }

            $disks = (array)Config::get('elfinder.disks', []);
            foreach ($disks as $key => $root) {
                if (is_string($root)) {
                    $key = $root;
                    $root = [];
                }
                $disk = app('filesystem')->disk($key);
                if ($disk instanceof \FilesystemAdapter) {
                    $defaults = [
                        'driver' => 'Flysystem',
                        'filesystem' => $disk->getDriver(),
                        'alias' => $key,
                    ];
                    $roots[] = array_merge($defaults, $root);
                }
            }
        }

        $opts = ['roots' => $roots, 'debug' => TRUE];

        $connector = new \Barryvdh\Elfinder\Connector(new \elFinder($opts));
        $connector->run();
        return $connector->getResponse();
    }

    public function anyCreateFolder($folderName) {
        $csrf = TRUE;
        $url = $this->adminPath;
        if (empty($folderName) || is_null($folderName)) {
            $url = asset($url . '/files/connector');
            return view('admin.files.file-manager', compact('csrf', 'url'));
        }
        $roots = Config::get('elfinder.roots', []);

        if (empty($roots)) {
            $dirs = (array)Config::get('elfinder.dir', []);

            if (!is_dir($dirs[0])) {
                mkdir($dirs[0], 0777, TRUE);
            }
            $path = $dirs[0] . DIRECTORY_SEPARATOR . $folderName;
            if (!is_dir($path)) {
                mkdir($path, 0775, TRUE);
            }
            $roots = [
                'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                'path' => public_path($path), // path to files (REQUIRED)
                'tmpPath' => public_path($path),
                'URL' => url($path), // URL to files (REQUIRED)
                'accessControl' => Config::get('elfinder.access'), // filter callback (OPTIONAL),
                'autoload' => TRUE,
                'uploadDeny' => array('all'), // All Mimetypes not allowed to upload
                'uploadAllow' => array('image', 'text/plain'), // Mimetype `image` and `text/plain` allowed to upload
                'uploadOrder' => array('deny', 'allow'), // allowed Mimetype `image` and `text/plain` only
            ];

            $disks = (array)Config::get('elfinder.disks', []);
            foreach ($disks as $key => $root) {
                if (is_string($root)) {
                    $key = $root;
                    $root = [];
                }
                $disk = app('filesystem')->disk($key);
                if ($disk instanceof \FilesystemAdapter) {
                    $defaults = [
                        'driver' => 'Flysystem',
                        'filesystem' => $disk->getDriver(),
                        'alias' => $key,
                    ];
                    $roots[] = array_merge($defaults, $root);
                }
            }
        }

        $opts = ['roots' => $roots, 'debug' => TRUE];

        $connector = new \Barryvdh\Elfinder\Connector(new \elFinder($opts));
        $connector->run();
        return $connector->getResponse();
    }

}