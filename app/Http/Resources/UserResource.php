<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        /* 
                {
            "id":"ahd123@zod", // can contain number, characters and symbols "name":"username", // only characters no symbols or numbers "email":"username@gmail.com", // can contain numbers and characters "job":"userjob", // only characters no symbols or numbers
            "cv":"url", // contain url to a cv doc
            "user_image":"url", // contain url for image
            "experience":[. // array of object contain experiences
            {
            "job_title":"title", // only characters no symbols or numbers "location":"location", // contain location
            "start_date":"date", // contain date in date format (dd/mm/yyyy) "end_date":"date" // contain date in date format (dd/mm/yyyy)
            }, {
            "job_title":"title", "location":"location", "start_date":"date", "end_date":"date"
            } ]
            } */
        return [
            "id" => $this->_id, // can contain number, characters and symbols
            "name" => $this->name, // only characters no symbols or numbers
            "email" => $this->email, // can contain numbers and characters 
            "job" => $this->job, // only characters no symbols or numbers
            "cv" => $this->cv, // contain url to a cv doc
            "user_image" => $this->user_image, // contain url for image
            "experiences" => $this->experiences
        ];
    }
}
