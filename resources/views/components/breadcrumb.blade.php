<div class="breadcrumb">

    <a href="{{ url('/dashboard') }}" class="breadcrumb-home">
        <img src="{{ asset($item['icon']) }}" class="breadcrumb-icon">
        Dashboard
    </a>

    @if(isset($items))
        @foreach($items as $item)
            <span>/</span>

            @if(!$loop->last)
                <a href="{{ $item['url'] ?? '#' }}">
                    {{ $item['label'] }}
                </a>
            @else
                <span class="active">{{ $item['label'] }}</span>
            @endif
        @endforeach
    @endif

</div>