@extends('layouts.stile')
@section('titolo', 'Categories')

@section('content')
    <div class="p-3">

        @if(session()->has('message'))
            <x-alert
                :info="session()->get('tipo')"
                :messaggio="session()->get('message')">
            </x-alert>
        @endif

        <div class="row">
            <div class="col"><h2>Categories</h2></div>
            <div class="col"><a href="{{route('categories.create')}}" class="btn btn-primary">Nuova Categoria</a></div>
        </div>
        <div class="row">
            <div class="col-8">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th >Id</th>
                        <th >Name</th>
                        <th >Created</th>
                        <th >Updated</th>
                        <th >Nr. di Albums</th>
                        <th ></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $cat)
                        <tr class="align-middle" id="tr-{{$cat->id}}">
                            <td>{{$cat->id}}</td>
                            <td>{{$cat->category_name}}</td>
                            <td>{{$cat->created_at->format('d-m-Y')}}</td>
                            <td>{{$cat->updated_at->format('d-m-Y')}}</td>
                            <td>
                                @if($cat->albums_count > 0)
                                    <form class="row g-3" action="{{route('albums.filtra')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="category_id" value="{{$cat->id}}">
                                        <div class="col-auto">
                                            <button type="submit" class="btn mb-3">{{$cat->albums_count}}</button>
                                        </div>
                                    </form>
                                @else
                                    {{$cat->albums_count}}
                                @endif
                            </td>
                            <td class="d-flex justify-content-center">
                                <a title="modifica" href="{{route('categories.edit', $cat->id)}}" class="btn btn-primary m-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{route('categories.destroy', $cat->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button id="btnDelete-{{$cat->id}}" class="btn btn-danger m-1"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tfoot>
                        <tr>
                            <td colspan="6">No records</td>
                        </tr>
                        </tfoot>
                    @endforelse
                    <tfoot>
                    <tr>
                        <td colspan="6">{{$categories->links('vendor.pagination.bootstrap-4')}}</td>
                    </tr>
                    </tfoot>
                    </tbody>
                </table>
            </div>
            <div class="col-4">
                @include('category.categoryForm')
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
    <script>
        $('document').ready(function () {
            $('div.alert').fadeOut(4000);

            $('form .btn-danger').on('click', function (evt) {
                evt.preventDefault();

                let form = this.parentNode;
                let urlCategory = form.action;
                let categoryId = this.id.replace('btnDelete-', '');
                let tr = $('#tr-' + categoryId);
                $.ajax(urlCategory,
                    {
                        method: 'DELETE',
                        data: {
                            '_token': Laravel.csrfToken,
                        },
                        complete: function (resp) {
                            let risposta = JSON.parse(resp.responseText);
                            if (risposta.success == 1) {
                                tr.remove();
                                alert(risposta.message)
                            } else {
                                alert('problemi nella cancellazione')
                            }
                        }
                    }
                )
            });
        });
    </script>
@stop
