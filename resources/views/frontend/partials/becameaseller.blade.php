@if(auth::check())
<a class="d-flex align-items-center text-reset border-md-right pr-3 border-left-0">
    {{-- <i class="las la-truck-loading la-2x opacity-80"></i> --}}
    @php
        $user = auth::user();
    @endphp
    <span class="flex-grow-1 ml-1">      
        <span class="nav-box-text d-block d-xl-block d-md-none">{{$user->name}}</span>
    </span>
</a>
@else
<a href="{{ route('shops.create') }}" class="d-flex align-items-center text-reset border-md-right pr-3 border-left-0">
    <i class="las la-truck-loading la-2x opacity-80"></i>
    <span class="flex-grow-1 ml-1">      
        <span class="nav-box-text d-block d-xl-block d-md-none">{{translate('Sell on Sadar24')}}</span>
    </span>
</a>
@endif