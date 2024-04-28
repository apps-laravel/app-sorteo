<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;


class UserRequest extends FormRequest
{


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors()->first(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users',
            'cc' => 'required|numeric|unique:users',
            'phone' => 'required|numeric',
            'department' => 'required|string',
            'city' => 'required|string'
        ];
    }
    function messages():array
    {
        return [
            'name.required' => 'el campo nombre es requerido',
            'lastname.required' => 'el campo apellido es requerido',
            'email.required' => 'el campo email es requerido',
            'email.email' => 'el campo email debe ser un email valido',
            'email.unique' => 'el campo email ya esta en uso',
            'cc.required' => 'el campo cc es requerido',
            'cc.numeric' => 'el campo cc debe ser un numero',
            'cc.unique' => 'el campo cc ya esta en uso',
            'phone.required' => 'el campo telefono es requerido',
            'phone.numeric' => 'el campo telefono debe ser un numero',
            'department.required' => 'el campo departamento es requerido',
            'city.required' => 'el campo ciudad es requerido',
        ];
    }

}
