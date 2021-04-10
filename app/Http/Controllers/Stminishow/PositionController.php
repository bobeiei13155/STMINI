<?php

namespace App\Http\Controllers\Stminishow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\position;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function searchPOS(Request $request)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission2')) {
                $searchPOS = $request->searchPOS;
                $positions = DB::table('positions')->select('Id_Position','Name_Position','Status')->where('Status', '=', 0)
                    ->where('Id_Position', "LIKE", "%{$searchPOS}%")
                    ->orwhere('Name_Position', "LIKE", "%{$searchPOS}%")->paginate(5);
                $count = position::where('Status', '=', 0)->count();
                return view("Stminishow.SearchPositionForm")->with("positions", $positions)->with("count", $count);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    public function index()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission2')) {
                $positions = position::paginate(5);
                $GenId = DB::table('positions')->max('Id_Position');

                if (is_null($GenId)) {
                    $Id_Position = "POS" . "-" . date('Y') . date('m') . "-" . "000";
                } else {
                    $GenId_GEN = substr($GenId, 11, 14) + 1;

                    if ($GenId_GEN < 10) {
                        $Id_Position = "POS" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_GEN;
                    } elseif ($GenId_GEN >= 10 && $GenId_GEN < 100) {
                        $Id_Position = "POS" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_GEN;
                    } elseif ($GenId_GEN >= 100) {
                        $Id_Position = "POS" . "-" . date('Y') . date('m') . "-" . $GenId_GEN;
                    }
                }
                Session::put('Id_Position', $Id_Position);

                return view('Stminishow.PositionForm', compact("positions"));
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    public function ShowPosition()

    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission2')) {
                $positions = position::where('Status', '=', 0)->paginate(5);
                $count = position::where('Status', '=', 0)->count();
                return view('Stminishow.ShowPositionForm', compact("positions"))->with('count', $count);
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

        if (is_null($request->employee)) {
            $employee = 0;
        } else {
            $employee = 1;
        }
        if (is_null($request->position)) {
            $position = 0;
        } else {
            $position = 1;
        }
        if (is_null($request->product)) {
            $product = 0;
        } else {
            $product = 1;
        }
        if (is_null($request->partner)) {
            $partner = 0;
        } else {
            $partner = 1;
        }
        if (is_null($request->member)) {
            $member = 0;
        } else {
            $member = 1;
        }
        if (is_null($request->promotion)) {
            $promotion = 0;
        } else {
            $promotion = 1;
        }
        if (is_null($request->premiumpro)) {
            $premiumpro = 0;
        } else {
            $premiumpro = 1;
        }
        if (is_null($request->offerorder)) {
            $offerorder = 0;
        } else {
            $offerorder = 1;
        }
        if (is_null($request->approveorder)) {
            $approveorder = 0;
        } else {
            $approveorder = 1;
        }
        if (is_null($request->order)) {
            $order = 0;
        } else {
            $order = 1;
        }
        if (is_null($request->receive)) {
            $receive = 0;
        } else {
            $receive = 1;
        }
        if (is_null($request->sell)) {
            $sell = 0;
        } else {
            $sell = 1;
        }
        if (is_null($request->preorder)) {
            $preorder = 0;
        } else {
            $preorder = 1;
        }
        if (is_null($request->receivepreorder)) {
            $receivepreorder = 0;
        } else {
            $receivepreorder = 1;
        }
        if (is_null($request->Claim)) {
            $Claim = 0;
        } else {
            $Claim = 1;
        }
        if (is_null($request->report)) {
            $report = 0;
        } else {
            $report = 1;
        }

        $userpositions = $employee . $position . $product . $partner .
            $member . $promotion . $premiumpro . $offerorder . $approveorder .
            $order . $receive . $sell . $preorder . $receivepreorder . $Claim . $report;


        // dd($userpositions);
        $GenId = DB::table('positions')->max('Id_Position');

        if (is_null($GenId)) {
            $Id_Position = "POS" . "-" . date('Y') . date('m') . "-" . "000";
        } else {
            $GenId_GEN = substr($GenId, 11, 14) + 1;

            if ($GenId_GEN < 10) {
                $Id_Position = "POS" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_GEN;
            } elseif ($GenId_GEN >= 10 && $GenId_GEN < 100) {
                $Id_Position = "POS" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_GEN;
            } elseif ($GenId_GEN >= 100) {
                $Id_Position = "POS" . "-" . date('Y') . date('m') . "-" . $GenId_GEN;
            }
        }

        $request->validate([
            'Name_Position' => 'required|unique:positions'
        ]);
        $position = new position;
        $position->Id_Position = $Id_Position;
        $position->Name_Position = $request->Name_Position;

        $position->Permission = $userpositions;

        $position->save();
        return redirect('/Stminishow/showPosition');
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
    public function edit($Id_Position)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission2')) {
                $position = position::find($Id_Position);
                $Permission = DB::table('positions')->select('Permission')->where('Id_Position', $Id_Position)->get();
                $employee = substr($Permission, 16, 1);
                $pmposition = substr($Permission, 17, 1);
                $product = substr($Permission, 18, 1);
                $partner = substr($Permission, 19, 1);
                $member = substr($Permission, 20, 1);
                $promotion = substr($Permission, 21, 1);
                $premiumpro = substr($Permission, 22, 1);
                $offerorder = substr($Permission, 23, 1);
                $approveorder = substr($Permission, 24, 1);
                $order = substr($Permission, 25, 1);
                $receive = substr($Permission, 26, 1);
                $sell = substr($Permission, 27, 1);
                $preorder = substr($Permission, 28, 1);
                $receivepreorder = substr($Permission, 29, 1);
                $Claim = substr($Permission, 30, 1);
                $report = substr($Permission, 31, 1);

                return view('Stminishow.EditPositionForm', ['position' => $position])
                    ->with('employee', $employee)->with('pmposition', $pmposition)
                    ->with('product', $product)->with('partner', $partner)
                    ->with('member', $member)->with('promotion', $promotion)->with('premiumpro', $premiumpro)
                    ->with('offerorder', $offerorder)->with('approveorder', $approveorder)
                    ->with('order', $order)->with('receive', $receive)
                    ->with('sell', $sell)->with('preorder', $preorder)->with('receivepreorder', $receivepreorder)->with('Claim', $Claim)
                    ->with('report', $report);
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
    public function update(Request $request, $Id_Position)
    {

        if (is_null($request->employee)) {
            $employee = 0;
        } else {
            $employee = 1;
        }
        if (is_null($request->position)) {
            $position = 0;
        } else {
            $position = 1;
        }
        if (is_null($request->product)) {
            $product = 0;
        } else {
            $product = 1;
        }
        if (is_null($request->partner)) {
            $partner = 0;
        } else {
            $partner = 1;
        }
        if (is_null($request->member)) {
            $member = 0;
        } else {
            $member = 1;
        }
        if (is_null($request->promotion)) {
            $promotion = 0;
        } else {
            $promotion = 1;
        }
        if (is_null($request->premiumpro)) {
            $premiumpro = 0;
        } else {
            $premiumpro = 1;
        }
        if (is_null($request->offerorder)) {
            $offerorder = 0;
        } else {
            $offerorder = 1;
        }
        if (is_null($request->approveorder)) {
            $approveorder = 0;
        } else {
            $approveorder = 1;
        }
        if (is_null($request->order)) {
            $order = 0;
        } else {
            $order = 1;
        }
        if (is_null($request->receive)) {
            $receive = 0;
        } else {
            $receive = 1;
        }
        if (is_null($request->sell)) {
            $sell = 0;
        } else {
            $sell = 1;
        }
        if (is_null($request->preorder)) {
            $preorder = 0;
        } else {
            $preorder = 1;
        }
        if (is_null($request->receivepreorder)) {
            $receivepreorder = 0;
        } else {
            $receivepreorder = 1;
        }
        if (is_null($request->Claim)) {
            $Claim = 0;
        } else {
            $Claim = 1;
        }
        if (is_null($request->report)) {
            $report = 0;
        } else {
            $report = 1;
        }

        $userpositions = $employee . $position . $product . $partner .
            $member . $promotion . $premiumpro . $offerorder . $approveorder .
            $order . $receive . $sell . $preorder . $receivepreorder . $Claim . $report;

        $request->validate([
            'Name_Position' => 'required'
        ]);



        $position = position::find($Id_Position);
        $position->Name_Position = $request->Name_Position;
        $position->Permission = $userpositions;
        $position->save();
        return redirect('/Stminishow/showPosition');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($Id_Position)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission2')) {
                $position = position::find($Id_Position);
                $position->Status = 1;
                $position->save();
                return redirect('/Stminishow/showPosition');
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }
}
