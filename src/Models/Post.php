<?php
namespace app\Models;

use app\Entities\PostEntity;

class Post extends Model{

    protected $Filename = "Posts";
    protected $EntityClass = PostEntity::class;

}