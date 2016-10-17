<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 10/8/2016
 * Time: 2:27 PM
 */

namespace App\Http\Controllers\Admin;

use App\Repositories\PostRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers\Admin
 */
class DashboardController extends BaseAdminController {
    private $postRepository;
    private $userRepository;

    public function __construct(PostRepositoryInterface $postRepository, UserRepositoryInterface $userRepository) {
        parent::__construct('dashboard');
        $this->setPageTitle('dashboard', 'dashboard & statistics');
        $this->setBodyClass($this->bodyClass);

        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function getIndex() {
        $posts = $this->postRepository->count();
        $this->data['postsCount'] = $posts;

        $this->data['pagesCount'] = $posts;

        $this->data['productsCount'] = $posts;

        $users = $this->userRepository->count();
        $this->data['usersCount'] = $users;

        return view('admin.dashboard.index', $this->data);
    }
}