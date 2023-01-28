<?php

namespace App\Http\Controllers\SubConstructor;

use App\Skill;
use App\SubConstructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubConstructorSkillController extends Controller
{
    public function update(Request $request, $id)
    {   
        $sub_constructor = SubConstructor::where('id', $id)->firstOrFail();

        $sub_constructor->skills()->sync($request->skills);
       
        return redirect()
                ->route('sub_constructors.edit', ['id' => $sub_constructor->id , '#SkillSection'])
                ->with('sub_constructor_skill', __("Sub Constructor Skill has been update successfully."));
    }
}
