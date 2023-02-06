<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreVehicleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|required',
            'type_id' => 'numeric',
            'note' => 'string|nullable',
            'license_number' => 'string',
            'capacity' => 'numeric|min:0',
            'capacity_unit' => 'string',
        ];
    }

    public function failedValidation(Validator $request)
    {
        throw new HttpResponseException(response()->json($request->errors(), 400));
    }
}
