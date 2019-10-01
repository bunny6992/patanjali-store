<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Excel;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Imports\ProductsUpdate;

class ImportExcelController extends Controller
{
	/**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new ProductsExport, 'users.xlsx');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function bulkAddNewStock() 
    {
        Excel::import(new ProductsImport,request()->file('file'));
        request()->file('file')->storeAs('uploads', time().".xlsx");
        return back();
    }   

    /**
    * @return \Illuminate\Support\Collection
    */
    public function bulkUpdateStock() 
    {
    	//return "Phoch Gaya Tera Bhai";
        Excel::import(new ProductsUpdate,request()->file('file'));
        //request()->file('file')->storeAs('uploads', time().".xlsx");
        return back();
    }   

}
