<!-- Modal -->
<div class="modal fade" id="showChangeStockStatusModal234" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <span> Change Status </span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.member.stock_status_change', ) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="assign_id" id="assign_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-sm-3">

                                <div class="form-group row @error('status') error @enderror">
                                    <label class="col-sm-3 col-form-label required"
                                        for="name">{{ __('Status') }}</label>
                                    <div class="col-sm-9">
                                        <select class="select form-control" name="status" id="status"
                                            style="width: 100%;" required>
                                            <option value="" selected disabled>Select One</option>
                                            @foreach($stock_status as $key => $status)

                                                @if($key == \App\Library\Enum::STOCK_AVAILABLE || $key == \App\Library\Enum::STOCK_ASSIGNED || $key == \App\Library\Enum::STOCK_OUT)
                                                    @continue
                                                @endif

                                                <option value="{{ $key }}" {{ old('status')  == $key ? "selected" : "" }}> {{ $status }}</option>

                                            @endforeach
                                        </select>
                                        @error('status')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('note') error @enderror">
                                    <label class="col-sm-3 col-form-label required" for="name">{{ __('Note') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" name="note" class="form-control"
                                            placeholder="{{ __('Write Note') }}"
                                            rows="4" required>{{ old('note') }}</textarea>
                                        @error('note')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center">
                            {!! \App\Library\Html::btnReset() !!}
                            {!! \App\Library\Html::btnSubmit() !!}
                        </div>

                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    const showChangeStockStatusModal = "#showChangeStockStatusModal234";

    function openChangeStockStatusModal(id, status) {
        $("#status").val(status);
        $("#assign_id").val(id);
        $(showChangeStockStatusModal).modal('show');
    }
</script>
@endpush
