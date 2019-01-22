@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <section class="col-md-9">
                <h1>KPI Dashboard</h1>

                <section class="card dataCard" style="width: 20rem;">
                    <div class="card-body" >
                        <div class="card-title">Tiendas</div>
                        <div class="center-icon">
                            <i class="material-icons">
                                store
                            </i>
                        </div>
                        <div class="card-content">
                            <h3>{{ $store_count }}</h3>
                        </div>
                    </div>

                </section>

                <section class="card dataCard" style="width: 20rem;">

                    <div class="card-body">
                        <div class="card-title">Dispositivos</div>
                        <div class="center-icon">
                            <i class="material-icons">
                                phone_android
                            </i>
                        </div>
                        <div class="card-content">
                            <h3>{{ $device_count }} / {{ $device_count }}</h3>
                        </div>
                        <div class="card-subtitle">( activos / total )</div>
                    </div>
                </section>

                <section class="card dataCard" style="width: 20rem;">

                    <div class="card-body">
                        <div class="card-title">Eventos</div>
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


                <div class="row">
                    <div class="col-md-12">

                        <h2>Log de eventos</h2>
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

                                    @if(!$log)
                                        @foreach($log as $log_entry)
                                            <tr>
                                                <td>{{ $log_entry->timestamp }}</td>
                                                <td>{{ $log_entry->device_id }}</td>
                                                <td>{{ $log_entry->event }}</td>
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
