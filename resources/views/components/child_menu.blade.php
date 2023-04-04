@if ($cat->cat_child->count())
    <ul class="sub-menu">
        @foreach ($cat->cat_child as $item)
            @if ($item->status == 1)
                <li>
                    <a href="{{ route('product.cat', $item->slug) }}" title="">{{ $item->name }}</a>
                    @if ($item->cat_child->count())
                        @include('components.child_menu', ['cat' => $item])
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
@endif
