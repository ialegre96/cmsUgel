<?php

namespace App\Http\Controllers\Admin;

use Hash;
use App\Admin;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        /*  $numRegulations = Documents::where('category_id', 3)->count();
        $numAnnouncements = Documents::where('category_id', 2)->count();
        $numDocuments = Documents::where('category_id', 1)->count();
        $numArticles = Article::count(); */
        $companyData = getCompanyData();
        return view('admin.admin_dashboard', compact('companyData'))->with('title', 'Dashboard');
    }

    public function settings()
    {
        Session::put('page', 'settings');
        /* echo "<pre>"; print_r(Auth::guard('admin')->user()); die; */
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        $company = new Company;
        $companyData = getCompanyData();
        return view('admin.admin_settings')->with(compact('adminDetails', 'companyData'));
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            /* echo "<pre>";
            print_r($data);
            die; */
            $rulesData = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessages = [
                'email.required' => 'El campo email es requerido',
                'email.email' => 'El email es invalido',
                'password.required' => 'El campo contraseña es requerido',
            ];

            $this->validate($request, $rulesData, $customMessages);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect()->route('dashboard');
            } else {
                Session::flash('error_message', 'Email o contraseña invalidos');
                return redirect()->back();
            }
        }
        $companyData = getCompanyData();
        return view('admin.admin_login')->with(compact('companyData'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function verifyPassword(Request $request)
    {
        $data = $request->all();
        /* echo "<pre>"; print_r($data); die; */
        $userPwd = Auth::guard('admin')->user()->password;
        echo "<pre>";
        print_r($userPwd);
        die;
        if (Hash::check($data['currentPwd'], $userPwd)) {
            echo true;
        }
        echo false;
    }

    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            $userPwd = Auth::guard('admin')->user()->password;
            if (Hash::check($data['currentPassword'], $userPwd)) {
                if ($data['newPassword'] == $data['confirmPassword']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['newPassword'])]);
                    Session::flash('success_message', 'La Contraseña se actualizo correctamente.');
                    return redirect()->back();
                } else {
                    Session::flash('error_message', 'Ambas Contraseñas no coinciden.');
                    return redirect()->back();
                }
            } else {
                Session::flash('error_message', 'La Contraseña Actual es incorrecta.');
                return redirect()->back();
            }
        }
    }

    public function updateAdminDetails(Request $request)
    {
        Session::put('page', 'upd-admin-details');
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rulesData = [
                'adminName' => 'required|regex:/^[A-Za-zá-úÁ-ÚñÑ0-9\-! ,&\'\"\/@\.:\(\)]+$/',
                'adminEmail' => 'required|email|max:255',
                'adminImage' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];

            $customMessages = [
                'adminName.required' => 'El campo nombre es requerido',
                'adminName.alpha' => 'El campo nombre debe ser válido',
                'adminEmail.required' => 'El campo email es requerido',
                'adminEmail.alpha' => 'El campo email debe ser válido',
                'adminImage.mimes' => 'Formato invalido, formatos soportados: jpeg, png, jpg, gif, svg',
                'adminImage.max' => 'La imagen no debe pesar mas de 2MB',
            ];


            Admin::where('id', Auth::guard('admin')->user()->id)->update(['name' => $data['adminName'], 'email' => $data['adminEmail']]);

            Session::flash('success_message', 'Los datos se actualizaron correctamente');
            return redirect()->back();
        }
        $company = new Company;
        $companyData = getCompanyData();
        return view('admin.upd_admin_details', compact('companyData'));
    }
}
