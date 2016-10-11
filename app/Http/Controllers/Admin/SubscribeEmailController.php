<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 10/11/2016
 * Time: 9:20 PM
 */

namespace App\Http\Controllers\Admin;

use App\Repositories\SubscribeEmailRepositoryInterface;

/**
 * Class SubscribeEmailController
 *
 * @package App\Http\Controllers\Admin
 */
class SubscribeEmailController extends BaseAdminController {
    protected $emailRepository;

    public function __construct(SubscribeEmailRepositoryInterface $emailRepository) {
        parent::__construct('');
        $this->emailRepository = $emailRepository;
    }

    public function getIndex() {
        return view('admin.subscribed-emails.index');
    }

    public function postIndex() {
        $this->data['object'] = $this->emailRepository->getByPage();
    }
}