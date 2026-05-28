<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
   
    public function myReviews(Request $request)
    {
        // Solo cogemos las reseñas del usuario que ha iniciado sesión
        $reviews = $request->user()->reviews()->latest()->get();
        return view('reviews.my_reviews', compact('reviews'));
    }

    // Guarda la reseña desde la pestaña privada
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $request->user()->reviews()->create([
            'content' => $request->content,
        ]);

        return redirect()->route('mis-resenas')->with('success', '¡Telemetría publicada! Gracias por tu opinión.');
    }

    // Actualiza una reseña existente
    public function update(Request $request, Review $review)
    {
       
        if ($review->user_id !== $request->user()->id) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $review->update([
            'content' => $request->content,
        ]);

        return redirect()->route('mis-resenas')->with('success', 'Reseña actualizada correctamente en boxes.');
    }

    // Elimina una reseña propia si le pertenece claro
    public function userDestroy(Request $request, Review $review)
    {
        
        if ($review->user_id !== $request->user()->id) {
            abort(403);
        }

        $review->delete();
        return redirect()->route('mis-resenas')->with('success', 'Reseña eliminada de tu historial.');
    }


   

    public function index()
    {
        $reviews = Review::with('user')->latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->back()->with('success', 'Reseña eliminada de boxes permanentemente por el administrador.');
    }
}