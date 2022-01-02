@extends('layouts.dashboard')

@section('content')

    <div class="row">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-orange shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">paid</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Ganhos Hoje</p>
                        <h4 class="mb-0">{{ $valorGanhoHoje['valor'] }}</h4>
                    </div>
                </div>
                <hr class="success horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span
                            class="{{ $valorGanhoHoje['porcentagem'] <= 0 ? 'text-danger' : 'text-success' }} text-sm font-weight-bolder">
                            {{ $valorGanhoHoje['porcentagem'] }}
                        </span>
                        que o dia anterior
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-purple shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">savings</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Ganhos no mês</p>
                        <h4 class="mb-0">{{ $valorGanhoNoMes['valor'] }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span
                            class="{{ $valorGanhoNoMes['porcentagem'] <= 0 ? 'text-danger' : 'text-success' }} text-sm font-weight-bolder">
                            {{ $valorGanhoNoMes['porcentagem'] }}
                        </span>
                        que o mês passado
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-success shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">weekend</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Valor total</p>
                        <h4 class="mb-0">{{ $valorGanhoTotal }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0 d-flex align-items-center">
                        <span class="text-success text-sm font-weight-bolder">
                            <i class="material-icons opacity-10">paid</i>
                        </span>
                        <span class="pb-2 d-block ms-1">Ganhos</span>

                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-4">
        {{-- histórico de vendas --}}
        <div class="col-12  mt-4 mb-4">
            <div class="card z-index-2  ">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-orange shadow-danger border-radius-lg py-3 pe-1">
                        <div class="d-flex justify-content-end pe-2">
                            <div class="btn-group">
                                @if ($vendasPaginate->hasPages())
                                    <a href="{{ $vendasPaginate->nextPageUrl() }}" class="btn-next-prev btn @if ($vendasPaginate->currentPage() == $vendasPaginate->lastPage()) disabled @endif" href="#" role="button">
                                        <i class="fas fa-angle-left fa-sm"></i>
                                    </a>
                                    <a href="{{ $vendasPaginate->previousPageUrl() }}"
                                        class="btn-next-prev btn @if (!$vendasPaginate->previousPageUrl()) disabled @endif"
                                        href="#" role="button">
                                        <i class="fas fa-angle-right fa-sm"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0 "> Histórico de vendas</h6>

                    <hr class="dark horizontal my-1">
                    <div class="d-flex ">
                        @if (isset($historico[0]))
                            <i class="material-icons text-sm my-auto me-1">schedule</i>
                            <p class="mb-0 text-sm">
                                Atualizado em {{ $historico[0]->created_at->format('d/m/Y à\\s h:i A') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- total --}}
        <div class="col-12 mt-4 mb-3">
            <div class="card z-index-2 ">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    {{-- <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1"> --}}
                    <div class="bg-gradient-purple shadow-info border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0 ">Lucro mensal</h6>
                    <hr class="dark horizontal my-1">
                    <div class="d-flex ">
                        @if (isset($historico[0]))
                            <i class="material-icons text-sm my-auto me-1">schedule</i>
                            <p class="mb-0 text-sm">
                                Atualizado em {{ $historico[0]->created_at->format('d/m/Y à\\s h:i A') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row mb-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>Dados</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-check text-info" aria-hidden="true"></i>
                                <span class="font-weight-bold ms-1">{{ $vendasPaginate->total() }}</span> Registros
                            </p>
                        </div>
                        <div class="col-lg-6 col-5 my-auto text-end">
                            <div class="dropdown float-lg-end pe-4">
                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v text-secondary"></i>
                                </a>
                                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                    <li>
                                        <a class="dropdown-item border-radius-md"
                                            href="{{ route('viewExportar') }}">Exportar</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item border-radius-md"
                                            href="{{ route('viewImportar') }}">Importar</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pb-2">
                    <iframe src="{{ route('vendas') }}" class="w-100" frameborder="0"
                        onload="this.style.height=(this.contentWindow.document.body.scrollHeight+20)+'px';"> </iframe>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Histório de atualizações de dados</h6>
                    @if (isset($historico[0]) && $historico[0]->created_at->format('d-m-Y') == date('d-m-Y'))
                        <p class="text-sm fw-bold">
                            <i class="fa fa-check-circle text-success text-gradient" aria-hidden="true"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Atualizado hoje!"></i>
                            Hoje
                        </p>
                    @else
                        <p class="text-sm fw-bold">
                            <i class="fa fa-info-circle text-danger text-gradient" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Nenhuma atualização hoje!" aria-hidden="true"></i>
                            Hoje
                        </p>


                    @endif
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        @foreach ($historico as $item)
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="material-icons text-success text-gradient">update</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">
                                        {{ date('d-m-Y h-i A', strtotime($item->created_at)) }}
                                    </h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                        {{ $item->total_registros }} Registros
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        var dadosVendas = JSON.parse('<?= $dadosVendas ?>');
        var dadosMes = JSON.parse('<?= $dadosMes ?>');
        console.log(dadosVendas)

        var ctx2 = document.getElementById("chart-line").getContext("2d");

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: dadosVendas.datas,
                datasets: [{
                    label: "Valor venda",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 4,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: dadosVendas.valor_venda,
                    maxBarThickness: 6
                }, {
                    label: "Valor Projetado",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 4,
                    pointBackgroundColor: "yellow",
                    pointBorderColor: "transparent",
                    borderColor: "yellow",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: dadosVendas.valor_projetado,
                    maxBarThickness: 6
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

        new Chart(ctx3, {
            type: "bar",
            data: {
                labels: dadosMes.meses,
                datasets: [{
                    label: "Valor",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    // borderWidth: 4,
                    // backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                    backgroundColor: [
                        "rgb(255,255,0)",
                        "rgb(255,235,0)",
                        "rgb(255,225,0)",
                        "rgb(255,215,0)",
                        "rgb(255,205,0)",
                        "rgb(255,195,0)",
                        "rgb(255,185,0)",
                        "rgb(255,175,0)",
                        "rgb(255,165,0)",
                        "rgb(255,155,0)",
                        "rgb(255,145,0)",
                        "rgb(255,135,0)",
                        "rgb(255,125,0)",
                    ],
                    fill: true,
                    data: dadosMes.valor,
                    // maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#f8f9fa',
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

    </script>
@endsection
