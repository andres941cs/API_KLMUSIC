<?php
namespace App\Http\Controllers;

use App\Models\Karaoke;
use Illuminate\Http\Request;

class SearchController extends Controller
{
        /**
     * Display a random resource.
     */
    public function random()
    {
        return Karaoke::inRandomOrder()->first();
    }
}