<?php

namespace App\Http\Controllers;

use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function create(Request $request)
    {
        $invoice = $this->invoiceService->create($request);
        return response([$invoice['message'], $invoice['data']], $invoice['status_code']);
    }

    public function get(){
        $invoices = $this->invoiceService->list();
        return response([$invoices['message'], $invoices['data']], $invoices['status_code']);
    }
}
