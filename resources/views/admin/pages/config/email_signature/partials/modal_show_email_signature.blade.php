<!-- Modal -->
<div class="modal fade" id="showEmailSignatureModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-default" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <span id="show_name"> </span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 p-3">
                        <span id="show_signature" > </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                {!! \App\Library\Html::btnClose() !!}
            </div>
        </div>
        </form>

    </div>
</div>

@push('scripts')
<script type="text/javascript">
    const showEmailSignatureModal = "#showEmailSignatureModal";

    function showViewEmailSignatureModal(id) {
        loading('show');

        const url = BASE_URL + '/configs/email-signature/' + id + '/show-api';
        axios.get(url)
            .then(response => {
                const data = response.data;
                console.log(data.name);
                $('span#show_name').html(data.name);
               
                $('#show_signature').html(data.signature);
                $(showEmailSignatureModal).modal('show');
            })
            .catch(error => {
                const response = error.response;
                if (response)
                    notify(response.data.message, 'error');
            })
            .finally(() => {
                loading('hide');
            });
    }
</script>
@endpush