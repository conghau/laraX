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
    
  }

  public function getEdit(Request $request, $id) {
    $this->data['object'] = new \stdClass();
    return view('admin.posts.edit', $this->data);
  }

  public function postEdit() {

  }
}