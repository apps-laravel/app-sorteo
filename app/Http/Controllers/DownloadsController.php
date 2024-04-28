<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DownloadsController extends Controller
{

    public function __invoke()
    {
        return Excel::download(new UsersExport, 'users.xlsx');

//        return Excel::download(new UsersExport, 'users.xlsx');

    }
}
