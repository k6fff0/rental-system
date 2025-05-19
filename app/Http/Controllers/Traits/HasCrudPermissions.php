<?php

namespace App\Http\Controllers\Traits;

trait HasCrudPermissions
{
    protected function applyCrudPermissions(string $resource)
    {
        $this->middleware("permission:view $resource")->only('index');
        $this->middleware("permission:create $resource")->only(['create', 'store']);
        $this->middleware("permission:edit $resource")->only(['edit', 'update']);
        $this->middleware("permission:delete $resource")->only('destroy');
    }
}
