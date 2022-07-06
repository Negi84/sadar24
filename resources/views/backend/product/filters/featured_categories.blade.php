@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Categories') }}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <button type="submit" onclick="addFeaturedCategoryRow(this)" class="btn btn-primary">{{ translate('Add new featured category') }}</button>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row gutters-10">
                <div class="col-lg-12">
                    <div class="card shadow-none border-none border-0" id="featuredCategoryRow">
                        @php
                            $i = 0;
                            $status = 'true';
                        @endphp
                        @while ($status == 'true')
                        {{-- {{dd(get_setting('featured_category_desktop_banner_'.$i.''))}} --}}
                            @if (get_setting('featured_category_' . $i, null, $lang) != null)
                                <div class="card-body bg-light mb-2">
                                    <form action="{{ route('business_settings.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        {{-- <input type="hidden" name="types[][{{ $lang }}]" value="featured_categories"> --}}
                                        <div class="form-group">
                                            <label>{{ translate('Title') }} ({{ translate('Translatable') }})</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="featured_category_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="Widget title"
                                                name="featured_category_{{ $i }}"
                                                value="{{ get_setting('featured_category_' . $i, null, $lang) }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="">{{ translate('Desktop banner') }}</label>
                                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ translate('Browse') }}</div>
                                                </div>
                                                <div class="form-control file-amount">{{ translate('Choose File') }}
                                                </div>
                                                <input type="hidden" name="types[]" value="featured_category_desktop_banner_{{$i}}">
                                                <input type="hidden" name="featured_category_desktop_banner_{{$i}}" class="selected-files"
                                                    value="{{ get_setting('featured_category_desktop_banner_'.$i.'') }}">
                                            </div>
                                            <div class="file-preview"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="">Mobile banner</label>
                                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ translate('Browse') }}</div>
                                                </div>
                                                <div class="form-control file-amount">{{ translate('Choose File') }}
                                                </div>
                                                <input type="hidden" name="types[]" value="featured_category_mobile_banner_{{$i}}">
                                                <input type="hidden" name="featured_category_mobile_banner_{{$i}}" class="selected-files"
                                                    value="{{ get_setting('featured_category_mobile_banner_'.$i.'') }}">
                                            </div>
                                            <div class="file-preview"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ translate('Links') }} - ({{ translate('Translatable') }}
                                                {{ translate('Label') }})</label>
                                            <div class="w3-links-target-{{$i}}">
                                                {{-- <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="featured_category_{{ $i }}_labels"> --}}
                                                <input type="hidden" name="types[]"
                                                    value="featured_category_{{ $i }}_links">
                                                @if (get_setting('featured_category_' . $i . '_links', null, $lang) != null)
                                                    @foreach (json_decode(get_setting('featured_category_' . $i . '_links', null, $lang), true) as $key => $value)
                                                        <div class="row gutters-5">
                                                            {{-- <div class="col-4">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="{{ translate('Label') }}"
                                                                        name="featured_category_{{ $i }}_labels[]"
                                                                        value="{{ $value }}">
                                                                </div>
                                                            </div> --}}
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="http://"
                                                                        name="featured_category_{{ $i }}_links[]"
                                                                        value="{{ json_decode(get_setting('featured_category_' . $i . '_links'), true)[$key] }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <button type="button"
                                                                    class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger"
                                                                    data-toggle="remove-parent" data-parent=".row">
                                                                    <i class="las la-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-soft-secondary btn-sm"
                                                data-toggle="add-more" data-content='<div class="row gutters-5">
												<div class="col">
												<div class="form-group">
												<input type="text" class="form-control" placeholder="http://" name="featured_category_{{ $i }}_links[]">
												</div>
												</div>
												<div class="col-auto">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
												</button>
												</div>
												</div>' data-target=".w3-links-target-{{$i}}">
                                                {{ translate('Add New') }}
                                            </button>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit"
                                                class="btn btn-primary">{{ translate('Update') }}</button>
                                        </div>
                                    </form>
                                </div>
                                @php $i = ++$i; @endphp
                            @else
                                @if ($i == 0)
                                    <div class="card-body bg-light mb-2">
                                        <form action="{{ route('business_settings.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>{{ translate('Title') }}
                                                    ({{ translate('Translatable') }})</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="featured_category_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="Widget title"
                                                    name="featured_category_{{ $i }}"
                                                    value="{{ get_setting('featured_category_' . $i, null, $lang) }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="">{{ translate('Desktop banner') }}</label>
                                                <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose File') }}
                                                    </div>
                                                    <input type="hidden" name="types[]" value="featured_category_desktop_banner_{{$i}}">
                                                    <input type="hidden" name="featured_category_desktop_banner_{{$i}}" class="selected-files"
                                                        value="{{ get_setting('featured_category_desktop_banner_'.$i.'') }}">
                                                </div>
                                                <div class="file-preview"></div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="">Mobile banner</label>
                                                <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose File') }}
                                                    </div>
                                                    <input type="hidden" name="types[]" value="featured_category_mobile_banner_{{$i}}">
                                                    <input type="hidden" name="featured_category_mobile_banner_{{$i}}" class="selected-files"
                                                        value="{{ get_setting('featured_category_mobile_banner_'.$i.'') }}">
                                                </div>
                                                <div class="file-preview"></div>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ translate('Links') }} - ({{ translate('Translatable') }}
                                                    {{ translate('Label') }})</label>
                                                <div class="w3-links-target-{{$i}}">
                                                    <input type="hidden" name="types[][{{ $lang }}]"
                                                        value="featured_category_{{ $i }}_labels">
                                                    <input type="hidden" name="types[]"
                                                        value="featured_category_{{ $i }}_links">
                                                    @if (get_setting('featured_category_' . $i . '_links', null, $lang) != null)
                                                        @foreach (json_decode(get_setting('featured_category_' . $i . '_links', null, $lang), true) as $key => $value)
                                                            <div class="row gutters-5">

                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="http://"
                                                                            name="featured_category_{{ $i }}_links[]"
                                                                            value="{{ json_decode(get_setting('featured_category_' . $i . '_links'), true)[$key] }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <button type="button"
                                                                        class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger"
                                                                        data-toggle="remove-parent" data-parent=".row">
                                                                        <i class="las la-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <button type="button" class="btn btn-soft-secondary btn-sm"
                                                    data-toggle="add-more" data-content='<div class="row gutters-5">
                                                    <div class="col">
                                                    <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="http://" name="featured_category_{{ $i }}_links[]">
                                                    </div>
                                                    </div>
                                                    <div class="col-auto">
                                                    <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
                                                    <i class="las la-times"></i>
                                                    </button>
                                                    </div>
                                                    </div>' data-target=".w3-links-target-{{$i}}">
                                                    {{ translate('Add New') }}
                                                </button>
                                            </div>
                                            <div class="text-right">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translate('Update') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                    @php $i = ++$i; @endphp
                                @else
                                    @php
                                        $status = 'false';
                                    @endphp
                                @endif
                            @endif
                        @endwhile
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('modal')
@endsection


@section('script')
<script>
	function addFeaturedCategoryRow(e){
		// console.log($("#footerLinkRow .card-body").children().length);
		var num = $("#featuredCategoryRow .card-body").children().length;
		var linkRow = `
		<div class="card-body bg-light mb-2">
                                    <form action="{{ route('business_settings.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>{{ translate('Title') }} ({{ translate('Translatable') }})</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="featured_category_`+num+`">
                                            <input type="text" class="form-control" placeholder="Widget title"
                                                name="featured_category_`+num+`"
                                                value="{{ get_setting('featured_category_`+num+`', null, $lang) }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="">{{ translate('Desktop banner') }}</label>
                                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ translate('Browse') }}</div>
                                                </div>
                                                <div class="form-control file-amount">{{ translate('Choose File') }}
                                                </div>
                                                <input type="hidden" name="types[]" value="featured_category_desktop_banner_`+num+`">
                                                <input type="hidden" name="featured_category_desktop_banner_`+num+`" class="selected-files"
                                                    value="{{ get_setting('featured_category_desktop_banner_'.$i.'') }}">
                                            </div>
                                            <div class="file-preview"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label"
                                                for="">Mobile banner</label>
                                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ translate('Browse') }}</div>
                                                </div>
                                                <div class="form-control file-amount">{{ translate('Choose File') }}
                                                </div>
                                                <input type="hidden" name="types[]" value="featured_category_mobile_banner_`+num+`">
                                                <input type="hidden" name="featured_category_mobile_banner_`+num+`" class="selected-files"
                                                    value="{{ get_setting('featured_category_mobile_banner_'.$i.'') }}">
                                            </div>
                                            <div class="file-preview"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ translate('Links') }} - ({{ translate('Translatable') }}
                                                {{ translate('Label') }})</label>
                                            <div class="w3-links-target-`+num+`">
                                                {{-- <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="featured_category_`+num+`_labels"> --}}
                                                <input type="hidden" name="types[]"
                                                    value="featured_category_`+num+`_links">
                                                @if (get_setting('featured_category_`+num+`' . '_links', null, $lang) != null)
                                                    @foreach (json_decode(get_setting('featured_category_`+num+`' . '_links', null, $lang), true) as $key => $value)
                                                        <div class="row gutters-5">
                                                            {{-- <div class="col-4">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="{{ translate('Label') }}"
                                                                        name="featured_category_`+num+`_labels[]"
                                                                        value="{{ $value }}">
                                                                </div>
                                                            </div> --}}
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="http://"
                                                                        name="featured_category_`+num+`_links[]"
                                                                        value="{{ json_decode(get_setting('featured_category_`+num+`' . '_links'), true)[$key] }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <button type="button"
                                                                    class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger"
                                                                    data-toggle="remove-parent" data-parent=".row">
                                                                    <i class="las la-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-soft-secondary btn-sm"
                                                data-toggle="add-more" data-content='<div class="row gutters-5">
												<div class="col">
												<div class="form-group">
												<input type="text" class="form-control" placeholder="http://" name="featured_category_`+num+`_links[]">
												</div>
												</div>
												<div class="col-auto">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
												</button>
												</div>
												</div>' data-target=".w3-links-target-`+num+`">
                                                {{ translate('Add New') }}
                                            </button>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit"
                                                class="btn btn-primary">{{ translate('Update') }}</button>
                                        </div>
                                    </form>
                                </div>
		`;
		$("#featuredCategoryRow").append(linkRow);
	}
</script>
@endsection
