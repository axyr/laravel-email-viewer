<section class="flex flex-row flex-wrap h-full">
    @foreach($tabs as $tab)
        <input id="tab-{{ $loop->index }}" type="radio" name="tabs" class="peer/tab-{{ $loop->index }} opacity-0 absolute" {{ $loop->first ? 'checked' : '' }} />
        <label for="tab-{{ $loop->index }}" class="cursor-pointer peer-checked/tab-{{ $loop->index }}:border-b-2 ml-3 p-3 block">
            {{ $tab['title'] }}
        </label>
    @endforeach
    <div class="basis-full h-0 border-b"></div>
    @foreach($tabs as $tab)
        <div class="hidden peer-checked/tab-{{ $loop->index }}:block pt-6 p-3 w-full h-full overflow-y-scroll">
            {!! $tab['content'] !!}
        </div>
    @endforeach
</section>
