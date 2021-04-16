<?php

namespace App\Http\Controllers\Stminishow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ShowPayment()
    {
        if (session()->has('login')) {
            if (session()->has('loginpermission5')) {



                // $GenId = DB::table('members')->max('Id_Member');
                // if (is_null($GenId)) {
                //     $Id_Member = "MEM" . "-" . date('Y') . date('m') . "-" . "000";
                // } else {


                //     $GenId_Mem = substr($GenId, 11, 14) + 1;
                //     if ($GenId_Mem < 10) {
                //         $Id_Member = "MEM" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_Mem;
                //     } elseif ($GenId_Mem >= 10 && $GenId_Mem < 100) {
                //         $Id_Member = "MEM" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_Mem;
                //     } elseif ($GenId_Mem >= 100) {
                //         $Id_Member = "MEM" . "-" . date('Y') . date('m') . "-" . $GenId_Mem;
                //     }
                // }

                // $Id_Member = json_decode(json_encode($Id_Member), true);


                // Session::put('Id_Member', $Id_Member);
                $show_payments = DB::table('payments')->where('Status', '=', '0')->get();


                return view('Stminishow.PaymentForm')->with('show_payments', $show_payments);
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

        $GenId = DB::table('payments')->max('Id_Payment');

        if (is_null($GenId)) {
            $Id_Payment = "PYM" . "-" . date('Y') . date('m') . "-" . "000";
        } else {
            $GenId_Payment = substr($GenId, 11, 14) + 1;

            if ($GenId_Payment < 10) {
                $Id_Payment = "PYM" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_Payment;
            } elseif ($GenId_Payment >= 10 && $GenId_Payment < 100) {
                $Id_Payment = "PYM" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_Payment;
            } elseif ($GenId_Payment >= 100) {
                $Id_Payment = "PYM" . "-" . date('Y') . date('m') . "-" . $GenId_Payment;
            }
        }
        // dd($request);
        $sql_in_payment  = array(
            'Id_Payment' => $Id_Payment,
            'Name_Payment' => $request->Name_Payment,
        );
        // dd($sql_in_payment);
        DB::table('payments')->insert([$sql_in_payment]);
        // dd($Id_Color);
        // $request->validate([
        //     'Name_Color' => 'required|unique:colors'
        // ]);
        // // $color = new color;
        // // $color->Id_Color = $Id_Color;
        // // $color->Name_Color = $request->Name_Color;
        // // $color->save();
        return redirect('/Stminishow/createPayment');
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
    public function edit($Id_Payment)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission5')) {
                // $payment = Pattern::find($Id_Payment);
                $payments = DB::table('payments')->where('Id_Payment', '=', $Id_Payment)->first();
                // dd($payment);
                return view('Stminishow.EditPaymentForm', ['payments' => $payments]);
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
    public function update(Request $request, $Id_Payment)
    {
        DB::table('payments')->where('Id_Payment', '=', $Id_Payment)->update([
            "Name_Payment" => $request->Name_Payment,
        ]);
        return redirect('/Stminishow/createPayment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($Id_Payment)
    {
        DB::table('payments')->where('Id_Payment', '=', $Id_Payment)->update([
            "Status" => '1',
        ]);
        return redirect('/Stminishow/createPayment');
    }
}
