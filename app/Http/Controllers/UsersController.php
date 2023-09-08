<?php

namespace App\Http\Controllers;

use App\Ldap\LdapUser;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new LdapUser();
        $user->cn = 'testing';
        $user->uid = 'johndoe';
        $user->givenname = 'John';
        $user->mail = 'johndoe@example.com';
        $user->userpassword = 'password123';

        $user->save();

        return 'User created successfully.';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
