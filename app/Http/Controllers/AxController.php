<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class AxController extends Controller
{
    public static function GetContacts($id) {
        $data = DB::connection('sqlsrv')->table('contactperson as cp')
            ->select('cp.custaccount', 'cp.function_', 'cp.GOVERNMENTIDNUMBER', 'dtable.firstname', 'dtable.lastname', 'dirmail.locator', 'dtable.recid')
            ->join('dirpartynameview as dtable', 'cp.party', 'dtable.recid' )
            ->join('dirpartycontactinfoview as dirmail', 'dtable.party', 'dirmail.party')
            ->where('dtable.validto', '>', date('Y-m-d H:i:s'))
            ->where('isprimary', 1)
            ->where('dirmail.type', '2')
            ->where('cp.custaccount', $id)
            ->get();

        //check if user is already in web
        foreach ($data as $contact) {
            if(UserController::ifPersExistsInComp($contact->locator, $contact->custaccount)) {
                $contact->web = 0;
            } elseif (UserController::ifPersExists($contact->locator)) {
                $contact->web = 2;
            }
            else {
                $contact->web = 1;
            }
        }

        //dd($data);
        return $data;
    }

    public static function getContact($id) {
        $data = DB::connection('sqlsrv')->table('dirpartynameview as dtable')
            ->select('dtable.firstname as firstname', 'dtable.lastname as lastname', 'dtable.recid', 'cp.GOVERNMENTIDNUMBER as personal_id', 'dirmail.locator as email','cp.custaccount as client')
            ->join('contactperson as cp', 'dtable.recid','cp.party')
            ->join('dirpartycontactinfoview as dirmail', 'dtable.party', 'dirmail.party')
            ->where('dtable.recid', $id)
            ->where('dtable.validto', '>', Carbon::now())
            ->first();

        //dd($data);
        return $data;
    }


}
