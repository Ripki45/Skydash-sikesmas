<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->get();
        return view('tag.index', ['tags' => $tags]);
    }

    public function store(Request $request)
    {
        $request->validate(['nama_tag' => 'required|string|max:255|unique:tags']);
        Tag::create([
            'nama_tag' => $request->nama_tag,
            'slug' => Str::slug($request->nama_tag, '-'),
        ]);
        return redirect()->route('admin.tag.index')->with('success', 'Tag baru berhasil ditambahkan.');
    }

    public function edit(Tag $tag)
    {
        $tags = Tag::latest()->get();
        return view('tag.index', ['tags' => $tags, 'tagToEdit' => $tag]);
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate(['nama_tag' => 'required|string|max:255|unique:tags,nama_tag,' . $tag->id]);
        $tag->update([
            'nama_tag' => $request->nama_tag,
            'slug' => Str::slug($request->nama_tag, '-'),
        ]);
        return redirect()->route('admin.tag.index')->with('success', 'Tag berhasil diperbarui.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tag.index')->with('success', 'Tag berhasil dihapus.');
    }
}
