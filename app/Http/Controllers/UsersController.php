<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Дані в запиті не заповнені або не вірні!'], 400);
        }

        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

                        $credentials = $request->only('email', 'password');
                        Auth::attempt($credentials);

                        $user->changeToken();
                        $user->save();

                        $result = array();
                        $result = array_add($result, 'name', $user->name);
                        $result = array_add($result, 'email', $user->email);
                        $result = array_add($result, 'token', $user->token);

                        return response($result);
                    } else {
                        return response()->json(['message' => 'Упс! Щось пішло не так!'], 500);
                    }
                }
            }

            return response()->json(['message' => 'Користувача немає або логін / пароль не підходять'], 401);

        } catch (\Exception $exception) {
            Log::warning('UsersController@login Exception: ' . $exception->getMessage() . "Line - " . $exception->getLine());
            return response()->json(['message' => 'Упс! Щось пішло не так!'], 500);
        }
    }


    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:6|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Дані в запиті не заповнені або не вірні!'], 400);
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->token = Hash::make(time());
            $user->save();

            $result = array();
            $result = array_add($result, 'name', $user->name);
            $result = array_add($result, 'email', $user->email);
            $result = array_add($result, 'token', $user->token);

            return response($result);
        } catch (\Exception $exception) {
            Log::warning('UsersController@register Exception: ' . $exception->getMessage() . "Line - " . $exception->getLine());
            return response()->json(['message' => 'Упс! Щось пішло не так!'], 500);
        }
    }


    public function logout(Request $request)
    {
        try {
            $user = User::where('token', '=', $request->header('x-auth-token'))->first();
            $user->changeToken();
            $user->save();

            Auth::logout();

            return response()->json(['success' => true], 200);

        } catch (\Exception $exception) {
            Log::warning('UsersController@logout Exception: ' . $exception->getMessage());
            return response()->json(['message' => 'Упс! Щось пішло не так!'], 500);
        }
    }


    public function generatePassword($length = 8)
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }


    public function ResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        $validator_exist = Validator::make($request->all(), [
            'email' => 'exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Дані в запиті не заповнені або не вірні!'], 400);
        }

        if ($validator_exist->fails()) {
            return response()->json(['message' => 'Користувача не існує!'], 404);
        }

        try {
            $user = User::where('email', $request->email)->first();
            $new_password = $this->generatePassword();
            $user->password = bcrypt($new_password);

            \Mail::to($request->email)->send(new ResetPassword($user, $new_password));

            $user->save();

            return response()->json(['message' => 'Перевірте пошту з новим паролем!'], 200);
        } catch (\Exception $exception) {
            Log::warning('UsersController@resetPassword Exception: ' . $exception->getMessage());
            return response()->json(['message' => 'Упс! Щось пішло не так!'], 500);
        }
    }


    public function ChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_old' => 'required|string|min:6|max:255',
            'password' => 'required|string|min:6|max:255',
            'password_confirmation' => 'required|string|min:6|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Дані в запиті не заповнені або не вірні!'], 400);
        }

        if ($request->password !== $request->password_confirmation) {
            return response()->json(['message' => 'Паролі не співпадають!'], 422);
        }

        $user = User::where('token', '=', $request->header('x-auth-token'))->first();

        if (Hash::check($request->password_old, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json(['message' => 'Пароль змінений!'], 200);
        } else {
            return response()->json(['message' => 'Старий пароль невірний!'], 422);
        }
    }

    public function SetAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Дані в запиті не заповнені або не вірні!'], 400);
        }

        try {
            $user = User::where('token', '=', $request->header('x-auth-token'))->first();

            $image = $this->storeBase64Image($request->avatar);

            if (!$image) {
                return response()->json(['message' => 'Збереження не вдалося. Перевірте картинку!'], 422);
            }

            if (isset($user->avatar) || !empty($user->avatar)) {
                $this->deletePreviousImage($user->avatar);
            }

            $user->avatar = $image;
            $user->save();

            return response()->json(['message' => 'Аватар змінено!', 'avatar' => Config::get('app.url') . $image], 200);

        } catch (\Exception $exception) {
            Log::warning('UsersController@SetAvatar Exception: ' . $exception->getMessage() . " - " . $exception->getLine());
            return response()->json(['message' => 'Упс! Щось пішло не так!'], 500);
        }
    }


    public function SetPlayer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Дані в запиті не заповнені або не вірні!'], 400);
        }

        try {
            $user = User::where('token', '=', $request->header('x-auth-token'))->first();
            $user->player_id = $request->player;
            $user->save();

            return response()->json(['message' => 'Player_id Встановлено!'], 200);

        } catch (\Exception $exception) {
            Log::warning('UsersController@SetPlayer Exception: ' . $exception->getMessage() . " - " . $exception->getLine());
            return response()->json(['message' => 'Упс! Щось пішло не так!'], 500);
        }
    }


    public function SetPush(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'push' => [
                'required',
                'string',
                Rule::in(['enabled', 'disabled']),
            ]
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Дані в запиті не заповнені або не вірні!'], 400);
        }

        try {
            $user = User::where('token', '=', $request->header('x-auth-token'))->first();
            $user->push = $request->push;
            $user->save();

            return response()->json(['message' => 'Push повiдомлення змiнено!', 'data' => $user->push], 200);

        } catch (\Exception $exception) {
            Log::warning('UsersController@SetPlayer Exception: ' . $exception->getMessage() . " - " . $exception->getLine());
            return response()->json(['message' => 'Упс! Щось пішло не так!'], 500);
        }
    }

    public function SetPushChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'push' => [
                'required',
                'string',
                Rule::in(['true', 'false']),
            ]
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Дані в запиті не заповнені або не вірні!'], 400);
        }

        try {
            $user = User::where('token', '=', $request->header('x-auth-token'))->first();
            $user->push_chat = $request->push;
            $user->save();

            return response()->json(['message' => 'Push повiдомлення змiнено!', 'data' => $user->push_chat], 200);

        } catch (\Exception $exception) {
            Log::warning('UsersController@SetPushChat Exception: ' . $exception->getMessage() . " - " . $exception->getLine());
            return response()->json(['message' => 'Упс! Щось пішло не так!'], 500);
        }
    }

    public function storeBase64Image($data)
    {
        $folderPath = "images/uploads/avatars/";
        $image_parts = explode(";base64,", $data);

        if (!$image_parts || !isset($image_parts[1]) || $image_parts[1] == null || $image_parts[1] == "") {
            return null;
        }

        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . time() . "-" . uniqid() . '.png';
        $image = "/" . $file;

        if (file_put_contents($file, $image_base64) !== false) {
            return $image;
        } else {
            return null;
        }
    }

    public function deletePreviousImage($data)
    {
        $preview = public_path() . $data;
        if (file_exists($preview)) {
            unlink($preview);
        }

        return true;
    }

}
