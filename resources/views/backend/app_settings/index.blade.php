@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Featured Cards') }}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <button type="submit" onclick="addFeaturedCardRow(this)"
                    class="btn btn-primary">{{ translate('Add new featured card') }}</button>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row gutters-10">
                <div class="col-lg-12">
                    <div class="card shadow-none border-none border-0" id="featuredCardRow">
                        @php
                            $i = 0;
                            $status = 'true';
                        @endphp
                        @while ($status == 'true')
                            {{-- {{dump(get_setting('featured_card_1'))}} --}}
                            @if (get_setting('featured_card_'.$i, null, $lang) != null)
                                <div class="card-body bg-light mb-2">
                                    <form action="{{ route('business_settings.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="types[][{{ $lang }}]"
                                            value="featured_card_{{ $i }}">
                                        <input type="hidden" name="featured_card_{{ $i }}" value="true">
                                        <div class="form-group">
                                            <label>{{ translate('Featured Offer Card Title') }}
                                                ({{ translate('Translatable') }})</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="offer_card_title_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="Widget title"
                                                name="offer_card_title_{{ $i }}"
                                                value="{{ get_setting('offer_card_title_' . $i, null, $lang) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>{{ translate('Card Background Color') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="offer_card_bg_color_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="Card Background Color"
                                                name="offer_card_bg_color_{{ $i }}"
                                                value="{{ get_setting('offer_card_bg_color_' . $i, null, $lang) }}">
                                        </div>
                                        <div class="form-group border-1 border p-2">
                                            <label class="form-label"
                                                for="">{{ translate('First Offer Card Image') }}</label>
                                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ translate('Browse') }}</div>
                                                </div>
                                                <div class="form-control file-amount">{{ translate('Choose File') }}
                                                </div>
                                                <input type="hidden" name="types[]"
                                                    value="first_offer_card_img_{{ $i }}">
                                                <input type="hidden" name="first_offer_card_img_{{ $i }}"
                                                    class="selected-files"
                                                    value="{{ get_setting('first_offer_card_img_' . $i . '') }}">
                                            </div>
                                            <div class="file-preview"></div>
                                            <label class="mt-2">{{ translate('Category') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="first_offer_category_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="category"
                                                name="first_offer_category_{{ $i }}"
                                                value="{{ get_setting('first_offer_category_' . $i, null, $lang) }}">
                                            <label class="mt-2">{{ translate('Offer') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="first_offer_heading_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="Offer"
                                                name="first_offer_heading_{{ $i }}"
                                                value="{{ get_setting('first_offer_heading_' . $i, null, $lang) }}">
                                            <label class="mt-2">{{ translate('Link Slug') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="first_offer_link_slug_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="Link Slug"
                                                name="first_offer_link_slug_{{ $i }}"
                                                value="{{ get_setting('first_offer_link_slug_' . $i, null, $lang) }}">
                                        </div>
                                        <div class="form-group border-1 border p-2">
                                            <label class="form-label"
                                                for="">{{ translate('Second Offer Card Image') }}</label>
                                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ translate('Browse') }}</div>
                                                </div>
                                                <div class="form-control file-amount">{{ translate('Choose File') }}
                                                </div>
                                                <input type="hidden" name="types[]"
                                                    value="second_offer_card_img_{{ $i }}">
                                                <input type="hidden" name="second_offer_card_img_{{ $i }}"
                                                    class="selected-files"
                                                    value="{{ get_setting('second_offer_card_img_' . $i . '') }}">
                                            </div>
                                            <div class="file-preview"></div>
                                            <label class="mt-2">{{ translate('Category') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="second_offer_category_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="category"
                                                name="second_offer_category_{{ $i }}"
                                                value="{{ get_setting('second_offer_category_' . $i, null, $lang) }}">
                                            <label class="mt-2">{{ translate('Offer') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="second_offer_heading_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="Offer"
                                                name="second_offer_heading_{{ $i }}"
                                                value="{{ get_setting('second_offer_heading_' . $i, null, $lang) }}">
                                            <label class="mt-2">{{ translate('Link Slug') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="second_offer_link_slug_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="Link Slug"
                                                name="second_offer_link_slug_{{ $i }}"
                                                value="{{ get_setting('second_offer_link_slug_' . $i, null, $lang) }}">
                                        </div>
                                        <div class="form-group border-1 border p-2">
                                            <label class="form-label"
                                                for="">{{ translate('Third Offer Card Image') }}</label>
                                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ translate('Browse') }}</div>
                                                </div>
                                                <div class="form-control file-amount">{{ translate('Choose File') }}
                                                </div>
                                                <input type="hidden" name="types[]"
                                                    value="third_offer_card_img_{{ $i }}">
                                                <input type="hidden" name="third_offer_card_img_{{ $i }}"
                                                    class="selected-files"
                                                    value="{{ get_setting('third_offer_card_img_' . $i . '') }}">
                                            </div>
                                            <div class="file-preview"></div>
                                            <label class="mt-2">{{ translate('Category') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="third_offer_category_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="category"
                                                name="third_offer_category_{{ $i }}"
                                                value="{{ get_setting('third_offer_category_' . $i, null, $lang) }}">
                                            <label class="mt-2">{{ translate('Offer') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="third_offer_heading_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="Offer"
                                                name="third_offer_heading_{{ $i }}"
                                                value="{{ get_setting('third_offer_heading_' . $i, null, $lang) }}">
                                            <label class="mt-2">{{ translate('Link Slug') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="third_offer_link_slug_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="Link Slug"
                                                name="third_offer_link_slug_{{ $i }}"
                                                value="{{ get_setting('third_offer_link_slug_' . $i, null, $lang) }}">
                                        </div>
                                        <div class="form-group border-1 border p-2">
                                            <label class="form-label"
                                                for="">{{ translate('Fourth Offer Card Image') }}</label>
                                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ translate('Browse') }}</div>
                                                </div>
                                                <div class="form-control file-amount">{{ translate('Choose File') }}
                                                </div>
                                                <input type="hidden" name="types[]"
                                                    value="fourth_offer_card_img_{{ $i }}">
                                                <input type="hidden" name="fourth_offer_card_img_{{ $i }}"
                                                    class="selected-files"
                                                    value="{{ get_setting('fourth_offer_card_img_' . $i . '') }}">
                                            </div>
                                            <div class="file-preview"></div>
                                            <label class="mt-2">{{ translate('Category') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="fourth_offer_category_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="category"
                                                name="fourth_offer_category_{{ $i }}"
                                                value="{{ get_setting('fourth_offer_category_' . $i, null, $lang) }}">
                                            <label class="mt-2">{{ translate('Offer') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="fourth_offer_heading_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="Offer"
                                                name="fourth_offer_heading_{{ $i }}"
                                                value="{{ get_setting('fourth_offer_heading_' . $i, null, $lang) }}">
                                            <label class="mt-2">{{ translate('Link Slug') }}</label>
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="fourth_offer_link_slug_{{ $i }}">
                                            <input type="text" class="form-control" placeholder="Link Slug"
                                                name="fourth_offer_link_slug_{{ $i }}"
                                                value="{{ get_setting('fourth_offer_link_slug_' . $i, null, $lang) }}">
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
                                            <input type="hidden" name="types[][{{ $lang }}]"
                                                value="featured_card_{{ $i }}">
                                            <input type="hidden" name="featured_card_{{ $i }}" value="true">
                                            <div class="form-group">
                                                <label>{{ translate('Featured Offer Card Title') }}
                                                    ({{ translate('Translatable') }})</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="offer_card_title_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="Widget title"
                                                    name="offer_card_title_{{ $i }}"
                                                    value="{{ get_setting('offer_card_title_' . $i, null, $lang) }}">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ translate('Card Background Color') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="offer_card_bg_color_{{ $i }}">
                                                <input type="text" class="form-control"
                                                    placeholder="Card Background Color"
                                                    name="offer_card_bg_color_{{ $i }}"
                                                    value="{{ get_setting('offer_card_bg_color_' . $i, null, $lang) }}">
                                            </div>
                                            <div class="form-group border-1 border p-2">
                                                <label class="form-label"
                                                    for="">{{ translate('First Offer Card Image') }}</label>
                                                <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose File') }}
                                                    </div>
                                                    <input type="hidden" name="types[]"
                                                        value="first_offer_card_img_{{ $i }}">
                                                    <input type="hidden" name="first_offer_card_img_{{ $i }}"
                                                        class="selected-files"
                                                        value="{{ get_setting('first_offer_card_img_' . $i . '') }}">
                                                </div>
                                                <div class="file-preview"></div>
                                                <label class="mt-2">{{ translate('Category') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="first_offer_category_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="category"
                                                    name="first_offer_category_{{ $i }}"
                                                    value="{{ get_setting('first_offer_category_' . $i, null, $lang) }}">
                                                <label class="mt-2">{{ translate('Offer') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="first_offer_heading_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="Offer"
                                                    name="first_offer_heading_{{ $i }}"
                                                    value="{{ get_setting('first_offer_heading_' . $i, null, $lang) }}">
                                                <label class="mt-2">{{ translate('Link Slug') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="first_offer_link_slug_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="Link Slug"
                                                    name="first_offer_link_slug_{{ $i }}"
                                                    value="{{ get_setting('first_offer_link_slug_' . $i, null, $lang) }}">
                                            </div>
                                            <div class="form-group border-1 border p-2">
                                                <label class="form-label"
                                                    for="">{{ translate('Second Offer Card Image') }}</label>
                                                <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose File') }}
                                                    </div>
                                                    <input type="hidden" name="types[]"
                                                        value="second_offer_card_img_{{ $i }}">
                                                    <input type="hidden" name="second_offer_card_img_{{ $i }}"
                                                        class="selected-files"
                                                        value="{{ get_setting('second_offer_card_img_' . $i . '') }}">
                                                </div>
                                                <div class="file-preview"></div>
                                                <label class="mt-2">{{ translate('Category') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="second_offer_category_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="category"
                                                    name="second_offer_category_{{ $i }}"
                                                    value="{{ get_setting('second_offer_category_' . $i, null, $lang) }}">
                                                <label class="mt-2">{{ translate('Offer') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="second_offer_heading_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="Offer"
                                                    name="second_offer_heading_{{ $i }}"
                                                    value="{{ get_setting('second_offer_heading_' . $i, null, $lang) }}">
                                                <label class="mt-2">{{ translate('Link Slug') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="second_offer_link_slug_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="Link Slug"
                                                    name="second_offer_link_slug_{{ $i }}"
                                                    value="{{ get_setting('second_offer_link_slug_' . $i, null, $lang) }}">
                                            </div>
                                            <div class="form-group border-1 border p-2">
                                                <label class="form-label"
                                                    for="">{{ translate('Third Offer Card Image') }}</label>
                                                <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">
                                                        {{ translate('Choose File') }}
                                                    </div>
                                                    <input type="hidden" name="types[]"
                                                        value="third_offer_card_img_{{ $i }}">
                                                    <input type="hidden" name="third_offer_card_img_{{ $i }}"
                                                        class="selected-files"
                                                        value="{{ get_setting('third_offer_card_img_' . $i . '') }}">
                                                </div>
                                                <div class="file-preview"></div>
                                                <label class="mt-2">{{ translate('Category') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="third_offer_category_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="category"
                                                    name="third_offer_category_{{ $i }}"
                                                    value="{{ get_setting('third_offer_category_' . $i, null, $lang) }}">
                                                <label class="mt-2">{{ translate('Offer') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="third_offer_heading_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="Offer"
                                                    name="third_offer_heading_{{ $i }}"
                                                    value="{{ get_setting('third_offer_heading_' . $i, null, $lang) }}">
                                                <label class="mt-2">{{ translate('Link Slug') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="third_offer_link_slug_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="Link Slug"
                                                    name="third_offer_link_slug_{{ $i }}"
                                                    value="{{ get_setting('third_offer_link_slug_' . $i, null, $lang) }}">
                                            </div>
                                            <div class="form-group border-1 border p-2">
                                                <label class="form-label"
                                                    for="">{{ translate('Fourth Offer Card Image') }}</label>
                                                <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">
                                                        {{ translate('Choose File') }}
                                                    </div>
                                                    <input type="hidden" name="types[]"
                                                        value="fourth_offer_card_img_{{ $i }}">
                                                    <input type="hidden" name="fourth_offer_card_img_{{ $i }}"
                                                        class="selected-files"
                                                        value="{{ get_setting('fourth_offer_card_img_' . $i . '') }}">
                                                </div>
                                                <div class="file-preview"></div>
                                                <label class="mt-2">{{ translate('Category') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="fourth_offer_category_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="category"
                                                    name="fourth_offer_category_{{ $i }}"
                                                    value="{{ get_setting('fourth_offer_category_' . $i, null, $lang) }}">
                                                <label class="mt-2">{{ translate('Offer') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="fourth_offer_heading_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="Offer"
                                                    name="fourth_offer_heading_{{ $i }}"
                                                    value="{{ get_setting('fourth_offer_heading_' . $i, null, $lang) }}">
                                                <label class="mt-2">{{ translate('Link Slug') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="fourth_offer_link_slug_{{ $i }}">
                                                <input type="text" class="form-control" placeholder="Link Slug"
                                                    name="fourth_offer_link_slug_{{ $i }}"
                                                    value="{{ get_setting('fourth_offer_link_slug_' . $i, null, $lang) }}">
                                            </div>
                                            <div class="text-right">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translate('Update') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- </div> --}}
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
        function addFeaturedCardRow(e) {
            // console.log($("#footerLinkRow .card-body").children().length);
            var num = $("#featuredCardRow .card-body").children().length;
            var linkRow =
                `
			<div class="card-body bg-light mb-2">
                                        <form action="{{ route('business_settings.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="types[][{{ $lang }}]" value="featured_card_` +
                num + `">
                                            <input type="hidden" name="featured_card_` + num + `"value="true">
                                            <div class="form-group">
                                                <label>{{ translate('Featured Offer Card Title') }}
                                                    ({{ translate('Translatable') }})</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="offer_card_title_` + num + `">
                                                <input type="text" class="form-control" placeholder="Widget title"
                                                    name="offer_card_title_` + num + `"
                                                    value="{{ get_setting('offer_card_title_`+num+`', null, $lang) }}">
                                            </div>
                                            <div class="form-group">
                                                <label>{{ translate('Card Background Color') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="offer_card_bg_color_` + num + `">
                                                <input type="text" class="form-control"
                                                    placeholder="Card Background Color"
                                                    name="offer_card_bg_color_` + num + `"
                                                    value="{{ get_setting('offer_card_bg_color_`+num+`', null, $lang) }}">
                                            </div>
                                            <div class="form-group border-1 border p-2">
                                                <label class="form-label"
                                                    for="">{{ translate('First Offer Card Image') }}</label>
                                                <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose File') }}
                                                    </div>
                                                    <input type="hidden" name="types[]"
                                                        value="first_offer_card_img_` + num + `">
                                                    <input type="hidden" name="first_offer_card_img_` + num + `"
                                                        class="selected-files"
                                                        value="{{ get_setting('first_offer_card_img_`+num+`' . '') }}">
                                                </div>
                                                <div class="file-preview"></div>
                                                <label class="mt-2">{{ translate('Category') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="first_offer_category_` + num + `">
                                                <input type="text" class="form-control" placeholder="category"
                                                    name="first_offer_category_` + num + `"
                                                    value="{{ get_setting('first_offer_category_`+num+`', null, $lang) }}">
                                                <label class="mt-2">{{ translate('Offer') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="first_offer_heading_` + num + `">
                                                <input type="text" class="form-control" placeholder="Offer"
                                                    name="first_offer_heading_` + num + `"
                                                    value="{{ get_setting('first_offer_heading_`+num+`', null, $lang) }}">
                                                <label class="mt-2">{{ translate('Link Slug') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="first_offer_link_slug_` + num + `">
                                                <input type="text" class="form-control" placeholder="Link Slug"
                                                    name="first_offer_link_slug_` + num + `"
                                                    value="{{ get_setting('first_offer_link_slug_`+num+`', null, $lang) }}">
                                            </div>
                                            <div class="form-group border-1 border p-2">
                                                <label class="form-label"
                                                    for="">{{ translate('Second Offer Card Image') }}</label>
                                                <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose File') }}
                                                    </div>
                                                    <input type="hidden" name="types[]"
                                                        value="second_offer_card_img_` + num + `">
                                                    <input type="hidden" name="second_offer_card_img_` + num + `"
                                                        class="selected-files"
                                                        value="{{ get_setting('second_offer_card_img_`+num+`' . '') }}">
                                                </div>
                                                <div class="file-preview"></div>
                                                <label class="mt-2">{{ translate('Category') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="second_offer_category_` + num + `">
                                                <input type="text" class="form-control" placeholder="category"
                                                    name="second_offer_category_` + num + `"
                                                    value="{{ get_setting('second_offer_category_`+num+`', null, $lang) }}">
                                                <label class="mt-2">{{ translate('Offer') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="second_offer_heading_` + num + `">
                                                <input type="text" class="form-control" placeholder="Offer"
                                                    name="second_offer_heading_` + num + `"
                                                    value="{{ get_setting('second_offer_heading_`+num+`', null, $lang) }}">
                                                <label class="mt-2">{{ translate('Link Slug') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="second_offer_link_slug_` + num + `">
                                                <input type="text" class="form-control" placeholder="Link Slug"
                                                    name="second_offer_link_slug_` + num + `"
                                                    value="{{ get_setting('second_offer_link_slug_`+num+`', null, $lang) }}">
                                            </div>
											<div class="form-group border-1 border p-2">
                                                <label class="form-label"
                                                    for="">{{ translate('Third Offer Card Image') }}</label>
                                                <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose File') }}
                                                    </div>
                                                    <input type="hidden" name="types[]"
                                                        value="third_offer_card_img_` + num + `">
                                                    <input type="hidden" name="third_offer_card_img_` + num + `"
                                                        class="selected-files"
                                                        value="{{ get_setting('third_offer_card_img_`+num+`' . '') }}">
                                                </div>
                                                <div class="file-preview"></div>
                                                <label class="mt-2">{{ translate('Category') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="third_offer_category_` + num + `">
                                                <input type="text" class="form-control" placeholder="category"
                                                    name="third_offer_category_` + num + `"
                                                    value="{{ get_setting('third_offer_category_`+num+`', null, $lang) }}">
                                                <label class="mt-2">{{ translate('Offer') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="third_offer_heading_` + num + `">
                                                <input type="text" class="form-control" placeholder="Offer"
                                                    name="third_offer_heading_` + num + `"
                                                    value="{{ get_setting('third_offer_heading_`+num+`', null, $lang) }}">
                                                <label class="mt-2">{{ translate('Link Slug') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="third_offer_link_slug_` + num + `">
                                                <input type="text" class="form-control" placeholder="Link Slug"
                                                    name="third_offer_link_slug_` + num + `"
                                                    value="{{ get_setting('third_offer_link_slug_`+num+`', null, $lang) }}">
                                            </div>
											<div class="form-group border-1 border p-2">
                                                <label class="form-label"
                                                    for="">{{ translate('Fourth Offer Card Image') }}</label>
                                                <div class="input-group " data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose File') }}
                                                    </div>
                                                    <input type="hidden" name="types[]"
                                                        value="fourth_offer_card_img_` + num + `">
                                                    <input type="hidden" name="fourth_offer_card_img_` + num + `"
                                                        class="selected-files"
                                                        value="{{ get_setting('fourth_offer_card_img_`+num+`' . '') }}">
                                                </div>
                                                <div class="file-preview"></div>
                                                <label class="mt-2">{{ translate('Category') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="fourth_offer_category_` + num + `">
                                                <input type="text" class="form-control" placeholder="category"
                                                    name="fourth_offer_category_` + num + `"
                                                    value="{{ get_setting('fourth_offer_category_`+num+`', null, $lang) }}">
                                                <label class="mt-2">{{ translate('Offer') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="fourth_offer_heading_` + num + `">
                                                <input type="text" class="form-control" placeholder="Offer"
                                                    name="fourth_offer_heading_` + num + `"
                                                    value="{{ get_setting('fourth_offer_heading_`+num+`', null, $lang) }}">
                                                <label class="mt-2">{{ translate('Link Slug') }}</label>
                                                <input type="hidden" name="types[][{{ $lang }}]"
                                                    value="fourth_offer_link_slug_` + num + `">
                                                <input type="text" class="form-control" placeholder="Link Slug"
                                                    name="fourth_offer_link_slug_` + num + `"
                                                    value="{{ get_setting('fourth_offer_link_slug_`+num+`', null, $lang) }}">
                                            </div>
                                            <div class="text-right">
                                                <button type="submit"
                                                    class="btn btn-primary">{{ translate('Update') }}</button>
                                            </div>
                                        </form>
                                    </div>
		`;
            $("#featuredCardRow").append(linkRow);
        }
    </script>
@endsection
