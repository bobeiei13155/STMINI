<?php

namespace App\Http\Controllers\Receipt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ShowLot()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission11')) {

                $lots = DB::table('lots')
                    ->Join('lot_lists', 'lots.Id_Lot', '=', 'lot_lists.Id_Lot')
                    ->join('receipt_lists', function ($join_order) {
                        $join_order->on('lot_lists.Id_Receipt', '=', 'receipt_lists.Id_Receipt')
                            ->on('lot_lists.No_Receipt', '=', 'receipt_lists.No_Receipt');
                    })
                    ->Join('receipts', 'receipts.Id_Receipt', '=', 'receipt_lists.Id_Receipt')
                    ->Join('products', 'products.Id_Product', '=', 'lot_lists.Id_Product')
                    ->select('lots.Id_Lot', 'lots.Receipt_Date', 'receipts.Id_Emp')
                    ->groupBy('lots.Id_Lot', 'lots.Receipt_Date', 'receipts.Id_Emp')
                    ->get();
                $employees = DB::table('employees')->get();
                return view("Receipt.ShowLotForm")->with('lots', $lots)->with('employees', $employees);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }



    public function Detail_Lot(Request $request)
    {
        $Id_Lot = $request->Id_Lot;

        $lots = DB::table('lots')
            ->Join('lot_lists', 'lots.Id_Lot', '=', 'lot_lists.Id_Lot')
            ->join('receipt_lists', function ($join_order) {
                $join_order->on('lot_lists.Id_Receipt', '=', 'receipt_lists.Id_Receipt')
                    ->on('lot_lists.No_Receipt', '=', 'receipt_lists.No_Receipt');
            })
            ->Join('receipts', 'receipts.Id_Receipt', '=', 'receipt_lists.Id_Receipt')
            ->Join('products', 'products.Id_Product', '=', 'lot_lists.Id_Product')
            ->select('products.Name_Product', 'lot_lists.Id_Product', 'lot_lists.Cost', 'lot_lists.Amount_Lot')->where('lot_lists.Id_Lot', '=', $Id_Lot)
            ->get();


        $output = '';
        $output .= '<h3>ID: ' . $Id_Lot . '</h3>';
        $output .= '<table class="table table-hover text-center">';
        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th>ชื่อสินค้า</th>';
        $output .= '<th>จำนวนสินค้าในล็อต</th>';
        $output .= '<th>ราคาทุน</th>';
        $output .= '</tr>';
        $output .= '</thead>';
        $output .= '<tbody>';
        foreach ($lots as $row) {
            $output .= '<tr>';
            $output .= '<td>' . $row->Name_Product .  '</td>';
            $output .= '<td>' . $row->Amount_Lot .  '</td>';
            $output .= '<td>' . $row->Cost .  '</td>';
            $output .= '</tr>';
        }
        $output .= '</tbody>';
        $output .= '</table>';
        echo $output;
    }


    public function ShowReceipt()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission11')) {

                $receipt_lists =  DB::table('receipts')
                    ->join('receipt_lists', 'receipts.Id_Receipt', '=', 'receipt_lists.Id_Receipt')
                    ->join('order_lists', function ($join_order) {
                        $join_order->on('order_lists.Id_Order', '=', 'receipt_lists.Id_Order')
                            ->on('order_lists.No_Order', '=', 'receipt_lists.No_Order');
                    })
                    ->join('orders', 'orders.Id_Order', '=', 'order_lists.Id_Order')
                    ->join('offer_costs', function ($join_offer) {
                        $join_offer->on('order_lists.Id_Offer', '=', 'offer_costs.Id_Offer')
                            ->on('order_lists.No_Offer', '=', 'offer_costs.No_Offer')
                            ->on('order_lists.Id_Partner', '=', 'offer_costs.Id_Partner')
                            ->on('order_lists.Id_Product', '=', 'offer_costs.Id_Product');
                    })->join('costs', function ($join_costs) {
                        $join_costs->on('costs.Id_Partner', '=', 'offer_costs.Id_Partner')
                            ->on('costs.Id_Product', '=', 'offer_costs.Id_Product');
                    })
                    ->join('products', 'products.Id_Product', '=', 'costs.Id_Product')
                    ->join('partners', 'partners.Id_Partner', '=', 'costs.Id_Partner')
                    ->select('order_lists.Id_Order',  'partners.Name_Partner', 'orders.Status_Order', 'receipts.Receipt_Date',  'receipts.Id_Emp')
                    ->groupBy('order_lists.Id_Order',  'partners.Name_Partner', 'orders.Status_Order', 'receipts.Receipt_Date',  'receipts.Id_Emp')
                    // ->where('order_lists.Id_Product', '=', 'products.Id_Product')
                    ->get();

                $employees = DB::table('employees')->select('Id_Emp', 'FName_Emp')->get();

                return view("Receipt.ShowReceiptForm")->with('receipt_lists', $receipt_lists)->with('employees', $employees);
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
    public function createReceipt()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission11')) {


                $orders =  DB::table('orders')
                    ->join('order_lists', 'orders.Id_Order', '=', 'order_lists.Id_Order')
                    ->select('orders.Id_Order')->where('Status_Order', '=', 0)
                    ->groupBy('orders.Id_Order')->get();


                // dd($orders);

                return view('Receipt.ReceiptForm')->with('orders', $orders);
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
    public function select_receipt(Request $request)
    {
        $Id_Order = $request->Id_Order;

        // $select_name =  DB::table('orders')
        //     ->join('order_lists', 'orders.Id_Order', '=', 'order_lists.Id_Order')
        //     ->select('order_lists.Id_Partner')
        //     ->groupBy('order_lists.Id_Partner')
        //     ->where('orders.Id_Order', '=', $Id_Order)->get();



        $order_lists =  DB::table('orders')
            ->join('order_lists', 'orders.Id_Order', '=', 'order_lists.Id_Order')
            ->join('offer_costs', function ($join_offer) {
                $join_offer->on('order_lists.Id_Offer', '=', 'offer_costs.Id_Offer')
                    ->on('order_lists.No_Offer', '=', 'offer_costs.No_Offer')
                    ->on('order_lists.Id_Partner', '=', 'offer_costs.Id_Partner')
                    ->on('order_lists.Id_Product', '=', 'offer_costs.Id_Product');
            })->join('costs', function ($join_costs) {
                $join_costs->on('costs.Id_Partner', '=', 'offer_costs.Id_Partner')
                    ->on('costs.Id_Product', '=', 'offer_costs.Id_Product');
            })
            ->join('products', 'products.Id_Product', '=', 'costs.Id_Product')
            ->join('partners', 'partners.Id_Partner', '=', 'costs.Id_Partner')
            ->select('order_lists.Id_Product', 'order_lists.Amount_Order', 'order_lists.Id_Order', 'order_lists.No_Order', 'order_lists.Amount_Remain', 'partners.Name_Partner', 'products.Name_Product', 'offer_costs.Cost')
            ->where('order_lists.Id_Order', '=', $Id_Order)->where('order_lists.Amount_Remain', '!=', 0)
            // ->where('order_lists.Id_Product', '=', 'products.Id_Product')
            ->get();




        foreach ($order_lists as $name) {
            $Name_Product =  $name->Name_Partner;
        }





        $output = '<table class="table table-hover text-center " >';

        // $output .= '    <input type="text" class="form-control text-center noHover"  value="' . session()->get('fname') .  '" name="[]" >';
        foreach ($order_lists as $row) {
            $output .= '<tr>';
            $output .= '<td scope="row" width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Product .  '"  disabled> 
              <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product_Receipt[]" ></td>';

            $output .= '<td scope="row" width="6%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Cost .  '"  disabled>
            <input type="hidden" class="form-control text-center noHover"  value="' . $row->Cost .  '" name="Cost_Receipt[]" ></td>';

            $output .= '<td scope="row" width="6%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Amount_Order .  '"  style="" disabled>
            <input type="hidden" class="form-control text-center noHover"  value="' . $row->Amount_Order .  '" name="Amount_Order_Receipt[]" ></td>';

            $output .= '<td scope="row" width="6%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Amount_Remain .  '" name="Amount_Remain[]" readonly>
            <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Order .  '"  >
            <input type="hidden" class="form-control text-center noHover"  value="' . $row->No_Order .  '" name="No_Order[]" ></td>';

            $output .= '<td scope="row" width="6%" ><input type="number" class="form-control text-center noHover" name="Amount_Remain_Receipt[]" value="Amount_Remain_Receipt[]" min="0" max="' . $row->Amount_Remain .  '" title= "กรุณาใส่ให้ตรง" required></td>';

            $output .= '<td scope="row" width="6%" > <button type="button" class="btn btn-danger remove " id=""  style="border-radius: 5px; width: 80px; "> <i class="fas fa-cart-arrow-down" style="margin-right: 5px;"></i>ลบ</button></td>';
        }

        $output .= '</tr>';
        echo $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function name_partner(Request $request)
    {
        $Id_Order = $request->Id_Order;

        $order_lists =  DB::table('orders')
            ->join('order_lists', 'orders.Id_Order', '=', 'order_lists.Id_Order')
            ->join('offer_costs', function ($join_offer) {
                $join_offer->on('order_lists.Id_Offer', '=', 'offer_costs.Id_Offer')
                    ->on('order_lists.No_Offer', '=', 'offer_costs.No_Offer')
                    ->on('order_lists.Id_Partner', '=', 'offer_costs.Id_Partner')
                    ->on('order_lists.Id_Product', '=', 'offer_costs.Id_Product');
            })->join('costs', function ($join_costs) {
                $join_costs->on('costs.Id_Partner', '=', 'offer_costs.Id_Partner')
                    ->on('costs.Id_Product', '=', 'offer_costs.Id_Product');
            })
            ->join('products', 'products.Id_Product', '=', 'costs.Id_Product')
            ->join('partners', 'partners.Id_Partner', '=', 'costs.Id_Partner')
            ->select('order_lists.Id_Product', 'order_lists.Amount_Order', 'order_lists.Id_Order', 'partners.Name_Partner', 'products.Name_Product')
            ->where('order_lists.Id_Order', '=', $Id_Order)
            // ->where('order_lists.Id_Product', '=', 'products.Id_Product')
            ->get();




        foreach ($order_lists as $name) {
            $Name_Product =  $name->Name_Partner;
        }


        echo $Name_Product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store_receipt(Request $request)
    {

  

        $GenId = DB::table('receipts')->max('Id_Receipt');
        $GenId_Receipt = substr($GenId, 11, 14) + 1;
        if (is_null($GenId)) {
            $Id_Receipt = "REP" . "-" . date('Y') . date('m') . "-" . "000";
        } else {

            if ($GenId_Receipt < 10) {
                $Id_Receipt = "REP" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_Receipt;
            } elseif ($GenId_Receipt >= 10 && $GenId_Receipt < 100) {
                $Id_Receipt = "REP" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_Receipt;
            } elseif ($GenId_Receipt >= 100) {
                $Id_Receipt = "REP" . "-" . date('Y') . date('m') . "-" . $GenId_Receipt;
            }
        }
        $Id_Receipt = json_decode(json_encode($Id_Receipt), true);


        $chk = 0;

        $No_Receipt = 0; 
        $Id = session()->get('fname');
        $id_Emp = DB::table('employees')->select('Id_Emp')->where('FName_Emp', "=", "{$Id}")->get();
        $Id_Emp = $id_Emp[0]->Id_Emp;

        $GenId = DB::table('lots')->max('Id_Lot');
        $GenId_Lot = substr($GenId, 11, 14) + 1;
        if (is_null($GenId)) {
            $Id_Lot = "LOT" . "-" . date('Y') . date('m') . "-" . "000";
        } else {

            if ($GenId_Lot < 10) {
                $Id_Lot = "LOT" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_Lot;
            } elseif ($GenId_Lot >= 10 && $GenId_Lot < 100) {
                $Id_Lot = "LOT" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_Lot;
            } elseif ($GenId_Lot >= 100) {
                $Id_Lot = "LOT" . "-" . date('Y') . date('m') . "-" . $GenId_Lot;
            }
        }
        $Id_Lot = json_decode(json_encode($Id_Lot), true);
        // DB::raw('sum(preorder_lists.Amount_Preorder) as Amount_Preorder'),

        // Session::put('Id_Lot', $Id_Lot);

        $sql_in_receipt  = array(
            'Id_Receipt' => $Id_Receipt,
            'Id_Emp' => $Id_Emp,
            'Receipt_Date' => $request->Receipt_date,
            'Status_Receipt' => 0
        );

        DB::table('receipts')->insert([$sql_in_receipt]); ////////////////////////////////////////////////

        $Amount_Remain_Receipt = $request['Amount_Remain_Receipt'];

        $sql_in_lot  = array(
            'Id_Lot' => $Id_Lot,
            'Receipt_Date' => $request->Receipt_date,

        );

        DB::table('lots')->insert([$sql_in_lot]); ///////////////////////////////////////
        // exit();
        $Id_Product_Receipt = $request['Id_Product_Receipt'];
        $Amount_Remain = $request['Amount_Remain'];
        $Cost_Receipt = $request['Cost_Receipt'];


        foreach ($Amount_Remain_Receipt  as $item => $value) {
            $No_Receipt++;
            $sql_in_receipt_list  = array(
                'Id_Receipt' => $Id_Receipt,
                'No_Receipt' => $No_Receipt,
                'Amount_Receipt' => $value,
                'Id_Order' =>  $request->Id_Order,
                'No_Order' => $request['No_Order'][$item]
            );

            DB::table('receipt_lists')->insert([$sql_in_receipt_list]); ///////////////////////////////////////

            $sql_in_lot_list  = array(
                'Id_Receipt' => $Id_Receipt,
                'No_Lot' => $No_Receipt,
                'Id_Lot' => $Id_Lot,
                'No_Receipt' => $No_Receipt,
                'Amount_Lot' => $value,
                'Id_Product' => $Id_Product_Receipt[$item],
                'Cost' => $Cost_Receipt[$item]
            );


            DB::table('lot_lists')->insert([$sql_in_lot_list]); ///////////////////////////////

            DB::table('order_lists')->where([
                'Id_Product' => $Id_Product_Receipt[$item],
                'Id_Order' =>  $request->Id_Order
            ])->update(['Amount_Remain' => $Amount_Remain[$item] - $value]); ///////////////////////////////////////
        }



        $Q = DB::table('orders')->join('order_lists', 'order_lists.Id_Order', '=', 'orders.Id_Order')
            ->select(DB::raw('sum(order_lists.Amount_Remain) as Amount_Remain'))
            ->where('order_lists.Id_Order', '=', $request->Id_Order)->get();

        // dd($Q);

        $Q_en = json_decode(json_encode($Q), true);
        $arr = array();

        foreach ($Q  as $item => $value) {
            if ($value->Amount_Remain == 0) {
                DB::table('orders')->where([
                    'Id_Order' =>  $request->Id_Order
                ])->update(['Status_Order' => 1]); //////////////////////////////
            }
            // echo 'yes';
        }
        return redirect('/Receipt/ShowReceipt');
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
