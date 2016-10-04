<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 21/09/2016
 * Time: 12:38
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\PostRepositoryInterface;

class PostController extends BaseAdminController {

  protected $postRepo;

  public function __construct(PostRepositoryInterface $postRepositoryInterface) {
    parent::__construct();
    $this->postRepo = $postRepositoryInterface;
  }

  public function getIndex(Request $request) {
    return view('admin.posts.index');
  }

  public function postIndex(Request $request) {
    $result = $this->postRepo->getByPage(1, 2);
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
        $item->id,
        $item->post_title,
        $status,
        $item->orders,
        $popular,
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

  public function getEdit(Request $request, $id) {
    $this->data['object'] = new \stdClass();
    return view('admin.posts.edit', $this->data);
  }

  public function postEdit(Request $request) {
    $data = $request->all();
    $this->postRepo->create($data);

  }
}