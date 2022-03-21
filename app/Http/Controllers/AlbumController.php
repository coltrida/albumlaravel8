<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $albums = Album::withCount('photos')->latest()->get();
        return view('album.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $album = new Album();
        return view('album.createalbum', compact('album'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $album = new Album();
        $album->album_name = $request->album_name;
        $album->description = $request->description;
        $album->user_id = \Auth::user()->id;

        $this->processFile($request, $album);

        $res = $album->save();
        $message = $res ? "Album creato con succeesso" : 'Album non creato';
        $tipo = $res ? 'success' : 'danger';
        session()->flash('message', $message);
        session()->flash('tipo', $tipo);
        return redirect()->route('albums.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Album $album
     * @return Factory|View
     */
    public function show(Album $album)
    {
        $alb = Album::with('photos')->find($album->id);
        return view('photo.albumImages', compact('alb'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Album $album
     * @return Factory|View
     */
    public function edit(Album $album)
    {
        return view('album.editalbum', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Album $album
     * @return RedirectResponse
     */
    public function update(Request $request, Album $album)
    {
        $album->album_name = $request->input('album_name');
        $album->description = $request->input('description');

        $this->processFile($request, $album);

        $res = $album->save();
        $message = $res ? "Album con id $album->id modificato" : 'Album non aggiornato';
        $tipo = $res ? 'success' : 'danger';
        session()->flash('message', $message);
        session()->flash('tipo', $tipo);
        return redirect()->route('albums.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Album $album
     * @return bool
     */
    public function destroy(Album $album)
    {
        $thumbNail = $album->album_thumb;
        $res = $album->delete();
        if ($res && $thumbNail && \Storage::exists($thumbNail)){
            \Storage::delete($thumbNail);
        }
        return $res;
    }

    /**
     * @param Request $request
     * @param Album $album
     */
    private function processFile(Request $request, Album &$album): void
    {
        if ($request->hasFile('album_thumb')) {
            $file = $request->file('album_thumb');
            $filename = $album->id . '.' . $file->extension();
            $filenameWithPath = $file->storeAs(env('IMG_DIR'), $filename);
            $album->album_thumb = $filenameWithPath;
        }
    }
}
