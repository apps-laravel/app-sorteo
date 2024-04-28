<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function index()
    {
        $users = User::join('cities','users.city_id','=','cities.id')
              ->where('cities.name','like','%Bogota%')
              ->select('users.name','last_name','gender')->get();

        $users->map(function($item){
            $item->name = $item->fullName;
            unset($item->last_name);
            return $item;
        });

        return response()->json(['data'=>$users],200);
    }
    function save(UserRequest $request):JsonResponse
    {
            User::create([
            'name' => $request->name,
            'last_name' => $request->lastname,
            'email' => $request->email,
            'cc' => $request->cc,
            'phone' => $request->phone,
            'gender'=>$request->gender,
            'department_id' => $this->departmentId($request->department),
            'city_id' => $this->cityId($request->city),
        ]);
        return response()->json(['message'=>'User created successfully'],201);
    }

    function removeSpecialCharacters($data): string
    {
        $mapTildes = array(
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U'
        );
        return strtr($data, $mapTildes);
    }
    function departmentId($department): int
    {
        $department = $this->removeSpecialCharacters($department);
        $data = DB::query()->from('departments')->where('name',$department);
        return $data->exists() ? $data->value('id') : DB::table('departments')->insertGetId(['name'=>$department]);
    }

    function cityId($city): int
    {
        $city = $this->removeSpecialCharacters($city);
        $data = DB::query()->from('cities')->where('name',$city);
        return $data->exists() ? $data->value('id') : DB::table('cities')->insertGetId(['name'=>$city]);
    }



}
