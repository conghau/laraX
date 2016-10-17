<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
  protected $table = 'posts';
  protected $fillable = ['id', 'post_author_id', 'post_date_gmt', 'post_content', 'post_title', 'post_slug', 'post_excerpt', 'comment_status', 'ping_status', 'post_name', 'post_content_filtered', 'menu_order', 'post_type', 'comment_count', 'guid', 'created_at', 'updated_at', 'post_status', 'is_popular'];
}
