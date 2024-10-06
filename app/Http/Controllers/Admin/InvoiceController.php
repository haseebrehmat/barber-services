<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Invoice;
use App\Models\Admin\InvoiceItem;
use Illuminate\Http\Request;
use PDF;
use DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('admin.invoice_builder.index', ['invoices' => $invoices]);
    }

    public function create()
    {
        return view('admin.invoice_builder.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number' => 'required|unique:invoices,number|max:100',
            'street' => 'sometimes|max:225',
            'city' => 'sometimes|max:225',
            'country' => 'sometimes|max:225',
            'state' => 'sometimes|max:225',
            'issue_date' => 'required|date',
            'client_name' => 'required|max:225',
            'client_email' => 'required|max:225',
            'status' => 'required|in:paid,unpaid,draft',
            'tax' => 'sometimes',
            'items.*.description' => 'required|max:500',
            'items.*.qty' => 'required|numeric',
            'items.*.unit_price' => 'required|numeric',
        ]);

        $invoice = Invoice::create($data);
        if (isset($data['items'])) {
            $invoice->items()->createMany($data['items']);
        }

        return redirect()->route('invoice-builder.index')->with('success', 'Invoice is built successfully!');
    }

    public function edit($id)
    {
        $invoice = Invoice::find($id);
        if (isset($invoice)) {
            return view('admin.invoice_builder.edit', ['invoice' => $invoice]);
        }
        return redirect()->route('invoice-builder.index')->with('error', 'Invoice not found!');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'number' => 'required|unique:invoices,number,' . $id . '|max:100',
            'street' => 'sometimes|max:225',
            'city' => 'sometimes|max:225',
            'country' => 'sometimes|max:225',
            'state' => 'sometimes|max:225',
            'issue_date' => 'required|date',
            'client_name' => 'required|max:225',
            'client_email' => 'required|max:225',
            'status' => 'required|in:paid,unpaid,draft',
            'tax' => 'sometimes',
            'items.*.id' => 'sometimes|exists:invoice_items,id',
            'items.*.description' => 'required|max:500',
            'items.*.qty' => 'required|numeric',
            'items.*.unit_price' => 'required|numeric',
        ]);

        $invoice = Invoice::find($id);
        if (isset($invoice)) {

            $invoice->update($data);
            if (!empty($data['items'])) {
                foreach ($data['items'] as $value) {
                    if (isset($value['id'])) {
                        InvoiceItem::find($value['id'])->update(['description' => $value['description'], 'qty' => $value['qty'], 'unit_price' => $value['unit_price']]);
                    } else {
                        $invoice->items()->create($value);
                    }
                }
            }
            return redirect()->route('invoice-builder.index')->with('success', 'Invoice is updated successfully!');
        }
        return redirect()->route('invoice-builder.index')->with('error', 'Invoice not found!');
    }

    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        if (isset($invoice)) {
            $invoice->items()->delete();
            $invoice->delete();
            return redirect()->route('invoice-builder.index')->with('success', 'Invoice is removed successfully!');
        }
        return redirect()->route('invoice-builder.index')->with('error', 'Invoice not found!');
    }
    public function deleteItem($id)
    {
        $item = InvoiceItem::find($id);
        if (isset($item)) {
            $item->delete();
            return redirect()->back()->with('success', 'Invoice Item is removed successfully!');
        }
        return redirect()->route('invoice-builder.index')->with('error', 'Invoice Item is not found!');
    }

    public function getInvoice(Request $request)
    {
        $invoice = Invoice::find($request['id']);
        if (isset($invoice)) {
            $g_setting = DB::table('general_settings')->where('id', 1)->first();
            $pdf = PDF::loadView('admin.invoice_builder.show', [
                'invoice' => $invoice,
                'g_setting' => $g_setting,
            ]);
            return $pdf->download(time() . ".invoice.pdf");
        }
        return redirect()->route('invoice-builder.index')->with('error', 'Invoice not found!');
    }

    public function thermal_invoice(Request $request)
    {
        $invoice = Invoice::find($request['id']);
        if (isset($invoice)) {
            $g_setting = DB::table('general_settings')->where('id', 1)->first();
            $pdf = PDF::loadView('admin.invoice_builder.thermal', [
                'invoice' => $invoice,
                'g_setting' => $g_setting,
            ]);
            return $pdf->stream(time() . ".thermal_invoice.pdf");
        }
        return redirect()->route('invoice-builder.index')->with('error', 'Invoice not found!');
    }
}
