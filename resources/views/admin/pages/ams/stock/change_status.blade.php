<!-- Modal -->
<div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-l" role="document">
        <form method="post" action="{{ route('admin.ams.stock.change_status',$stock->id) }}" enctype="multipart/form-data" id="updateStatusForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('Change Status') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @php
                        $type = $stock->product->category->categoryType->entry_type;
                    @endphp

                    <div class="row form-group mb-0 @error('status') error @enderror">
                        <label class="col-md-3 col-form-label required">{{ __('Status') }}</label>
                        <select class="form-control col-md-9" name="status" required>
                            <option value="" class="selected highlighted">Select One</option>
                            @foreach(\App\Library\Enum::getStockStatus() as $index => $value)

                                @if($index == \App\Library\Enum::STOCK_ASSIGNED || $index == \App\Library\Enum::STOCK_OUT)
                                @continue
                                @endif

                                <option value="{{ $index }}" {{ $stock->status == $index ? "selected" : ""}}
                                    {{ $stock->status == $index && $stock->status == \App\Library\Enum::STOCK_AVAILABLE && $type == \App\Library\Enum::CATEGORY_INDIVIDUAL? "disabled" : "" }}
                                >{{ ucwords($value) }}</option>
                            @endforeach
                        </select>
                        @error('status')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($type == \App\Library\Enum::CATEGORY_BULK)
                        <div class="row form-group mb-0 @error('quantity') error @enderror">
                            <label class="col-md-3 col-form-label required">{{ __('Quantity') }}</label>
                            <input type="number" class="form-control col-md-9" name="quantity" id="quantity"
                                value="{{ old('quantity') }}" min="1" max="{{ $stock->product->stock > 0 ? $stock->product->stock : '' }}" placeholder="{{ __('Quantity') }}"
                                {{ $type == \App\Library\Enum::CATEGORY_BULK ? 'required' : '' }}>
                            @error('quantity')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="row form-group mb-0 @error('note') error @enderror">
                        <label class="col-md-3 col-form-label required">{{ __('Note') }}</label>
                        <textarea type="text" name="note" class="form-control col-md-9" required
                            placeholder="{{ __('Write Note') }}" rows="4">{{ old('note') }}</textarea>
                        @error('note')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="modal-footer justify-content-center">
                    {!! \App\Library\Html::btnSubmit() !!}
                </div>
            </div>
        </form>

    </div>
</div>
