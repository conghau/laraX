<?php
/**
 * Created by PhpStorm.
 * User: HAUTRUONG
 * Date: 9/17/2016
 * Time: 6:28 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MenuNode
 *
 * @package App\Models
 */
class MenuNode extends Model {
    protected $table = 'menu_nodes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'url',
        'css_class',
        'position',
        'icon_font',
        'type',
        'menu_content_id',
        'parent_id',
        'related_id',

    ];
    protected $editableFields = [
        'title',
        'url',
        'css_class',
        'position',
        'icon_font',
        'type',
        'menu_content_id',
        'parent_id',
        'related_id',

    ];

    public function menuContent() {
        return $this->belongsTo('App\Models\MenuContent', 'menu_content_id');
    }

    public function menuNode() {
        return $this->hasMany('App\Models\MenuNode', 'menu_id');
    }

    public function parent() {
        return $this->belongsTo('App\Models\MenuNode', 'parent_id');
    }

    public function child() {
        return $this->hasMany('App\Models\MenuNode', 'parent_id');
    }

    public function getRelated($theme = FALSE) {
        $item = new \stdClass();
        $item->name = NULL;
        $item->url = NULL;
        switch ($this->type) {
            case 'category':
                $category = $this->category;
                if ($category) {
                    if (trim($this->title) == NULL) {
                        $item->name = $category->name;
                    } else {
                        $item->name = $this->title;
                    }
                    if ($theme) {
                        $item->url = route('public.view', $category->slug);
                    } else {
                        $item->url = route('categories.edit', $category->id);
                    }
                }
                break;
            case 'tag':
                $tag = $this->tag;
                if ($tag) {
                    if (trim($this->title) == NULL) {
                        $item->name = $tag->name;
                    } else {
                        $item->name = $this->title;
                    }
                    if ($theme) {
                        $item->url = route('public.tag', $tag->slug);
                    } else {
                        $item->url = route('tags.edit', $tag->id);
                    }
                }
                break;
            case 'page':
                $page = $this->page;
                if ($page) {
                    if (trim($this->title) == NULL) {
                        $item->name = $page->name;
                    } else {
                        $item->name = $this->title;
                    }
                    if ($theme) {
                        $item->url = route('public.view', $page->slug);
                    } else {
                        $item->url = route('pages.edit', $page->id);
                    }
                }
                break;
            default:
                $item->name = $this->title;
                $item->url = url($this->url);
                break;
        }
        return $item;
    }

//  public function hasChild() {
//    $menu  = MenuNode::whereParentId($this->id)->select('id')->
//  }
}