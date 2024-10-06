@extends('admin.layouts.master')

@section('title', __('Update room'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.ams.room.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update room')) }}</h4>
        </div>
       
    </div>

    <div class="card shadow-sm col-md-6">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.ams.room.update', $room->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('office_room') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Office Room Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="office_room"
                                        value="{{ old('office_room', $room->user->f_name) }}" placeholder="{{ __('Office Room Name') }}"
                                        required>
                                    @error('office_room')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('location') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Location') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="location"
                                        value="{{ old('location', $room->location) }}" placeholder="{{ __('Location') }}"
                                        required>
                                    @error('location')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('responsible_person') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Responsible Person') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="responsible_person" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($responsible_persons as $key => $responsible_person)
                                            <option value="{{ $responsible_person->id }}" {{(old("responsible_person", $room->responsible_person) == $responsible_person->id) ? "selected" : ""}}>
                                                {{ ucwords($responsible_person->getFullNameAttribute()) }}</option>
                                        @endforeach
                                    </select>
                                    @error('responsible_person')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('address') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Address') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="address"
                                        value="{{ old('address', $room->address) }}" placeholder="{{ __('Address') }}"
                                        required>
                                    @error('address')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('discription') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Discription') }}</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control" rows="5" name="discription" placeholder="{{ __('Discription') }}">{{ old('discription', $room->discription) }}</textarea>
                                    @error('discription')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="modal-footer justify-content-center col-md-12">
                        {!! \App\Library\Html::btnReset() !!}
                        {!! \App\Library\Html::btnSubmit() !!}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@include('admin.assets.select2')

@push('scripts')
@vite('resources/admin_assets/js/pages/asset/create.js')
@endpush