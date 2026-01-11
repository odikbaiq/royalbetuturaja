<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Mail\ContactReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Exception;

class ContactController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->get();
        return view('admin.contact.index', compact('messages'));
    }

    public function show($id)
    {
        // Gunakan nama variabel yang unik agar tidak bentrok di Blade
        $contactMessage = ContactMessage::findOrFail($id);

        // Tandai sudah dibaca
        if (!$contactMessage->is_read) {
            $contactMessage->update(['is_read' => true]);
        }

        return view('admin.contact.show', compact('contactMessage'));
    }

    public function reply(Request $request, $id)
{
    $request->validate([
        'reply_content' => 'required|string|min:5',
    ]);

    $contactMessage = ContactMessage::findOrFail($id);

    try {
        // Pastikan variabel yang dikirim ke class ContactReply adalah $contactMessage
        Mail::to($contactMessage->email)->send(new ContactReply($contactMessage, $request->reply_content));

        $contactMessage->update(['status' => 'replied']);

        return redirect()->route('admin.contact.show', $id)
                         ->with('success', 'Balasan berhasil dikirim.');
    } catch (\Exception $e) {
        return redirect()->route('admin.contact.show', $id)
                         ->with('error', 'Gagal: ' . $e->getMessage());
    }
}
}
