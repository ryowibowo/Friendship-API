<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;


class UserController extends Controller
{



    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */

    public function sendFriendRequest(Request $request)
    {

        if($request->requestor == ''){
            return response()->json(['metaData' => ['code' => 400, 'message' => 'Requestor Cant Be Empty']], 400);
        }
        if($request->to == ''){
            return response()->json(['metaData' => ['code' => 400, 'message' => 'To Cant Be Empty']], 400);
        }

        if ($request->requestor ==  $request->to) {
            return response()->json(['metaData' => ['code' => 400, 'message' => 'Requestor and To cant be the same']], 400);
        }

        $checkIfExist = User::select('users.id','email','status', 'user_id_1','user_id_2')
            ->join('friends', 'users.id', '=', 'friends.user_id_2')
            ->where('users.email', $request->to)
            ->orWhere('status', '=', 'Blocked')
            ->first();

        if($checkIfExist){
            return response()->json(['metaData' => ['code' => 400, 'message' => 'Request Already Send']], 400);
        }

        $from = User::select('id','email')
            ->where('email', '=', $request->requestor)
            ->first();

        $to = User::select('id','email')
            ->where('email', '=', $request->to)
            ->first();

        if(!$from){
            return response()->json(['metaData' => ['code' => 400, 'message' => 'Requestor Not Found']], 400);
        }elseif (!$to){
            return response()->json(['metaData' => ['code' => 400, 'message' => 'To Not Found']], 400);
        }else{
            try {
                Friend::insert([
                    'user_id_1' => $from->id,
                    'user_id_2' => $to->id,
                    'status' => "Pending",         //0 = pending request
                ]);

                return response()->json(['metaData' => ['code' => 200, 'message' => 'Success']], 200);
            } catch (QueryException $e) {
                return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 500);
            }
        }
    }

    public function acceptRequest(Request $request)
    {
        try {
            if($request->requestor == ''){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'Requestor Cant Be Empty']], 400);
            }
            if($request->to == ''){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'To Cant Be Empty']], 400);
            }

            if ($request->requestor ==  $request->to) {
                return response()->json(['metaData' => ['code' => 400, 'message' => 'Requestor and To cant be the same']], 400);
            }


            $from = User::select('id','email')
            ->where('email', '=', $request->requestor)
            ->first();

            $to = User::select('id','email')
                ->where('email', '=', $request->to)
                ->first();

            if(!$from){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'Requestor Not Found']], 400);
            }elseif (!$to){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'To Not Found']], 400);
            }else{
                $relationshipA = Friend::where('user_id_1', $from->id)
                    ->where('user_id_2', $to->id);
                $accept =  Friend::where('user_id_1', $from->id)
                    ->where('user_id_2', $to->id)
                    ->union($relationshipA)
                    ->update([
                        'status' => "Accepted"
                    ]);
            }
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Success']], 200);
        } catch (\Throwable $th) {
            return response()->json(['metaData' => ['code' => 500, 'message' => $th->getMessage()]], 500);
        }
    }

    public function declineRequest(Request $request)
    {
        try {
            if($request->requestor == ''){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'Requestor Cant Be Empty']], 400);
            }
            if($request->to == ''){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'To Cant Be Empty']], 400);
            }

            if ($request->requestor ==  $request->to) {
                return response()->json(['metaData' => ['code' => 400, 'message' => 'Requestor and To cant be the same']], 400);
            }


            $from = User::select('id','email')
            ->where('email', '=', $request->requestor)
            ->first();

            $to = User::select('id','email')
                ->where('email', '=', $request->to)
                ->first();

            if(!$from){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'Requestor Not Found']], 400);
            }elseif (!$to){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'To Not Found']], 400);
            }else{
                $relationshipA = Friend::where('user_id_1', $from->id)
                    ->where('user_id_2', $to->id);
                $accept =  Friend::where('user_id_1', $from->id)
                    ->where('user_id_2', $to->id)
                    ->union($relationshipA)
                    ->update([
                        'status' => "Rejected"
                    ]);
            }
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Success']], 200);
        } catch (\Throwable $th) {
            return response()->json(['metaData' => ['code' => 500, 'message' => $th->getMessage()]], 500);
        }
    }

    public function blockRequest(Request $request)
    {
        try {
            if($request->requestor == ''){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'Requestor Cant Be Empty']], 400);
            }
            if($request->to == ''){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'To Cant Be Empty']], 400);
            }

            if ($request->requestor ==  $request->to) {
                return response()->json(['metaData' => ['code' => 400, 'message' => 'Requestor and To cant be the same']], 400);
            }


            $from = User::select('id','email')
            ->where('email', '=', $request->requestor)
            ->first();

            $to = User::select('id','email')
                ->where('email', '=', $request->to)
                ->first();

            if(!$from){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'Requestor Not Found']], 400);
            }elseif (!$to){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'To Not Found']], 400);
            }else{
                $relationshipA = Friend::where('user_id_1', $from->id)
                    ->where('user_id_2', $to->id);
                $accept =  Friend::where('user_id_1', $from->id)
                    ->where('user_id_2', $to->id)
                    ->union($relationshipA)
                    ->update([
                        'status' => "Blocked"
                    ]);
            }
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Success']], 200);
        } catch (\Throwable $th) {
            return response()->json(['metaData' => ['code' => 500, 'message' => $th->getMessage()]], 500);
        }
    }

    /**
     * Pour recupérer tous les utilsateurs de la BD
     * @return \Illuminate\Http\JsonResponse
     */
    public function test()
    {

        return response()->json(['Success' => true], 200);
    }



    /**
     * On renvoit l'individu dans la BD
     * correspondant à l'id spécifié
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        try {

            if($request->email == ''){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'Email Cant Be Empty']], 400);
            }

            $getUserRequest = User::select('users.id','email','status', 'user_id_1','user_id_2')
                ->join('friends', 'users.id', '=', 'friends.user_id_2')
                ->where('users.email', $request->email)
                ->get();



            foreach($getUserRequest as $key => $task_log) {
                $users[] = User::find($task_log['user_id_1'],['email as requestor']);
            }

            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data Found'], 'response' => $users], 200);

        } catch (\Throwable $th) {
            return response()->json(['metaData' => ['code' => 500, 'message' => $th->getMessage()]], 500);
        }

    }

    public function getFriends(Request $request)
    {
        try {

            if($request->email == ''){
                return response()->json(['metaData' => ['code' => 400, 'message' => 'Email Cant Be Empty']], 400);
            }

            $getUserRequest = User::select('users.id','email','status', 'user_id_1','user_id_2')
                ->join('friends', 'users.id', '=', 'friends.user_id_2')
                ->where('users.email', $request->email)
                ->first();

            $friendsA = Friend::select('user_id_2')
                ->where('user_id_1', $getUserRequest->id)
                ->where('status', '!=', 'Blocked');
            $friends = Friend::select('user_id_1')
                ->where('user_id_2', $getUserRequest->id)
                ->where('status', '!=', 'Blocked')
                ->union($friendsA)
                ->get();
            foreach ($friends as $key => &$friend) {
                $users[] = User::find($friend->user_id_1,['email']);
            }

            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data Found'], 'response' => $users], 200);

        } catch (\Throwable $th) {
            return response()->json(['metaData' => ['code' => 500, 'message' => $th->getMessage()]], 500);
        }

    }

    public function mutualFriends(Request $request)
    {
        try {

            // $relationshipA = Friend::where('user_id_1', 13)
            // ->where('user_id_2', 1);
            // return Friend::where('user_id_1', 1)
            //     ->where('user_id_2', 13)
            //     ->union($relationshipA)
            //     ->get();

                $profile = User::where('id', 13)->first();
                $profileFriends = $profile->friends;
                $profileFriendsIds = [];
                foreach ($profileFriends as $entry){
                    $profileFriendsIds[] = $entry->id;
                    }
                $loggedUserFriends = $profile->friends->whereIn('id', $profileFriendsIds);

                return $loggedUserFriends;

            // return response()->json(['metaData' => ['code' => 200, 'message' => 'Data Found'], 'response' => $users], 200);

        } catch (\Throwable $th) {
            return response()->json(['metaData' => ['code' => 500, 'message' => $th->getMessage()]], 500);
        }

    }

}
