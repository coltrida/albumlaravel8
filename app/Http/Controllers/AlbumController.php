<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Auth;


class AlbumController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Album::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $selectedCategory = null;
        $albums = Album::withCount('photos')
            ->where('user_id', Auth::id())->latest()->paginate(env('IMG_PER_PAGE'));
        $categories = auth()->user()->categories;
        return view('album.index', compact('albums', 'categories', 'selectedCategory'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function filtra(Request $request)
    {
        $selectedCategory = $request->category_id;
        $albums = Album::withCount('photos')
            ->where('user_id', Auth::id())
            ->whereHas('categories', function ($q) use($selectedCategory){
                $q->where('category_id', $selectedCategory);
            })
            ->latest()->paginate(env('IMG_PER_PAGE'));
        $categories = auth()->user()->categories;
        return view('album.index', compact('albums', 'categories', 'selectedCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $album = new Album();
        $categories = Category::orderBy('category_name')->get();
        $selectedCategories = [];
        return view('album.createalbum', compact('album', 'categories', 'selectedCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AlbumRequest $request
     * @return RedirectResponse
     */
    public function store(AlbumRequest $request)
    {
        $album = new Album();
        $album->album_name = $request->album_name;
        $album->description = $request->description;
        $album->user_id = Auth::id();
        $album->album_thumb = ' ';
        $album->save();
        $this->processFile($request, $album);
        $res = $album->save();

        if ($res && $request->has('categories')){
            $album->categories()->attach($request->categories);
        }

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
    //  $alb = Album::with('photos')->find($album->id);
        $images = Photo::latest()->wherealbumId($album->id)->paginate(env('IMG_PER_PAGE'));
        return view('photo.albumImages', compact('album', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Album $album
     * @return Factory|View
     */
    public function edit(Album $album)
    {
        /*if ($album->user_id !== Auth::id()){
            abort(401);
        }*/
        $categories = Category::orderBy('category_name')->get();
        $selectedCategories = $album->categories()->get()->pluck('id')->toArray();
        return view('album.editalbum', compact('album', 'categories', 'selectedCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AlbumRequest $request
     * @param Album $album
     * @return RedirectResponse
     */
    public function update(AlbumRequest $request, Album $album)
    {
        $album->album_name = $request->input('album_name');
        $album->description = $request->input('description');

        $this->processFile($request, $album);

        $res = $album->save();

        if ($res && $request->has('categories')){
            $album->categories()->sync($request->categories);
        }

        $message = $res ? "Album con id $album->id modificato" : 'Album non aggiornato';
        $tipo = $res ? 'success' : 'danger';
        session()->flash('message', $message);
        session()->flash('tipo', $tipo);
        return redirect()->route('albums.index');
    }


    public function destroy(Album $album)
    {
        $thumbNail = $album->album_thumb;
        $res = $album->delete();
        if ($res && $thumbNail && \Storage::exists($thumbNail)){
            \Storage::delete($thumbNail);
        }
        if (request()->ajax()) {
            return $res;
        }
        $message = $res ? "Album con id $album->id eliminato" : 'Album non aggiornato';
        $tipo = $res ? 'success' : 'danger';
        session()->flash('message', $message);
        session()->flash('tipo', $tipo);
        return redirect()->route('albums.index');
    }

    /**
     * @param Request $request
     * @param Album $album
     */
    private function processFile(Request $request, Album $album): void
    {
        if ($request->hasFile('album_thumb')) {
            $file = $request->file('album_thumb');
            $filename = $album->id . '.' . $file->extension();
            $filenameWithPath = $file->storeAs(env('ALBUM_THUMB_DIR'), $filename);
            $album->album_thumb = $filenameWithPath;
        }
    }
}
