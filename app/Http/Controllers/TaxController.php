<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;
class TaxController extends Controller
{
    public function __construct(string $title = null) {
        $this->title = 'Tax';
        view()->share('title',$this->title);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('taxes.index');
    }

    public function getTaxes(Request $request)
    {
        $query = Tax::where(function($query) use ($request) {
            $query->orWhere('from', 'like', "%" . $request->search['value'] . "%");
        });
    
        $total = $query->count();
        $taxes = $query->skip($request->start)->take($request->length)->get(['id','from','to','tax_percent','amount']);
        return response()->json([
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $taxes->map(function($tax) {
                return [
                    'id' => $tax->id,
                    'from' => $tax->from,
                    'to' => $tax->to,
                    'tax_percent' => $tax->tax_percent,
                    'amount' => $tax->amount,
                    'action' => '<a href="'.route('taxes.edit',$tax->id).'" class="btn btn-sm btn-primary">Edit</a>' 
                ];
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = null;
        return view('taxes.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'to'   =>  'required',
            'tax_percent'  => 'required',
            'amount'   =>  'required'   
        ]);

        $tax = new Tax();
        $tax->fill($request->only(['from','to','tax_percent','amount']));
        $tax->save();
        return redirect()->route('taxes.index')->with('success','Tax Created Successfully');
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
        $data = Tax::find($id);
        return view('taxes.create',compact('data'));
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
        $request->validate([
            'from' => 'required',
            'to'   =>  'required',
            'tax_percent'  => 'required',
            'amount'   =>  'required'   
        ]);

        $tax = Tax::find($id);
        $tax->fill($request->only(['from','to','tax_percent','amount']));
        $tax->save();
        return redirect()->route('taxes.index')->with('success','Tax Created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $taxes = Tax::findOrFail($request->id);
        $taxes->delete();
        return redirect()->route('taxes.index')->with('success','Tax Deleted Successfully');
    }
}
