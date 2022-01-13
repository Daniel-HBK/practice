<?php

namespace App\Http\Controllers\Web;

use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;

class CustomerController extends Controller
{
    public function index(CustomerRepositoryInterface $customersRepo, Request $request) {
        $customers = $customersRepo->getCustomers();
        if ($request->ajax()) {
            return Datatables::of($customers)->make(true);
        }
        return view('index', compact('customers'));
    }
    
    public function filter(Request $request) {
        $request->has('sel_country') == true ? $request->session()->put('sel_country', $request->sel_country) : null;
        $request->has('sel_state') == true ? $request->session()->put('sel_state', $request->sel_state) : null;
        return redirect(route('customers.index'));
    }

    public function reset(Request $request) {
        $request->session()->forget(['sel_country', 'sel_state']);
        return redirect(route('customers.index'));
    }
}
