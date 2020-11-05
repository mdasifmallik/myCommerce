@if ($paginator->lastPage() > 1)
    <ul class="page-numbers">
        <li>
            @if ($paginator->currentPage() == 1)
                <span style="background: none; color: #EF4836"><i class="fa fa-arrow-left"></i></span>
            @else
                <a class="prev page-numbers" href="{{ $paginator->url(1) }}"><i class="fa fa-arrow-left"></i></a>
            @endif
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li>
                @if ($paginator->currentPage() == $i)
                    <span class="page-numbers current">{{ $i }}</span>
                @else
                    <a class="page-numbers" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                @endif
            </li>
        @endfor
        <li>
            @if ($paginator->currentPage() == $paginator->lastPage())
                <span style="background: none; color: #EF4836"><i class="fa fa-arrow-right"></i></span>
            @else
                <a class="next page-numbers" href="{{ $paginator->url($paginator->currentPage()+1) }}" ><i class="fa fa-arrow-right"></i></a>
            @endif
        </li>
    </ul>
@endif
