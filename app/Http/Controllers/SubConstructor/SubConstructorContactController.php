<?php

namespace App\Http\Controllers\SubConstructor;

use App\Contact;
use App\SubConstructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubConstructorContactRequest;
use App\Http\Requests\UpdateSubConstructorContactRequest;

class SubConstructorContactController extends Controller
{

    public function store(StoreSubConstructorContactRequest $request, $id)
    {   
        $sub_constructor = SubConstructor::findOrFail($id);   
        $validated_data = $request->validated();        
        $sub_constructor->contacts()->create($validated_data); 

        return redirect()
                ->route('sub_constructors.edit', ['id' => $sub_constructor->id , '#ContactSection'])
                ->with('sub_constructor_contact', __("Sub Constructor Contact has been created successfully."));
    }

    public function edit($id, $contact_id)
    {
        $contact = Contact::findOrFail($contact_id);
        
        return view('sub_constructor.edit_contact', compact('contact'));
       
    }
    public function update(UpdateSubConstructorContactRequest $request, $id, $contact_id)
    {
        $contact = Contact::findOrFail($contact_id);
        $validated_data = $request->validated();
   
        $contact->fill($validated_data);
        $contact->save();
        
        return redirect()
            ->route('sub_constructors.edit', ['id' => $id])
            ->with('update_sub_constructor_contact', __("Sub Constructor Contact has been updated successfully."));
    } 

    public function showDeleteForm($id, $contact_id) 
    {
        $contact = Contact::findOrFail($contact_id);
        
        return view('sub_constructor.delete_contact',compact('contact'));
    }  

    public function delete($id, $contact_id)
    {
        $contact = Contact::findOrFail($contact_id);
        $contact->delete();

        return redirect()
                ->route('sub_constructors.edit', ['id' => $id])
                ->with('status', "Contact : $contact->name has been successfully deleted.");
    }
}
