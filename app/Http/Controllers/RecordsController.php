<?php

namespace App\Http\Controllers;

use App\User;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RecordsController extends Controller
{
    public function show(Request $request, $activityId)
    {
        if (!$activityId) {
            return response()->json(['message' => 'Дані в запиті не заповнені або не вірні!'], 400);
        }

        try {
            $user = User::where('token', '=', $request->header('x-auth-token'))->first();

            $records = Record::where('activity_id', $activityId)->where('user_id', $user->id)->get();

            return response()->json(['data' => $records], 200);

        } catch (\Exception $exception) {
            Log::warning('RecordsController@show Exception: ' . $exception->getMessage());
            return response()->json(['message' => 'Упс! Щось пішло не так!'], 500);
        }
    }

    public function updateOrStore(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'record_id' => '',
                'activity_id' => 'required',
                'value' => 'required',
                'date' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Дані в запиті не заповнені або не вірні!'], 400);
            }

            $user = User::where('token', '=', $request->header('x-auth-token'))->first();
            $record = Record::where('id', $request->id)->first();

            if (!$record){
                $record = new Record();
                $record->activity_id = $request->activity_id;
                $record->user_id = $user->id;
                $record->value = $request->value;
                $record->date = $request->date;
            }else{
                $record->value = $request->value;
                $record->save();
            }

            return response()->json(['data' => $record], 200);

        } catch (\Exception $exception) {
            Log::warning('RecordsController@updateOrStore Exception: ' . $exception->getMessage());
            return response()->json(['message' => 'Упс! Щось пішло не так!'], 500);
        }
    }
}
