<div class="border rounded-md bg-white w-full">
    <table class="w-full">
        <tbody class="[&>tr>th]:text-left [&>tr>th]:font-medium [&>tr>td]:text-gray-500 [&>tr>*]:p-2">
        @foreach($email->headers() as $name => $value)
            <tr class="{{ $loop->last ? '' : 'border-b' }}">
                <th>{{ ucfirst(str_replace('x-', '', $name)) }}:</th>
                <td>{{ $value }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
