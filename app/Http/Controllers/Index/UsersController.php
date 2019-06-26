<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UserRequest;//用户信息表单验证
use App\Handlers\ImageUploadHandler;//图片上传类

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
    /**
     * 用户展示
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function show(User $user)
    {
		return view('index.users.show',compact('user'));
    }
    /**
     * 用户编辑
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
		return view('index.users.edit',compact('user'));
    }
	/**
	 * 用户更新资料
	 * @param  UserRequest $request [description]
	 * @param  User        $user    [description]
	 * @return [type]               [description]
	 */
    public function update(UserRequest $request, User $user,ImageUploadHandler $uploader)
    {
        $this->authorize('update', $user);
    	$data = $request->all();
    	if($request->avatar){
            $result = $uploader->save($request->avatar, 'avatars', $user->id,416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
    	} 
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
