<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 10/9/2016
 * Time: 8:15 PM
 */

namespace App\Http\Controllers\Admin;

use App\Repositories\UserRepositoryInterface;
use \Illuminate\Http\Request;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Admin
 */
class UserController extends BaseAdminController {
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        parent::__construct('users');
        $this->userRepository = $userRepository;
    }

    public function getIndex() {
        return view('admin.users.index');
    }

    public function postIndex() {
        $result = $this->userRepository->getByPage(1, 2);
        $records = [];
        foreach ($items = $result->items as $item) {
            $status = '<span class="label label-success label-sm">Activated</span>';
            if ($item->post_status != 1) {
                $status = '<span class="label label-danger label-sm">Disabled</span>';
            }
            $popular = '';
            if ($item->is_popular != 0) {
                $popular = '<span class="label label-success label-sm">Popular</span>';
            }
            $records['data'][] = array(
                '<input type="checkbox" name="id[]" value="' . $item->id . '">',
                $item->email,
                $item->first_name,
                $item->last_name,
                $item->status,
                $item->created_at->toDateTimeString(),
                '<a class="fast-edit" title="Fast edit">Fast edit</a>',
                '<a href="' . '#lom' . '" class="btn btn-outline green btn-sm"><i class="icon-pencil"></i></a>' . '<button type="button" data-ajax="' . '#link' . '" data-method="DELETE" data-toggle="confirmation" class="btn btn-outline red-sunglo btn-sm ajax-link"><i class="fa fa-trash"></i></button>',
            );
        }
        $records["sEcho"] = 'echo';
        $records["iTotalRecords"] = $result->totalItems;
        $records["iTotalDisplayRecords"] = 5;
        return response()->json($records);
    }

    public function getEdit(Request $request, $user_id = 0) {
        $this->data['object'] = new \stdClass();

        if ($user_id !== 0) {

        }

        return view('admin.users.edit', $this->data);
    }

    public function postEdit(Request $request, $user_id = 0) {
        $data = $request->all();

        $data['id'] = (int)$user_id;

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        if ($user_id != 0) {
            //unset($data['email']);
            //$result = $object->fastEdit($data, false, true);
        } else {
            // $result = $object->fastEdit($data, true, false);
        }
        $result = $this->userRepository->create($data);
        if (!$result) {
            $this->setFlashMessages('Save is fail', 'error');
            $this->showFlashMessages();
            return redirect()->back();
        }

        $this->setFlashMessages('Save is success', 'success');
        $this->showFlashMessages();

        if ($user_id == 0) {
            return redirect()->to(asset($this->adminPath . '/' . $this->routeLink . '/edit/' . $result['object']->id));
        }
        return redirect()->back();
    }
}