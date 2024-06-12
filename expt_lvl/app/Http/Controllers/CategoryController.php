<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\ExptUsers;
use App\Models\ExptBankAccounts;
use App\Models\ExptCategory;
use App\Models\ExptIncome;
use App\Models\ExptExpense;
use App\ASPLibraries\CustomFunctions;
Use DB;
Use Mail;
use Session;


class CategoryController extends BaseController{

    public function category() {

        if(!session::has('normalUserId')){
            return redirect('/');
        };

        $categoryList = ExptCategory::select('id', 'category_name', 'active', 'created_at')->where('user_id', session::get('normalUserId'))->orderBy('active', 'DESC')->orderBy('id', 'DESC')->get();

        return view('category', ['categoryList' => $categoryList]);
    }

    public function categoryProcess(Request $request) {
        if ($request->category_process_val == "add_category") {
            return $this->addNewCategory($request);
        }
        else if ($request->category_process_val == "get_category_data") {
            return $this->getCategoryData($request);
        }
        else if ($request->category_process_val == "update_category") {
            return $this->updateCategoryData($request);
        }
        else if ($request->category_process_val == "filter_category") {
            return $this->filterCategoryData($request);
        }
    }

    public function addNewCategory(Request $request) {

        $cat_name = $request->category_name_val;

        $checkCatExists = ExptCategory::select('id', 'category_name')->where('user_id', session::get('normalUserId'))->where('category_name', $cat_name)->first();

        if ($checkCatExists != '') {
            return 'category exists';
        }

        $InsertCat = new ExptCategory();
        $InsertCat->user_id = session::get('normalUserId');
        $InsertCat->category_name = $cat_name;
        $InsertCat->save();

    }
    
    public function getCategoryData(Request $request) {
 
        $catId = $request->category_id_val;

        $categoryData = ExptCategory::select('id', 'category_name', 'active', 'created_at')->where('user_id', session::get('normalUserId'))->where('id', $catId)->first();

        return view('ajax/ajax_edit_category', ['categoryData' => $categoryData]);
 
    }

    public function updateCategoryData(Request $request) {
 
        $catId = $request->update_category_id_val;
        $catName = $request->update_category_name_val;
        $catActive = $request->update_category_active_val;

        $checkCatExists = ExptCategory::select('id', 'category_name')->where('user_id', session::get('normalUserId'))->where('category_name', '<>', $catName)->first();

        if ($checkCatExists != '') {
            return 'category exists';
        }

        ExptCategory::where('id', $catId)->update(array(

            'category_name' => $catName,
            'active' => $catActive,

        ));

        return 'Updated';
 
    }
    
    public function filterCategoryData(Request $request) {
    
        $catFilterName = $request->filter_category_name_val;
        $catFilterActive = $request->filter_category_active_val;

        $categoryListQuery = ExptCategory::select('id', 'category_name', 'active', 'created_at')
                                        ->where('user_id', session::get('normalUserId'))
                                        ->orderBy('id', 'DESC');
    
        if ($catFilterName != '') {
            
            $categoryListQuery->where('category_name', 'like', '%'.$catFilterName.'%');
            
        }
        if ($catFilterActive != '') {
            
            $categoryListQuery->where('active', $catFilterActive);
            
        }

        $categoryList = $categoryListQuery->get();

        if ($categoryList->isEmpty()) {
            return '<h2 class="text-center">No Records</h2>';
        }

        return view('ajax/ajax_category_body', ['categoryList' => $categoryList]);
    
    }

}