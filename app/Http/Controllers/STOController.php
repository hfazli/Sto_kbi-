<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class STOController extends Controller
{
    public function index()
    {
        return view('sto.index');
    }

    public function showForm()
    {
        $user = Auth::user();
        return view('STO.from', compact('user'));
    }

    public function manage(Request $request, $id)
    {
        // Your manage logic here
    }
}