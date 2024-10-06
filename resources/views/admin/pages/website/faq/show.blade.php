@extends('admin.layouts.master') 

@section('title', 'FAQ Details')

@section('content') 


<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.website.faq.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('FAQ Details')) }}</h4>
        </div>
        
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">

                
                    <table class="table org-data-table table-bordered show-table">
                        <tbody>
                            <tr>
                                <td>Status</td>
                                <td>
                                    <span class="badge {{ ($faq->is_active == \App\Library\Enum::STATUS_ACTIVE) ? "btn2-secondary" : "btn-secondary" }}">
                                        {{ ($faq->is_active == \App\Library\Enum::STATUS_ACTIVE) ? "Active" : "Inactive" }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Qustion</td>
                                <td> {{ $faq->qustion }} </td>
                            </tr>
                            <tr>
                                <td>Created By </td>
                                <td> {{ $faq->user->getFullNameAttribute() }} </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center my-4">
                        <button class="btn btn-sm mr-1 {{ $faq->is_active == \App\Library\Enum::STATUS_ACTIVE ? 'btn-secondary' : 'btn2-secondary' }}"
                            onclick="confirmFormModal('{{ route('admin.website.faq.change_status.api', $faq->id) }}', 'Confirmation', 'Are you sure to change status?')">
                            <i class="fas fa-power-off"></i> {{ $faq->is_active == \App\Library\Enum::STATUS_ACTIVE ? 'Make Inactive' : 'Make Active' }} 
                        </button>
                        <a href="{{ route('admin.website.faq.update', $faq->id) }}" class="btn btn-sm btn-warning mr-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button class="btn btn-sm btn-danger"
                            onclick="confirmFormModal('{{ route('admin.website.faq.delete.api', $faq->id) }}', 'Confirmation', 'Are you sure to delete operation?')">
                            <i class="fas fa-trash-alt"></i> Delete 
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body py-4">
                    <div class="text-left">
                    
                    <h3>Answer</h3>
                    <hr>
                    <td> {{ $faq->answer }} </td>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@stop


@push('scripts')
<script>
    function clickChangeStatus() {
        $(changeStatusModal).modal('show');
    }
</script>
@endpush