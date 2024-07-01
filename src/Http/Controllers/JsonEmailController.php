<?php

namespace Axyr\EmailViewer\Http\Controllers;

use Axyr\EmailViewer\Facades\Emails;
use Axyr\EmailViewer\Http\Resources\EmailResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class JsonEmailController
{
    public function index(): ResourceCollection
    {
        $emails = Emails::server()->paginate();

        return EmailResource::collection($emails)->preserveQuery();
    }

    public function show(string|int $id): EmailResource
    {
        $email = Emails::find($id);

        abort_if(! $email, SymfonyResponse::HTTP_NOT_FOUND);

        return new EmailResource($email);
    }

    public function destroy(string|int $id): Response
    {
        Emails::delete($id);

        return response()->noContent();
    }
}
