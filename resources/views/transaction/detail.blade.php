
@extends('layout.default_layout')

@section('title', 'Purchase')

@section('content')

    <div class="page-header">
        <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2">
                      <i class="mdi mdi-barcode"></i>
                    </span> Transaction Detail </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end">
                @if($data->is_done == 1)
                    <label class="badge badge-success p-2" style="font-size: 17px">Lunas</label>
                @else
                    <label class="badge badge-danger p-2" style="font-size: 17px">Hutang</label>
                @endif
            </div>
            <div>
                <div class="form-group">
                    <h4>Transaction Code:</h4>
                    <div>
                        {{$data->id}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h4>Due Date:</h4>
                            <div>
                                @if($data->is_done == 0)
                                    {{$data->due_date}}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h4>Need to Pay:</h4>
                            <div>
                                @if($data->is_done == 0)
                                    Rp. {{number_format($data->needs,0)}}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div>
                <table class="table table-hover" style="table-layout: fixed;">
                    <thead>
                    <tr>
                        <th class="w-50">Name</th>
                        <th>Quantity</th>
                        <th>Sell Price</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data->details as $d)
                        <tr>
                            <td class="text-truncate">
                                {{json_decode($d->productDetail->name)->name}}
                                {{json_decode($d->productDetail->name)->code}}
                                {{json_decode($d->productDetail->name)->color}}
                                {{json_decode($d->productDetail->name)->type}}
                                {{json_decode($d->productDetail->name)->unit}}
                            </td>
                            <td>
                                {{$d->quantity}}
                                {{json_decode($d->productDetail->name)->unit}}
                            </td>
                            <td>
                                Rp. {{number_format($d->price)}}
                            </td>
                            <td>
                                Rp. {{number_format($d->price * $d->quantity)}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="form-group d-flex justify-content-end mt-3 mr-4">
                    <div>
                        <h4>
                            Total: Rp. {{number_format($total, 0)}}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

