<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPayment(Request $request)
    {
        // Obtener datos de la reserva desde la sesión
        $booking = session('current_booking');

        if (!$booking) {
            return redirect()->route('bookings.create')->with('error', 'No hay reserva activa. Por favor completa el formulario de reserva primero.');
        }

        return view('bookings.payment', compact('booking'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:nequi,daviplata,credit_card,debit_card,pse',
            'card_number' => 'required_if:payment_method,credit_card,debit_card',
            'card_expiry' => 'required_if:payment_method,credit_card,debit_card',
            'card_cvv' => 'required_if:payment_method,credit_card,debit_card'
        ]);

        try {
            // Simular procesamiento de pago
            $paymentSuccess = rand(0, 1); // 50% de probabilidad de éxito

            if ($paymentSuccess) {
                // Pago exitoso - redirigir a confirmación
                return redirect()->route('bookings.confirmation')->with('success', 'Pago procesado exitosamente.');
            } else {
                // Pago fallido
                return back()->with('error', 'El pago falló. Por favor intenta con otro método.');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }
}