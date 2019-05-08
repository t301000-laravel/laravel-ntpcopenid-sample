<?php

namespace App\Http\Controllers;

use App\Models\BackpackUser as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NtpcOpenIdController extends Controller
{
    /**
     * NTPC OpenID 登入，通過登入規則之後處理 user 帳號，然後登入
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function userProcess()
    {

        if (is_null($data = session()->pull(config('ntpcopenid.sessionKey')))) {
            return redirect('/login');
        }

        $data = $this->convertOpenIdData($data);
        $user = User::firstOrCreate(['email' => $data['email']], $data);
        Auth::login($user);
        $user->assignRole($data['role']);
        // $user->syncRoles($data['role']);

        return redirect('/home');
    }

    /**
     * 轉換 OpenID 資料
     *
     * @param array $source
     *
     * @return array
     */
    private function convertOpenIdData(array $source)
    {
        $data = [
            'schoolId' => $source['pref/timezone'][0]['id'],  // 校代碼
            'name' => $source['namePerson'],  // 姓名
            'email' => $source['contact/email'],  // email
            'classInfo' => $source['pref/language'],  // 年班座號
            'role' => $source['pref/timezone'][0]['role'],  // 身分

            // 'password' => bcrypt($source['contact/email']), // 以 email 當密碼
            'password' => bcrypt(Str::random(8)), // 隨機密碼，8碼
        ];

        return $data;
    }
}
