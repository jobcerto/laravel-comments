<?php

namespace Jobcerto\Comments\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Jobcerto\Comments\Traits\Commentable;

class Post extends Model
{
    use Commentable;

    protected $guarded = [];
}
