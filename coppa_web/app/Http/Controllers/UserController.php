<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use Auth, Hash;

class UserController extends Controller
{

    /**
     * list users
     *
     * @param User $mUser
     * @return void
     */
    public function getList(User $mUser)
    {
        if (Auth::user()->level == 1) {
            $listUser = $mUser->all()->toArray();
            $data = [
                'listUser' => $listUser
            ];
            return view('user.list', $data);
        }
        return redirect()->route('home');
    }

    /**
     * screen add new user
     *
     * @return void
     */
    public function getAdd()
    {
        return view('user.add');
    }

    /**
     * submit to create a new user
     *
     * @param UserRequest $request
     * @return void
     */
    public function postAdd(UserRequest $request)
    {
        $data = $request->except(['_token', 'repassword']);

        $data['password'] = Hash::make($data['password']);
        $user = new User($data);
        $user->save();

        return redirect()->route('list-user')->with(['flashDataSuccess' => 'Thêm tài khoản thành công!']);
    }

    /**
     * screen to edit info user
     *
     * @param [int] $id
     * @param User $mUser
     * @return void
     */
    public function getEdit($id, User $mUser)
    {
        $user = $mUser->find($id);
        if ($user) {
            $user = $user->toArray();
            $data = [
                'user' => $user
            ];
            return view('user.edit', $data);
        }
        return redirect()->route('list-user')->with(['flashDataDanger' => 'Không tìm thấy tài khoản để sửa!']);
    }

    /**
     * submit to save info user
     *
     * @param [int] $id
     * @param UserRequest $request
     * @param User $mUser
     * @return void
     */
    public function postEdit($id, UserRequest $request, User $mUser)
    {
        $data = $request->except('_token');

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        try {
            $user = $mUser->find($id);
            $user->fill($data);
            $user->save();
            return redirect()->route('list-user')->with(['flashDataSuccess' => 'Cập nhật tài khoản thành công!']);
        } catch (Exception $e) {
            return redirect()->route('list-user')->with(['flashDataDanger' => 'Đã xảy ra lỗi trong quá trình cập nhật tài khoản!']);
        }
    }

    /**
     * delete a user
     *
     * @param [int] $id
     * @param User $mUser
     * @return void
     */
    public function getDelete($id, User $mUser)
    {
        if ($id != Auth::id()) {
            $user = $mUser->find($id);
            $user->delete();
            return redirect()->route('list-user')->with(['flashDataSuccess' => 'Xóa tài khoản thành công!']);
        }

        return redirect()->route('list-user')->with(['flashDataDanger' => 'Không thể xóa tài khoản của chính mình!']);
    }

    /**
     * page login
     *
     * @return void
     */
    public function getLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('user.login');
    }

    /**
     * submit login
     *
     * @param LoginRequest $request
     * @param User $mUser
     * @return void
     */
    public function postLogin(LoginRequest $request, User $mUser)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = $mUser->find(Auth::id());
            return redirect()->route('home');
        }
        $errors = [
            'loginfaild' => 'Thông tin đăng nhập không chính xác.'
        ];
        return redirect()->route('login')->withInput()->withErrors($errors);
    }

    /**
     * submit logout
     *
     * @return void
     */
    public function getLogout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect()->route('home');
    }
}