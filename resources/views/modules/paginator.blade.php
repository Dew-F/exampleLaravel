@if ($paginator->hasPages())
<div class="paginator">
        @foreach ($elements[0] as $page => $url)
        @if ($page == $paginator->currentPage())
            <a class="active"><span>{{ $page }}</span></a>
        @else
            <a href="{{ $url }}"><span>{{ $page }}</span></a>
        @endif
        @endforeach
</div>
@endif
