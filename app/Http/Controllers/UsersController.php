<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function __construct(){
        // 必须先登录
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index', 'destroy'],
        ]);
        $this->middleware('guest', [
            'only' => ['create'],
        ]);
    }
    public function create(){
        return view('users.create');
    }

    public function show(User $user){
        return view('users.show', compact('user'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'password' => 'required|min:6|confirmed',
            'email' => 'required|email|unique:users|max:255',
        ]);
        // 写入数据库
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        // 重定向到个人主页
        return redirect()->route('users.show', [$user]);
    }

    public function edit(User $user){
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user){
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|min:6|confirmed',
        ]);
        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success', '资料修改成功');
        return redirect()->route('users.show', $user);
    }

    public function index(){
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function destroy(User $user){
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '用户删除成功!');
        return back();
    }
}
