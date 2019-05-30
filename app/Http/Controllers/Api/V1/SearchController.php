<?php

namespace App\Http\Controllers\Api\V1;

use App\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Movie as MovieResource;

class SearchController extends Controller
{

    public function search(Request $request)
    {
//        dd($request->keywords);
        $keywords = '%' . $request->keywords . '%';
        $movies = Movie::where('title', 'LIKE', $keywords)
                ->orWhere('title_en', 'LIKE', $keywords)
                ->get();
        return MovieResource::collection($movies);
    }

}
