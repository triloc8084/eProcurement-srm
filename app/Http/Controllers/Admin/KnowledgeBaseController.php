<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KnowledgeBaseController extends Controller
{
    public function index()
    {
        $articles = KnowledgeBase::where('created_by', Auth::id())->latest()->paginate(10);
        return view('admin.knowledge-base.index', compact('articles'));
    }



    public function create()
    {
        return view('admin.knowledge-base.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'document_path' => 'nullable|string', // simplified for now (no file upload to save time)
        ]);
        
        $validated['created_by'] = Auth::id();

        KnowledgeBase::create($validated);

        return redirect()->route('admin.knowledge-base.index')->with('success', 'Article created successfully.');
    }

    public function edit(KnowledgeBase $knowledgeBase)
    {
        if ($knowledgeBase->created_by !== Auth::id()) {
            abort(403);
        }
        return view('admin.knowledge-base.edit', compact('knowledgeBase'));
    }




    public function update(Request $request, KnowledgeBase $knowledgeBase)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'document_path' => 'nullable|string',
        ]);

        $knowledgeBase->update($validated);

        return redirect()->route('admin.knowledge-base.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(KnowledgeBase $knowledgeBase)
    {
        $knowledgeBase->delete();
        return redirect()->route('admin.knowledge-base.index')->with('success', 'Article deleted successfully.');
    }
}
