<?php

namespace App\Http\Controllers\Stminishow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pattern;
use Illuminate\Support\Facades\DB;

class PatternController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission3')) {
                $patterns = pattern::where('Status', '=', 0)->paginate(5);
                $count = pattern::where('Status', '=', 0)->count();
                return view('Stminishow.PatternForm', compact("patterns"))->with('count', $count);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }


    public function searchPTN(Request $request)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission2')) {
                $searchPTN = $request->searchPTN;
                $patterns = DB::table('patterns')->select('Id_Pattern','Name_Pattern','Status')->where('Status', '=', 0)
                    ->where('Id_Pattern', "LIKE", "%{$searchPTN}%")
                    ->orwhere('Name_Pattern', "LIKE", "%{$searchPTN}%")->paginate(5);
                $count = pattern::where('Status', '=', 0)->count();
                return view("Stminishow.SearchPatternForm")->with("patterns", $patterns)->with('count', $count);
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
        $GenId = DB::table('patterns')->max('Id_Pattern');

        if (is_null($GenId)) {
            $Id_Pattern = "PTN" . "-" . date('Y') . date('m') . "-" . "000";
        } else {
            $GenId_PTN = substr($GenId, 11, 14) + 1;

            if ($GenId_PTN < 10) {
                $Id_Pattern = "PTN" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_PTN;
            } elseif ($GenId_PTN >= 10 && $GenId_PTN < 100) {
                $Id_Pattern = "PTN" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_PTN;
            } elseif ($GenId_PTN >= 100) {
                $Id_Pattern = "PTN" . "-" . date('Y') . date('m') . "-" . $GenId_PTN;
            }
        }
        // dd($Id_Color);
        $request->validate([
            'Name_Pattern' => 'required|unique:patterns'
        ]);
        $pattern = new pattern;
        $pattern->Id_Pattern = $Id_Pattern;
        $pattern->Name_Pattern = $request->Name_Pattern;
        $pattern->save();
        return redirect('/Stminishow/createPattern');
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
    public function edit($Id_Pattern)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission2')) {
                $pattern = Pattern::find($Id_Pattern);

                return view('Stminishow.EditPatternForm', ['patterns' => $pattern]);
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
    public function update(Request $request, $Id_Pattern)
    {
        $request->validate([
            'Name_Pattern' => 'required'
        ]);

        $pattern = Pattern::find($Id_Pattern);
        $pattern->Name_Pattern = $request->Name_Pattern;
        $pattern->save();
        return redirect('/Stminishow/createPattern');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($Id_Pattern)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission2')) {
                $Pattern =  Pattern::find($Id_Pattern);
                $Pattern->Status = 1;
                $Pattern->save();
                return redirect('/Stminishow/createPattern');
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }
}
