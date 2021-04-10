<?php

namespace App\Http\Controllers\Stminishow;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('loginstmini');
    }

    public function indexform()
    {
        return redirect('/layouts/stmininav');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'Username' => 'required',
            'Password' => 'required'
        ]);
        $Usernameold = $request->Username;
        $Passwordold = $request->Password;
        $checkusername = DB::table('employees')
            ->select('Username_Emp')
            ->where('Username_Emp', '=', "{$Usernameold}")->get();
        $checkpassword = DB::table('employees')
            ->select('Password_Emp')
            ->where('Password_Emp', '=', "{$Passwordold}")->get();

        $Username = json_decode(json_encode($checkusername), true);
        $Password = json_decode(json_encode($checkpassword), true);

        $Fnameold = DB::table('employees')
            ->select('FName_Emp')
            ->where('Username_Emp', '=', "{$Usernameold}")->get();
        // $Fnamenew = json_decode(json_encode($Fnameold), true);


        $Lnameold = DB::table('employees')
            ->select('LName_Emp')
            ->where('Username_Emp', '=', "{$Usernameold}")->get();

        $img = DB::table('employees')
            ->select('Img_Emp')
            ->where('Username_Emp', '=', "{$Usernameold}")->get();

        if (empty($Username) || empty($Password)) {
            Session()->flash("warning", "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง");
            return redirect('/login');
        } else {

            $Permission = Employee::join('positions', 'employees.Position_Id', "=", 'positions.Id_Position')
                ->select('Permission')->where('Username_Emp', '=', "{$Usernameold}")
                ->get();
            $Permissionnew = json_decode(json_encode($Permission), true);
            if (empty($Permissionnew)) {

                $request->session()->put(['login' => $checkusername[0]->Username_Emp]);
                $request->session()->put(['fname' => $Fnameold[0]->FName_Emp]);
                $request->session()->put(['lname' => $Lnameold[0]->LName_Emp]);
                $request->session()->put(['Img_Emp' => $img[0]->Img_Emp]);
                return view('Stminishow.indexForm')->with('login', $request->session())->with('Img_Emp', $request->session())->with('fname', $request->session())->with('lname', $request->session());
            }

            Session()->flash("success", "เข้าสู่ระบบสำเร็จ");

            //Hello
            $loginpermission = [
                substr($Permission[0]->Permission, 0, 1), substr($Permission[0]->Permission, 1, 1),
                substr($Permission[0]->Permission, 2, 1), substr($Permission[0]->Permission, 3, 1),
                substr($Permission[0]->Permission, 4, 1), substr($Permission[0]->Permission, 5, 1),
                substr($Permission[0]->Permission, 6, 1), substr($Permission[0]->Permission, 7, 1),
                substr($Permission[0]->Permission, 8, 1), substr($Permission[0]->Permission, 9, 1),
                substr($Permission[0]->Permission, 10, 1), substr($Permission[0]->Permission, 11, 1),
                substr($Permission[0]->Permission, 12, 1), substr($Permission[0]->Permission, 13, 1),
                substr($Permission[0]->Permission, 14, 1), substr($Permission[0]->Permission, 15, 1)
            ];
            $request->session()->put(['login' => $checkusername[0]->Username_Emp]);
            $request->session()->put(['fname' => $Fnameold[0]->FName_Emp]);
            $request->session()->put(['lname' => $Lnameold[0]->LName_Emp]);
            $request->session()->put(['Img_Emp' => $img[0]->Img_Emp]);
            if ($loginpermission[0] == 1) {
                $request->session()->put(['loginpermission1' => $loginpermission[0]]);
            }
            // dd($loginpermission[0]);
            if ($loginpermission[1] == 1) {
                $request->session()->put(['loginpermission2' => $loginpermission[1]]);
            }
            if ($loginpermission[2] == 1) {
                $request->session()->put(['loginpermission3' => $loginpermission[2]]);
            }
            if ($loginpermission[3] == 1) {
                $request->session()->put(['loginpermission4' => $loginpermission[3]]);
            }
            if ($loginpermission[4] == 1) {
                $request->session()->put(['loginpermission5' => $loginpermission[4]]);
            }
            if ($loginpermission[5] == 1) {
                $request->session()->put(['loginpermission6' => $loginpermission[5]]);
            }
            if ($loginpermission[6] == 1) {
                $request->session()->put(['loginpermission7' => $loginpermission[6]]);
            }
            if ($loginpermission[7] == 1) {
                $request->session()->put(['loginpermission8' => $loginpermission[7]]);
            }
            if ($loginpermission[8] == 1) {
                $request->session()->put(['loginpermission9' => $loginpermission[8]]);
            }
            if ($loginpermission[9] == 1) {
                $request->session()->put(['loginpermission10' => $loginpermission[9]]);
            }
            if ($loginpermission[10] == 1) {
                $request->session()->put(['loginpermission11' => $loginpermission[10]]);
            }
            if ($loginpermission[11] == 1) {
                $request->session()->put(['loginpermission12' => $loginpermission[11]]);
            }
            if ($loginpermission[12] == 1) {
                $request->session()->put(['loginpermission13' => $loginpermission[12]]);
            }
            if ($loginpermission[13] == 1) {
                $request->session()->put(['loginpermission14' => $loginpermission[13]]);
            }
            if ($loginpermission[14] == 1) {
                $request->session()->put(['loginpermission15' => $loginpermission[14]]);
            }
            if ($loginpermission[15] == 1) {
                $request->session()->put(['loginpermission16' => $loginpermission[15]]);
            }

            return view('Stminishow.indexForm')->with('login', $request->session())->with('Img_Emp', $request->session())->with('fname', $request->session())->with('lname', $request->session());
        };




        // dd($logpermiss[0]);

        //dd($Username_Emp);

        // $Username_Emp = json_decode(json_encode($Username_Emp), true);
        // $Password_Emp = json_decode(json_encode($Password_Emp), true);
        // if (empty($Username_Emp) || empty($Password_Emp)) {
        //     Session()->flash("warning", "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง");
        //     return view('login');
        // } else {
        //     



        //     return view('/Stminishow/indexform')->with('login', $Username);
        // }
        // if(empty($Username_Emp->items)){
        //     Session()->flash("warning", "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง");
        //     return view('login');

        // }else{
        //     Session()->flash("success", "เข้าสู่ระบบสำเร็จ");
        //     return view('/Stminishow/showEmployee');
        // }


    }

    public function logout()
    {
        Session()->flash("warning", "ออกจากระบบสำเร็จ");
        session()->flush();
        return redirect('/login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
