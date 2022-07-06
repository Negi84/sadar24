@extends('frontend.layouts.user_panel')

@section('panel_content')
	

    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Support Ticket') }}</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mx-auto mb-3" >
            <div class="p-3 rounded mb-3 c-pointer text-center bg-white shadow-sm hov-shadow-lg has-transition" data-bs-toggle="modal" data-bs-target="#ticket_modal">
                <span class="size-70px rounded-circle mx-auto bg-secondary d-flex align-items-center justify-content-center mb-3">
                    <i class="las la-plus la-3x text-white"></i>
                </span>
                <div class="fs-20 text-primary">{{ translate('Create a Ticket') }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Tickets')}} </h5>
        </div>
          <div class="card-body">
              <table class="table aiz-table mb-0">
                  <thead>
                      <tr>
                          <th data-breakpoints="lg">{{ translate('Ticket ID') }}</th>
						  <th data-breakpoints="lg">{{ translate('Order ID') }}</th>
                          <th data-breakpoints="lg">{{ translate('Sending Date') }}</th>
                          <th>{{ translate('Subject')}}</th>
                          <th>{{ translate('Status')}}</th>
                          <th data-breakpoints="lg">{{ translate('Options')}}</th>
                      </tr>
                  </thead>
                  <tbody>
					@php
						$data=[];
						$user_type = '';
					@endphp
                      @foreach ($tickets as $key => $ticket)
						
						@if($ticket->status == 'pending' || $ticket->status == 'open')
							@php
								array_push($data,$ticket->order_id);
							@endphp							
						@endif
                          <tr>
                              <td>#{{ $ticket->code }}</td>
							  <td>{{ $ticket->order_id }}</td>
                              <td>{{ $ticket->created_at }}</td>
                              <td>{{ $ticket->subject }}</td>
                              <td>
                                  @if ($ticket->status == 'pending')
                                      <span class="badge badge-inline badge-danger">{{ translate('Pending')}}</span>
                                  @elseif ($ticket->status == 'open')
                                      <span class="badge badge-inline badge-secondary">{{ translate('Open')}}</span>
                                  @else
                                      <span class="badge badge-inline badge-success">{{ translate('Solved')}}</span>
                                  @endif
                              </td>
                              <td>
                                  <a href="{{route('support_ticket.show', encrypt($ticket->id))}}" class="btn btn-styled btn-link py-1 px-0 icon-anim text-underline--none">
                                      {{ translate('View Details')}}
                                      <i class="la la-angle-right text-sm"></i>
                                  </a>
                              </td>
                          </tr>
                      @endforeach					 
                  </tbody>
              </table>
              <div class="aiz-pagination">
                  {{ $tickets->links() }}
              </div>
          </div>
    </div>
@endsection

@section('modal')
	<div class="modal" id="ticket_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog   modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title strong-600 heading-5">{{ translate('Create a Ticket')}}</h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body px-3 pt-3">
					<form class="" action="{{ route('support_ticket.store') }}" method="post" enctype="multipart/form-data" onSubmit="document.getElementById('button_disabled').disabled=true;">
						@csrf					
						
						<div class="row">
							<div class="col-md-3">
								<label>{{ translate('Order ID')}}</label>
							</div>
							<div class="col-md-9">
								<select class="form-control form-control-sm mb-2" name="order_id" id="order_id" onchange="getval(this);" required>
									<option value="">Please Select Order ID</option>									
									@if(Auth::user()->user_type != 'customer')
										@php $user_type = 'seller_id'; @endphp
									@else										
										@php $user_type = 'user_id';  @endphp
									@endif
								
									@php										
										$orders = \App\Order::where($user_type, Auth::user()->id)->select('code')->orderBy('code', 'desc')->get();
									@endphp
									@foreach ($orders as $key => $order)
										<option value="{{ $order->code }}">
											{{ $order->code }} 
										</option>
									@endforeach	
								</select>
								
								<div id="check_ticket_status" class="alert alert-danger" role="alert" style="display:none">Ticket already open. Please check your existing ticket for further updates.</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-3">
								<label>{{ translate('Subject')}}</label>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control mb-3" placeholder="{{ translate('Subject')}}" name="subject" required>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">
								<label>{{ translate('Provide a detailed description')}}</label>
							</div>
							<div class="col-md-9">
								<textarea type="text" class="form-control mb-3" rows="3" name="details" placeholder="{{ translate('Type your reply')}}" data-buttons="bold,underline,italic,|,ul,ol,|,paragraph,|,undo,redo" required></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-3 col-form-label">{{ translate('Photo') }}</label>
							<div class="col-md-9">
								<div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
									<div class="input-group-prepend">
										<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
									</div>
									<div class="form-control file-amount">{{ translate('Choose File') }}</div>
									<input type="hidden" name="attachments" class="selected-files">
								</div>
								<div class="file-preview box sm">
								</div>
						  </div>
						</div>
						<div class="text-right mt-4">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ translate('cancel')}}</button>
							<button type="submit" id="button_disabled" class="btn btn-primary">{{ translate('Send Ticket')}}</button>
						</div>
					</form>					
				</div>
			</div>
		</div>
	</div>
@endsection



@section('script')
    <script type="text/javascript">
		function getval(sel)
		{			
			var arrayFromPHP = <?php echo json_encode($data); ?>;	
			if(jQuery.inArray(sel.value, arrayFromPHP) != -1) {				
				$("#check_ticket_status").css("display", "block");
				$("#button_disabled").attr('disabled','disabled');
			} else {
				$("#check_ticket_status").css("display", "none");
				$("#button_disabled").removeAttr('disabled');
			}			
		}
	</script>
@endsection

