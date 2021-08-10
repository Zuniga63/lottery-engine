<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\LotteryTicket;
use App\Models\LotteryTicketPayment;
use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LotteryTicketController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $allTickets = LotteryTicket::orderBY('payment_date')
      ->orderBy('first_option')
      ->orderBy('second_option')
      ->with([
        'seller:id,first_name,last_name',
        'customer:id,first_name,last_name'
      ])
      ->withSum('payments as payments', 'amount')
      ->get();

    return Inertia::render('Tickets/Index', compact('allTickets'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $sellers = Seller::orderBy('first_name')->get(['id', 'first_name', 'last_name']);
    $customers = Customer::orderBy('first_name')->get(['id', 'first_name', 'last_name']);
    return Inertia::render('Tickets/Create', compact('sellers', 'customers'));
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
      'customer_id' => 'required|integer|exists:customer,id',
      'seller_id' => 'required|integer|exists:seller,id',
      'first_option' => 'required|string|min:3|max:3|unique:lottery_ticket,first_option,NULL|unique:lottery_ticket,second_option',
      'second_option' => 'required|string|min:3|max:3|unique:lottery_ticket,second_option|unique:lottery_ticket,first_option',
    ]);

    LotteryTicket::create($request->all());

    return Redirect::route('tickets.index');
  }

  public function storePayment(Request $request)
  {
    $request->validate([
      'lottery_ticket_id' => 'required|integer|exists:lottery_ticket,id',
      'customer_id' => 'required|integer|exists:customer,id',
      'seller_id' => 'required|integer|exists:seller,id',
      'amount' => 'required|numeric|min:1000|max:50000'
    ]);

    $success = null;
    $error = null;

    //Se recupera el ticket
    $inputs = $request->all();
    $ticket = LotteryTicket::find($inputs['lottery_ticket_id']);
    //Se recuperan los abonos
    $payments = $ticket->payments()->sum('amount');
    if ($payments) {
      $payments = intval($payments);
      $amount = intval($inputs['amount']);
      if ($payments < 50000) {
        $balance = 50000 - $payments;
        $message = null;
        /**
         * Si el importe a abonar es menor que el saldo se agrega la
         * transacción común y corriente, pero si es mayor o igual entonces se salda 
         * la boleta. En ambos casos el proceso es satisfactorio.
         */
        if ($amount < $balance) {
          $ticket->payments()->create($inputs);
          $message = "Se ha abonado el dinero al boleto.";
        } else {
          //Se abona el saldo
          $inputs['amount'] = $balance;
          $ticket->payments()->create($inputs);
          //Se actualiza el ticket
          $ticket->payment_date = Carbon::now();
          $ticket->save();
          $message = "Se ha cancelado el boleto.";
        }

        $success = [
          'title' => "Abono Registrado",
          'message' => $message
        ];
      } else {
        $error = [
          'title' => 'No Abonado',
          'message' => 'Este boleto y está pagado.'
        ];
      }
    } else {
      $ticket->payments()->create($inputs);
      $amount = intval($inputs['amount']);
      if ($amount === 50000) {
        //Se actualiza el ticket
        $ticket->payment_date = Carbon::now();
        $ticket->save();
      }
      $success = [
        'title' => '¡Abono Registrado!',
        'message' => "Se ha registrado el abono correctamente."
      ];
    }

    // return Redirect::route('tickets.show', $ticket->id)->with([
    //   'success' => $success,
    //   'error' => $error
    // ]);
    return Redirect::back()->with([
      'success' => $success,
      'error' => $error
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\LotteryTicket  $lotteryTicket
   * @return \Illuminate\Http\Response
   */
  public function show(LotteryTicket $lotteryTicket)
  {
    $customer = $lotteryTicket->customer()->first(['id', 'first_name', 'last_name']);
    $seller = $lotteryTicket->seller()->first(['id', 'first_name', 'last_name']);
    $data = [
      'seller' => $seller,
      'customer' => $customer,
      'ticket' => $lotteryTicket,
      'payments' => $lotteryTicket->payments()->orderBy('created_at')->get(),
    ];
    return Inertia::render('Tickets/Show', compact('data'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\LotteryTicket  $lotteryTicket
   * @return \Illuminate\Http\Response
   */
  public function destroy(LotteryTicket $lotteryTicket)
  {
    $payments = $lotteryTicket->payments()->count();
    $error = null;
    $success = null;
    if ($payments) {
      $error = [
        'title' => '¡Boleto no Borrado!',
        'message' => 'El boleto no se puede borrar porque presenta pagos a favor del cliente.'
      ];
    } else {
      $success = [
        'title' => '¡Boleto Eliminado!',
        'message' => "Los numero \"$lotteryTicket->first_option - $lotteryTicket->second_option\" fueron eliminados y ya se encuentran disponibles para otro cliente.",
      ];

      $lotteryTicket->delete();
    }

    return Redirect::route('tickets.index')->with([
      'success' => $success,
      'error' => $error
    ]);
  }

  /**
   * Remove the specified resource from storage
   * @param  \App\Models\LotteryTicket  $lotteryTicket
   * @return \Illuminate\Http\Response
   */
  public function destroyPayment(LotteryTicketPayment $lotteryTicketPayment)
  {
    DB::beginTransaction();
    $ticket = $lotteryTicketPayment->lotteryTicket()->first(['id', 'payment_date']);
    if ($ticket->payment_date) {
      $ticket->payment_date = null;
      $ticket->save();
    }

    $lotteryTicketPayment->delete();
    DB::commit();

    // return Redirect::route('tickets.show', $ticket->id)->with('success', true);
    return Redirect::back()->with('success', true);
  }
}
