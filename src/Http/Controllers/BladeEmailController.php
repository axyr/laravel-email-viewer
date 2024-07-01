<?php

namespace Axyr\EmailViewer\Http\Controllers;

use Axyr\EmailViewer\Facades\Emails;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class BladeEmailController
{
    public function index(): View
    {
        $emails = Emails::server()->paginate();

        return view('email-viewer::index', compact('emails'));
    }

    public function show(string|int $id): View
    {
        $emails = Emails::paginate();
        $email = Emails::server()->find($id);

        abort_if(! $email, Response::HTTP_NOT_FOUND);

        return view('email-viewer::show', compact('emails', 'email'));
    }

    public function destroy(tring|int $id): RedirectResponse
    {
        Emails::delete($id);

        $routeNamespace = config('emailviewer.route-namespace');

        return redirect(route($routeNamespace . '.index'));
    }
}
