<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppDownloadController extends Controller
{	
	public function showIOSDownloadView(Request $request) 
	{
		return view('app_download');
	}

	public function showIOSDevDownloadView(Request $request) 
	{
		return view('app_download_dev');
	}
}
