<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TestsController extends Controller
{
    public function testArea($data = 'empty', Request $request)
    {

        $user = auth()->user();
        $data = Gate::define('isAdmin', function($user) {
            return $user->roles->pluck('title')[0] == 'Admin';
         });
        dd($user->roles->pluck('title')[0] == 'Admin');

        $roles = Role::get();

        // foreach ($roles->title as $role) {
        //     Gate::define($role, function ($user) use ($roles) {
        //         return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
        //     });
        // }

        dd($data, $roles);

        return 'Sushant is testing...';

    }
}
