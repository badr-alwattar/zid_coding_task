<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipmentCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sender_name' => 'required',
            'sender_phone' => 'required',
            'sender_city' => 'required',
            'sender_latitude' => 'required',
            'sender_longitude' => 'required',
            'receiver_name' => 'required',
            'receiver_phone' => 'required',
            'receiver_city' => 'required',
            'receiver_latitude' => 'required',
            'receiver_longitude' => 'required',
        ];
    }
}
