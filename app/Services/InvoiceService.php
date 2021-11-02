<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceService{
    
    public function create($request){
        $record = new Invoice();
        $items =  json_decode($request['items'], true);
        $record->due_date = $request['due_date'];
        $record->description = $request['description'];
        $record->tax_percentage = $request['tax_percentage'];

        //calculate tax and total amount
        $grand_total = 0;
        for($i=0; $i<count($items['data']); $i++){
            $grand_total += ($items['data'][$i]['quantity'] * $items['data'][$i]['unit_price']);
        }
        $tax_amount = (($request['tax_percentage']/100) * $grand_total);

        $record->tax_amount = $tax_amount;
        $record->grand_total = $grand_total;

        try{
            $record->save();
            //save items in the invoice
            try{
                $record->items()->createMany($items['data']);
            }catch(\Exception $e){
                return [
                    'message'=>'Error encountered while trying to save record.'. $e, 
                    'data'=>[], 
                    'status_code'=>501];
            }
        }catch(\Exception $e){
                return [
                    'message'=>'Error encountered while trying to save record.'. $e, 
                    'data'=>[], 
                    'status_code'=>501
                ];
        }
        
        return [
            "message"=>"Invoice successfully created", 
            "data"=>['invoice'=>$record, 'invoice_items'=>$record->items], 
            'status_code'=>201
        ];
        
    } 

    public function list(){
        try{
            $invoices = Invoice::all();
            $total_invoice_amount = 0;
            foreach($invoices as $invoice){
                $total_invoice_amount += $invoice->grand_total;
            }
            return [
                'message'=>'Records successfully fetched',
                'data'=>['invoice_count'=>count($invoices), 'total_invoice_amount'=>$total_invoice_amount, 'invoices_list'=>$invoices],
                'status_code'=> 202
            ];
        }catch(\Exception $e){
            return [
                'message'=>'Error occured while fetching records.'. $e, 
                'data'=>[], 
                'status_code'=>501
            ];
        }
    }
}