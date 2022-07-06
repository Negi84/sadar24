@extends('frontend.layouts.user_panel')

@section('panel_content')

    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Products') }}</h1>
            </div>
        </div>
    </div>

    <div class="row gutters-10 justify-content-center">
        @if (addon_is_activated('seller_subscription'))
            <div class="col-md-4 mx-auto mb-3">
                <div class="bg-grad-1 text-white rounded-lg overflow-hidden">
                    <span
                        class="size-30px rounded-circle mx-auto bg-soft-primary d-flex align-items-center justify-content-center mt-3">
                        <i class="las la-upload la-2x text-white"></i>
                    </span>
                    <div class="px-3 pt-3 pb-3">
                        <div class="h4 fw-700 text-center">{{ max(0, Auth::user()->seller->remaining_uploads) }}</div>
                        <div class="opacity-50 text-center">{{ translate('Remaining Uploads') }}</div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-4 mx-auto mb-3">
            <a href="{{ route('seller.products.upload') }}">
                <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition">
                    <span
                        class="size-60px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                        <i class="las la-plus la-3x text-white"></i>
                    </span>
                    <div class="fs-18 text-primary">{{ translate('Add New Product') }}</div>
                </div>
            </a>
        </div>

        @if (addon_is_activated('seller_subscription'))
            @php
                $seller_package = \App\SellerPackage::find(Auth::user()->seller->seller_package_id);
            @endphp
            <div class="col-md-4">
                <a href="{{ route('seller_packages_list') }}"
                    class="text-center bg-white shadow-sm hov-shadow-lg text-center d-block p-3 rounded">
                    @if ($seller_package != null)
                        <img src="{{ uploaded_asset($seller_package->logo) }}" height="44" class="mw-100 mx-auto">
                        <span class="d-block sub-title mb-2">{{ translate('Current Package') }}:
                            {{ $seller_package->getTranslation('name') }}</span>
                    @else
                        <i class="la la-frown-o mb-2 la-3x"></i>
                        <div class="d-block sub-title mb-2">{{ translate('No Package Found') }}</div>
                    @endif
                    <div class="btn btn-outline-primary py-1">{{ translate('Upgrade Package') }}</div>
                </a>
            </div>
        @endif

    </div>
    @php
    //$shop = \App\Shop::where('user_id', Auth::user()->id);
    /* echo "<pre>";
                   print_r(Auth::user()->seller->user->shop->holiday);
                   die; */
    $holiday = Auth::user()->seller->user->shop->holiday;
    @endphp
    <div class="card">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ translate('All Products') }}</h5>
            </div>
            <label>On Vacation</label>
            <div class="col-md-1">
                <label class="aiz-switch aiz-switch-success mb-0">

                    <input onchange="update_seller_on_vacation(this)" value="{{ Auth::user()->id }}" type="checkbox"
                        <?php if ($holiday == 1) {
                            echo 'checked="checked"';
                        } ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <form class="" action="" method="GET">
                        <input type="text" class="form-control" id="search" name="search"
                            @isset($search) value="{{ $search }}" @endisset
                            placeholder="{{ translate('Search product') }}">
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th width="30%">{{ translate('Name') }}</th>
                        <th data-breakpoints="md">{{ translate('Category') }}</th>
                        <th data-breakpoints="md">{{ translate('Current Qty') }}</th>
                        <th>{{ translate('MRP') }}</th>
                        <th>{{ translate('selling Price') }}</th>
                        <th data-breakpoints="md">{{ translate('Published') }}</th>
                        <th data-breakpoints="md">{{ translate('Approved') }}</th>
                        <th data-breakpoints="md" class="text-right">{{ translate('Options') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $key => $product)
                        @php
                            $photos = explode(',', $product->photos);
                        @endphp
                        <tr>
                            <td>{{ $key + 1 + ($products->currentPage() - 1) * $products->perPage() }}</td>
                            <td>
                                <a href="{{ route('product', $product->slug) }}" target="_blank" class="text-reset">
                                    <div class="row gutters-5 w-200px w-md-300px mw-100">
                                        <div class="col-auto">
                                            <img src="{{ uploaded_asset($photos[0]) }}" alt="Image"
                                                class="size-50px img-fit">
                                        </div>
                                        <div class="col">
                                            <span
                                                class="text-muted text-truncate-2">{{ $product->getTranslation('name') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                @if ($product->category != null)
                                    {{ $product->category->getTranslation('name') }}
                                @endif
                            </td>
                            <td>
                                @php
                                    $qty = 0;
                                    foreach ($product->stocks as $key => $stock) {
                                        $qty += $stock->qty;
                                    }
                                    echo $qty;
                                @endphp
                            </td>
                            <td>{{ $product->unit_price }}</td>
                            <td>{{ $product->unit_price - $product->discount }}</td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    @if ($product->published == 1)
                                        <span class="badge badge-inline badge-success">Published</span>
                                    @else
                                        <span class="badge badge-inline badge-danger">Unpublished</span>
                                    @endif
                                </label>
                            </td>

                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    @if ($product->approved == 1)
                                        <span class="badge badge-inline badge-success">Approved</span>
                                    @else
                                        <span class="badge badge-inline badge-danger">Pending</span>
                                    @endif
                                </label>
                            </td>

                            <td class="text-right">
                                <a class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                    href="{{ route('seller.products.edit', ['id' => $product->id, 'lang' => env('DEFAULT_LANGUAGE')]) }}"
                                    title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                                <a class="btn btn-soft-success btn-icon btn-circle btn-sm" {{-- href="{{ route('products.duplicate', $product->id) }}" --}}
                                    {{-- data-bs-toggle="modal" data-bs-target="#dubPorduct" --}}
                                    onclick="dubProd('{{ route('products.duplicate', $product->id) }}')"
                                    title="{{ translate('Duplicate') }}">
                                    <i class="las la-copy"></i>
                                </a>
                                {{-- href="{{ route('products.duplicate', $product->id) }}" --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{-- {{dd($products->links())}} --}}
                {{ $products->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')

    <!-- Confirm Dublicate Modal -->
    <div class="modal fade" id="dubProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="GET" id="dubProductM">
                    <div class="modal-body">
                        <h5>Are you sure you wanna duplicate this product!?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-success" onclick="submitbtn(this)">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Confirm Dublicate Modal -->
@endsection

@section('script')
    <script type="text/javascript">
        function dubProd(e) {
            document.getElementById("dubProductM").setAttribute("action", e);
            $("#dubProduct").modal("show");
        }

        function submitbtn(e) {
            e.disabled = true;
            document.getElementById("dubProductM").submit();
            //Validation code goes here
        }

        function update_featured(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.seller.featured') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Featured products updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function update_published(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.published') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Published products updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function update_seller_on_vacation(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('products.seller-on-vacation') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Vacation updated successfully') }}');
                    location.reload();
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
