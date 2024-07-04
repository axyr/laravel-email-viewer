<?php

/** @var \Axyr\EmailViewer\Contracts\EmailMessage $email */
$routeNamespace = config('emailviewer.route-prefix')
?>
@foreach($emails as $email)
    <a href="{{ route($routeNamespace . '.show', $email->id()) }}">
        <div class="border-b p-3 text-sm hover:bg-gray-50 {{ url()->current() === route('emails.show', $email->id()) ? 'bg-gray-100' : '' }}">
            <h3 class="font-medium pb-1">
                {{ str($email->subject())->limit(35) }}
            </h3>
            <div class="grid grid-cols-6 w-full text-xs">
                <span class="col-span-4">To: {{ str($email->to())->limit(25) }}</span>
                <span class="col-span-2 text-right">{{ $email->date()->format('D H:i:s') }}</span>
            </div>
        </div>
    </a>
@endforeach
