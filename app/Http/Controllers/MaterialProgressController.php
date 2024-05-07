<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialProgress;

class MaterialProgressController extends Controller
{
    // Method to mark material as done
    public function markAsDone(Request $request)
    {
        // Validate the request data if needed
        $request->validate([
            'material_id' => 'required|exists:materials,id',
        ]);

        // Get the authenticated user
        $user = auth()->user();

        // Check if the material progress record already exists for the user and material
        $progress = MaterialProgress::where('student_id', $user->id)
            ->where('material_id', $request->material_id)
            ->first();

        // If the progress record exists, update it, otherwise create a new record
        if ($progress) {
            $progress->update(['is_completed' => !$progress->is_completed]);
            return back()->with('mark_not_done', 'Marked as not done.');
        } else {
            MaterialProgress::create([
                'student_id' => $user->id,
                'material_id' => $request->material_id,
                'is_completed' => true,
                'is_assessment' => 0,
            ]);
        }

        // You can return a response or redirect the user as needed
        return back()->with('mark_done', 'Marked as done.');
    }

    
}
