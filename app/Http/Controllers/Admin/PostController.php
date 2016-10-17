<?php
/**
 * Created by PhpStorm.
 * User: hautruong
 * Date: 21/09/2016
 * Time: 12:38
 */

namespace App\Http\Controllers\Admin;

use App\Repositories\LanguageRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\PostRepositoryInterface;
use TCH\LaraXConfig;

/**
 * Class PostController
 * 
 * @package App\Http\Controllers\Admin
 */
class PostController extends BaseAdminController {

  protected $postRepo;
  protected $languageRepo;

  public function __construct(PostRepositoryInterface $postRepositoryInterface , LanguageRepositoryInterface $languageRepositoryInterface) {
    parent::__construct();
    $this->postRepo = $postRepositoryInterface;
    $this->languageRepo = $languageRepositoryInterface;
    $this->data['activatedLanguages'] = $this->languageRepo->getManyBy('status', LaraXConfig::STATUS_ACTIVE, [], ['id', 'language_name']);
    $this->data['postStatus'] = LaraXConfig::postStatus();
  }

  public function getIndex(Request $request) {
    $this->setFlashMessages(LaraXConfig::MESSAGE_TYPE_INFO, 'Go to posts');
    $this->showFlashMessages();
    return view('admin.posts.index', $this->data);
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

  /**
   * Init page create/edit post
   * 
   * @param \Illuminate\Http\Request $request
   * @param $post_id
   * @param $language_id
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function getEdit(Request $request, $post_id, $language_id) {
    $this->data['object'] = new \stdClass();
    $item = new \stdClass();
    
    //case create
    if($post_id == 0) {
      return;
    }

    $item = $this->postRepo->getById($post_id);
    if(!$item) {
      //todo set message no find post
    }

    return view('admin.posts.edit', $this->data);
  }

  public function postEdit(Request $request) {
    $data = $request->all();
    $this->postRepo->create($data);

  }
}