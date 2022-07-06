@extends('backend.layouts.app')
@section('content')

<div class="row">
	<div class="col-xl-10 mx-auto">
		<h6 class="fw-600">{{ translate('Home Page Settings') }}</h6>

		{{-- App Slider --}}
		<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('App Slider') }}</h6>
			</div>
			<div class="card-body">
				<div class="alert alert-info">
					{{ translate('We have limited banner height to maintain UI. We had to crop from both left & right side in view for different devices to make it responsive. Before designing banner keep these points in mind.') }}
				</div>
				<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>{{ translate('Photos & Links') }}</label>
						<div class="home-slider-target">
							<input type="hidden" name="types[]" value="home_slider_images">
							<input type="hidden" name="types[]" value="home_slider_links">
							@if (get_setting('home_slider_images') != null)
								@foreach (json_decode(get_setting('home_slider_images'), true) as $key => $value)
									<div class="row gutters-5">
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
					                                <div class="input-group-prepend">
					                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
					                                </div>
					                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="types[]" value="home_slider_images">
					                                <input type="hidden" name="home_slider_images[]" class="selected-files" value="{{ json_decode(get_setting('home_slider_images'), true)[$key] }}">
					                            </div>
					                            <div class="file-preview box sm">
					                            </div>
				                            </div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<input type="hidden" name="types[]" value="home_slider_links">
												<input type="text" class="form-control" placeholder="http://" name="home_slider_links[]" value="{{ json_decode(get_setting('home_slider_links'), true)[$key] }}">
											</div>
										</div>
										<div class="col-md-auto">
											<div class="form-group">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						</div>
						<button
							type="button"
							class="btn btn-soft-secondary btn-sm"
							data-toggle="add-more"
							data-content='
							<div class="row gutters-5">
								<div class="col-md-5">
									<div class="form-group">
										<div class="input-group" data-toggle="aizuploader" data-type="image">
											<div class="input-group-prepend">
												<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
											</div>
											<div class="form-control file-amount">{{ translate('Choose File') }}</div>
											<input type="hidden" name="types[]" value="home_slider_images">
											<input type="hidden" name="home_slider_images[]" class="selected-files">
										</div>
										<div class="file-preview box sm">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group">
										<input type="hidden" name="types[]" value="home_slider_links">
										<input type="text" class="form-control" placeholder="http://" name="home_slider_links[]">
									</div>
								</div>
								<div class="col-md-auto">
									<div class="form-group">
										<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
											<i class="las la-times"></i>
										</button>
									</div>
								</div>
							</div>'
							data-target=".home-slider-target">
							{{ translate('Add New') }}
						</button>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>

		{{-- Website Slider --}}
		<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('Website Slider') }}</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>{{ translate('Banner & Links') }}</label>
						<div class="home-banner1-target">
							<input type="hidden" name="types[]" value="home_banner1_images">
							<input type="hidden" name="types[]" value="home_banner1_links">
							@if (get_setting('home_banner1_images') != null)
								@foreach (json_decode(get_setting('home_banner1_images'), true) as $key => $value)
									<div class="row gutters-5">
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
					                                <div class="input-group-prepend">
					                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
					                                </div>
					                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="types[]" value="home_banner1_images">
					                                <input type="hidden" name="home_banner1_images[]" class="selected-files" value="{{ json_decode(get_setting('home_banner1_images'), true)[$key] }}">
					                            </div>
					                            <div class="file-preview box sm">
					                            </div>
				                            </div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<input type="hidden" name="types[]" value="home_banner1_links">
												<input type="text" class="form-control" placeholder="http://" name="home_banner1_links[]" value="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}">
											</div>
										</div>
										<div class="col-md-auto">
											<div class="form-group">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						</div>
						<button
							type="button"
							class="btn btn-soft-secondary btn-sm"
							data-toggle="add-more"
							data-content='
							<div class="row gutters-5">
								<div class="col-md-5">
									<div class="form-group">
										<div class="input-group" data-toggle="aizuploader" data-type="image">
											<div class="input-group-prepend">
												<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
											</div>
											<div class="form-control file-amount">{{ translate('Choose File') }}</div>
											<input type="hidden" name="types[]" value="home_banner1_images">
											<input type="hidden" name="home_banner1_images[]" class="selected-files">
										</div>
										<div class="file-preview box sm">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group">
										<input type="hidden" name="types[]" value="home_banner1_links">
										<input type="text" class="form-control" placeholder="http://" name="home_banner1_links[]">
									</div>
								</div>
								<div class="col-md-auto">
									<div class="form-group">
										<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
											<i class="las la-times"></i>
										</button>
									</div>
								</div>
							</div>'
							data-target=".home-banner1-target">
							{{ translate('Add New') }}
						</button>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>

			{{-- best sellers category --}}
			<div class="card">
				<div class="card-header">
					<h6 class="mb-0">{{ translate('Best sellers category') }}</h6>
				</div>
				<div class="card-body">
					<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-group">
							<label>{{ translate('Banner & Links') }}</label>
							<div class="best-seller-category-target">
								<input type="hidden" name="types[]" value="best_seller_category_images">
								<input type="hidden" name="types[]" value="best_seller_category_heading">
								<input type="hidden" name="types[]" value="best_seller_category_offer">
								<input type="hidden" name="types[]" value="best_seller_category_tag">
								<input type="hidden" name="types[]" value="best_seller_category_links">
								@if (get_setting('best_seller_category_images') != null)
									@foreach (json_decode(get_setting('best_seller_category_images'), true) as $key => $value)
										<div class="row gutters-5">
											<div class="col-md-3">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose File') }}</div>
														<input type="hidden" name="types[]" value="best_seller_category_images">
														<input type="hidden" name="best_seller_category_images[]" class="selected-files" value="{{ json_decode(get_setting('best_seller_category_images'), true)[$key] }}">
													</div>
													<div class="file-preview box sm">
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<input type="hidden" name="types[]" value="best_seller_category_heading">
													<input type="text" class="form-control" placeholder="" name="best_seller_category_heading[]" value="{{ json_decode(get_setting('best_seller_category_heading'), true)[$key] }}">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<input type="hidden" name="types[]" value="best_seller_category_offer">
													<input type="text" class="form-control" placeholder="" name="best_seller_category_offer[]" value="{{ json_decode(get_setting('best_seller_category_offer'), true)[$key] }}">
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<input type="hidden" name="types[]" value="best_seller_category_tag">
													<input type="text" class="form-control" placeholder="" name="best_seller_category_tag[]" value="{{ json_decode(get_setting('best_seller_category_tag'), true)[$key] }}">
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<input type="hidden" name="types[]" value="best_seller_category_links">
													<input type="text" class="form-control" placeholder="http://" name="best_seller_category_links[]" value="{{ json_decode(get_setting('best_seller_category_links'), true)[$key] }}">
												</div>
											</div>
											<div class="col-md-auto">
												<div class="form-group">
													<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
														<i class="las la-times"></i>
													</button>
												</div>
											</div>
										</div>
									@endforeach
								@endif
							</div>
							<button
								type="button"
								class="btn btn-soft-secondary btn-sm"
								data-toggle="add-more"
								data-content='
								<div class="row gutters-5">
									<div class="col-md-3">
										<div class="form-group">
											<div class="input-group" data-toggle="aizuploader" data-type="image">
												<div class="input-group-prepend">
													<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
												</div>
												<div class="form-control file-amount">{{ translate('Choose File') }}</div>
												<input type="hidden" name="types[]" value="best_seller_category_images">
												<input type="hidden" name="best_seller_category_images[]" class="selected-files">
											</div>
											<div class="file-preview box sm">
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input type="hidden" name="types[]" value="best_seller_category_heading">
											<input type="text" class="form-control" placeholder="Heading" name="best_seller_category_heading[]">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input type="hidden" name="types[]" value="best_seller_category_offer">
											<input type="text" class="form-control" placeholder="offer" name="best_seller_category_offer[]" >
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input type="hidden" name="types[]" value="best_seller_category_tag">
											<input type="text" class="form-control" placeholder="Tag line" name="best_seller_category_tag[]" >
										</div>
									</div>
									<div class="col-md">
										<div class="form-group">
											<input type="hidden" name="types[]" value="best_seller_category_links">
											<input type="text" class="form-control" placeholder="http://" name="best_seller_category_links[]">
										</div>
									</div>
									<div class="col-md-auto">
										<div class="form-group">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>
								</div>'
								data-target=".best-seller-category-target">
								{{ translate('Add New') }}
							</button>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
						</div>
					</form>
				</div>
			</div>
			
				{{-- Recommended on Sadar --}}
				<div class="card">
					<div class="card-header">
						<h6 class="mb-0">{{ translate('Recommended on Sadar 24') }}</h6>
					</div>
					<div class="card-body">
						<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label>{{ translate('Banner & Links') }}</label>
								<div class="recommended-on-sadar-target">
									<input type="hidden" name="types[]" value="recommended_on_sadar_images">
									<input type="hidden" name="types[]" value="recommended_on_sadar_heading">
									<input type="hidden" name="types[]" value="recommended_on_sadar_offer">
									<input type="hidden" name="types[]" value="recommended_on_sadar_tag">
									<input type="hidden" name="types[]" value="recommended_on_sadar_links">
									@if (get_setting('recommended_on_sadar_images') != null)
										@foreach (json_decode(get_setting('recommended_on_sadar_images'), true) as $key => $value)
											<div class="row gutters-5">
												<div class="col-md-3">
													<div class="form-group">
														<div class="input-group" data-toggle="aizuploader" data-type="image">
															<div class="input-group-prepend">
																<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
															</div>
															<div class="form-control file-amount">{{ translate('Choose File') }}</div>
															<input type="hidden" name="types[]" value="recommended_on_sadar_images">
															<input type="hidden" name="recommended_on_sadar_images[]" class="selected-files" value="{{ json_decode(get_setting('recommended_on_sadar_images'), true)[$key] }}">
														</div>
														<div class="file-preview box sm">
														</div>
													</div>
												</div>
												<div class="col-md">
													<div class="form-group">
														<input type="hidden" name="types[]" value="recommended_on_sadar_heading">
														<input type="text" class="form-control" placeholder="" name="recommended_on_sadar_heading[]" value="{{ json_decode(get_setting('recommended_on_sadar_heading'), true)[$key] }}">
													</div>
												</div>
												<div class="col-md">
													<div class="form-group">
														<input type="hidden" name="types[]" value="recommended_on_sadar_offer">
														<input type="text" class="form-control" placeholder="" name="recommended_on_sadar_offer[]" value="{{ json_decode(get_setting('recommended_on_sadar_offer'), true)[$key] }}">
													</div>
												</div>
												<div class="col-md">
													<div class="form-group">
														<input type="hidden" name="types[]" value="recommended_on_sadar_tag">
														<input type="text" class="form-control" placeholder="" name="recommended_on_sadar_tag[]" value="{{ json_decode(get_setting('recommended_on_sadar_tag'), true)[$key] }}">
													</div>
												</div>
												<div class="col-md">
													<div class="form-group">
														<input type="hidden" name="types[]" value="recommended_on_sadar_links">
														<input type="text" class="form-control" placeholder="http://" name="recommended_on_sadar_links[]" value="{{ json_decode(get_setting('recommended_on_sadar_links'), true)[$key] }}">
													</div>
												</div>
												<div class="col-md-auto">
													<div class="form-group">
														<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
															<i class="las la-times"></i>
														</button>
													</div>
												</div>
											</div>
										@endforeach
									@endif
								</div>
								<button
									type="button"
									class="btn btn-soft-secondary btn-sm"
									data-toggle="add-more"
									data-content='
									<div class="row gutters-5">
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
													<div class="input-group-prepend">
														<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
													</div>
													<div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="types[]" value="recommended_on_sadar_images">
													<input type="hidden" name="recommended_on_sadar_images[]" class="selected-files">
												</div>
												<div class="file-preview box sm">
												</div>
											</div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<input type="hidden" name="types[]" value="recommended_on_sadar_heading">
												<input type="text" class="form-control" placeholder="heading" name="recommended_on_sadar_heading[]">
											</div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<input type="hidden" name="types[]" value="recommended_on_sadar_offer">
												<input type="text" class="form-control" placeholder="offer" name="recommended_on_sadar_offer[]">
											</div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<input type="hidden" name="types[]" value="recommended_on_sadar_tag">
												<input type="text" class="form-control" placeholder="Tag" name="recommended_on_sadar_tag[]">
											</div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<input type="hidden" name="types[]" value="recommended_on_sadar_links">
												<input type="text" class="form-control" placeholder="http://" name="recommended_on_sadar_links[]">
											</div>
										</div>
										<div class="col-md-auto">
											<div class="form-group">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>
									</div>'
									data-target=".recommended-on-sadar-target">
									{{ translate('Add New') }}
								</button>
							</div>
							<div class="text-right">
								<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
							</div>
						</form>
					</div>
				</div>

					{{-- Deal Of The Day --}}
			<div class="card">
				<div class="card-header">
					<h6 class="mb-0">{{ translate('Deal Of The Day') }}</h6>
				</div>
				<div class="card-body">
					<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="form-group">
							<label>{{ translate('Banner & Links') }}</label>
							<div class="deal-of-the-day-target">
								<input type="hidden" name="types[]" value="deal_of_the_day_images">
								<input type="hidden" name="types[]" value="deal_of_the_day_heading">
								<input type="hidden" name="types[]" value="deal_of_the_day_links">
								@if (get_setting('deal_of_the_day_images') != null)
									@foreach (json_decode(get_setting('deal_of_the_day_images'), true) as $key => $value)
										<div class="row gutters-5">
											<div class="col-md-3">
												<div class="form-group">
													<div class="input-group" data-toggle="aizuploader" data-type="image">
														<div class="input-group-prepend">
															<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
														</div>
														<div class="form-control file-amount">{{ translate('Choose File') }}</div>
														<input type="hidden" name="types[]" value="deal_of_the_day_images">
														<input type="hidden" name="deal_of_the_day_images[]" class="selected-files" value="{{ json_decode(get_setting('deal_of_the_day_images'), true)[$key] }}">
													</div>
													<div class="file-preview box sm">
													</div>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<input type="hidden" name="types[]" value="deal_of_the_day_heading">
													<input type="text" class="form-control" placeholder="http://" name="deal_of_the_day_heading[]" value="{{ json_decode(get_setting('deal_of_the_day_heading'), true)[$key] }}">
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<input type="hidden" name="types[]" value="deal_of_the_day_links">
													<input type="text" class="form-control" placeholder="http://" name="deal_of_the_day_links[]" value="{{ json_decode(get_setting('deal_of_the_day_links'), true)[$key] }}">
												</div>
											</div>
											<div class="col-md-auto">
												<div class="form-group">
													<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
														<i class="las la-times"></i>
													</button>
												</div>
											</div>
										</div>
									@endforeach
								@endif
							</div>
							<button
								type="button"
								class="btn btn-soft-secondary btn-sm"
								data-toggle="add-more"
								data-content='
								<div class="row gutters-5">
									<div class="col-md-5">
										<div class="form-group">
											<div class="input-group" data-toggle="aizuploader" data-type="image">
												<div class="input-group-prepend">
													<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
												</div>
												<div class="form-control file-amount">{{ translate('Choose File') }}</div>
												<input type="hidden" name="types[]" value="deal_of_the_day_images">
												<input type="hidden" name="deal_of_the_day_images[]" class="selected-files">
											</div>
											<div class="file-preview box sm">
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input type="hidden" name="types[]" value="deal_of_the_day_heading">
											<input type="text" class="form-control" placeholder="Heading" name="deal_of_the_day_heading[]">
										</div>
									</div>
									<div class="col-md">
										<div class="form-group">
											<input type="hidden" name="types[]" value="deal_of_the_day_links">
											<input type="text" class="form-control" placeholder="http://" name="deal_of_the_day_links[]">
										</div>
									</div>
									<div class="col-md-auto">
										<div class="form-group">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>
								</div>'
								data-target=".deal-of-the-day-target">
								{{ translate('Add New') }}
							</button>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
						</div>
					</form>
				</div>
			</div>


		{{-- Home Banner 2 --}}
		<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('Home Banner 2 (Max 3)') }}</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>{{ translate('Banner & Links') }}</label>
						<div class="home-banner2-target">
							<input type="hidden" name="types[]" value="home_banner2_images">
							<input type="hidden" name="types[]" value="home_banner2_links">
							@if (get_setting('home_banner2_images') != null)
								@foreach (json_decode(get_setting('home_banner2_images'), true) as $key => $value)
									<div class="row gutters-5">
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
					                                <div class="input-group-prepend">
					                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
					                                </div>
					                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="types[]" value="home_banner2_images">
					                                <input type="hidden" name="home_banner2_images[]" class="selected-files" value="{{ json_decode(get_setting('home_banner2_images'), true)[$key] }}">
					                            </div>
					                            <div class="file-preview box sm">
					                            </div>
				                            </div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<input type="hidden" name="types[]" value="home_banner2_links">
												<input type="text" class="form-control" placeholder="http://" name="home_banner2_links[]" value="{{ json_decode(get_setting('home_banner2_links'), true)[$key] }}">
											</div>
										</div>
										<div class="col-md-auto">
											<div class="form-group">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						</div>
						<button
							type="button"
							class="btn btn-soft-secondary btn-sm"
							data-toggle="add-more"
							data-content='
							<div class="row gutters-5">
								<div class="col-md-5">
									<div class="form-group">
										<div class="input-group" data-toggle="aizuploader" data-type="image">
											<div class="input-group-prepend">
												<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
											</div>
											<div class="form-control file-amount">{{ translate('Choose File') }}</div>
											<input type="hidden" name="types[]" value="home_banner2_images">
											<input type="hidden" name="home_banner2_images[]" class="selected-files">
										</div>
										<div class="file-preview box sm">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group">
										<input type="hidden" name="types[]" value="home_banner2_links">
										<input type="text" class="form-control" placeholder="http://" name="home_banner2_links[]">
									</div>
								</div>
								<div class="col-md-auto">
									<div class="form-group">
										<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
											<i class="las la-times"></i>
										</button>
									</div>
								</div>
							</div>'
							data-target=".home-banner2-target">
							{{ translate('Add New') }}
						</button>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>

		{{-- Home categories--}}
		<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('Home Categories') }}</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>{{ translate('Categories') }}</label>
						<div class="home-categories-target">
							<input type="hidden" name="types[]" value="home_categories">
							@if (get_setting('home_categories') != null)
								@foreach (json_decode(get_setting('home_categories'), true) as $key => $value)
									<div class="row gutters-5">
										<div class="col">
											<div class="form-group">
												<select class="form-control aiz-selectpicker" name="home_categories[]" data-live-search="true" data-selected={{ $value }} required>
													@foreach (\App\Category::where('parent_id', 0)->with('childrenCategories')->get() as $category)
														<option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
														@foreach ($category->childrenCategories as $childCategory)
															@include('categories.child_category', ['child_category' => $childCategory])
														@endforeach
													@endforeach
					                            </select>
											</div>
										</div>
										<div class="col-auto">
											<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
												<i class="las la-times"></i>
											</button>
										</div>
									</div>
								@endforeach
							@endif
						</div>
						<button
							type="button"
							class="btn btn-soft-secondary btn-sm"
							data-toggle="add-more"
							data-content='<div class="row gutters-5">
								<div class="col">
									<div class="form-group">
										<select class="form-control aiz-selectpicker" name="home_categories[]" data-live-search="true" required>
											@foreach (\App\Category::all() as $key => $category)
												<option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-auto">
									<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
										<i class="las la-times"></i>
									</button>
								</div>
							</div>'
							data-target=".home-categories-target">
							{{ translate('Add New') }}
						</button>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>


		{{-- Home Banner 3 --}}
		<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('Home Banner 3 (Max 3)') }}</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>{{ translate('Banner & Links') }}</label>
						<div class="home-banner3-target">
							<input type="hidden" name="types[]" value="home_banner3_images">
							<input type="hidden" name="types[]" value="home_banner3_links">
							@if (get_setting('home_banner3_images') != null)
								@foreach (json_decode(get_setting('home_banner3_images'), true) as $key => $value)
									<div class="row gutters-5">
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
					                                <div class="input-group-prepend">
					                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
					                                </div>
					                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="types[]" value="home_banner3_images">
					                                <input type="hidden" name="home_banner3_images[]" class="selected-files" value="{{ json_decode(get_setting('home_banner3_images'), true)[$key] }}">
					                            </div>
					                            <div class="file-preview box sm">
					                            </div>
				                            </div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<input type="hidden" name="types[]" value="home_banner3_links">
												<input type="text" class="form-control" placeholder="http://" name="home_banner3_links[]" value="{{ json_decode(get_setting('home_banner3_links'), true)[$key] }}">
											</div>
										</div>
										<div class="col-md-auto">
											<div class="form-group">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						</div>
						<button
							type="button"
							class="btn btn-soft-secondary btn-sm"
							data-toggle="add-more"
							data-content='
							<div class="row gutters-5">
								<div class="col-md-5">
									<div class="form-group">
										<div class="input-group" data-toggle="aizuploader" data-type="image">
											<div class="input-group-prepend">
												<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
											</div>
											<div class="form-control file-amount">{{ translate('Choose File') }}</div>
											<input type="hidden" name="types[]" value="home_banner3_images">
											<input type="hidden" name="home_banner3_images[]" class="selected-files">
										</div>
										<div class="file-preview box sm">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group">
										<input type="hidden" name="types[]" value="home_banner3_links">
										<input type="text" class="form-control" placeholder="http://" name="home_banner3_links[]">
									</div>
								</div>
								<div class="col-md-auto">
									<div class="form-group">
										<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
											<i class="las la-times"></i>
										</button>
									</div>
								</div>
							</div>'
							data-target=".home-banner3-target">
							{{ translate('Add New') }}
						</button>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
		{{-- Home Banner 3 --}}
		<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('Sponsored Banners') }}</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>{{ translate('Banner & Links') }}</label>
						<div class="sponsored-banner-target">
							<input type="hidden" name="types[]" value="sponsored_images">
							<input type="hidden" name="types[]" value="sponsored_links">
							@if (get_setting('sponsored_images') != null)
								@foreach (json_decode(get_setting('sponsored_images'), true) as $key => $value)
									<div class="row gutters-5">
										<div class="col-md-5">
											<div class="form-group">
												<div class="input-group" data-toggle="aizuploader" data-type="image">
					                                <div class="input-group-prepend">
					                                    <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
					                                </div>
					                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
													<input type="hidden" name="types[]" value="sponsored_images">
					                                <input type="hidden" name="sponsored_images[]" class="selected-files" value="{{ json_decode(get_setting('sponsored_images'), true)[$key] }}">
					                            </div>
					                            <div class="file-preview box sm">
					                            </div>
				                            </div>
										</div>
										<div class="col-md">
											<div class="form-group">
												<input type="hidden" name="types[]" value="sponsored_links">
												<input type="text" class="form-control" placeholder="http://" name="sponsored_links[]" value="{{ json_decode(get_setting('sponsored_links'), true)[$key] }}">
											</div>
										</div>
										<div class="col-md-auto">
											<div class="form-group">
												<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
													<i class="las la-times"></i>
												</button>
											</div>
										</div>
									</div>
								@endforeach
							@else
							<div class="row gutters-5">
								<div class="col-md-5">
									<div class="form-group">
										<div class="input-group" data-toggle="aizuploader" data-type="image">
											<div class="input-group-prepend">
												<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
											</div>
											<div class="form-control file-amount">{{ translate('Choose File') }}</div>
											<input type="hidden" name="types[]" value="sponsored_images">
											<input type="hidden" name="sponsored_images[]" class="selected-files" value="">
										</div>
										<div class="file-preview box sm">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group">
										<input type="hidden" name="types[]" value="sponsored_links">
										<input type="text" class="form-control" placeholder="http://" name="sponsored_links[]" value="">
									</div>
								</div>
								<div class="col-md-auto">
									<div class="form-group">
										<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
											<i class="las la-times"></i>
										</button>
									</div>
								</div>
							</div>
							@endif
						</div>
						<button
							type="button"
							class="btn btn-soft-secondary btn-sm"
							data-toggle="add-more"
							data-content='
							<div class="row gutters-5">
								<div class="col-md-5">
									<div class="form-group">
										<div class="input-group" data-toggle="aizuploader" data-type="image">
											<div class="input-group-prepend">
												<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
											</div>
											<div class="form-control file-amount">{{ translate('Choose File') }}</div>
											<input type="hidden" name="types[]" value="sponsored_images">
											<input type="hidden" name="sponsored_images[]" class="selected-files">
										</div>
										<div class="file-preview box sm">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group">
										<input type="hidden" name="types[]" value="sponsored_links">
										<input type="text" class="form-control" placeholder="http://" name="sponsored_links[]">
									</div>
								</div>
								<div class="col-md-auto">
									<div class="form-group">
										<button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-toggle="remove-parent" data-parent=".row">
											<i class="las la-times"></i>
										</button>
									</div>
								</div>
							</div>'
							data-target=".sponsored-banner-target">
							{{ translate('Add New') }}
						</button>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>

		{{-- Top 10 --}}
		<div class="card">
			<div class="card-header">
				<h6 class="mb-0">{{ translate('Top 10') }}</h6>
			</div>
			<div class="card-body">
				<form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-md-2 col-from-label">{{translate('Top Categories (Max 10)')}}</label>
						<div class="col-md-10">
							<input type="hidden" name="types[]" value="top10_categories">
							<select name="top10_categories[]" class="form-control aiz-selectpicker" multiple data-max-options="10" data-live-search="true" data-selected="{{ get_setting('top10_categories') }}">
								@foreach (\App\Category::where('parent_id', 0)->with('childrenCategories')->get() as $category)
									<option value="{{ $category->id }}">{{ $category->getTranslation('name') }}</option>
									@foreach ($category->childrenCategories as $childCategory)
										@include('categories.child_category', ['child_category' => $childCategory])
									@endforeach
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-md-2 col-from-label">{{translate('Top Brands (Max 10)')}}</label>
						<div class="col-md-10">
							<input type="hidden" name="types[]" value="top10_brands">
							<select name="top10_brands[]" class="form-control aiz-selectpicker" multiple data-max-options="10" data-live-search="true" data-selected="{{ get_setting('top10_brands') }}">
								@foreach (\App\Brand::all() as $key => $brand)
									<option value="{{ $brand->id }}">{{ $brand->getTranslation('name') }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">{{ translate('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
    <script type="text/javascript">
		$(document).ready(function(){
		    AIZ.plugins.bootstrapSelect('refresh');
		});
    </script>
@endsection
