<?php

namespace Jobcerto\Comments;

use Illuminate\Database\Eloquent\Model;
use Jobcerto\Comments\Traits\Commentable;

class Comment extends Model
{
    use Commentable;

    protected $fillable = [
        'body',
        'owner_id',
        'owner_type',
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Comment morphs to models in owner_type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }
}
