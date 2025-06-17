<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Merchant;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // Store a new note for a specific merchant
    public function store(Request $request, $merchantId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $merchant = Merchant::findOrFail($merchantId);

        $note = Note::create([
            'merchant_id' => $merchant->id,
            'title' => $request->title,
            'content' => $request->content,
            'priority' => $request->priority,
        ]);

        return response()->json([
            'message' => 'Note created successfully',
            'note' => $note
        ], 201);
    }

    // Update an existing note
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $note = Note::findOrFail($id);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
            'priority' => $request->priority,
        ]);

        return response()->json([
            'message' => 'Note updated successfully',
            'note' => $note
        ]);
    }

    // Delete a note
    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return response()->json([
            'message' => 'Note deleted successfully'
        ]);
    }

    // Search notes with optional filters: keyword, date
    public function search(Request $request)
    {
        $query = Note::query()->with('merchant');

        // Keyword search (title, content)
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');

            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%$keyword%")
                  ->orWhere('content', 'like', "%$keyword%")
                  ->orWhereHas('merchant', function ($q) use ($keyword) {
                      $q->where('name', 'like', "%$keyword%");
                  });
            });
        }

        // Filter by specific date (UTC-based)
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        // Filter by merchant ID
        if ($request->has('merchant_id')) {
            $query->where('merchant_id', $request->input('merchant_id'));
        }

        $notes = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'notes' => $notes
        ]);
    }
}
