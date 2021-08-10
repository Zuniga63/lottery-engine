<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CustomerController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $name = $request->query('name', null);
    $allCustomers = Customer::where('first_name', 'like', "%$name%")
      ->orderBy('first_name')
      ->orderBy('last_name')
      ->withCount('tickets as tickets')
      ->withSum('payments as paymentAmount', 'amount')
      ->get();

    return Inertia::render('Customers/Index', compact('allCustomers'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return Inertia::render('Customers/Create');
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
      'first_name' => 'required|string|min:3|max:45',
      'last_name' => 'nullable|string|min:3|max:45',
      'nit' => 'nullable|string|max:20|unique:customer,nit',
      'phone' => 'nullable|string|min:10|max:20|unique:customer,phone',
      'address' => 'nullable|string|max:100'
    ]);

    $customer = Customer::create($request->all());

    return Redirect::route('customers.index')->with('success', [
      'title' => '¡Cliente Registrado!',
      'message' => "Se ha registrado al cliente $customer->first_name $customer->last_name"
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function show(Customer $customer)
  {
    $customer->load([
      'tickets' => function($query) {
        $query->with('payments')->withSum('payments', 'amount');
      }
    ]);

    return Inertia::render('Customers/Show', compact('customer'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function edit(Customer $customer)
  {
    return Inertia::render('Customers/Edit', compact('customer'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Customer $customer)
  {
    $request->validate([
      'first_name' => 'required|string|min:3|max:45',
      'last_name' => 'nullable|string|min:3|max:45',
      'nit' => 'nullable|string|max:20|unique:customer,nit,' . $customer->id,
      'phone' => 'nullable|string|min:10|max:20|unique:customer,phone,' . $customer->id,
      'address' => 'nullable|string|max:100'
    ]);

    $customer->update($request->all());

    return Redirect::route('customers.index')->with('success', [
      'title' => '¡Cliente Actualizado!',
      'message' => "Se ha actualizado al cliente $customer->first_name $customer->last_name"
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function destroy(Customer $customer)
  {
    $tickets = $customer->tickets()->count();
    $error = null;
    $success = null;

    if($tickets){
      $error = [
        'title' => "¡Cliente no Eliminado!",
        'message' => "Este cliente no se puede eliminar porque tiene boletos asignados"
      ];
    }else{
      $customer->delete();
      $success = [
        'title' => "¡Cliente Eliminado!",
        'message' => "El cliente $customer->first_name fue eliminado de la plataforma."
      ];
    }

    return Redirect::route('customers.index')->with('success', $success)->with('error', $error);
  }
}
