<?php

namespace App\Http\Controllers\SubConstructor;

use App\SubConstructor;
use App\IdentityDocument;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSubConstructorIdentityDocumentRequest;
use App\Http\Requests\UpdateSubConstructorIdentityDocumentRequest;

class SubConstructorIdentityDocumentController extends Controller
{

    public function store(StoreSubConstructorIdentityDocumentRequest $request, $id)
    {           
        $sub_constructor = SubConstructor::findOrFail($id);
        $validated_data = $request->validated();
        $validated_data = $this->covertToStandardDateFormat($validated_data, ['issue_date','expiration_date',]);
        $identity_document = $sub_constructor->identityDocuments()->create($validated_data);
        if ( $request->hasFile('attachment') ) {
            $identity_document->addMedia($validated_data['attachment'])->toMediaCollection();
        }

        return redirect()
                     ->route('sub_constructors.edit', ['id' => $sub_constructor->id , '#IdentityDocumentSection'])
                     ->with('sub_constructor_identity_document', __("Sub Constructor Identity Document has been created successfully."));
    }

    public function edit($id, $identity_document_id)
    {
        $identity_document = IdentityDocument::findOrFail($identity_document_id);
        $identity_document->load(['media']);

        return view('sub_constructor.edit_identity_document', compact('identity_document'));
    }
    
    public function update(UpdateSubConstructorIdentityDocumentRequest $request, $id, $identity_document_id)
    {
        $identity_document = IdentityDocument::findOrFail($identity_document_id);
        $sub_constructor = SubConstructor::findOrFail($id);

        $validated_data = $request->validated();
        $validated_data = $this->covertToStandardDateFormat($validated_data, ['issue_date','expiration_date',]);

        if ( $request->hasFile('attachment') ) {
            $identity_document->clearMediaCollection();
            $identity_document->addMediaFromRequest('attachment')->toMediaCollection();
        }

        $identity_document->fill($validated_data);
        $identity_document->save();

        return redirect()
            ->route('sub_constructors.edit', ['id' => $id])
            ->with('update_sub_constructor_identity_document', __("Sub Constructor Identity Document as been updated successfully."));
    } 

    public function delete($id, $identity_document_id)
    {
        $identity_document = IdentityDocument::findOrFail($identity_document_id);
        $identity_document->delete();

        return redirect()
                ->route('sub_constructors.edit', ['id' => $id])
                ->with('status', "Identity Document : $identity_document->name has been successfully deleted.");
    }
}
