<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\League;
use App\Task;
use App\User;

use Carbon;

class ClassController extends Controller
{
    public function getList(Request $request)
    {
        $response = [];
        $input = $request->all();
        $data = League::with('user', 'players', 'tasks.users')->where('gm_id', $input['gm_id'])->get();

        if (! is_null($data)) {
            $response['data'] = $data;
            $response['message'] = 'Successfully retrieved data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to retrieve data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function findList(Request $request)
    {
        $response = [];
        $input = $request->all();
        $input['slug'] = join("-", explode(" ", strtolower($input['keyword'])));

        if(@$input['gm'] > 0) {
            $data = League::whereHas('user', function($q) use($input) {
                    $q->where('id', $input['gm']);
                })
                ->with('players', 'tasks.users')
                ->where('name', 'LIKE' , $input['keyword'] . '%')
                ->orWhere('slug', $input['slug'])
                ->get();
        } else {
            
            if($input['keyword']) {
                $data = League::with('user', 'tasks.users', 'players')->where('name', 'LIKE' , $input['keyword'] . '%')->orWhere('slug', $input['slug'])->get();
            } else {
                $user = User::with('leagues.user', 'leagues.players', 'leagues.tasks.users')->find($input['player']);
                $leagues = [];

                foreach($user->leagues as $league) {
                    $leagues[] = $league->id;
                }

                $data = League::with('user', 'tasks.users', 'players')
                            ->whereIn('id', $leagues)
                            ->where('name', 'LIKE' , $input['keyword'] . '%')
                            ->orWhere('slug', $input['slug'])->get();
            }
        }

        if (! is_null($data)) {
            $response['data'] = $data;
            $response['message'] = 'Successfully retrieved data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to retrieve data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function create(Request $request)
    {
        $response = [];
        $input = $request->all();
        $input['slug'] = join("-", explode(" ", strtolower($input['name'])));
        $data = League::create($input);

        if (! is_null($data)) {
            $response['data'] = $data;
            $response['message'] = 'Successfully created data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to create data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function delete(Request $request)
    {
        $response = [];
        $input = $request->all();
        $data = League::destroy($input['ids']);

        if (! is_null($data)) {
            $response['data'] = $data;
            $response['message'] = 'Successfully deleted data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to delete data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function getTasks(Request $request)
    {
        $response = [];
        $input = $request->all();
        $data = League::with('user', 'tasks.users', 'players')->where('slug', $input['slug'])->first();

        if (! is_null($data)) {
            $response['data'] = $data;
            $response['message'] = 'Successfully retrieved data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to retrieve data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function addTask(Request $request)
    {
        $response = [];
        $input = $request->all();
        $input['status'] = 'active';
        $task = Task::create($input);

        if (! is_null($task)) {
            $response['data'] = $task;
            $response['message'] = 'Successfully created data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to retrieve data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function join(Request $request)
    {
        $response = [];
        $input = $request->all();
        
        $league = League::find($input['league']);

        $league->players()->attach([$input['player'] => ['status' => 'pending']]);

        if (! is_null($league)) {
            $response['data'] = $league;
            $response['message'] = 'Successfully created data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to retrieve data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function getLeagues(Request $request)
    {
        $response = [];
        $input = $request->all();
        $leagues = [];
        $user = User::with('leagues.user', 'leagues.players', 'leagues.tasks.users')->find($input['player']);

        if (! is_null($user->leagues)) {
            $response['data'] = $user->leagues;
            $response['message'] = 'Successfully created data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to retrieve data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function acceptUser(Request $request)
    {
        $response = [];
        $input = $request->all();
        $league = League::find($input['league']);

        $league->players()->detach([$input['player']]);
        $league->players()->attach([$input['player'] => ["status" => 'accepted']]);

        $player = $league->players()->where('id', $input['player'])->first();
        // die(var_dump($player));
        if (! is_null($player)) {
            $response['data'] = $player;
            $response['message'] = 'Successfully added player data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to add player data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function removeUser(Request $request)
    {
        $response = [];
        $input = $request->all();
        $league = League::find($input['league']);

        $league->players()->detach([$input['player']]);
        // die(var_dump($player));
        if (! is_null($player)) {
            $response['data'] = $league;
            $response['message'] = 'Successfully added player data.';
            $status = 200;
        } else {
            $response['message'] = 'Failed to add player data.';
            $status = 500;
        }

        return response($response, $status);
    }

    public function completeTask(Request $request) {
        $response = [];
        $input = $request->all();

        $task = Task::find($input['task']);

        if($input['status'] == 'teacher') {
            $task->users()->detach([$input['player']]);
        }

        $task->users()->attach([
            $input['player'] => [
                'status' => $input['status'],
                'score' => @$input['score']
            ]
        ]);

        $response['message'] = 'Successfully completed task.';
        $status = 200;

        return response($response, $status);
    }

/** Copy/paste these lines to app\Http\routes.api.php 
Route::get('api/classes/list', array('as'=>'apiClassesList','uses'=>'ClassController@getList', 'middleware'=>'cors'));
Route::get('api/classes/get', array('as'=>'apiClassesGet','uses'=>'ClassController@get', 'middleware'=>'cors'));
Route::post('api/classes/store', array('as'=>'apiClassesStore','uses'=>'ClassController@store', 'middleware'=>'cors'));
Route::post('api/classes/update', array('as'=>'apiClassesUpdate','uses'=>'ClassController@update', 'middleware'=>'cors'));
Route::post('api/classes/destroy', array('as'=>'apiClassesDestroy','uses'=>'ClassController@destroy', 'middleware'=>'cors'));
*/
}
