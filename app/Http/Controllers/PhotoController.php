<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoRequest;
use App\Models\Album;
use App\Models\Photo;
use Auth;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Photo::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $photos = Photo::get();
        return view('photo.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Album $album)
    {
        $albums = $this->getAlbums();
        return view('photo.createimage', compact('album', 'albums'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PhotoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PhotoRequest $request)
    {
        $photo = new Photo();
        $photo->name = $request->name;
        $photo->description = $request->description;
        $photo->album_id = $request->album_id;
        $photo->img_path = ' ';
        $photo->save();
        $this->processFile($photo, $request);
        $res = $photo->save();

        $message = $res ? "Photo creato con succeesso" : 'Photo non creato';
        $tipo = $res ? 'success' : 'danger';
        session()->flash('message', $message);
        session()->flash('tipo', $tipo);
        return redirect()->route('albums.show', $photo->album_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Photo $photo)
    {
        $albums = $this->getAlbums();
        return view('photo.editimage', compact('photo', 'albums'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PhotoRequest $request
     * @param \App\Models\Photo $photo
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PhotoRequest $request, Photo $photo)
    {
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $photo->album_id = $request->album_id;

        $this->processFile($photo, $request);

        $res = $photo->save();
        $message = $res ? "Photo con id $photo->id modificato" : 'Photo non aggiornato';
        $tipo = $res ? 'success' : 'danger';
        session()->flash('message', $message);
        session()->flash('tipo', $tipo);
        return redirect()->route('albums.show', $photo->album_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return bool
     */
    public function destroy(Photo $photo)
    {
        $res = $photo->delete();
        if ($res){
            $this->deleteFoto($photo);
        }
        return  $res;
    }

    /**
     * @param Request $request
     * @param Photo $photo
     */
    private function processFile(Photo $photo, Request $request): void
    {
        if ($request->hasFile('img_path')) {
            $file = $request->file('img_path');
            $filename = $photo->id . '.' . $file->extension();
            $filenameWithPath = $file->storeAs(env('IMG_DIR'), $filename);
            $photo->img_path = $filenameWithPath;
        }
    }

    /**
     * @param Photo $photo
     * @return bool
     */
    private function deleteFoto(Photo $photo)
    {
        if ($photo->img_path && \Storage::exists($photo->img_path)){
            return \Storage::delete($photo->img_path);
        }
        return false;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    private function getAlbums()
    {
        return Album::whereUserId(Auth::id())->orderBy('album_name')->get();
    }
}
