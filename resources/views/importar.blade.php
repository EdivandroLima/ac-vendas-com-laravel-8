@extends('layouts.dashboard', ['title' => 'Importar Planilha'])

@section('content')

    <div class="row">
        <div class="col-12">

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible text-white " role="alert">
                    <i class="material-icons align-middle me-1"> warning </i>
                    <strong>{{ session('error') }}</strong>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible text-white" role="alert">
                    <i class="material-icons align-middle me-1"> check_circle </i>
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif


            <div class="card z-index-2  ">
                <div class="card-body">
                    <h5 class="mb-3 "> Faça upload de uma planilha com os dados de vendas </h5>
                    <div class="">
                        <div class="text-xs">
                            <strong>Formatos suportados:</strong>
                             XLSX, CSV, ODS, XLS, HTML e XML
                        </div>
                        <button type="button" class="btn btn-primary btn-lg mt-2"
                            onclick="document.getElementById('form-file').click()">
                            <span class="material-icons me-2 fs-4"> cloud_upload </span>
                            Selecione uma planilha para fazer upload
                        </button>

                        <form action="{{ route('importar') }}" method="post" id="form-import"
                            enctype="multipart/form-data">
                            @csrf
                            <input class="invisible" type="file" name="arquivo" id="form-file"
                                onchange="document.getElementById('form-import').submit()"
                                accept=".xlsx,.csv,.ods,.xls,.html,.xml">
                        </form>

                        <h6 class="mb-3">
                            Exemplo de planilha, <a href="{{asset('exemplo.xlsx')}}" class="text-primary text-decoration-underline" download>baixar</a> 
                        </h6>
                        <style>
                            table,
                            th,
                            td {
                                border: 1px solid #bbb;
                                padding: 2px 10px;
                                border-collapse: collapse;
                            }

                        </style>
                        <table class="">
                            <thead>
                                <tr class="text-start">
                                    <th class="text-start">Data</th>
                                    <th class="text-start">Valor de vendas</th>
                                    <th class="text-start">Valor Projetado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01/12/2021</td>
                                    <td>400</td>
                                    <td>300</td>
                                </tr>
                                <tr>
                                    <td>02/12/2021</td>
                                    <td>400</td>
                                    <td>300</td>
                                </tr>
                                <tr>
                                    <td>03/12/2021</td>
                                    <td>400</td>
                                    <td>300</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
