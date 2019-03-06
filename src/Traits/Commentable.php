<?php

namespace Jobcerto\Comments\Traits;

use Illuminate\Database\Eloquent\Model;

trait Commentable
{
    /**
     * Return all comments for this model.
     *
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(config('comments.comment_model'), 'commentable');
    }

    /**
     * Attach a comment to this model.
     *
     * @param string $comment
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function comment(string $comment)
    {
        return $this->commentAsUser(auth()->user(), $comment);
    }

    /**
     * Attach a comment to this model as a specific user.
     *
     * @param Model|null $user
     * @param string $comment
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function commentAsUser( ? Model $user, string $comment)
    {
        $commentClass = config('comments.comment_model');

        $comment = new $commentClass([
            'body'             => $comment,
            'owner_id'         => is_null($user) ? null : $user->getKey(),
            'owner_type'       => is_null($user) ? null : get_class($user),
            'commentable_id'   => $this->getKey(),
            'commentable_type' => get_class(),
        ]);

        return $this->comments()->save($comment);
    }
}
