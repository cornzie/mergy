<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Experience;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    //    
    /**
     * Index - List all users
     *
     * @return void
     */
    public function index()
    {
        // 
    }

    /**
     * Store - Create a new user in the DB
     *
     * @return void
     */
    public function store(StoreUserRequest $request)
    {
        // 
        $request->validated();

        try{

            $user = User::create([
                '_id' => $request->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'job' => $request->job,
                'cv' => $request->cv,
                'user_image' => $request->user_image,
            ]);

            if($user && ($request->has('experiences') && $request->filled('experiences')))
            {
                foreach ($request->experiences as $experience) {
                    Experience::create([
                        'user_id' => $user->id,
                        'job_title' => $experience['job_title'],
                        'location' => $experience['location'],
                        'start_date' => date('Y-m-d', strtotime($experience['start_date'])),
                        'end_date' => date('Y-m-d', strtotime($experience['end_date'])),
                    ]);
                }
            }

    
            return $this->formattedResponse((new UserResource($user)), 201);

        } catch(Throwable $th)
        {
            Log::critical('Store user failed', [
                'exception' => $th->getMessage()
            ]);

            return $this->formattedError($th->getMessage());
        }
    }

    /**
     * Show - Return one user
     *
     * @return void
     */
    public function show(string $user)
    {
        // 

        $user = User::where('_id', $user)->first();
        
        return is_null($user) ? $this->formattedError('No user found', 404) : $this->formattedResponse((new UserResource($user)), 200);

    }

    /**
     * Show - Update a user resource
     *
     * @return void
     */
    public function update(string $user, UpdateUserRequest $request)
    {
        $request->validated();

        $user = User::where('_id', $user)->first();

        if($user){
            // 
            foreach ($request->except('experiences', 'id') as $key => $value) {
                $user->{$key} = $value;
            }
    
            if($user->save())
            {
                if($request->has('experiences'))
                {
                    
                    foreach ($request->experiences as $experience) {
                        $user->experiences()->updateOrCreate([
                            'job_title' => $experience['job_title'],
                            'location' => $experience['location'],
                        ],
                        [
                            'start_date' => date('Y-m-d', strtotime($experience['start_date'])),
                            'end_date' => date('Y-m-d', strtotime($experience['end_date'])),
                        ]
                        );
                    }
                }
    
                return $this->formattedResponse((new UserResource($user)));
            }
        }
    }

    /**
     * Destroy - Update a user resource
     *
     * @return void
     */
    public function destroy(Request $request)
    {
        // 
        $request->validate([
            'id' => 'required|exists:users,_id',
        ]);

        if($user = User::where('id', $request->id)->orWhere('_id', $request->id)->first()->delete())
        {
            return $this->formattedResponse();
        }

        return $this->formattedError();
        
    }


}
