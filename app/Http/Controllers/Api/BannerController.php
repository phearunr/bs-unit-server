<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Http\Resources\Banner as BannerResource;
use App\Http\Resources\BannerCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
   	public function index(Request $request) 
   	{
   		return new BannerCollection(
   			Banner::active()
   				  ->orderBy('order')
   				  ->get()
   		);
   	}
}
