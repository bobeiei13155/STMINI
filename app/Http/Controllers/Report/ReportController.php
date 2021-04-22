<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ShowCosttap()
    {
        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission13')) {

                $costtap = DB::select(DB::raw("SELECT y1.Id_Product , y1.Name_Product  ,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-01')) ,0.00) as Jan,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-02')) , 0.00) as Feb,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-03')) , 0.00)as Mar,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-04')) , 0.00)as Apr,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-05')) , 0.00) as May,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-06'))  , 0.00)as Jun,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-07')) , 0.00) as Jul,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-08')) , 0.00) as Aug,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-09'))  , 0.00)as Sep,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-10'))  , 0.00)as Oct,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-11'))  , 0.00)as Nov,
                IFNULL(SUM(y2.Total_Price * (y2.yymm='2021-12')),0.00) as 'Dec'
                
                FROM products as y1
                LEFT JOIN
                (
                SELECT sell_lists.Id_Sell , sell_lists.No_Sell , products.Id_Product , sum(sell_lists.Total_Price)as Total_Price , sells.Sell_Date , SUBSTR(sells.Sell_Date,1,7) as yymm 
                FROM sell_lists 
                JOIN sells  ON sells.Id_Sell = sell_lists.Id_Sell
                JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and lot_lists.No_Lot  = sell_lists.No_Lot
                RIGHT JOIN   products on products.Id_Product = lot_lists.Id_Product
                GROUP BY products.Id_Product ,sell_lists.Id_Sell , sell_lists.No_Sell , products.Id_Product ,  sells.Sell_Date ,yymm 
                )y2 ON y1.Id_Product = y2.Id_Product
                WHERE y1.`Status` = '0'
                GROUP BY y1.Id_Product,y1.Id_Product , y1.Name_Product
                "));

                return view("report.Report_CosttapForm")->with('costtap', $costtap);
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
    public function select_corttap(Request $request)
    {

        $Year = $request->year;
        // dd($Year);
        $costtap = DB::select(DB::raw("SELECT y1.Id_Product , y1.Name_Product  ,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-01')) ,0.00) as Jan,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-02')) , 0.00) as Feb,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-03')) , 0.00)as Mar,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-04')) , 0.00)as Apr,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-05')) , 0.00) as May,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-06'))  , 0.00)as Jun,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-07')) , 0.00) as Jul,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-08')) , 0.00) as Aug,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-09'))  , 0.00)as Sep,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-10'))  , 0.00)as Oct,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-11'))  , 0.00)as Nov,
        IFNULL(SUM(y2.Total_Price * (y2.yymm='" . $Year . "-12')),0.00) as 'Dec'
        
        FROM products as y1
        LEFT JOIN
        (
        SELECT sell_lists.Id_Sell , sell_lists.No_Sell , products.Id_Product , sum(sell_lists.Total_Price)as Total_Price , sells.Sell_Date , SUBSTR(sells.Sell_Date,1,7) as yymm 
        FROM sell_lists 
        JOIN sells  ON sells.Id_Sell = sell_lists.Id_Sell
        JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and lot_lists.No_Lot  = sell_lists.No_Lot
        RIGHT JOIN   products on products.Id_Product = lot_lists.Id_Product
        GROUP BY products.Id_Product ,sell_lists.Id_Sell , sell_lists.No_Sell , products.Id_Product ,  sells.Sell_Date ,yymm 
        )y2 ON y1.Id_Product = y2.Id_Product
        WHERE y1.`Status` = '0'
        GROUP BY y1.Id_Product,y1.Id_Product , y1.Name_Product
        "));

        $output = '';
        foreach ($costtap as $row) {
            $output .= '<tr>';
            $output .= ' <td>' . $row->Name_Product . '</td>';
            $output .= ' <td>' . number_format($row->Jan, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Feb, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Mar, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Apr, 2) . '</td>';
            $output .= ' <td>' . number_format($row->May, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Jun, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Jul, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Aug, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Sep, 2) . '</td>';
            $output .= ' <td>' . number_format($row->Oct, 2) . '</td>';
            $output .= '<td>' . number_format($row->Nov, 2) . '</td>';
            $output .= '<td>' . number_format($row->Dec, 2) . '</td>';
            $output .= '</tr>';
        }

        echo $output;

        // dd($costtap);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ShowReportSell(Request $request)
    {

        Session()->forget("echo", "คุณไม่มีสิทธิ์");
        if (session()->has('login')) {
            if (session()->has('loginpermission13')) {


                $reportsells = DB::select(DB::raw("SELECT  products.Id_Product ,products.Name_Product,sum(sell_lists.Amount_Sell) as Amount_Sell 
                FROM sell_lists 
                JOIN sells  ON sells.Id_Sell = sell_lists.Id_Sell
                JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and lot_lists.No_Lot  = sell_lists.No_Lot
                RIGHT JOIN   products on products.Id_Product = lot_lists.Id_Product
                WHERE sells.`Status` = '0' 
                GROUP BY products.Id_Product ,products.Name_Product 

                "));



            

                return view("report.ReportSellForm")->with('reportsells', $reportsells);
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
    public function select_Edate(Request $request)
    {

        $Sdate = $request->Sdate;
        $Edate = $request->Edate;





        $reportsells = DB::select(DB::raw("SELECT  products.Id_Product ,products.Name_Product,sum(sell_lists.Amount_Sell) as Amount_Sell 
            FROM sell_lists 
            JOIN sells  ON sells.Id_Sell = sell_lists.Id_Sell
            JOIN lot_lists on sell_lists.Id_Lot = lot_lists.Id_Lot and lot_lists.No_Lot  = sell_lists.No_Lot
            RIGHT JOIN   products on products.Id_Product = lot_lists.Id_Product
            WHERE sells.`Status` = '0' and (STR_TO_DATE(sells.Sell_Date,'%Y-%m-%d') BETWEEN '" . $Sdate . "' AND '" . $Edate . "')
            GROUP BY products.Id_Product ,products.Name_Product ORDER BY Amount_Sell DESC
            "));




        return view("report.ReportSellForm")->with('reportsells', $reportsells);
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
