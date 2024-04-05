@extends('layouts.admin')

@section('page-title')
   {{ __('Manage Salary Breakup') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Manage Salary') }}</li>
@endsection

@section('action-button')
    <a href="#" data-url="{{ route('salarybreakup.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create New Salary Breakup') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
    </a>
@endsection

@section('content')
<div class="row">

    <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5></h5> --}}
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Component Name') }}</th>
                                <th>{{ __('Component Type') }}</th>
                                <th>{{ __('Component Value') }}</th>
                                <th width="200px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($breackups as $breakup)
                                <tr>
                                    <td>{{ $breakup->component_name }}</td>
                                    <td>{{ $breakup->component_type }}</td>
                                    <td>{{ $breakup->component_value_type }}</td>
                                    <td class="Action">
                                        <span>
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                        data-url="{{  URL::to('salary-breakup-edit/' . $breakup->id) }}"
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                                        data-title="{{ __('Edit Breakup') }}"
                                                        data-bs-original-title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>

                                            <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['salarybreakup.delete', $breakup->id], 'id' => 'delete-form-' . $breakup->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete"><i
                                                            class="ti ti-trash text-white text-white"></i></a>
                                                    </form>
                                                </div>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
