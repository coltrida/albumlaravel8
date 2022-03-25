<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = Album::with('categories')->latest()->paginate(10);
        $category_id = null;
        return view('gallery.albums', compact('albums', 'category_id'));
    }

    public function showAlbumImages($album)
    {
        $images = Photo::whereAlbumId($album)->latest()->paginate(10);
        return view('gallery.images', compact('images'));
    }

    public function showCategoryAlbums(Category $category)
    {
        $albums = $category->albums()->with('categories')->latest()->paginate();
        $category_id = $category->id;
        return view('gallery.albums', compact('albums', 'category_id'));
    }
}
