<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DailyClosing;
use App\Expense;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $returnData = [];
        $closingDays = DailyClosing::all();
        foreach ($closingDays as $closingDay) {
            $returnData[$closingDay['date']] = [
                'total_sales' => $closingDay['sales'],
                'total_returns' => $closingDay['returns'],
                'total_expenses' => $closingDay['expenses'],
                'expected_closing_cash' => $closingDay['expected_closing_cash'],
                'expenses' => $closingDay->allExpenses,
                'closing_cash' => $closingDay['closing_cash'],
                'id' => $closingDay['id']
            ];   
        }
        return $returnData;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        if(array_key_exists('closing_date_id', $requestData)) {
            $closingModel = DailyClosing::find($requestData['closing_date_id']);
        } else {
           $closingModel = new DailyClosing;
        }
        
        $closingModel->date = $requestData['closing_date'];
        $closingModel->expenses = $requestData['total_expenses'];
        $closingModel->sales = $requestData['total_sales'];
        $closingModel->returns = $requestData['total_returns'];
        $closingModel->expected_closing_cash = $requestData['expected_closing_cash'];
        $closingModel->closing_cash = $requestData['closing_cash'];
        $closingModel->save();

        foreach ($requestData['expenses'] as $expense) {
            if(array_key_exists('id', $expense)) {
                $expenseModel = Expense::find($expense['id']);
            } else {
                $expenseModel = new Expense;
            }
            
            $expenseModel->daily_closing_id = $closingModel->id;
            $expenseModel->amount = $expense['amount'];
            $expenseModel->remark = $expense['remark'];
            $expenseModel->save();
        }

        foreach ($requestData['deleted_expenses'] as $delExpense) {
           $deleteModel = Expense::find($delExpense);
           $deleteModel->delete();
        }

        $returnData = [];
        $returnData[$closingModel['date']] = [
            'total_sales' => $closingModel['sales'],
            'total_returns' => $closingModel['returns'],
            'total_expenses' => $closingModel['expenses'],
            'expected_closing_cash' => $closingModel['expected_closing_cash'],
            'expenses' => $closingModel->allExpenses,
            'closing_cash' => $closingModel['closing_cash'],
            'id' => $closingModel['id']
        ];   

        return $returnData;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function saveSalesReturn(Request $request)
    {
        $requestData = $request->all();
        $closingModel = DailyClosing::find($requestData['closing_date_id']);
        $closingModel->sales = $requestData['total_sales'];
        $closingModel->returns = $requestData['total_returns'];
        $closingModel->expected_closing_cash = $requestData['total_sales'] - $requestData['total_returns'] - $closingModel->expenses;
        $closingModel->save();
        return ;
    }
}
