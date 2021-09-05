@include('layouts.header')



@include('layouts.sidebar')
<div id="main" class="layout-navbar">
  @include('layouts.nav')

<div class="content" id="main-content">
  	<div class="container-fluid">
		<div class="row">

			<div class="col-md-6">
				<div class="card card-profile">
					<div class="card-avatar bg-danger" style="overflow: hidden">
						<img id="avatar" class="img-fluid" src="@php echo $tenant->avatar ? json_decode($tenant->avatar)[0]->url : asset('/images/faces/1.jpg') @endphp">
					</div>
				</div>
			</div>


			<div class="col-md-6">
				<div class="card">
					<div class="card-header card-header-primary">
						<h5 class="card-title">Tenant Profile Details</h5>
					</div>

					<div class="card-body">
					<div class="row">
							<div class="col-12 d-flex justify-content-between align-items-center">
								<div class="col-auto mb-3">
									<div class="badge badge-shadow {{ $tenant->status ? 'bg-dark' : 'bg-warning' }}">
										{{ $tenant->status ? 'Active' : 'Suspended' }}
									</div>
								</div>
							</div>

							<div class="col-12 mb-0">
								<div class="card bg-light-primary">
									<div class="card-body pb-0">
										<div class="col-12">
											<div class="row">
												<div class="col-6 col-md-4">
													<p class="fw-bolder lh-0 mb-2">Firstname</p>
													<p>{{$tenant->firstname}}</p>
												</div>
					
												<div class="col-6 col-md-4">
												<p class="fw-bolder lh-0 mb-2">Lastname</p>
												<p>{{$tenant->lastname}}</p>
												</div>
					
												<div class="col-6 col-md-4">
													<p class="fw-bolder lh-0 mb-2">Email Address</p>
													<p>{{$tenant->email}}</p>
												</div>

												<div class="col-6 col-md-4">
													<p class="fw-bolder lh-0 mb-2">State</p>
													<p>{{$tenant->state ?: 'nill'}}</p>
												</div>

												<div class="col-6 col-md-4">
													<p class="fw-bolder lh-0 mb-2">Local Govt</p>
													<p>{{$tenant->lga ?: 'nill'}}</p>
												</div>

												<div class="col-6 col-md-4">
													<p class="fw-bolder lh-0 mb-2">No of Wishlists</p>
													<p>{{$tenant->wishlists}}</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<hr/>

						<div class="col-12">
							<a href="/tenants/suspend/{{$tenant->unique_id}}" class="btn btn-outline-primary px-4">{{ $tenant->status ? 'Suspend' : 'Unsuspend' }}</a>
							<a href="/tenants/delete/{{$tenant->unique_id}}" class="btn">Delete</a>
						</div>
					</div>
				</div>
			</div>


			<div class="col-12">
				<div class="card">
					<div class="card-header card-header-primary">
						<h5 class="card-title">Tenant's Wishlists</h5>
					</div>

					<div class="card-body">
						<div class="row">
							@if (isset($wishlists) && count($wishlists) > 0)
								@foreach ($wishlists as $wishlist)
									<div class="col-md-6 mb-0">
										<div class="card bg-light-secondary">
											<div class="card-body pb-0">
												<div class="col-12">
													<div class="row">
														<div class="col-12 mb-2">
															<div class="mb-2 badge badge-shadow {{ $wishlist->status ? 'bg-success' : 'bg-warning' }}">
																{{ $wishlist->status ? 'Active' : 'Blocked' }}
															</div>
															<h5 class="fw-bolder">{{$wishlist->desc}}</h5>
														</div>
														
														<div class="col-12">
															<div class="row">
																<div class="col-12 d-flex">
																	<div class="badge badge-shadow bg-primary">
																		{{ $wishlist->category }}
																	</div>
																	<div class="m-0 mx-3">
																		<p class="fw-bold m-0">&#8358; {{$wishlist->budget}}</p>
																	</div>
																</div>
															</div>
														</div>


														<div class="col-12 mb-1">
															<div class="card bg-white mt-3 p-3 py-0 rounded-2">
																<p class="my-3">{{$wishlist->additional}}</p>
	
																<div class="col-12 border-top pt-2">
																	<div class="row">
																		<div class="col-auto">
																			<p class="fw-bold">{{$wishlist->city}}, {{$wishlist->state}}</p>
																		</div>
		
																		<div class="col-auto">
																			<p class="fw-bold">{{$wishlist->area}}</p>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="card-footer bg-transparent p-0 pb-3 border-0">
														<a href="/wishlists/block/{{$wishlist->unique_id}}" class="btn btn-outline-primary">Block</a>
														<a href="/wishlists/delete/{{$wishlist->unique_id}}" class="btn">Delete</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						</div>
					</div>
				</div>
			</div>

			
			
@include('layouts.footer')