<?php

namespace Jobcerto\LaravelComments;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jobcerto\LaravelComments\Skeleton\SkeletonClass
 */
class LaravelCommentsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-comments';
    }
}
