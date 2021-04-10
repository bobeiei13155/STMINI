<?php

namespace App\Http\Controllers\Stminishow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Null_;
use SebastianBergmann\Environment\Console;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Select_Preorder(Request $request)
    {
        $Id_Product_Preorder = $request->Id_Product_Preorder;
        $Fill_Amount = $request->Fill_Amount;
        echo ($Id_Product_Preorder);
        echo ('<br>');
        echo ($Fill_Amount);
    }

    public function Detail_Offer(Request $request)
    {
        $Id_Offer = $request->Id_Offer;

        $offer_costs = DB::table('offer_costs')
            ->join('offer_lists', function ($join_offer) {
                $join_offer->on('offer_lists.Id_Offer', '=', 'offer_costs.Id_Offer')
                    ->on('offer_lists.No_Offer', '=', 'offer_costs.No_Offer');
            })
            ->join('offers', 'offer_lists.Id_Offer', '=', 'offers.Id_Offer')

            ->join('costs', function ($join_costs) {
                $join_costs->on('costs.Id_Partner', '=', 'offer_costs.Id_Partner')
                    ->on('costs.Id_Product', '=', 'offer_costs.Id_Product');
            })
            ->join('partners', 'partners.Id_Partner', '=', 'costs.Id_Partner')
            ->join('products', 'products.Id_Product', '=', 'costs.Id_Product')
            ->select('offer_costs.Id_Product', 'products.Name_Product', 'offer_lists.Amount_Post', 'offer_costs.No_Offer')
            ->where('offers.Id_Offer', $Id_Offer)->groupBy('offer_costs.Id_Product', 'products.Name_Product', 'offer_lists.Amount_Post', 'offer_costs.No_Offer')->get();

        $output = '';
        $output .= '<h3>ID: ' . $Id_Offer . '</h3>';
        $output .= '<table class="table table-hover text-center">';
        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th>ชื่อสินค้า</th>';
        $output .= '<th>จำนวนที่เสนอ</th>';
        $output .= '</tr>';
        $output .= '</thead>';
        $output .= '<tbody>';
        foreach ($offer_costs as $row) {
            $output .= '<tr>';
            $output .= '<td>' . $row->Name_Product .  '</td>';
            $output .= '<td>' . $row->Amount_Post .  '</td>';
            $output .= '</tr>';
        }
        $output .= '</tbody>';
        $output .= '</table>';
        echo $output;
    }

    public function ShowOffer()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission8')) {

                $offers = DB::table('offers')->get();

                $employees = DB::table('employees')->select('Id_Emp', 'Fname_Emp')->get();
                return view('Stminishow.ShowOfferForm')->with('offers', $offers)->with('employees', $employees);
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
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission8')) {
                $test = DB::table('employees')->select('fname_emp')->get();

                $products = DB::table('products')->get();
                $brands = DB::table('brands')->get();
                $patterns = DB::table('patterns')->get();
                $colors = DB::table('colors')->get();
                $categories = DB::table('categories')->get();
                $gens = DB::table('gens')->get();

                $GenId = DB::table('Offers')->max('Id_Offer');
                $GenId_Offer = substr($GenId, 11, 14) + 1;
                if (is_null($GenId)) {
                    $Id_Offer = "OFF" . "-" . date('Y') . date('m') . "-" . "000";
                } else {

                    if ($GenId_Offer < 10) {
                        $Id_Offer = "OFF" . "-" . date('Y') . date('m') . "-" . "00" . $GenId_Offer;
                    } elseif ($GenId_Offer >= 10 && $GenId_Offer < 100) {
                        $Id_Offer = "OFF" . "-" . date('Y') . date('m') . "-" . "0" . $GenId_Offer;
                    } elseif ($GenId_Offer >= 100) {
                        $Id_Offer = "OFF" . "-" . date('Y') . date('m') . "-" . $GenId_Offer;
                    }
                }
                $Id_Offer = json_decode(json_encode($Id_Offer), true);
                // DB::raw('sum(preorder_lists.Amount_Preorder) as Amount_Preorder'),

                Session::put('Id_Offer', $Id_Offer);

                $Preorders = DB::table('preorder_lists')
                    ->join('preorders', 'preorders.Id_Preorder', "=", 'preorder_lists.Id_Preorder')
                    ->join('products', 'products.Id_Product', "=", 'preorder_lists.Id_Product')
                    ->select(
                        'preorder_lists.Id_Product',
                        'products.Name_Product',
                        DB::raw('sum(preorder_lists.Amount_Preorder) as Amount_Preorder'),
                    )->where('preorders.Status_Preorder', '=', '0')
                    ->groupBy('preorder_lists.Id_Product', 'products.Name_Product')
                    ->get();

                // dd($Preorders);
                $arr = array();

                foreach ($Preorders as $item => $value) {
                    array_push($arr, $value->Id_Product);
                }

                $query = DB::table('costs')
                    ->join('products', 'costs.Id_Product', "=", 'products.Id_Product')
                    ->join('partners', 'costs.Id_Partner', "=", 'partners.Id_Partner')
                    ->select(
                        'costs.Id_Product',
                        'products.Id_Product',
                        'costs.Id_Product',
                        'partners.Id_Partner',
                        'costs.cost',
                        'products.Name_Product',
                        'partners.Name_Partner'
                    )->WhereIN('costs.Id_Product', $arr)->orderBy('costs.Id_Product')
                    ->get();

                // dd($query);


                return view('Stminishow.OfferForm')->with('Preorder', $query)->with('products', $products)->with('gens', $gens)->with('Preorders', $Preorders)
                    ->with('brands', $brands)
                    ->with('patterns', $patterns)
                    ->with('colors', $colors)
                    ->with('categories', $categories);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }

    public function select_Product(Request $request)
    {
        $id = $request->get('select');

        $query = DB::table('products')
            ->join('categories', 'products.Category_Id', "LIKE", 'categories.Id_Category')
            ->join('brands', 'products.Brand_Id', "LIKE", 'brands.Id_Brand')
            ->join('gens', 'products.Gen_Id', "LIKE", 'gens.Id_Gen')
            ->select(
                'products.Category_Id',
                'categories.Id_Category',
                'products.Brand_Id',
                'brands.Id_Brand',
                'products.Gen_Id',
                'gens.Id_Gen',
                'products.Id_Product',
                'products.Img_Product',
                'products.Name_Product',
                'categories.Name_Category',
                'brands.Name_Brand',
                'gens.Name_Gen',
                'products.Price',
                'products.Status'
            )
            ->where('products.Status', '=', 0)
            ->where('Id_Product', "LIKE", "%{$id}%")
            ->orwhere('Name_Product', "LIKE", "%{$id}%")
            ->orwhere('Name_Category', "LIKE", "%{$id}%")
            ->orwhere('Name_Brand', "LIKE", "%{$id}%")
            ->orwhere('Name_Gen', "LIKE", "%{$id}%")->get();


        $output = '';
        foreach ($query as $row) {
            $output .= '<tr id="' . $row->Id_Product . '">';
            $output .= '<td>' . $row->Id_Product .  '</td>';
            $output .= '<td>' . $row->Name_Product .  '</td>';
            $output .= '<td>' . $row->Name_Category .  '</td>';
            $output .= '<td>  <button  type="button"   class="btn btn-primary buttonID" style="border-radius: 5px; width: 120px; "> <i class="fas fa-cart-arrow-down" style="margin-right: 5px;"></i> เลือกสินค้า</button></td>';
            $output .= '</tr>';
        }
        echo $output;
    }

    public function select_Partner(Request $request)
    {
        $button_test = $request->button_test;

        $query = DB::table('costs')
            ->join('products', 'costs.Id_Product', "=", 'products.Id_Product')
            ->join('partners', 'costs.Id_Partner', "=", 'partners.Id_Partner')
            ->select(
                'costs.Id_Product',
                'products.Id_Product',
                'costs.Id_Product',
                'partners.Id_Partner',
                'costs.cost',
                'products.Name_Product',
                'partners.Name_Partner'
            )->where('costs.Id_Product', "=", $button_test)->get();

        // dd($query);
        if ($query->isEmpty()) {
            echo "<script>";
            echo "swal('สินค้ายังไม่ถูกเพิ่มบริษัท');";
            // echo $output = "1";
            echo "</script>";
            exit();
        } else {
            $output = "";

            foreach ($query as $row) {
                $output .= '<tr>';
                $output .= '<td width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Partner .  '" disabled>';
                $output .= '    <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Partner .  ' ></td>';
                $output .= ' <td width="6%">   </td>';
                // $output .= ' <td>  <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product[]" ></td>';
                $output .= '<td width="6%"><input type="text" class="form-control text-center" value="' . $row->cost .  '" " name="cost[]"></td>';
                $output .= '<td width="6%" style="text-align: center; vertical-align: middle;  ">';
                $output .= '<div class="form-check"><input class=" form-check-input largerCheckbox chk2" " name="Id_Partner[]" type="checkbox" value="' . $row->Id_Partner .  '"  ></div></td>';

                $output .= '</tr>';
            }
            $output .= '  <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product[]" >';
            echo  $output;
        }
    }

    public function select_Partner_Preorder(Request $request)
    {
        $Id_Product_Preorder = $request->Id_Product_Preorder;
        $Amount_Preorder = $request->Amount_Preorder;

        $query = DB::table('costs')
            ->join('products', 'costs.Id_Product', "=", 'products.Id_Product')
            ->join('partners', 'costs.Id_Partner', "=", 'partners.Id_Partner')
            ->select(
                'costs.Id_Product',
                'products.Id_Product',
                'costs.Id_Product',
                'partners.Id_Partner',
                'costs.cost',
                'products.Name_Product',
                'partners.Name_Partner'
            )->where('costs.Id_Product', "=", $Id_Product_Preorder)->get();

        // dd($query);
        if ($query->isEmpty()) {
            echo "<script>";
            echo "swal('สินค้ายังไม่ถูกเพิ่มบริษัท');";
            // echo $output = "1";
            echo "</script>";
            exit();
        } else {
            $output = "";

            foreach ($query as $row) {
                $output .= '<tr>';
                $output .= '<td width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Partner .  '" disabled>';
                $output .= '    <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Partner .  ' ></td>';
                $output .= ' <td width="6%">   </td>';
                // $output .= ' <td>  <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product[]" ></td>';
                $output .= '<td width="6%"><input type="text" class="form-control text-center" value="' . $row->cost .  '" " name="cost[]"></td>';
                $output .= '<td width="6%" style="text-align: center; vertical-align: middle;  ">';
                $output .= '<div class="form-check"><input class=" form-check-input largerCheckbox chk3" " name="Id_Partner_Preorder[]" type="checkbox" value="' . $row->Id_Partner .  '"  ></div></td>';

                $output .= '</tr>';
            }
            $output .= '  <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product_Preorder[]" >';
            $output .= '  <input type="hidden" class="form-control text-center noHover"  value="' . $Amount_Preorder .  '" name="Amount_Preorder[]" >';
            echo  $output;
        }
    }

    public function select_Cost(Request $request)
    {
        $Id_Product = $request->Id_Product;
        $Id_Partner = $request->Id_Partner;
        $Amount_Preorder = $request->Amount_Preorder;

        // dd($Id_Partner);
        $arr = array();
        $query = DB::table('costs')
            ->join('products', 'costs.Id_Product', "=", 'products.Id_Product')
            ->join('partners', 'costs.Id_Partner', "=", 'partners.Id_Partner')
            ->select(
                'costs.Id_Product',
                'products.Id_Product',
                'costs.Id_Product',
                'costs.Id_Partner',
                'costs.cost',
                'products.Name_Product',
                'partners.Name_Partner'
            )->WhereIN('costs.Id_Partner', $Id_Partner)->where('costs.Id_Product', $Id_Product)
            ->get();
        // print_r($query);


        $output = '<table class="table table-hover text-center" >';


        foreach ($query as $row) {
            $output .= '<tr>';
            $output .= '<td scope="row" width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Product .  '"  disabled>  
      
            <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Product_Offer[]" ></td>';
            $output .= '<td width="9%" ><input type="text" class="form-control text-center noHover"  value="' . $row->Name_Partner .  '" disabled>
            <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Partner .  '" name="Id_Partner_Offer[]" ></td>';
            $output .= '<td width="6%"><input type="text" class="form-control text-center" value="' . $row->cost .  '" " name="cost_Offer[]"></td>';

            $output .= '</tr>';
        }
        if (is_null($Amount_Preorder)) {
            $output .= '<tr>';
            $output .= '<td  width="9%" ></td>';
            $output .= '<td  width="9%" style=" text-align:right;"><div class = "row ">';
            $output .= '   <label class="col-auto col-form-label">';
            $output .= '       <h5>จำนวนสินค้าที่เสนอ :</h5>';
            $output .= '    </label>';
            $output .= ' <div class = "col "><input type="text" class="form-control  text-center" name="amount_post[]"  value = "1"required></div></div></td>';
            $output .= '<td  width="6%"> <a href="#"';
            $output .= 'class="btn btn-danger remove" style="border-radius: 5px; width: 60px; "> <i class="fas fa-minus-circle"></i></a> </td>';
            $output .= '</tr>';
            $output .= '</table>';

            echo  $output;
        } else {

            $output .= '<tr>';
            $output .= '<td  width="9%" ></td>';
            $output .= '<td  width="9%" style=" text-align:right;"><div class = "row ">';
            $output .= '   <label class="col-auto col-form-label">';
            $output .= '       <h5>จำนวนสินค้าที่เสนอ :</h5>';
            $output .= '    </label>';
            $output .= ' <div class = "col "><input type="text" class="form-control  text-center" name="amount_post[]"  value = "' . $Amount_Preorder . '"required>

            <input type="hidden" class="form-control text-center noHover"  value="' . $row->Id_Product .  '" name="Id_Pro_Pre[]" ></div></div>
            <input type="hidden" class="form-control text-center noHover"  value="' . $Amount_Preorder . '" name="Amount_Preorder_Up[]" ></div></div>';
            $output .= ' </td>';
            $output .= '<td  width="6%"> <a href="#"';
            $output .= 'class="btn btn-danger remove" style="border-radius: 5px; width: 60px; "> <i class="fas fa-minus-circle"></i></a> </td>';
            $output .= '</tr>';
            $output .= '</table>';
            echo  $output;
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

        $id = session()->get('fname');
        $id_Emp = DB::table('employees')->select('Id_Emp', 'FName_Emp')->where('FName_Emp', "=", "{$id}")->get();
        $no_product = 0;
        $no_off_pre = 0;
        $no_offer = 1;
        $Id_Offer = session()->get('Id_Offer');
        $Id_Emp = $id_Emp[0]->Id_Emp;
        $s = array();
        $save_pre = array();
        $dataproduct = array();
        $datapreorder = array();
        $No_Offer = array();
        $id_Product = $request['Id_Product_Offer'];

        $amount_post = $request['amount_post'];
        $cost = $request['cost_Offer'];
        // dd($cost);
        $offers = array(
            "Id_Offer" => $Id_Offer,
            "Emp_Id" => $Id_Emp,
            "Offer_date" => $request->Offer_date,
        );
        // print_r($offers);
        // echo '<br>';
        DB::table('offers')->insert([$offers]);
        // var_dump($amount_post);
        foreach ($amount_post as $item => $value) {

            $No_Offer[$item] =  $no_offer++;

            $offer_lists = array(
                "Id_Offer" => $Id_Offer,
                "No_Offer" => $No_Offer[$item],
                "Amount_Post" => $value,
                "Amount_Approve" =>  0,

            );
            // print_r($offer_lists);
            // echo '<br>';

            DB::table('offer_lists')->insert([$offer_lists]);
        }


        foreach ($id_Product as $item => $value) {
            if (!isset($dataproduct[$value])) {
                $dataproduct[$value] = array();
                $no_product++;
                $s[$item]  = $no_product;
            } else {
                $s[$item]  = $no_product;
            }
            // print_r($s[$item]);

            $offer_costs = array(
                "Id_Offer" => $Id_Offer,
                "No_Offer" => $s[$item],
                "Id_Product" => $value,
                "Id_Partner" => $request['Id_Partner_Offer'][$item],
                "cost" => $cost[$item]
            );


            // print_r($offer_costs);
            // echo '<br>';


            DB::table('offer_costs')->insert([$offer_costs]);
        }


        if ($request->has('Id_Pro_Pre')) {
            $Id_Pro_Pre = $request['Id_Pro_Pre'];
            $Amount_Preorder_Up = $request['Amount_Preorder_Up'];
            foreach ($Id_Pro_Pre as $item => $value) {


                $select = DB::table('offer_costs')->select('No_Offer')->where('Id_Product', $value)->where('Id_Offer', $Id_Offer)->distinct()->get();

                $No_Offer = json_decode(json_encode($select), true);



                DB::table('products')->where([
                    "Id_Product" => $value,
                ])->update([
                    "Amount_Preorder" => $Amount_Preorder_Up[$item],

                ]);



                foreach ($select as $item2 => $value_pre) {


                    DB::table('preorder_lists')->join('preorders', 'preorders.Id_Preorder', '=', 'preorder_lists.Id_Preorder')->whereNull('Id_Offer')->where([
                        "Id_Product" => $value,
                    ])->update([
                        "Id_Offer" => $Id_Offer,
                        "No_Offer" => $value_pre->No_Offer,

                    ]);
                }

                // echo 'Yes';
            }

            DB::table('preorders')->where('Status_Preorder', '=', '0')->update([
                "Status_Preorder" => 1,
            ]);

            // dd($Id_Pro_Pre);
        };










        return redirect('/Stminishow/ShowOffer');
    }



    // --------------------------------------------------------อนุมัติสั่งซื้อ--------------------------------------------------------

    public function ShowApprove()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission8')) {

                $offers = DB::table('offers')->get();
                $employees = DB::table('employees')->select('Id_Emp', 'Fname_Emp')->get();
                return view('Stminishow.ShowApproveForm')->with('offers', $offers)->with('employees', $employees);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ApproveOffer($Id_Offer)
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission8')) {

                $offers_ids = DB::table('offers')->select('Id_Offer')->where('Id_Offer', $Id_Offer)->get();
                $offers_date = DB::table('offers')->select('Offer_date')->where('Id_Offer', $Id_Offer)->get();

                $offers_Amounts = DB::table('offer_costs')
                    ->join('offer_lists', function ($join_offer) {
                        $join_offer->on('offer_lists.Id_Offer', '=', 'offer_costs.Id_Offer')
                            ->on('offer_lists.No_Offer', '=', 'offer_costs.No_Offer');
                    })
                    ->join('offers', 'offer_lists.Id_Offer', '=', 'offers.Id_Offer')
                    ->select('offer_lists.Amount_Post')->where('offer_costs.Id_Offer', $Id_Offer)->groupBy('offer_lists.Amount_Post')->get();

                // dd($offers_Amounts);


                $join_Products = DB::table('offer_costs')
                    ->join('offer_lists', function ($join_offer) {
                        $join_offer->on('offer_lists.Id_Offer', '=', 'offer_costs.Id_Offer')
                            ->on('offer_lists.No_Offer', '=', 'offer_costs.No_Offer');
                    })
                    ->join('offers', 'offer_lists.Id_Offer', '=', 'offers.Id_Offer')

                    ->join('costs', function ($join_costs) {
                        $join_costs->on('costs.Id_Partner', '=', 'offer_costs.Id_Partner')
                            ->on('costs.Id_Product', '=', 'offer_costs.Id_Product');
                    })
                    ->join('partners', 'partners.Id_Partner', '=', 'costs.Id_Partner')
                    ->join('products', 'products.Id_Product', '=', 'costs.Id_Product')
                    ->select('offer_costs.Id_Product', 'products.Name_Product', 'offer_lists.Amount_Post', 'offer_costs.No_Offer')
                    ->where('offers.Id_Offer', $Id_Offer)->groupBy('offer_costs.Id_Product', 'products.Name_Product', 'offer_lists.Amount_Post', 'offer_costs.No_Offer')->get();

                //   dd($join_Products);

                $join_Partners = DB::table('offer_costs')
                    ->join('offer_lists', function ($join_offer) {
                        $join_offer->on('offer_lists.Id_Offer', '=', 'offer_costs.Id_Offer')
                            ->on('offer_lists.No_Offer', '=', 'offer_costs.No_Offer');
                    })
                    ->join('offers', 'offer_lists.Id_Offer', '=', 'offers.Id_Offer')

                    ->join('costs', function ($join_costs) {
                        $join_costs->on('costs.Id_Partner', '=', 'offer_costs.Id_Partner')
                            ->on('costs.Id_Product', '=', 'offer_costs.Id_Product');
                    })
                    ->join('partners', 'partners.Id_Partner', '=', 'costs.Id_Partner')
                    ->join('products', 'products.Id_Product', '=', 'costs.Id_Product')
                    ->select('offer_costs.Id_Partner', 'partners.Id_Partner', 'partners.Name_Partner', 'offer_costs.Id_Product', 'products.Id_Product')
                    ->where('offers.Id_Offer', $Id_Offer)->get();

                // dd($join_Partners);

                $join_offers = DB::table('offer_costs')
                    ->join('offer_lists', function ($join_offer) {
                        $join_offer->on('offer_lists.Id_Offer', '=', 'offer_costs.Id_Offer')
                            ->on('offer_lists.No_Offer', '=', 'offer_costs.No_Offer');
                    })
                    ->join('offers', 'offer_lists.Id_Offer', '=', 'offers.Id_Offer')

                    ->join('costs', function ($join_costs) {
                        $join_costs->on('costs.Id_Partner', '=', 'offer_costs.Id_Partner')
                            ->on('costs.Id_Product', '=', 'offer_costs.Id_Product');
                    })
                    ->join('partners', 'partners.Id_Partner', '=', 'costs.Id_Partner')
                    ->join('products', 'products.Id_Product', '=', 'costs.Id_Product')

                    ->select(
                        'offer_costs.Id_Offer',
                        'offer_costs.Cost',
                        'offer_costs.No_Offer',
                        'offer_lists.No_Offer',
                        'offer_lists.Amount_Post',
                        'offer_lists.Amount_Approve',
                        'offer_lists.Id_Offer',
                        'offers.Id_Offer',
                        'costs.Id_Partner',
                        'offer_costs.Id_Partner',
                        'costs.Id_Product',
                        'offer_costs.Id_Product',
                        'partners.Id_Partner',
                        'costs.Id_Partner',
                        'products.Id_Product',
                        'costs.Id_Product',
                        'products.Name_Product',
                        'partners.Name_Partner',
                    )
                    ->where('offers.Id_Offer', $Id_Offer)
                    ->groupBy(
                        'offer_costs.Id_Offer',
                        'offer_costs.Cost',
                        'offer_costs.No_Offer',
                        'offer_lists.No_Offer',
                        'offer_lists.Amount_Post',
                        'offer_lists.Amount_Approve',
                        'offer_lists.Id_Offer',
                        'offers.Id_Offer',
                        'costs.Id_Partner',
                        'offer_costs.Id_Partner',
                        'costs.Id_Product',
                        'offer_costs.Id_Product',
                        'partners.Id_Partner',
                        'costs.Id_Partner',
                        'products.Id_Product',
                        'costs.Id_Product',
                        'products.Name_Product',
                        'partners.Name_Partner',
                    )->get();

                // dd($join_offers);
                // $Amount_Pres = DB::table('preorder_lists')->select('Id_Offer', 'Id_Product', DB::raw('sum(preorder_lists.Amount_Preorder) as Amount_Preorder'))->groupBy('Id_Product', 'Id_Offer')->get();


                return view('Stminishow.ApproveForm')->with('join_Products', $join_Products)->with('join_Partners', $join_Partners)
                    ->with('offers_Amounts', $offers_Amounts)->with('join_offers', $join_offers)
                    ->with('offers_ids', $offers_ids)
                    ->with('offers_date', $offers_date);
            } else {
                Session()->flash("echo", "คุณไม่มีสิทธิ์");
                return view('layouts.stmininav');
            }
        } else {

            return redirect('/login');
        }
    }



    public function select_Cost_Partner(Request $request)
    {
        $Id_Offer = $request->get('Id_Offer');
        $Id_Product = $request->get('Id_Product');
        $Id_Partner = $request->get('select');
        $result = array();
        $query = DB::table('offer_costs')
            ->select('Cost')
            ->where('Id_Offer', $Id_Offer)
            ->where('Id_Product', $Id_Product)
            ->where('Id_Partner', $Id_Partner)
            ->get();

        // dd($query);


        // $query = json_decode(json_encode($query), true);
        // $reindexed = array_values($query);
        // $sub =  strpos($query, ":");

        $sub = substr($query, 9, -2,);
        // echo json_encode($sub);
        return response()->json($sub);

        // $output =  '';


        // echo $output;


        // $costs = $query->Costs;

        // echo $costs;
    }

    public function storeApprove(Request $request)
    {

        $Id_Offer = $request->Id_Offer;


        $no_product = 0;
        $no_offer = 1;



        $s = array();
        $dataproduct = array();
        $No_Offer = array();
        $id_Product = $request['Id_Product'];
        $amount_Approve = $request['amount_Approve'];
        $No_Product = $request['No_Offer'];
        $id_Partner = $request['Id_Partner'];

        // dd($No_Product);
        $total = $request['total'];


        //  dd($offers);
        DB::table('offers')->where('Id_Offer', $Id_Offer)->update([
            "Status_Offer" => 1,
            "Total_Price" => $total
        ]);

        // $testsql = DB::table('offer_costs')->select('No_Offer')->where('Id_Offer', $Id_Offer)->where('Id_Partner', $Id_Partner)->get();
        foreach ($amount_Approve as $item => $value) {

            // $where2 = array();

            // $offer_lists = array();


            DB::table('offer_lists')->where([
                "Id_Offer" => $Id_Offer,
                "No_Offer" => $No_Product[$item]
            ])->update(["Amount_Approve" =>  $value,]);
        }

        // dd($offer_lists);
        foreach ($id_Partner as $item => $value) {

            // $where3 = array(

            // );
            // print_r($where3);
            // echo '<br>';
            // $offer_costs = array();


            // DB::table('offer_lists')->where([$where2])->update([$offer_lists]);
            DB::table('offer_costs')->where([
                "id_Partner" => $value,
                "id_Product" => $id_Product[$item],
                "Id_Offer" => $Id_Offer,
            ])->update([
                "Status_Approve" => 1
            ]);
        }
        // echo ('yes');

        return redirect('/Stminishow/ShowOffer');
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
