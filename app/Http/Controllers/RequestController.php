<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Http\Request;

class RequestController extends Controller
{
        public function reqAdmins()
        {
            return DB::connection('mysql')->select('select * from admin_user');
        }

        public function getClient(Request $request) {

            if(strlen($request->input('client') < 3)) {
                return view('client')->with('error', 'Puuduvad andmed');
            }

            $data =  DB::connection('mysql')->table('b2b_customer as b2b')
                ->select('b2b.ax_code', 'b2b.name', 'b2b.balance', 'b2b.allowed_emails',
                    'cust.email', 'cust.created_at',
                    'billingadr.postcode as billing_postcode', 'billingadr.city as billing_city', 'billingadr.region as billing_region', 'billingadr.street as billing_street',
                    'shippingadr.postcode as shipping_postcode', 'shippingadr.city as shipping_city', 'shippingadr.region as shipping_region', 'shippingadr.street as shipping_street'
                )
                ->join('byroomaailm_prelive.customer_entity as cust', 'b2b.customer_id', '=', 'cust.entity_id')
                ->join('byroomaailm_prelive.customer_address_entity as billingadr', 'cust.default_billing', '=', 'billingadr.entity_id')
                ->join('byroomaailm_prelive.customer_address_entity as shippingadr', 'cust.default_shipping', '=', 'shippingadr.entity_id')
                ->where('ax_code', $request->input('client'))->get();
            //dd($data);
            $users = $this->getUsers($request->input('client'));
            $axusers = AxController::GetContacts($request->input('client'));

            //dd($users);
            return view('client')
                ->with('data', $data)
                ->with('users', $users)
                ->with('axusers', $axusers);
        }

        public function getUsers($id) {
            if(strlen($id < 3)) {
                return view('client')->with('error', 'Puuduvad andmed');
            }

            $data = DB::connection('mysql')->table('b2b_customer as cust')
                ->select('cust.ax_code','apers1.id' ,'apers1.email', 'apers1.firstname', 'apers1.lastname', 'apers1.active', 'apers1.admin', 'apers1.personal_id')
                ->join('b2b_customer_authorized_person as apers', 'cust.id', '=', 'apers.b2b_customer_id')
                ->join('b2b_authorized_person as apers1', 'apers.authorized_person_id', '=', 'apers1.id')
                ->where('cust.ax_code', '=', $id)
                ->get();

            return $data;
        }
}
