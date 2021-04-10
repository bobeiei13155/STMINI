<?php

namespace App\Http\Controllers\Stminishow;

use Illuminate\Support\Facades\DB;
use App\promotion;
use App\payment_amount;
use App\PremiumPro;
use App\premium_payments;
use App\CartPromotionPay;
use App\Http\Controllers\Controller;
use App\Product;
use App\promotion_payments;
use App\promotion_prod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\promotionpays;
use App\brand;
use Illuminate\Support\Facades\Route;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function searchPOP(Request $request)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission6')) {


                $searchPOP = $request->searchPOP;
                $producttest = DB::table('promotion_prods')->orderBy('promotion_prods.Id_Promotion', 'DESC')
                    ->join('products', 'promotion_prods.Id_Product', "LIKE", 'products.Id_Product')
                    ->join('promotions', 'promotion_prods.Id_Promotion', "LIKE", 'promotions.Id_Promotion')
                    ->select(
                        'promotion_prods.Id_Product',
                        'products.Id_Product',
                        'promotion_prods.Id_Promotion',
                        'promotions.Id_Promotion',
                        'products.Name_Product'
                    )

                    ->where('promotions.Status', '=', 0)->distinct('promotion_prods.Id_Product')->get();
                $Promotion = DB::table('promotion_prods')->orderBy('promotion_prods.Id_Promotion', 'DESC')
                    ->join('products', 'promotion_prods.Id_Product', "LIKE", 'products.Id_Product')
                    ->join('promotions', 'promotion_prods.Id_Promotion', "LIKE", 'promotions.Id_Promotion')
                    ->select(
                        'promotion_prods.Id_Product',
                        'products.Id_Product',
                        'promotion_prods.Id_Promotion',
                        'promotions.Id_Promotion',
                        'promotions.Name_Promotion',
                        'products.Name_Product',
                        'promotions.Sdate_Promotion',
                        'promotions.Edate_Promotion',
                        'products.Name_Product',
                        'promotions.Status'
                    )
                    ->where('promotions.Status', '=', 0)
                    ->where('promotion_prods.Id_Promotion', "LIKE", "%{$searchPOP}%")
                    ->orwhere('products.Name_Product', "LIKE", "%{$searchPOP}%")
                    ->orwhere('promotions.Name_Promotion', "LIKE", "%{$searchPOP}%")
                    ->orwhere('promotions.Sdate_Promotion', "LIKE", "%{$searchPOP}%")
                    ->orwhere('promotions.Edate_Promotion', "LIKE", "%{$searchPOP}%")
                    ->distinct('promotion_prods.Id_Product')->paginate(5);
                $product = Product::all();
                $PremiumPro = PremiumPro::all();


                $Promotion_Prod = promotion_prod::all();

                $count = promotion::where('Status', '=', 0)->count();
                return view("Stminishow.SearchPromotionProForm")->with('promotion_prods', $Promotion_Prod)->with('producttest', $producttest)->with('promotions', $Promotion)->with('products', $product)->with('PremiumPros', $PremiumPro)->with("count", $count);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }
    public function ShowPromotionPro()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission6')) {
                $product = Product::all();
                $producttest = DB::table('promotion_prods')->orderBy('promotion_prods.Id_Promotion', 'DESC')
                    ->join('products', 'promotion_prods.Id_Product', "LIKE", 'products.Id_Product')
                    ->join('promotions', 'promotion_prods.Id_Promotion', "LIKE", 'promotions.Id_Promotion')
                    ->select(
                        'promotion_prods.Id_Product',
                        'products.Id_Product',
                        'promotion_prods.Id_Promotion',
                        'promotions.Id_Promotion',
                        'products.Name_Product'
                    )

                    ->where('promotions.Status', '=', 0)->distinct('promotion_prods.Id_Product')->get();

                //  dd( $producttest);
                $PremiumPro = PremiumPro::all();
                $Promotion = DB::table('promotions')->orderBy('promotions.Id_Promotion', 'DESC')->where('Status', '=', 0)->paginate(5);
                $count = promotion::where('Status', '=', 0)->count();
                $Promotion_Prod = promotion_prod::all();
                return view("Stminishow.ShowPromotionProForm")->with('promotion_prods', $Promotion_Prod)->with('producttest', $producttest)->with('promotions', $Promotion)->with('products', $product)->with('PremiumPros', $PremiumPro)->with("count", $count);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }
    public function indexPro()
    {
        $product = Product::all();
        $PremiumPro = PremiumPro::all();

        $GenId = DB::table('promotions')->max('Id_Promotion');

        if (is_null($GenId)) {
            $Id_Promotion = "POP" . "-" . date('Y') . date('m') . "-" . "000";
        } else {

            $GenId_POP = substr($GenId, 11, 14) + 1;

            if ($GenId_POP < 10) {
                $Id_Promotion = "POP" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_POP;
            } elseif ($GenId_POP >= 10 && $GenId_POP < 100) {
                $Id_Promotion = "POP" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_POP;
            } elseif ($GenId_POP >= 100) {
                $Id_Promotion = "POP" . "-" . date('Y') . date('m') . "-" . $GenId_POP;
            }
        }

        Session::put('Id_Promotion', $Id_Promotion);

        return view("Stminishow.PromotionProForm")->with('products', $product)->with('PremiumPros', $PremiumPro);
    }


    public function createPromotionPro(Request $request)
    {
        //dd($request);
        $GenId = DB::table('promotions')->max('Id_Promotion');

        if (is_null($GenId)) {
            $Id_Promotion = "POP" . "-" . date('Y') . date('m') . "-" . "000";
        } else {

            $GenId_POP = substr($GenId, 11, 14) + 1;

            if ($GenId_POP < 10) {
                $Id_Promotion = "POP" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_POP;
            } elseif ($GenId_POP >= 10 && $GenId_POP < 100) {
                $Id_Promotion = "POP" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_POP;
            } elseif ($GenId_POP >= 100) {
                $Id_Promotion = "POP" . "-" . date('Y') . date('m') . "-" . $GenId_POP;
            }
        }

        $request->validate([

            'Name_Promotion' => 'required|unique:promotions',
            'Sdate_Promotion' => 'required',
            'Edate_Promotion' => 'required',
            'Id_Product' => 'required'

        ]);
        $promotions = new promotion;
        $promotions->Id_Promotion = $Id_Promotion;
        $promotions->Name_Promotion = $request->Name_Promotion;
        $promotions->Sdate_Promotion = $request->Sdate_Promotion;
        $promotions->Edate_Promotion = $request->Edate_Promotion;


        $promotions->save();



        foreach ($request['Id_Premium_Pro'] as $item => $value) {
            $request2 = array(
                'Id_Promotion' => $Id_Promotion,
                'Id_Product' => $request->Id_Product,
                'Id_Premium_Pro' => $request['Id_Premium_Pro'][$item],
                'Amount_Premium_Pro' => $request['Amount_Premium_Pro'][$item]

            );


            promotion_prod::create($request2);
        }



        return redirect('/Stminishow/ShowPromotionPro');
    }


    public function editPro($Id_Promotion)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission6')) {
                $product = Product::all();
                $PremiumPro = PremiumPro::all();
                $Promotion = promotion::find($Id_Promotion);


                $Promotion_Prod = promotion_prod::all();

                $join = DB::table('promotion_prods')
                    ->join('products', 'products.Id_Product', '=', 'promotion_prods.Id_Product')
                    ->select('products.Name_Product', 'promotion_prods.Id_Product', 'products.Id_Product')
                    ->where('Id_Promotion', $Id_Promotion)->get();
                $joinpro = $join[0]->Id_Product;

                $join1 = DB::table('promotion_prods')
                    ->join('premium_pros', 'premium_pros.Id_Premium_Pro', '=', 'promotion_prods.Id_Premium_Pro')
                    ->select('premium_pros.Name_Premium_Pro', 'promotion_prods.Id_Premium_Pro', 'premium_pros.Id_Premium_Pro', 'promotion_prods.Amount_Premium_Pro')
                    ->where('Id_Promotion', $Id_Promotion)->get();

                $joinpre = $join1[0]->Id_Premium_Pro;


                return view("Stminishow.EditPromotionProForm", ['promotions' => $Promotion])->with('joinpro', $joinpro)
                    ->with('join1', $join1)
                    ->with('promotion_prods', $Promotion_Prod)->with('products', $product)->with('PremiumPros', $PremiumPro);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    public function updatePro(Request $request, $Id_Promotion)
    {
        $request->validate([]);

        $promotions = promotion::find($Id_Promotion);
        $promotions->Name_Promotion = $request->Name_Promotion;
        $promotions->Sdate_Promotion = $request->Sdate_Promotion;
        $promotions->Edate_Promotion = $request->Edate_Promotion;
        $promotions->save();

        $data = DB::table('promotion_prods')
            ->select('Id_Promotion')
            ->where('Id_Promotion', '=', $Id_Promotion)->get();


        $data1 = json_decode(json_encode($data), true);
        promotion_prod::destroy([$data1]);

        foreach ($request['Id_Premium_Pro'] as $item => $value) {
            $request2 = array(
                'Id_Promotion' => $Id_Promotion,
                'Id_Product' => $request->Id_Product,
                'Id_Premium_Pro' => $request['Id_Premium_Pro'][$item],
                'Amount_Premium_Pro' => $request['Amount_Premium_Pro'][$item]



            );


            promotion_prod::create($request2);
        }

        return redirect('/Stminishow/ShowPromotionPro');
    }

    public function deletePro($Id_Promotion)
    {

        // dd($Id_Partner);
        $promotions = promotion::find($Id_Promotion);
        $promotions->Status = 1;
        $promotions->save();
        return redirect('/Stminishow/ShowPromotionPro');
    }

    public function searchPOM(Request $request)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission6')) {


                $searchPOM = $request->searchPOM;



                $promotionpays = DB::table('promotion_payments')->orderBy('promotion_payments.Id_Promotion', 'DESC')
                    ->join('promotionpays', 'promotion_payments.Id_Promotion', "LIKE", 'promotionpays.Id_Promotion')
                    ->select(
                        'promotion_payments.Id_Promotion',
                        'promotionpays.Id_Promotion',
                        'promotionpays.Payment_Amount',
                        'promotionpays.Name_Promotion',
                        'promotionpays.Sdate_Promotion',
                        'promotionpays.Edate_Promotion',
                        'promotionpays.Status'
                    )
                    ->where('promotionpays.Status', '=', 0)
                    ->where('promotion_payments.Id_Promotion', "LIKE", "%{$searchPOM}%")
                    ->orwhere('promotionpays.Payment_Amount', "LIKE", "%{$searchPOM}%")
                    ->orwhere('promotionpays.Name_Promotion', "LIKE", "%{$searchPOM}%")
                    ->orwhere('promotionpays.Sdate_Promotion', "LIKE", "%{$searchPOM}%")
                    ->orwhere('promotionpays.Edate_Promotion', "LIKE", "%{$searchPOM}%")
                    ->distinct('promotionpays.Name_Promotion')->paginate(5);

                $count = promotionpays::where('Status', '=', 0)->count();
                $promotion_payments = promotion_payments::all();

                return view("Stminishow.SearchPromotionPayForm")->with('promotion_payments', $promotion_payments)->with('count', $count)->with('promotionpays', $promotionpays)->with("premium_pros", PremiumPro::all());
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {
            return redirect('/login');
        }
    }









    public function ShowPromotionPay()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission6')) {
                //   $promotionpaycount = DB::table('promotionpays')->where('Status', '=', 0)->count();
                // ->with('promotionpaycount', $promotionpaycount)
                $count = promotionpays::where('Status', '=', 0)->count();
                $promotionpays = DB::table('promotionpays')->orderBy('promotionpays.Id_Promotion', 'DESC')->where('Status', '=', 0)->paginate(5);
                return view("Stminishow.ShowPromotionPayForm")->with("promotionpays", $promotionpays)->with('count', $count)->with("premium_pros", PremiumPro::all())->with("promotion_payments", promotion_payments::all());
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    public function indexPay()
    {
        $brands = brand::all();
        $PremiumPro = PremiumPro::all();

        $GenId = DB::table('promotionpays')->max('Id_Promotion');

        if (is_null($GenId)) {
            $Id_PromotionPay = "POM" . "-" . date('Y') . date('m') . "-" . "000";
        } else {

            $GenId_POM = substr($GenId, 11, 14) + 1;

            if ($GenId_POM < 10) {
                $Id_PromotionPay = "POM" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_POM;
            } elseif ($GenId_POM >= 10 && $GenId_POM < 100) {
                $Id_PromotionPay = "POM" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_POM;
            } elseif ($GenId_POM >= 100) {
                $Id_PromotionPay = "POM" . "-" . date('Y') . date('m') . "-" . $GenId_POM;
            }
        }

        Session::put('Id_PromotionPay', $Id_PromotionPay);

        return view("Stminishow.PromotionPayForm")->with('brands', $brands)->with('PremiumPros', $PremiumPro);
    }
    public function createPromotionPay(Request $request)
    {
        // dd($request);
        $GenId = DB::table('promotionpays')->max('Id_Promotion');

        if (is_null($GenId)) {
            $Id_Promotion = "POM" . "-" . date('Y') . date('m') . "-" . "000";
        } else {

            $GenId_POM = substr($GenId, 11, 14) + 1;

            if ($GenId_POM < 10) {
                $Id_Promotion = "POM" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_POM;
            } elseif ($GenId_POM >= 10 && $GenId_POM < 100) {
                $Id_Promotion = "POM" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_POM;
            } elseif ($GenId_POM >= 100) {
                $Id_Promotion = "POM" . "-" . date('Y') . date('m') . "-" . $GenId_POM;
            }
        }

        $request->validate([

            'Name_Promotion' => 'required|unique:promotionpays'
            //'Payment_Amount' => 'required',
            // 'Sdate_Promotion' => 'required',
            // 'Edate_Promotion' => 'required',

        ]);
        $promotionpays = new promotionpays;
        $promotionpays->Id_Promotion = $Id_Promotion;
        $promotionpays->Name_Promotion = $request->Name_Promotion;
        $promotionpays->Brand_Id = $request->Brand_Id;
        $promotionpays->Payment_Amount = $request->Payment_Amount;
        $promotionpays->Sdate_Promotion = $request->Sdate_Promotion;
        $promotionpays->Edate_Promotion = $request->Edate_Promotion;


        $promotionpays->save();

        foreach ($request['Id_Premium_Pro'] as $item => $value) {
            $request2 = array(
                'Id_Promotion' => $Id_Promotion,
                'Id_Premium_Pro' => $request['Id_Premium_Pro'][$item],
                'Amount_Premium_Pro' => $request['Amount_Premium_Pro'][$item]

            );
            // dd( $request2);

            promotion_payments::create($request2);
        }


        // $request2 = array(
        //     'Id_Promotion' => $Id_Promotion,
        //     'Payment_Amount' => $request->Payment_Amount,
        //     'Id_Premium_Pro' => $request['Id_Premium_Pro']
        // );
        // promotion_payments::create($request2);

        return redirect('/Stminishow/ShowPromotionPay');
    }

    public function editPay($Id_Promotion)

    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission6')) {

                $PremiumPro = PremiumPro::all();
                $promotionpay = promotionpays::find($Id_Promotion);
                $promotion_payment = promotion_payments::all();
                $brands = brand::all();
                

                $join1 = DB::table('promotion_payments')
                    ->join('premium_pros', 'premium_pros.Id_Premium_Pro', '=', 'promotion_payments.Id_Premium_Pro')
                    ->select('premium_pros.Name_Premium_Pro', 'promotion_payments.Id_Premium_Pro', 'premium_pros.Id_Premium_Pro', 'promotion_payments.Amount_Premium_Pro')
                    ->where('Id_Promotion', $Id_Promotion)->get();
                $joinpre = $join1[0]->Id_Premium_Pro;


                return view("Stminishow.EditPromotionPayForm", ['promotionpays' => $promotionpay])
                    ->with('join1', $join1)->with('brands', $brands)
                    ->with('promotion_payments', $promotion_payment)->with('PremiumPros', $PremiumPro);
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
    public function updatePay(Request $request, $Id_Promotion)
    {
        $request->validate([]);

        $promotionpays = promotionpays::find($Id_Promotion);
        $promotionpays->Id_Promotion = $Id_Promotion;
        $promotionpays->Name_Promotion = $request->Name_Promotion;
        $promotionpays->Sdate_Promotion = $request->Sdate_Promotion;
        $promotionpays->Edate_Promotion = $request->Edate_Promotion;
        $promotionpays->save();

        $data = DB::table('promotion_payments')
            ->select('Id_Promotion')
            ->where('Id_Promotion', '=', $Id_Promotion)->get();


        $data1 = json_decode(json_encode($data), true);
        promotion_payments::destroy([$data1]);
        $request2 = array(
            'Id_Promotion' => $Id_Promotion,
            'Payment_Amount' => $request->Payment_Amount,
            'Id_Premium_Pro' => $request['Id_Premium_Pro']
        );
        promotion_payments::create($request2);

        return redirect('/Stminishow/ShowPromotionPay');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function deletePay($Id_Promotion)
    {
        $promotionpays = promotionpays::find($Id_Promotion);
        $promotionpays->Status = 1;
        $promotionpays->save();
        return redirect('/Stminishow/ShowPromotionPay');
    }
}
