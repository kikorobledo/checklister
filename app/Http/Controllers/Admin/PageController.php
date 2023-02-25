<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;

class PageController extends Controller
{

    public function welcome(){
        return view('home');
    }

    public function edit(Page $page): View
    {
         return view('admin.pages.edit', compact('page'));
    }

    public function update(StorePageRequest $request, Page $page)
    {
        $page->update($request->validated());

        return redirect()->route('admin.pages.edit', $page)->with('message', __('Success') );
    }

}
