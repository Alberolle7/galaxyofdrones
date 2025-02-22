<?php

namespace Koodilab\Http\Controllers\Api;

use Koodilab\Http\Controllers\Controller;
use Koodilab\Models\Rank;
use Koodilab\Transformers\RankTransformer;

class RankController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('verified');
        $this->middleware('player');
    }

    /**
     * Show the PvE in json format.
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function pve(RankTransformer $transformer)
    {
        return $transformer->transformCollection(
            Rank::paginatePveUsers()
        );
    }

    /**
     * Show the PvP in json format.
     *
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function pvp(RankTransformer $transformer)
    {
        return $transformer->transformCollection(
            Rank::paginatePvpUsers()
        );
    }
}
