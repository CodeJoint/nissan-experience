@extends('layouts.app')

@section('content')
    <div id="app" class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <section class="col-md-9 mainSection">
                <h1>{{ env('APP_NAME', "Nissan Oculus experience KPI") }}</h1>
                <h2>Reporte de actividad</h2>
                <section class="card dataCard" style="width: 16rem;">
                    <div class="card-body" >
                        <div class="card-title">Tiendas</div>
                        <div class="center-icon">
                            <i class="material-icons">
                                store
                            </i>
                        </div>
                        <div class="card-content">
                            <h3>{{ $store_count }}</h3>
                            <form method="GET" class="form-inline">
                                <div class="form-group mx-sm-3 mb-2">
                                    <div class="form-group">
                                        <select class="form-control" name="store" id="store">
                                            <option value="">Todas</option>
                                            @foreach($stores as $myStore)
                                                <option value="{{ $myStore->identifier }}">{{ $myStore->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                            </form>
                        </div>
                    </div>

                </section>

                <section class="card dataCard" style="width: 16rem;">

                    <div class="card-body">
                        <div class="card-title">Dispositivos</div>
                        <div class="card-content">
                            <doughnut-chart
                                :labels="['Activos','Inactivos']"
                                :values="[{{ $device_count }},1]"
                                >
                            </doughnut-chart>
                            <div class="center-icon under">
                                <i class="material-icons">
                                    phone_android
                                </i>
                            </div>
                            <h3>{{ 1 }} / {{ $device_count }}</h3>
                        </div>
                        <div class="card-subtitle">( activos / total )</div>
                    </div>
                </section>

                <section class="card dataCard" style="width: 16rem;">

                    <div class="card-body">
                        <div class="card-title">Interacciones diarias</div>
                        <div class="center-icon">
                            <i class="material-icons">
                                track_changes
                            </i>
                        </div>
                        <div class="card-content">
                            <h3>{{ $event_count }}</h3>
                        </div>
                    </div>
                </section>

                <section class="card dataCard" style="width: 16rem;">

                    <div class="card-body">
                        <div class="card-title">Sesión promedio</div>
                        <div class="center-icon">
                            <i class="material-icons">
                                alarm
                            </i>
                        </div>
                        <div class="card-content">
                            <h3>0.0 seg</h3>
                        </div>
                    </div>
                </section>


                <div class="row">
                    <div class="col-md-12">

                        <h2>Log de los últimos 10 interacciones</h2>
                        <br>

                        <div class="table-responsive">
                            <table class="table table-striped table-sm">

                                <thead>
                                    <tr>
                                        <th>Hora</th>
                                        <th>Equipo</th>
                                        <th>Evento</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @if(!empty($full_log))
                                        @foreach($full_log as $log_entry)
                                            <tr>
                                                <td>{{ $log_entry->timestamp }}</td>
                                                <td>{{ $log_entry->device_id }}</td>
                                                <td><strong>{{ $log_entry->event['name'] }}</strong> [Interacciones: {{ $log_entry->event['actions']->interaction }}, Tiempo: {{ $log_entry->event['actions']->timeSpent }}]</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3">No hay registros</td>
                                        </tr>
                                    @endif

                                </tbody>

                            </table>
                        </div>

                    </div>

                </div>

            </section>
        </div>


@endsection
