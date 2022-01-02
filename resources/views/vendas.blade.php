<!--
=========================================================
* Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vendas</title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
</head>

<body onload="closeLoad()">
    {{-- load --}}
    <div id="load-page" class="load-page d-flex">
        <div class="spinner-border text-primary m-auto" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    {{-- table --}}
    <div class="table-responsive">
        <table class="table table-striped ">
            <thead>
                <tr class="text-sm">
                    <th class="px-2 text-uppercase"> Data</th>
                    <th class="px-2 text-uppercase"> Valor de vendas</th>
                    <th class="px-2 text-uppercase"> Valor Projetado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendas as $venda)
                    <tr>
                        <td class=" ">
                            {{ date('d/m/Y', strtotime($venda->data)) }}
                        </td>
                        <td class=" ">
                            {{ $venda->valor_venda }}
                        </td>
                        <td class=" ">
                            {{ $venda->valor_projetado }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @empty($venda)
            <div class="px-2">
                Nenhum registro.
            </div>
        @endempty
        <nav aria-label="mt-3">
            {{ $vendas->links() }}
        </nav>
    </div>

    {{-- script --}}
    <script>
        function closeLoad() {
            document.getElementById('load-page').className = "d-none"
        }

        for (let elemento of document.getElementsByClassName("page-link")) {
            elemento.onclick = function() {
                document.getElementById('load-page').className = "load-page d-flex"
            };
        }

    </script>

</body>

</html>
