<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
class AdminController extends Controller
{
    public function addTag(Request $request){
        $this->validate($request,[
            'tagName' => 'required'
        ]);
        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }


    public function editTag(Request $request)
    {
        // validate request
        $this->validate($request, [
            'tagName' => 'required',
            'id' => 'required',
        ]);
        return Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName,
        ]);
    }
public function getTag(Request $request){
    return Tag::orderBy('id', 'desc')->get();
   
}

public function deleteTag(Request $request)
{
    // validate request
    $this->validate($request, [
        'id' => 'required',
    ]);
    return Tag::where('id', $request->id)->delete();
}
}
