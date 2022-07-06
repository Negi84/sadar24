<div class="">
    @if (count($products) > 0)
        <!--<div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary">{{translate('Category Suggestions')}}</div>-->

        <ul class="list-group list-group-raw">
            @foreach ($products as $key => $product)
                <li class="list-group-item py-1">
                    <a class="text-reset hov-text-primary" href="{{ route('product', $product->slug) }}">{{  $product->getTranslation('name')  }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
