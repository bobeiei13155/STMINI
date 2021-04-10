<?php

namespace App\Http\Controllers\Stminishow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Gen;
use Illuminate\Support\Facades\DB;

class GenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission3')) {
                $gens = Gen::paginate(5);
                $count = Gen::where('Status', '=', 0)->count();
                return view('Stminishow.GenForm', compact("gens"))->with('count', $count);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    public function searchGEN(Request $request)
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission3')) {
                $searchGEN = $request->searchGEN;
                $gens = DB::table('gens')
                    ->where('Id_Gen', "LIKE", "%{$searchGEN}%")
                    ->orwhere('Name_Gen', "LIKE", "%{$searchGEN}%")->paginate(5);
                    $count = Gen::where('Status', '=', 0)->count();
                return view("Stminishow.SearchGenForm")->with("gens", $gens)->with('count', $count);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $GenId = DB::table('gens')->max('Id_Gen');

        if (is_null($GenId)) {
            $Id_Gen = "GEN" . "-" . date('Y') . date('m') . "-" . "000";
        } else {
            $GenId_GEN = substr($GenId, 11, 14) + 1;

            if ($GenId_GEN < 10) {
                $Id_Gen = "GEN" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_GEN;
            } elseif ($GenId_GEN >= 10 && $GenId_GEN < 100) {
                $Id_Gen = "GEN" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_GEN;
            } elseif ($GenId_GEN >= 100) {
                $Id_Gen = "GEN" . "-" . date('Y') . date('m') . "-" . $GenId_GEN;
            }
        }
        // dd($Id_Color);
        $request->validate([
            'Name_Gen' => 'required|unique:gens'
        ]);
        $gen = new gen;
        $gen->Id_Gen = $Id_Gen;
        $gen->Name_Gen = $request->Name_Gen;
        $gen->save();
        return redirect('/Stminishow/createGen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Id_Gen)
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission3')) {
                $gen = gen::find($Id_Gen);

                return view('Stminishow.EditGenForm', ['gens' => $gen]);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Id_Gen)
    {
        $request->validate([
            'Name_Gen' => 'required|unique:gens'
        ]);

        $gen = gen::find($Id_Gen);
        $gen->Name_Gen = $request->Name_Gen;
        $gen->save();
        return redirect('/Stminishow/createGen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($Id_Gen)
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission3')) {
                $gen = gen::find($Id_Gen);
                $gen->Status = 1;
                $gen->save();
                return redirect('/Stminishow/createGen');
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }
}
