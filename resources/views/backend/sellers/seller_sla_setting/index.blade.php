@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{translate('SLA Activation')}}</h3>
                </div>
                <div class="card-body text-center">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'sla_activation')" {{ get_setting('sla_activation') == 1 ?"checked":''}}>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 h6 text-center">{{translate('Vendor Based SLA Charges')}}</h3>
                </div>
                <div class="card-body text-center">
                    <label class="aiz-switch aiz-switch-success mb-0">
                        <input type="checkbox" onchange="updateSettings(this, 'vendor_based_sla')" {{ get_setting('vendor_based_sla') == 1? "checked":''}}>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                  <h5 class="mb-0 h6">{{translate('SLA Breach Charge')}}</h5>
              </div>
              <div class="card-body">
                  <form class="form-horizontal" action="{{ route('business_settings.sla_charge.update') }}" method="POST" enctype="multipart/form-data">
                  	@csrf

                    @php
                    $sla_time = get_setting('sla_time');
                    @endphp
                    <div class="form-group row">
                        <label class="col-sm-4 col-from-label">{{translate('SLA Time')}} <small>Hrs</small></label>
                        <div class="col-sm-8">
                            <input type="hidden" name="types[]" value="sla_time">
                            <input type="number" min="32" step="1" name="sla_time" class="form-control" placeholder="Eg. 72" value="{{ $sla_time }}">
                        </div>
                    </div>
                    @php
                    $sla_charge_type =   get_setting('sla_charge_type','flat');
                    @endphp
                    <div class="form-group row">
                        <label class="col-sm-4 col-from-label">{{translate('SLA Charge Type')}}</label>
                        <input type="hidden" name="types[]" value="sla_charge_type">

                        <div class="col-sm-4">
                            <label for="sla_flat"><input type="radio" name="sla_charge_type" value="flat" {{ $sla_charge_type =="flat"?"checked":'' }} id="sla_flat">&nbsp;Flat</label>
                        </div>
                        <div class="col-sm-4">
                            <label for="sla_per"><input type="radio" name="sla_charge_type" value="per" {{ $sla_charge_type =="per"?"checked":'' }} id="sla_per">&nbsp;Percentage</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 col-from-label">{{translate('SLA Breach Charge')}}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="sla_charge">
                            <div class="input-group">
                                <input type="number" lang="en" min="0" step="0.01" value="{{ get_setting('sla_charge') }}" placeholder="{{translate('SLA Breach Charge')}}" name="sla_charge" class="form-control">
                                {{-- <div class="input-group-append">
                                    <span class="input-group-text" id="sla">%</span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                  </form>
              </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Note')}}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item text-muted">
                            1. {{ get_setting('sla_charge') }} {{$sla_charge_type=='per'?'%':' Flat '}} {{translate('of seller product price will be deducted from seller earnings if they breach the SLA threshold time of') }} {{$sla_time}} {{translate('hours')}}.
                        </li>
                        {{-- <li class="list-group-item text-muted">
                            2. {{translate('If Category Based Commission is enbaled, Set seller commission percentage 0.') }}.
                        </li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function updateSettings(el, type){
            if($(el).is(':checked')){
                var value = 1;
            }
            else{
                var value = 0;
            }
            
            $.post('{{ route('business_settings.update.activation') }}', {_token:'{{ csrf_token() }}', type:type, value:value}, function(data){
                if(data == '1'){
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection