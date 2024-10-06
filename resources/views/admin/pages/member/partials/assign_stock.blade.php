<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body py-sm-4">
                <div class="text-center pb-2">
                    <div class="mb-3">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Stock ID</th>
                                    <th>Stock</th>
                                    <th>Quantity</th>
                                    <th>Assign Date</th>
                                    <th>Status</th>
                                    <th>Acknowledgement Status</th>
                                    <th>Acknowledgement</th>
                                    <th>Operator</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assigns as $key => $assign)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>
                                        <a href="{{ route('admin.ams.stock.show', $assign->stock_id) }}">{{ $assign->stock->unique_id }}</a>
                                    </td>
                                    <td>{{ $assign->stock->product->name }}</td>
                                    <td>{{ $assign->quantity }}</td>
                                    <td>{{ $assign->assigned_date }}</td>
                                    <td>{!! App\Library\Html::stockStatusBadge($assign->status) !!}</td>
                                    <td>{!! App\Library\Html::AcknoledgementStatus($assign->acknowledgement_status)  !!}</td>
                                    <td>{{ $assign->received_by ? ' Received By '.$assign->receivedBy->full_name .', At : ' .$assign->received_at .'' : 'N/A' }}</td>
                                    <td>{{ $assign->operator->full_name }}</td>
                                    <td>
                                        <div class="action dropdown">
                                            <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-tools"></i> Action
                                            </button>
                                            <div class="dropdown-menu">

                                                @php
                                                    $types = $assign->stock->product->category->categoryType->entry_type;
                                                @endphp

                                                @if($assign->acknowledgement_status == 1 && $types == \App\Library\Enum::CATEGORY_INDIVIDUAL)
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="openChangeStockStatusModal({{$assign->id}}, {{$assign->status}})" ><i class="far fa-edit"></i> Change Status </a>
                                                @elseif($assign->acknowledgement_status == 0)
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="confirmModal(AcceptStock, '{{ $assign->id }}', 'Are you sure, You Read it?')" ><i class="fa-solid fa-check"></i> Accept </a>
                                                @elseif($types == \App\Library\Enum::CATEGORY_BULK )
                                                    <a class="dropdown-item" href="#"> Edit </a>
                                                @endif
                                            </div>
                                        </div>
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
</div>
