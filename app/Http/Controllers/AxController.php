<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AxController extends Controller
{
    public static function GetContacts($id) {
        return DB::connection('sqlsrv')->table('contactperson as cp')
            ->select('cp.custaccount', 'cp.function_', 'cp.GOVERNMENTIDNUMBER', 'dtable.firstname', 'dtable.lastname', 'dirmail.locator')
            ->join('dirpartynameview as dtable', 'cp.party', 'dtable.recid' )
            ->join('dirpartycontactinfoview as dirmail', 'dtable.party', 'dirmail.party')
            ->where('dtable.validto', '>', date('Y-m-d H:i:s'))
            ->where('isprimary', 1)
            ->where('dirmail.type', '2')
            ->where('cp.custaccount', $id)
            ->first();
    }
}
