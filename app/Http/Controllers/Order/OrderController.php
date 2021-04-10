<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Showorder()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission10')) {

                $orders =  DB::table('orders')
                    ->join('order_lists', 'orders.Id_Order', '=', 'order_lists.Id_Order')
                    ->join('employees', 'employees.Id_Emp', '=', 'orders.Id_Emp')
                    ->select('orders.Id_Order', 'orders.Order_Date', 'orders.Status_Order', 'orders.Id_Emp', 'employees.FName_Emp', 'orders.Total_Price', 'order_lists.Id_Partner')
                    ->where('Status_Order', '=', 0)->groupBy('orders.Id_Order', 'orders.Id_Order', 'orders.Status_Order', 'orders.Order_Date', 'employees.FName_Emp', 'orders.Id_Emp', 'orders.Total_Price', 'order_lists.Id_Partner')->get();

                $partners = DB::table('partners')->select('Id_Partner', 'Name_Partner')->get();
                // dd($partners);
                // dd($name_parnter);


                // $Id_Partner_J = DB::table('offer_costs')
                //     ->select('offer_costs.Id_Partner', 'partners.Name_Partner')
                //     ->join('offer_lists', function ($join_offer) {
                //         $join_offer->on('offer_lists.Id_Offer', '=', 'offer_costs.Id_Offer')
                //             ->on('offer_lists.No_Offer', '=', 'offer_costs.No_Offer');
                //     })->join('costs', function ($join_costs) {
                //         $join_costs->on('costs.Id_Partner', '=', 'offer_costs.Id_Partner')
                //             ->on('costs.Id_Product', '=', 'offer_costs.Id_Product');
                //     })
                //     ->join('partners', 'partners.Id_Partner', '=', 'costs.Id_Partner')
                //     ->join('products', 'products.Id_Product', '=', 'costs.Id_Product')
                //     ->where('Status_Approve', '=', 1)
                //     ->groupBy('offer_costs.Id_Partner', 'partners.Name_Partner')->get();

                return view("Order.ShowOrderForm")->with('orders', $orders)->with('partners', $partners);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }
    public function createOrder()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission10')) {
                $GenId = DB::table('orders')->max('Id_Order');
                $GenId_Order = substr($GenId, 11, 14) + 1;
                if (is_null($GenId)) {
                    $Id_Order = "ORD" . "-" . date('Y') . date('m') . "-" . "000";
                } else {

                    if ($GenId_Order < 10) {
                        $Id_Order = "ORD" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_Order;
                    } elseif ($GenId_Order >= 10 && $GenId_Order < 100) {
                        $Id_Order = "ORD" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_Order;
                    } elseif ($GenId_Order >= 100) {
                        $Id_Order = "ORD" . "-" . date('Y') . date('m') . "-" . $GenId_Order;
                    }
                }
                $Id_Order = json_decode(json_encode($Id_Order), true);
                // DB::raw('sum(preorder_lists.Amount_Preorder) as Amount_Preorder'),

                Session::put('Id_Order', $Id_Order);


                // $users = DB::table('users')
                //     ->whereNotIn('id', [1, 2, 3])
                //     ->get();
                $arr = array();
                $orders =  DB::table('orders')
                    ->join('order_lists', 'orders.Id_Order', '=', 'order_lists.Id_Order')->select('Id_Offer', 'Id_Partner')->groupBy('Id_Offer', 'Id_Partner')->get();
                foreach ($orders as $item => $value) {
                    array_push($arr, $value->Id_Offer);
                }
                $arr1 = array();
                foreach ($orders as $item => $value) {
                    array_push($arr1, $value->Id_Partner);
                }
             
                // dd($orders);
                $Id_Partner_J = DB::table('offer_costs')

                    ->join('offer_lists', function ($join_offer) {
                        $join_offer->on('offer_lists.Id_Offer', '=', 'offer_costs.Id_Offer')
                            ->on('offer_lists.No_Offer', '=', 'offer_costs.No_Offer');
                    })->join('costs', function ($join_costs) {
                        $join_costs->on('costs.Id_Partner', '=', 'offer_costs.Id_Partner')
                            ->on('costs.Id_Product', '=', 'offer_costs.Id_Product');
                    })
                    ->join('partners', 'partners.Id_Partner', '=', 'costs.Id_Partner')
                    ->join('products', 'products.Id_Product', '=', 'costs.Id_Product')
                    ->where('Status_Approve', '=', 1)
                    // ->whereNotIn('offer_lists.No_Offer', DB::table('order_lists')->pluck('order_lists.No_Offer'))
                    // ->whereNotIn('offer_lists.Id_Offer', DB::table('order_lists')->pluck('order_lists.Id_Offer'))
                    // ->whereNotIn(DB::raw('(`offer_lists.Id_Partner`, `offer_lists.Id_Offer`)'), function($query){
                    //     $query->select('order_lists.Id_Partner', 'order_lists.Id_Offer')
                    //     ->from('order_lists');
                    // })
                    // ->whereNotIn('offer_costs.Id_Partner', DB::table('order_lists')->pluck('order_lists.Id_Partner','order_lists.Id_Offer'))
                    ->select('offer_costs.Id_Partner', 'partners.Name_Partner')
                    ->groupBy('offer_costs.Id_Partner', 'partners.Name_Partner')->get();



                // dd($Id_Partner_J);

                return view('Order.OrderForm')->with('Id_Partner_J', $Id_Partner_J);
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
    public function select_order(Request $request)
    {
        // $Id_Partner = $request->get('Id_Partner');
        $Id_Partner = $request->Id_Partner;

        $Q = DB::table('offer_costs')
            ->select('offer_costs.Id_Product', 'products.Name_Product', 'offer_costs.Cost', 'offer_lists.Amount_Approve', 'offer_costs.Id_Offer', 'offer_costs.No_Offer')
            ->join('offer_lists', function ($join_offer) {
                $join_offer->on('offer_lists.Id_Offer', '=', 'offer_costs.Id_Offer')
                    ->on('offer_lists.No_Offer', '=', 'offer_costs.No_Offer');
            })->join('costs', function ($join_costs) {
                $join_costs->on('costs.Id_Partner', '=', 'offer_costs.Id_Partner')
                    ->on('costs.Id_Product', '=', 'offer_costs.Id_Product');
            })
            ->join('partners', 'partners.Id_Partner', '=', 'costs.Id_Partner')
            ->join('products', 'products.Id_Product', '=', 'costs.Id_Product')
            ->where('Status_Approve', '=', 1)->where('offer_costs.Id_Partner', '=', $Id_Partner)
            ->groupBy('offer_costs.Id_Product', 'products.Name_Product', 'offer_costs.Cost', 'offer_lists.Amount_Approve', 'offer_costs.Id_Offer', 'offer_costs.No_Offer')->get();
        // dd($Q);

        $output = '<table class="table table-hover text-center " >';


        foreach ($Q as $row) {
            $output .= '<tr>';
            $output .= '<td scope="row" width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Product .  '"  disabled>  
            <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product_Order[]" ></td>';
            $output .= '<td width="6%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Cost .  '" disabled>
            <input type="hidden" class="form-control text-center noHover"  value="' . $row->Cost .  '" name="Cost_Order[]" ></td>';
            $output .= '<td width="6%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Amount_Approve .  '" read>
            <input type="hidden" class="form-control text-center noHover"  value="' . $row->Amount_Approve .  '" name="Amount_Approve[]" ></td>';
            $Amount_Approve =  $row->Amount_Approve;
            $Cost = $row->Cost;
            $total_lists =  $Amount_Approve * $Cost;
            $output .= '<td width="6%" ><input type="text" class="form-control text-center noHover"  value="' . $total_lists . '" disabled>
                <input type="hidden" class="form-control text-center noHover total_lists"  value="' . $total_lists . '" name="Total_lists[]" ></td>';
            $output .= '</tr>';
        }

        $arr_1 = array();

        foreach ($Q as $item => $value) {
            array_push($arr_1, (($value->Amount_Approve  * $value->Cost) - ($value->Amount_Approve  * $value->Cost) * 0.07));
        }
        $total_product = array_sum($arr_1);

        $arr_2 = array();

        foreach ($Q as $item => $value) {
            array_push($arr_2, ($value->Amount_Approve  * $value->Cost) * 0.07);
        }
        $total_vat = array_sum($arr_2);

        $arr_3 = array();

        foreach ($Q as $item => $value) {
            array_push($arr_3, $value->Amount_Approve  * $value->Cost);
        }
        $total_all = array_sum($arr_3);


        $output .= '<tr >';
        $output .= ' <td scope="row" width="9%" ></td>';
        $output .= ' <td scope="row" width="6%" ></td>';
        $output .= '  <td width="6%" >       <h2>ราคาสุทธิสินค้าที่เสียภาษี :</h2>      </td>';
        $output .= '  <td width="6%" >   <div class="input-group"><input type="text" class="form-control text-center total_product_s" value="' . $total_product . '" name="total_product[]" readonly>  <div class="input-group-append"><span class="input-group-text">บาท</span></div></div> </td>';
        $output .= '</tr>';
        $output .= '<tr>';
        $output .= ' <td scope="row" width="9%" class="noBorder" ></td>';
        $output .= ' <td scope="row" width="6%" class="noBorder"></td>';
        $output .= '  <td width="6%" class="noBorder">       <h2>ภาษีมูลค่าเพิ่ม 7 % :</h2>      </td>';
        $output .= '  <td width="6%" class="noBorder">   <div class="input-group"><input type="text" class="form-control text-center " value="' . $total_vat . '" name="total_vat[]"  readonly>  <div class="input-group-append"><span class="input-group-text">บาท</span></div></div> </td>';
        $output .= '</tr>';
        $output .= '<tr>';


        $output .= ' <td scope="row" width="9%" class="noBorder"></td>';
        $output .= ' <td scope="row" width="6%" class="noBorder"></td>';
        $output .= '  <td width="6%" class="noBorder">       <h2>ยอดรวมสุทธิ :</h2>      </td>';
        $output .= '  <td width="6%" class="noBorder">   <div class="input-group"><input type="text" class="form-control text-center " value="' . $total_all . '" name="total_all[]"  readonly>  <div class="input-group-append"><span class="input-group-text">บาท</span></div></div> </td>';
        $output .= '</tr>';
        echo $output;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrder(Request $request)
    {
        // dd($request);
        $Id_Order  = session()->get('Id_Order');

        $Id = session()->get('fname');
        $id_Emp = DB::table('employees')->select('Id_Emp')->where('FName_Emp', "=", "{$Id}")->get();
        $Id_Emp = $id_Emp[0]->Id_Emp;
        $No_Order = 0;
        $sql_in_order  = array(
            'Id_Order' => $Id_Order,
            'Id_Emp' => $Id_Emp,
            'Order_Date' => $request->Order_date,
            'Total_Price' => $request->total_all[0],


        );
        // // print_r($sql_in_order);
        DB::table('orders')->insert([$sql_in_order]);

        $Q = DB::table('offer_costs')
            ->select('offer_costs.Id_Product', 'products.Name_Product', 'offer_costs.Cost', 'offer_lists.Amount_Approve', 'offer_costs.Id_Partner', 'offer_costs.Id_Offer', 'offer_costs.No_Offer')
            ->join('offer_lists', function ($join_offer) {
                $join_offer->on('offer_lists.Id_Offer', '=', 'offer_costs.Id_Offer')
                    ->on('offer_lists.No_Offer', '=', 'offer_costs.No_Offer');
            })->join('costs', function ($join_costs) {
                $join_costs->on('costs.Id_Partner', '=', 'offer_costs.Id_Partner')
                    ->on('costs.Id_Product', '=', 'offer_costs.Id_Product');
            })
            ->join('partners', 'partners.Id_Partner', '=', 'costs.Id_Partner')
            ->join('products', 'products.Id_Product', '=', 'costs.Id_Product')
            ->where('Status_Approve', '=', 1)->where('offer_costs.Id_Partner', '=', $request->Id_Partner)
            ->groupBy('offer_costs.Id_Product', 'products.Name_Product', 'offer_costs.Cost', 'offer_lists.Amount_Approve', 'offer_costs.Id_Partner', 'offer_costs.Id_Offer', 'offer_costs.No_Offer')->get();

        foreach ($Q as $item => $value) {
            $No_Order++;
            $sql_in_order_list = array(
                'Id_Order' => $Id_Order,
                'No_Order' => $No_Order,
                'Id_Product' => $value->Id_Product,
                'Id_Partner' => $value->Id_Partner,
                'Id_Offer' => $value->Id_Offer,
                'No_Offer' => $value->No_Offer,
                'Amount_Order' => $value->Amount_Approve,
                'Amount_Remain' => $value->Amount_Approve,
            );
            DB::table('order_lists')->insert([$sql_in_order_list]);
        }

        foreach ($Q as $item1 => $value1) {

            // $w = array(
            //     'Id_Product' => $value1->Id_Product,
            //     'Id_Partner' => $value1->Id_Partner,
            //     'Id_Offer' => $value1->Id_Offer,
            //     'No_Offer' => $value1->No_Offer,
            //     'Status_Approve' => 1
            // );

            // DB::table('offer_lists')->where([
            //     'Id_Product' => $value1->Id_Product,
            //     'Id_Partner' => $value1->Id_Partner,
            //     'Id_Offer' => $value1->Id_Offer,
            //     'No_Offer' => $value1->No_Offer,
            //     'Status_Approve' => 1
            // ])->update(['Status_Approve' => 2]);
            // echo $value->Id_Product;
            // DB::statement("UPDATE `stminidb`.`offer_costs` SET `Status_Approve` = '2' WHERE `No_Offer` = 4 AND `Id_Partner` = 'PTN-202009-004' AND `Id_Product` = 'PRO-202101-003' AND `Id_Offer` = 'OFF-202103-000'");
            DB::statement("UPDATE stminidb.`offer_costs` SET Status_Approve = '2' WHERE No_Offer = '" . $value1->No_Offer . "' AND Id_Partner = '" . $value1->Id_Partner . "' AND Id_Product = '" . $value1->Id_Product . "' AND Id_Offer = '" . $value1->Id_Offer . "'");

            // echo 'yes';
        }

        return redirect('/Order/ShowOrder');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
