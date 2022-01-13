<?php 

namespace App\Repositories\Customer;

use App\Models\Customer;
use Session;

class CustomerRepository implements CustomerRepositoryInterface
{
    protected $model;

    public function __construct(Customer $model) {
        $this->model = $model;
    }

    public function getCustomers() {
        $customers = $this->model->get();

        if(Session::has('sel_country')) {
            $sel_country = Session::get('sel_country');
            $customers = $customers->filter(function($record) use($sel_country) {
                return $record->country === $sel_country;
             });
        }

        if(Session::has('sel_state')) {
            $sel_state = Session::get('sel_state');
            $customers = $customers->filter(function($record) use($sel_state) {
                return $record->state === $sel_state;
             });
        }
        return $customers;
    }

}