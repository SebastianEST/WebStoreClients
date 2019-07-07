<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class AxController extends Controller
{
    public static function GetContacts($id) {
        $data = DB::connection('sqlsrv2')->table('SS_contacts_for_web')
            ->select('custaccount', 'function_', 'GOVERNMENTIDNUMBER', 'firstname', 'lastname', 'locator', 'recid')
            ->where('custaccount', $id)
            ->get();

        //check if webuser is already in web
        foreach ($data as $contact) {
            if(UserController::ifPersExistsInComp($contact->locator, $contact->custaccount)) {
                $contact->web = 0;
            } elseif (strlen($contact->locator) < 3 || $contact->function_ !== 'Volitatud isik') {
                $contact->web = 3;
            }
            elseif (UserController::ifPersExists($contact->locator)) {
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
            ->where('isprimary', 1)
            ->where('dirmail.type', '2')
            ->first();

        //dd($data);
        return $data;
    }


}
