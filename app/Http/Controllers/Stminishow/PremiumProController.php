<?php

namespace App\Http\Controllers\Stminishow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\PremiumPro;

use Illuminate\Support\Facades\Session;
class PremiumProController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function searchPMP(Request $request)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission7')) {
                $searchPMP = $request->searchPMP;


                $PremiumPros = DB::table('premium_pros')->where('Status', '=', 0)
                    ->where('Id_Premium_Pro', "LIKE", "%{$searchPMP}%")
                    ->orwhere('Name_Premium_Pro', "LIKE", "%{$searchPMP}%")
                    ->orwhere('Amount_Premium_Pro', "LIKE", "%{$searchPMP}%")->paginate(5);

                $count = PremiumPro::where('Status', '=', 0)->count();
                return view("Stminishow.SearchPremiumProForm")->with("premium_pros", $PremiumPros)->with("count", $count);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }



    public function ShowPremiumPro()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission7')) {
                $count = PremiumPro::where('Status', '=', 0)->count();
                return view('Stminishow.ShowPremiumProForm')->with("premium_pros", PremiumPro::where('Status', '=', 0)->paginate(5))->with("count", $count);
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
    public function index()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission7')) {
                
                $GenId = DB::table('premium_pros')->max('Id_Premium_Pro');

                if (is_null($GenId)) {
                    $Id_PremiumPro = "PMP" . "-" . date('Y') . date('m') . "-" . "000";
                } else {

                    $GenId_PMP = substr($GenId, 11, 14) + 1;

                    if ($GenId_PMP < 10) {
                        $Id_PremiumPro = "PMP" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_PMP;
                    } elseif ($GenId_PMP >= 10 && $GenId_PMP < 100) {
                        $Id_PremiumPro = "PMP" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_PMP;
                    } elseif ($GenId_PMP >= 100) {
                        $Id_PremiumPro = "PMP" . "-" . date('Y') . date('m') . "-" . $GenId_PMP;
                    }
                }

                Session::put('Id_PremiumPro', $Id_PremiumPro);

                

                return view('Stminishow.PremiumProForm');
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'Name' => 'required',
            'Amount' => 'required',
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:5000 '
            //
        ]);

        $stringImageReFormat = base64_encode('_' . time());
        $ext = $request->file('image')->getClientOriginalExtension();
        $imageName = $stringImageReFormat . "." . $ext;
        $imageEncoded = File::get($request->image);

        Storage::disk('local')->put('public/PremiumPro_image/' . $imageName, $imageEncoded);



        $GenId = DB::table('premium_pros')->max('Id_Premium_Pro');

        if (is_null($GenId)) {
            $Id_PremiumPro = "PMP" . "-" . date('Y') . date('m') . "-" . "000";
        } else {

            $GenId_PMP = substr($GenId, 11, 14) + 1;

            if ($GenId_PMP < 10) {
                $Id_PremiumPro = "PMP" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_PMP;
            } elseif ($GenId_PMP >= 10 && $GenId_PMP < 100) {
                $Id_PremiumPro = "PMP" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_PMP;
            } elseif ($GenId_PMP >= 100) {
                $Id_PremiumPro = "PMP" . "-" . date('Y') . date('m') . "-" . $GenId_PMP;
            }
        }
        $PremiumPros = new PremiumPro;
        $PremiumPros->Id_Premium_Pro = $Id_PremiumPro;
        $PremiumPros->Name_Premium_Pro = $request->Name;
        $PremiumPros->Amount_Premium_Pro = $request->Amount;
        $PremiumPros->Img_Premium_Pro = $imageName;

        $PremiumPros->save();

        return redirect('/Stminishow/ShowPremiumPro');
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
    public function edit($Id_Premium_Pro)
    {

        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission7')) {
                $PremiumPro = PremiumPro::find($Id_Premium_Pro);
                // dd($PremiumPro);
                return view('Stminishow.EditPremiumProForm', ['premium_pros' => $PremiumPro]);
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
    public function update(Request $request, $Id_Premium_Pro)
    {

        $request->validate([
            'Name' => 'required',
            'Amount' => 'required'


        ]);

        if ($request->hasFile("image")) {
            $PremiumPro = PremiumPro::find($Id_Premium_Pro);
            $exists = Storage::disk('local')->exists("public/PremiumPro_image/" . $PremiumPro->Img_Premium_Pro); //เจอไฟล์ภาพชื่อตรงกัน
            if ($exists) {
                Storage::delete("public/PremiumPro_image/" . $PremiumPro->Img_Premium_Pro);
            }
            $request->image->storeAs("public/PremiumPro_image/", $PremiumPro->Img_Premium_Pro);
        }

        $PremiumPro = PremiumPro::find($Id_Premium_Pro);
        $PremiumPro->Name_Premium_Pro = $request->Name;
        $PremiumPro->Amount_Premium_Pro = $request->Amount;
        $PremiumPro->save();

        return redirect('/Stminishow/ShowPremiumPro');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($Id_Premium_Pro)
    {

        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission7')) {
                $PremiumPro = PremiumPro::find($Id_Premium_Pro);
                // $exists = Storage::disk('local')->exists("public/PremiumPro_image/" . $PremiumPro->Img_Premium_Pro); //เจอไฟล์ภาพชื่อตรงกัน
                // if ($exists) {
                //     Storage::delete("public/PremiumPro_image/" . $PremiumPro->Img_Premium_Pro);
                // }
           
                $PremiumPro->Status = 1;
                $PremiumPro->save();
                return redirect('/Stminishow/ShowPremiumPro');
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }
}
