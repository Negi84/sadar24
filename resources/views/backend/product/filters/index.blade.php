@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('All Filters')}}</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="{{ route('filters.create') }}" class="btn btn-primary">
                <span>{{translate('Add New Filter')}}</span>
            </a>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header d-block d-md-flex">
        <h5 class="mb-0 h6">{{ translate('filters') }}</h5>
        <form class="" id="sort_filters" action="" method="GET">
            <div class="box-inline pad-rgt pull-left">
                <div class="" style="min-width: 200px;">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th>{{translate('Filter Name')}}</th>
                    <th data-breakpoints="lg">{{ translate('Parent Category') }}</th>
                    <th data-breakpoints="lg">{{ translate('Attribute Column') }}</th>
                    <th width="10%" class="text-right">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($filters as $key => $filter)
                    <tr>
                        <td>{{ ($key+1) + ($filters->currentPage() - 1)*$filters->perPage() }}</td>
                        <td>{{ $filter->column_name }}</td>
                        <td>
                            @php
                                $parent = \App\Category::where('id', $filter->category_id)->first();
                            @endphp
                            @if ($parent != null)
                                {{ $parent->name }}
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @php
                                $filter_attributes = DB::table('column_attributes')->where('column_id', $filter->id)->get();
                            @endphp
                            @foreach($filter_attributes as $key => $value)
                            <span class="badge badge-inline badge-md bg-soft-dark">{{ $value->attribute_name }}</span>
                            @endforeach
                        </td>
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('filters.edit', ['id'=>$filter->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                <i class="las la-edit"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('filters.destroy', $filter->id)}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
            {{ $filters->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection


@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
    
    </script>
@endsection
