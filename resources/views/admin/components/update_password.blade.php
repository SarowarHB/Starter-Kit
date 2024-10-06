<!-- Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <form id="updatePasswordForm" onsubmit="updatePassword(event, this)" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> {{ __('Update Password') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="required" for="">{{ __('Password') }}</label>
            <input name="password" type="password" name="password" class="form-control" id="password" aria-describedby="emailHelp" placeholder="{{ __('Password') }}" required>
            <small class="form-text error-message"></small>
          </div>
          <div class="form-group">
            <label class="required" for="">{{ __('Confirm Password') }}</label>
            <input name="password_confirmation" name="password_confirmation" type="password" class="form-control" id="password_confirmation" aria-describedby="emailHelp" placeholder="{{ __('Confirm Password') }}" required>
            <small class="form-text error-message"></small>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          {!! \App\Library\Html::btnClose() !!}
          {!! \App\Library\Html::btnSubmit() !!}
        </div>
      </div>
    </form>

  </div>
</div>

@push('scripts')
<script type="text/javascript">

    const updatePasswordModal = "#updatePasswordModal";
    const updatePasswordForm = "#updatePasswordForm";
    var user_id = null;

    function updateUserPassword(id)
    {
        clearValidation(updatePasswordForm);
        $(updatePasswordForm).find("input[name='password']").val('');
        $(updatePasswordForm).find("input[name='password_confirmation']").val('');
        $(updatePasswordModal).modal('show');
        user_id = id;
    }

  function updatePassword(e, t)
  {
    e.preventDefault();
    const url = BASE_URL + '/users/' + user_id + '/update-password-api';
    var form_data = $(t).serialize();

    // loading('show');
    axios.post(url, form_data)
      .then(response => {
          notify(response.data.message, 'success');
          $(updatePasswordModal).modal('hide');
      })
      .catch(error => {
          const response = error.response;
          console.log(response.data.errors);
          if (response) {
              if (response.status === 422)
                  validationForm(updatePasswordForm, response.data.errors);
              else if(response.status === 404)
                notify('Not found', 'error');
              else
                notify(response.data.message, 'error');
          }
      })
      .finally(() => {
        // loading('hide');
      });

  }
</script>
@endpush
