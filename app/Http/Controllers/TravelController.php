<?php

namespace App\Http\Controllers;

use App\Http\Resources\TravelResource;
use App\Models\Travel;
use App\Utils\APIResponder;

class TravelController extends Controller
{
    use APIResponder;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $travels = Travel::public()->with('tours')->paginate();

        return $this->successResponse(TravelResource::collection($travels), "There's all the travels!!");
    }
}
