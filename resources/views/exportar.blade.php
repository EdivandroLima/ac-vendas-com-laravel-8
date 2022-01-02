@extends('layouts.dashboard', ['title' => 'Exportar Planilha'])

@section('content')

    <div class="row">
        <div class="col-12">

            <div class="card z-index-2  ">
                <div class="card-body">

                    {{-- download --}}
                    <div class="">
                        <form action="{{ route('exportar') }}" method="post">
                            @csrf
                            <h5 class="mb-3 ">
                                Faça download da Planilha
                            </h5>
                            <button type="submit" class="btn btn-info btn-lg" @empty(App\Models\Venda::where('user_id', auth()->user()->id)->first()) disabled
                                @endempty>
                                <span class="material-icons me-2 fs-4"> download </span>
                                Exportar Planilha
                            </button>
                            <div class="mb-3">
                                <small>Formato do arquivo</small>
                                <select class="form-select px-2 py-0 d-inline text-dark bg-light" name="formato"
                                    id="formato" style="max-width: 150px">
                                    <option selected>XLSX</option>
                                    <option>CSV</option>
                                    <option>ODS</option>
                                    <option>XLS</option>
                                    <option>HTML</option>
                                    <option>PDF</option>
                                </select>
                            </div>
                            <div class="small">
                                Data entre
                                <input type="date" class="form-control d-inline px-2 py-0 bg-light border "
                                    style="max-width: 140px" name="data_inicio"> e
                                <input type="date" class="form-control d-inline px-2 py-0 bg-light border "
                                    style="max-width: 140px" name="data_final"> (Opcional)
                            </div>
                        </form>
                    </div>

                    {{-- Informações --}}
                    <h5 class="mt-4 pt-2">Informações</h5>
                    <table class="table table-bordered" style="max-width: 350px">
                        <thead>
                            <tr>
                                <th class="px-2">Data de upload</th>
                                <th class="px-2">N. Registros</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @if (!empty($hitorico))
                                    <td>{{ $hitorico->created_at->format('d-m-Y à\\s h:i A') }}</td>
                                    <td>{{ $hitorico->total_registros }}</td>
                                @else
                                    <td>0</td>
                                    <td>0</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>

                    {{-- Dados --}}
                    <h5 class="mt-4">Dados</h5>
                    <iframe src="{{route('vendas')}}" class="w-100" frameborder="0"
                        onload="this.style.height=(this.contentWindow.document.body.scrollHeight+20)+'px';"> </iframe>


                </div>
            </div>
        </div>
    </div>

@endsection
