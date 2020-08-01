
@extends('layout.default_layout')

@section('title', 'Customer')

@section('content')

    <div class="page-header">
        <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2">
                      <i class="mdi mdi-account-multiple"></i>
                    </span> Pengaturan Customer </h3>
    </div>
    <div class="card">
        <div class="card-body">
            <div>
                @if (session()->has('msg'))
                    <div class="alert alert-success">
                        {{ session()->get('msg') }}
                    </div>
                @endif
            </div>
            <div>
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
            </div>
            <div>
                <a href="{{route('customer-insert-view')}}"><button class="btn btn-gradient-success">+ Tambah Customer</button></a>
            </div>
            <table class="table table-hover" style="table-layout: fixed;">
                <thead>
                <tr>
                    <th class="w-25">Nama</th>
                    <th class="w-30">Alamat</th>
                    <th>Transaksi Hutang</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $d)
                    <tr>
                        <td>{{$d->name ?? ''}}</td>
                        <td>{{$d->address ?? ''}}</td>
                        <td>{{$d->debt ?? '-'}}</td>
                        <td class="row">
                            <div class="">
                                <a href="{{route('customer-detail-view', ['id'=>$d->id])}}">
                                    <button type="button" class="btn btn-gradient-success btn-rounded btn-icon" data-toggle="modal" data-target="#modal">
                                        <i class="mdi mdi-information-variant"></i>
                                    </button>
                                </a>
                            </div>
                            <div class="mx-2">
                                <a href="{{route('customer-update-view', ['id'=>$d->id])}}">
                                    <button type="submit" class="btn btn-gradient-info btn-rounded btn-icon">
                                        <i class="mdi mdi-lead-pencil"></i>
                                    </button>
                                </a>
                            </div>
                            <form action="{{route('customer-delete', ['id'=>$d->id])}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-gradient-danger btn-rounded btn-icon" data-toggle="modal" data-target="#modal">
                                    <i class="mdi mdi-close"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
                {{$data->links()}}
            </div>
        </div>
    </div>

@endsection

