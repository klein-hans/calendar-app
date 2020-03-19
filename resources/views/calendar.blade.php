@extends('master')

@section('title', 'Calendar')

{{-- @if (session('success'))
  <div class="alert alert-success alert-dismissible fade show w-25 mb-2 mx-auto" role="alert">
    <i class="icon fa fa-check fa-fw" aria-hidden="true"></i>
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

@section('content')
<div class="container mt-4 mx-auto">
  <div class="row">
    <div class="col-lg-4 mt-4 text-left">
      {{ Form::model(array('action' => 'CalendarController@store', 'method' => 'POST', 'role' => 'form')) }}
        {!! csrf_field() !!}
        <div class="form-group has-feedback row {{ $errors->has('event_name') ? 'is-invalid' : '' }}">
          {!! Form::label('event_name', 'Event', array('class' => 'control-label col-lg-12 pl-0')); !!}
          {!! Form::text('event_name', NULL, array('id' => 'event_name', 'class' => $errors->has('event_name') ? 'col-lg-12 form-control is-invalid' : 'col-lg-12 form-control')); !!}
          @if ($errors->has('event_name'))
            <span class="help-block col-lg-12 text-danger p-0">
              <strong>* {{ $errors->first('event_name') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group row">  
          {!! Form::label('start_date', 'From', array('class' => 'col-form-label col-lg-12 pl-0')); !!}
          {!! Form::input('date', 'start_date', NULL, array('id' => 'start_date', 'class' => $errors->has('start_date') ? 'col-lg-12 form-control is-invalid' : 'col-lg-12 form-control')); !!}
          @if ($errors->has('start_date'))
            <span class="help-block col-lg-12 text-danger p-0">
              <strong>* {{ $errors->first('start_date') }}</strong>
            </span>
          @endif
        </div>
        <div class="row mb-4">
          {!! Form::label('end_date', 'To', array('class' => 'col-lg-12 pl-0')); !!}
          {!! Form::input('date', 'end_date', NULL, array('id' => 'end_date', 'class' =>  $errors->has('end_date') ? 'col-lg-12 form-control is-invalid' : 'col-lg-12 form-control')); !!}
          @if ($errors->has('end_date'))
            <span class="help-block col-lg-12 text-danger p-0">
              <strong>* {{ $errors->first('end_date') }}</strong>
            </span>
          @endif
        </div>
        <div class="row mb-3">
          <div class="col-lg-12 px-0">
            <div class="form-check form-check-inline">
              {!! Form::checkbox('day[\'mon\']', 'Mon', false, array('class' => 'form-check-input m-0')); !!}
              {!! Form::label('day[\'mon\']', 'Mon', array('class' => 'form-check-label')); !!}
            </div>
            <div class="form-check form-check-inline">
              {!! Form::checkbox('day[\'tue\']', 'Tue', false, array('class' => 'form-check-input m-0')); !!}
              {!! Form::label('day[\'tue\']', 'Tue', array('class' => 'form-check-label')); !!}
            </div>
            <div class="form-check form-check-inline">
              {!! Form::checkbox('day[\'wed\']', 'Wed', false, array('class' => 'form-check-input m-0')); !!}
              {!! Form::label('day[\'wed\']', 'Wed', array('class' => 'form-check-label')); !!}
            </div>
            <div class="form-check form-check-inline">
              {!! Form::checkbox('day[\'thu\']', 'Thu', false, array('class' => 'form-check-input m-0')); !!}
              {!! Form::label('day[\'thu\']', 'Thu', array('class' => 'form-check-label')); !!}
            </div>
            <div class="form-check form-check-inline">
              {!! Form::checkbox('day[\'fri\']', 'Fri', false, array('class' => 'form-check-input m-0')); !!}
              {!! Form::label('day[\'fri\']', 'Fri', array('class' => 'form-check-label')); !!}
            </div>
            <div class="form-check form-check-inline">
              {!! Form::checkbox('day[\'sat\']', 'Sat', false, array('class' => 'form-check-input m-0')); !!}
              {!! Form::label('day[\'sat\']', 'Sat', array('class' => 'form-check-label')); !!}
            </div>
            <div class="form-check form-check-inline">
              {!! Form::checkbox('day[\'sun\']', 'Sun', false, array('class' => 'form-check-input m-0')); !!}
              {!! Form::label('day[\'sun\']', 'Sun', array('class' => 'form-check-label')); !!}
            </div>
          </div> {{-- end of col-lg-12 --
        </div> {{-- end of row --
        <div class="row">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      {{ Form::close() }}
    </div>
    <div id='wrap' class="col-lg-8">
      <full-calendar></full-calendar>
    </div>
  </div>
</div>
@endsection --}}
