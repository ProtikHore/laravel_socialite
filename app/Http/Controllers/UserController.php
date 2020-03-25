<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $recordPerPage = 10;
        return view('home.index', compact('recordPerPage'));
    }

    public function getRecords($searchKey)
    {
        $records =  User::where(function ($query) use ($searchKey) {
            if ($searchKey !== 'null') {
                $query->where('name', 'like', '%' . $searchKey . '%');
                $query->orWhere('email', 'like', '%' . $searchKey . '%');
                $query->orWhere('mobile_number', 'like', '%' . $searchKey . '%');
                $query->orWhere('status', 'like', '%' . $searchKey . '%');
                $query->orWhere('narrative', 'like', '%' . $searchKey . '%');
            }
        })->paginate(10);
        return response()->json($records);
    }
}
