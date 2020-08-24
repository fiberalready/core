@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>DataTables</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">DataTables</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    @if ($message = Session::get('success'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
      <strong>Success</strong> {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            @can('product-create')
            <a class="card-title mr-3 btn btn-success btn-flat" href="{{ route('products.create') }}"><i class="fas fa-plus-circle"></i> Create New</a>
            @endcan
            <h3 class="card-title">DataTable with minimal features & hover style</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive">
            <table id="example2" class="table table-sm table-bordered table-hover">
              <thead>
              <tr>
                <th width="10">No</th>
                <th>Name</th>
                <th>Details</th>
                <th width="100">Act</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($products as $product)
          	    <tr>
          	        <td>{{ ++$i }}</td>
          	        <td>{{ $product->name }}</td>
          	        <td>{{ $product->detail }}</td>
          	        <td>
                          <form action="{{ route('products.destroy',Crypt::encrypt($product->id)) }}" method="POST" id="product-delete">
                              <a class="btn btn-outline-primary btn-sm" href="{{ route('products.show',Crypt::encrypt($product->id)) }}"><i class="fas fa-eye"></i></a>
                              @can('product-edit')
                              <a class="btn btn-outline-secondary btn-sm" href="{{ route('products.edit',Crypt::encrypt($product->id)) }}"><i class="fas fa-edit"></i></a>
                              @endcan
                              @csrf
                              @method('DELETE')
                              @can('product-delete')
                              <button type="button" class="btn btn-outline-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                              @endcan
                          </form>
          	        </td>
          	    </tr>
          	    @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th width="10">No</th>
                <th>Name</th>
                <th>Details</th>
                <th width="100">Act</th>
              </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
{!! $products->links() !!}
@endsection
@section('js')
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script>
  $(function () {
    $("#example2").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  $('.delete').click(function(){
    Swal.fire({
      title: 'Apakah anda yakin menghapus data ini ?',
      text: "Data yang sudah terhapus tidak akan dapat dikembalikan !",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus Sekarang!'
    }).then((result) => {
      if (result.value) {
        document.getElementById('product-delete').submit();
      }
    })
  })
</script>
@endsection
