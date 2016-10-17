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
    $this->routeLink = 'users';
  }

  /**
   * Init list user
   *
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function getIndex() {
    return view('admin.users.index');
  }

  /**
   * Get list user with request
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function postIndex(Request $request) {
    $all = $request->all();

    //get pagination
    $offset = $request->get('start', 0);
    $limit = $request->get('length', 10);
    $paged = ceil(($offset + $limit) / $limit);

    $target_like_filters = [
      'email',
      'first_name',
      'last_name',
    ];

    $target_eq_filters = [
      'status'
    ];

    $target_orderBy = [
      1 => 'id',
      2 => 'email',
      3 => 'first_name',
      4 => 'last_name',
      5 => 'status',
      6 => 'created_at',
      7 => 'last_login_at'
    ];
    $conditions = [];

    //build where condition
    foreach ($target_like_filters as $like_filter) {
      if ($fv = laraX_get_value($all, $like_filter, FALSE)) {
        $conditions[] = [$like_filter, 'LIKE', "%$fv%"];
      }
    };
    foreach ($target_eq_filters as $eq_filter) {
      if ($fv = laraX_get_value($all, $eq_filter, FALSE)) {
        $conditions[$eq_filter] = $fv;
      }
    };

    $order_by = [];
    //build order by
    foreach ($items = laraX_get_value($all, 'order', []) as $item) {
      $order_by[array_key_exists($item['column'], $target_orderBy) ? $target_orderBy[$item['column']] : 'created_at'] = $item['dir'];
    };

    //get result
    $result = $this->userRepository->findWhere($conditions, $paged, $limit, $order_by);

    //prepare output
    $records = [];
    $records['data'] = [];
    foreach ($items = $result->items as $item) {
      $records['data'][] = array(
        '<input type="checkbox" name="id[]" value="' . $item->id . '">',
        $item->id,
        $item->email,
        $item->first_name,
        $item->last_name,
        '<span class="label label-success label-sm label-{{$item->status}}">' . $item->status . '</span>',
        $item->created_at,
        $item->last_login_at,
        laraX_build_button_confirmation(laraX_build_url($this->routeLink . '/active/' . $item->id), 'Active User', 'blue', 'fa fa-check')
        . laraX_build_button_confirmation(laraX_build_url($this->routeLink . '/disable/' . $item->id), 'Delete User', 'red-sunglo', 'fa fa-times')
        . laraX_build_button(laraX_build_url($this->routeLink . '/edit/' . $item->id), 'edit', 'green', 'icon-pencil'),
      );
    }
    $records["sEcho"] = 'echo';
    $records["iTotalRecords"] = $result->totalItems;
    $records["iTotalDisplayRecords"] = $result->totalItems;
    return response()->json($records);
  }

  public function getEdit(Request $request, $user_id = 0) {
    $this->data['object'] = new \stdClass();

    if ($user_id !== 0) {
      $this->data['object'] = $this->userRepository->getFirstBy('id',$user_id);
    }

    return view('admin.users.edit', $this->data);
  }

  public function postEdit(Request $request, $user_id = 0) {
//    $data = $request->all();
//
//    $data['id'] = (int) $user_id;
//
//    if (isset($data['password'])) {
//      $data['password'] = bcrypt($data['password']);
//    }
//
//    if ($user_id != 0) {
//      //unset($data['email']);
//      //$result = $object->fastEdit($data, false, true);
//    }
//    else {
//      // $result = $object->fastEdit($data, true, false);
//    }
//    $result = $this->userRepository->create($data);
//    if (!$result) {
//      $this->setFlashMessages('Save is fail', 'error');
//      $this->showFlashMessages();
//      return redirect()->back();
//    }
//
//    $this->setFlashMessages('Save is success', 'success');
//    $this->showFlashMessages();
//
//    if ($user_id == 0) {
//      return redirect()->to(asset($this->adminPath . '/' . $this->routeLink . '/edit/' . $result['object']->id));
//    }
//    return redirect()->back();
  }
}