<?php

namespace App\Http\Controllers;

use App\Http\Resources\PositionsResource;
use App\Models\Position;

class PositionController extends Controller
{
    public function getAll(): PositionsResource{
        return new PositionsResource(Position::whereStatus(true)->get());
    }

}
