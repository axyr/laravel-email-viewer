<?php
/** @var \Axyr\EmailViewer\Contracts\EmailMessage $email */

?>
<div class="p-3 border-b overflow-y-hidden">
    <h2 class="text-2xl">{{ $email->subject() }}</h2>
    <div class="pt-3 text-sm">
        <table>
            <tbody class="[&>tr>th]:text-left [&>tr>th]:font-medium [&>tr>td]:text-gray-500 [&>tr>*]:py-1">
            <tr>
                <th>From:</th>
                <td><h2>{{ $email->from() }}</h2></td>
            </tr>
            <tr>
                <th>To:</th>
                <td><h2>{{ $email->to() }}</h2></td>
            </tr>
            <tr>
                <th>Date:</th>
                <td><h2>{{ $email->date() }}</h2></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="h-full overflow-y-hidden">
    @include('email-viewer::tabs.tabs', ['tabs' => [
        [
            'title' => 'HTML',
            'content' => view('email-viewer::tabs.html', compact('email'))
        ],
        [
            'title' => 'Headers',
            'content' => view('email-viewer::tabs.headers', compact('email')),
        ],
        [
            'title' => 'Raw',
            'content' => nl2br(htmlentities($email->raw()))
        ],
    ]])
</div>
