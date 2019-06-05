<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Person extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        dd($request);
//        return parent::toArray($request);
        
        return [
            'Name' => $this->name,
            'FirstName' => $this->firstname,
            'LastName' => $this->lastname,
            'MiddleName' => $this->middlename,
            'Tall' => $this->tall,
            'Birth' => $this->birth_date,
            'Created' => (string)$this->created_at->format('d-m-Y'),
        ];
    }
}
