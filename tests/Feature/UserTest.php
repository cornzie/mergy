<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
   use RefreshDatabase, WithFaker;
    
    /**
     * A user can create an account.
     *
     * @return void
     */
    public function test_a_user_can_create_an_account()
    {
        $email = $this->faker->email;
        $name = $this->faker->firstName;

        $response = $this->post('api/users', [
            'id' => $this->faker->uuid,
            'name' => $name,
            'email' => $email,
            'job' => $this->faker->word,
            'cv' => 'http://exampleserver/files/cv.pdf',
            'user_image' => $this->faker->imageUrl(100, 100, 'cats'),
            'password' => 'password',
            'experiences' => [
                [
                    'job_title' => $this->faker->sentence,
                    'location' => $this->faker->address,
                    'start_date' => date('d/m/Y', strtotime($this->faker->date)),
                    'end_date' => date('d/m/Y', strtotime($this->faker->date)),
                ]
            ]
        ]);

        // dd($response);

        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);

        $response->assertStatus(201);
    }

    /**
     * A user can update their profile.
     *
     * @return void
     */
    public function test_a_user_can_update_their_profile()
    {

        $this->actingAs($user = User::factory()->create());
        $newEmail = $this->faker->email;
        $newName = $this->faker->firstName;
        $newCv = 'http://exampleserver/files/newcv.pdf';
        $newImage = $this->faker->imageUrl(100, 100, 'cats');
        $newJob = $this->faker->sentence;
        $newLocation = $this->faker->address;
        $newStartDate = $this->faker->date;
        $newEndDate = $this->faker->date;

        $response = $this->put('api/users/'.$user->_id, [
            'name' => $newName,
            'email' => $newEmail,
            'job' => $this->faker->word,
            'cv' => $newCv,
            'user_image' => $newImage,
            'password' => 'password',
            'experiences' => [
                [
                    'job_title' => $newJob,
                    'location' => $newLocation,
                    'start_date' => date('d/m/Y', strtotime($newStartDate)),
                    'end_date' => date('d/m/Y', strtotime($newEndDate)),
                ]
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $newEmail,
            'name' => $newName,
        ]);

        $this->assertDatabaseHas('experiences', [
            'job_title' => $newJob,
        ]);

        $response->assertStatus(200);
    }

    /**
     * A user can fetch their profile from storage.
     *
     * @return void
     */
    public function test_a_user_can_fetch_their_profile_from_storage()
    {

        $this->actingAs($user = User::factory()->create());

        $response = $this->get('api/users/'.$user->_id);

        // dd($response);

        $response->assertStatus(200)->assertJson([
            "message" => "success",
            "data" => [
                'id' => $user->_id,
                'name' => $user->name,
                'email' => $user->email,
                'job' => $user->job,
            ]
        ]);
    }


    /**
     * A user can delete their profile from storage.
     *
     * @return void
     */
    public function test_a_user_can_delete_their_profile_from_storage()
    {

        $this->actingAs($user = User::factory()->create());

        $response = $this->delete('api/users/', [
            'id' => $user->_id
        ]);

        // dd($response);

        $this->assertDatabaseMissing('users', [
            'email' => $user->email,
        ]);

        $response->assertStatus(200)->assertJson([
            "message" => "success",
            "data" => []
        ]);
    }


}
