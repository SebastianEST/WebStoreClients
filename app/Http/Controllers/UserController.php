<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('edituser');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createuser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);

        $request->validate([
            'email' => 'email|unique:mysql.b2b_authorized_person,email',
            'username' => 'email|unique:mysql.b2b_authorized_person,username',
            'firstname' => 'min:2|string',
            'lastname' => 'min:2|string',
            'password' => 'min:8'
        ]);

        //dd($request->input());
        $userid = DB::connection('mysql')->table('b2b_authorized_person')->insertGetId([
            'ax_code' => null,
            'b2b_customer_id' => null,
            'role_id' => null,
            'admin' => 1,
            'active' => 1,
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'personal_id' => $request->input('personal_id'),
            'password' => $this->getPassword($request->input('password')),
            'global_role_id' => null,
            'rp_token' => null,
            'rp_token_created_at' => null,
            'confirmation_token' => null


        ]);
        $adm = ($request->input('admin') === 'on') ? 1 : 0;

        $this->createLink($userid, $request->input('client'));
        $this->setAdmAndRole($userid, $request->input('client'), $adm, $request->input('role'));
        //return redirect("/client?client=" .$request->input('client'));
        return \Redirect::to("/client?client=" .$request->input('client'))->withSuccess( 'Kasutaja edukalt lisatud!' );



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dd($this->getUserData($id));
        return view('edituser')->with('webuser', $this->getUserData($id));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function connectUser(Request $request)
    {
        if($this->ifPersExists($request->input('email'))) {
            $userid = DB::connection('mysql')
                ->table('b2b_authorized_person')
                ->select('id')
                ->where('email', $request->input('email'))
                ->first();
            $this->createLink($userid->id, $request->input('client'));
            //return redirect("/client?client=" .$request->input('client'))->withSuccess( 'Kasutaja edukalt seotud!' ); //Täiesti kasutu, alumine on parem
            return \Redirect::back()->withSuccess( 'Kasutaja edukalt seotud!' );
        }
        //dd($request->input());
        return view('connectuser')->with('webuser', AxController::getContact($request->input('webuser')));
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
        //dd($request->input());
        if(strlen($request->input('password')) !== 0) {
            $request->validate([
                'password' => 'min:8'
            ]);

            DB::connection('mysql')->table('b2b_authorized_person')
                ->where('id', $id)
                ->update(array(
                    'password' => $this->getPassword($request->input('password'))));
        }
        //dd($request->input());
        $request->validate([
            'firstname' => 'min:2|required',
            'lastname' => 'min:2|required',
            'email' => 'min:3|required|email',
            'username' => 'min:3|required|email'

        ]);
        DB::connection('mysql')->table('b2b_authorized_person')
            ->where('id', $id)
            ->update(array('firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'personal_id' => $request->input('personal_id'),
                'password' => $this->getPassword($request->input('password'))));

        $adm = ($request->input('admin') === 'on') ? 1 : 0;

        $this->setAdmAndRole($id, $request->input('client'), $adm, $request->input('role'));
        //return redirect("/client?client=" .$request->input('client'));
        return \Redirect::to("/client?client=" .$request->input('client'))->withSuccess( 'Kasutaja andmed edukalt uuendatud!' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // We are not destroying anything!!!
    }

    public function getUserData($id) {
         $data = DB::connection('mysql')->table('b2b_authorized_person as auth1')
            ->select('auth1.id','auth1.email', 'auth1.firstname', 'auth1.lastname', 'auth1.personal_id', 'auth1.username', 'role.name', 'auth2.admin', 'auth2.global_role_id')
             ->join('b2b_customer_authorized_person as auth2', 'auth1.id', 'auth2.authorized_person_id')
             ->join('b2b_global_role as role', 'auth2.global_role_id','role.id')
             ->where('auth1.id', '=', $id)
            ->first();
         //dd($data);
         return $data;

    }
    //Get Magento ID for Company
    private function getCompId($id) {
        return DB::connection('mysql')->table('b2b_customer')->select('id')->where('ax_code', $id)->get()[0]->id;
        //dd($str[0]->id);
    }

    //Link between webuser and company
    private function createLink($user, $comp) {
        DB::connection('mysql')->table('b2b_customer_authorized_person')->insert([
            'b2b_customer_id' => $this->getCompId($comp),
            'authorized_person_id' => $user,
            'admin' => 1,
            'role_id' => (null),
            'global_role_id' => 1
        ]);
    }
    //Set roles and admin status
    private function setAdmAndRole($user, $comp, $adm, $role) {
        DB::connection('mysql')->table('b2b_customer_authorized_person')
            ->where('b2b_customer_id', '=', $this->getCompId($comp))
            ->where('authorized_person_id', '=', $user)
            ->update([
            'admin' => $adm,
            'global_role_id' => $role
        ]);

    }

    //Create correct password for magento
    private function getPassword($pass) {
        return hash('SHA256', $pass);
    }

    //Check if webuser is already in db
    public static function ifPersExistsInComp($email, $client) {
        $ret = DB::connection('mysql')->table('b2b_authorized_person as auth1')
            ->join('b2b_customer_authorized_person as auth2', 'auth1.id', 'auth2.authorized_person_id')
            ->join('b2b_customer as cust', 'auth2.b2b_customer_id', 'cust.id')
            ->where('auth1.email', $email)
            ->where('cust.ax_code', $client)
            ->get();
        //dd($ret);
        if(count($ret) > 0) {
            return true;
        }
        return false;
    }

    //Check if webuser is already in db
    public static function ifPersExists($email) {
        $ret = DB::connection('mysql')->table('b2b_authorized_person as auth1')
            ->where('auth1.email', $email)
            ->get();
        //dd($ret);
        if(count($ret) > 0) {
            return true;
        }
        return false;
    }
}
