<!-- Modal -->
<div class="modal fade" id="testMailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <form id="testMailForm" method="post" action="{{ route('admin.config.send.test.email') }}">
        @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus"></i> {{ __('Test Mail') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input name="email" type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter Email" required>
            <small class="form-text error-message"></small>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn2-light-secondary mr-3" data-dismiss="modal"><i class="fas fa-times"></i> {{ __('Close') }}</button>
          <button type="submit" class="btn btn2-secondary"><i class="fas fa-save"></i> {{ __('Send') }} </button>
        </div>
      </div>
    </form>

  </div>
</div>
