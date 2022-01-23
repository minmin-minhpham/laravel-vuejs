@extends('layouts.app')
@section('title', trans('category.title.list'))
@section('content-header', trans('category.title.list'))

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- iframe --}}
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <iframe src="" frameborder="0" width="100%" style="border-radius: inherit" class="iframe-full-height" ></iframe>
                    </div>
                </div>
            </div>
            {{-- ./iframe --}}

            <!-- filter -->
            <div class="card card-default card-primary card-outline collapsed-card">
                <div class="card-header">
                    <span class="card-title text-lg-left font-weight-bold">
                        <i class="fa fa-filter" aria-hidden="true"></i>&nbsp;@lang('common.title.filter')
                    </span>
                    <div class="card-tools">
                        <button class="btn btn-tool" type="button" data-card-widget="collapse" aria-expanded="true"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                </div>
            </div>
            <!-- ./filter -->

            <!-- list -->
            <div class="card">
                <div class="card-body table-responsive">
                    <div class="row">
                        <div class="col-6">
                            <a data-url="{{ route('admin.categories.create') }}" href="" role="button" class="btn btn-primary modal-trigger" title="{{trans('common.button.create')}}">
                                <i class="fas fa-plus-circle"></i>&nbsp;@lang('common.button.create')
                            </a>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <form action="" method="GET">
                                    <select onchange="this.form.submit()" name="limit" class="form-control form-control-sm">
                                        <option value="15" {{ old('limit') == 15 ? 'selected' : '' }}>15</option>
                                        <option value="50" {{ old('limit') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ old('limit') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="col-12 mt-1">
                            <span class="text-secondary">{{trans_choice('common.title.total', $total)}}</span>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center align-middle" style="width: 15%;">#</th>
                                <th class="text-center align-middle" style="width: 45%;">@lang('common.title.title')</th>
                                <th class="text-center align-middle" style="width: 20%;">@lang('common.title.active')</th>
                                <th class="text-center align-middle" style="width: 20%;">@lang('common.title.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="text-center align-middle">{{$category->id}}</td>
                                    <td class="align-middle">{{$category->title}}</td>
                                    <td class="text-center align-middle">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" {{$category->active ? "checked=checked" : ''}} class="custom-control-input" id="customSwitch_{{$category->id}}" onclick="updateStatus(this)"  data-url="{{ route('admin.categories.updateActive', ['category'=> $category] ) }}">
                                            <label class="custom-control-label" for="customSwitch_{{$category->id}}"></label>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a data-url="{{ route('admin.categories.edit', ['category' => $category]) }}" href="" role="button" class="btn btn-default btn-sm modal-trigger" title="{{ trans('common.button.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-delete" title="{{ trans('common.button.delete') }}" onclick="document.getElementById('form-delete').setAttribute('action', '{{ route('admin.categories.destroy', ['category' => $category]) }}')" >
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <div class="pagination-sm m-0 float-right">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
            <!-- ./list -->

            {{-- modal --}}
            <div class="modal fade" id="modal-delete">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">@lang('category.title.delete')</h4>
                        </div>
                        <form action="" method="POST" id="form-delete">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body col-sm-12">
                                <h6 class="mt-4 mb-4">@lang('category.message.confirm_delete')</h6>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('common.button.cancel')</button>
                                <button type="submit" class="btn btn-danger">@lang('common.button.delete')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- ./modal --}}
            
        </div>
    </div>
@endsection

@section('script')
    <script>
        function updateStatus(e) {
            axios({
                method: "PUT",
                url: e.dataset.url,
            })
            .then((result) => {
                Toast.fire({
                    icon: 'success',
                    title: "@lang('category.message.was_status_updated')",
                });
            })
            .catch((err) => {
                e.checked = !e.checked
                Toast.fire({
                    icon: 'error',
                    title: "@lang('category.message.try_again')",
                });
                // alert("Can't update status");
                console.log(err);
            });
        }
    </script>
@endsection