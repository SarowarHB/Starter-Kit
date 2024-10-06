<!-- Modal -->
<div class="modal fade" id="updateAssignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('admin.ticket.assignee',$ticket->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> <i class="ti-pencil-alt text-primary"></i> {{ __('Update Assign') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label class="required" for="name">{{ __('Assign To ') }}</label>
                    <div class="form-group @error('assigned_to') error @enderror">
                        <select name="assigned_to" id="assigned_to" class="form-control" required>
                            <option selected disabled value="default">Select One</option>
                            @foreach($employees as $key => $employee)
                            <option value="{{$employee->id}}"
                                {{old('assigned_to', $ticket->assign_to_id == $employee->id) ? "selected" : ""}}>
                                {{ $employee->full_name }}</option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="required" for="name">{{ __('Note ') }}</label>
                    <div class="form-group mb-0 @error('notes') error @enderror">

                        <textarea type="text" id="note" class="form-control todo-list-input" name="notes" rows="6"
                            placeholder="Add Note" required>{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn2-light-secondary mr-3" data-dismiss="modal"><i
                            class="fas fa-times"></i> {{ __('Close') }}</button>
                    {!! \App\Library\Html::btnSubmit() !!}
                </div>
            </div>
        </form>

    </div>
</div>
