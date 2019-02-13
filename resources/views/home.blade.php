@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <section class="col-md-9 mainSection">
                <h1>@if($storeObject){{$storeObject->identifier}}: @endif{{ env('APP_NAME', "Nissan Oculus experience KPI") }}</h1>

                <form action="{{ url('home') }}" method="GET" id="filterForm" style="width: 100%;">
                    <section class="filtersRow row">
                        <h2>Filtros</h2>
                        <div class="each-filter col">
                            <div class="form-group">
                                <select class="form-control" id="storeSelect" name="store" onchange="this.form.submit()">
                                    <option value="">Elige una tienda</option>
                                    @foreach($stores as $myStore)
                                        <option value="{{$myStore->identifier}}" selected="{{ set_active('/', $myStore->identifier, 'selected') }}">{{ $myStore->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="each-filter col">
                            <div class="form-group">
                                <div class='input-group mb-2 date _datepicker' id='datetimepicker_start'>
                                    <input type='text' name="start" class="form-control _datetimepicker" placeholder="MM/DD/AAAA" />
                                    <span class="input-group-text">
                                        <i class="material-icons">event</i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="each-filter col">
                            <div class="form-group">
                                <div class='input-group mb-2 date _datepicker' id='datetimepicker_end'>
                                    <input type='text' name="end" class="form-control _datetimepicker" placeholder="MM/DD/AAAA" />
                                    <span class="input-group-text">
                                        <i class="material-icons">event</i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
                <section class="row">
                    <h2>KPI @if($storeObject) Tienda: {{$storeObject->name}} @endif</h2>
                    <section class="card dataCard" style="width: 16rem;">
                        <div class="card-body" >
                            <div class="card-title">Tiendas activas</div>
                            <div class="card-content">

                            </div>
                            <div class="center-icon">
                                <i class="material-icons">
                                    store
                                </i>
                            </div>
                            <h3>{{ $store_count }}</h3>
                        </div>

                    </section>

                    <section class="card dataCard" style="width: 16rem;">

                        <div class="card-body">
                            <div class="card-title">Dispositivos</div>
                            <div class="card-content">
                                <doughnut-chart
                                        :labels="['Activos','Registrados']"
                                        :values="[{{$active_device_count}},{{ $device_count-$active_device_count }}]"
                                >
                                </doughnut-chart>
                                <div class="center-icon under">
                                    <i class="material-icons">
                                        phone_android
                                    </i>
                                </div>
                                <h3>{{ $active_device_count }} / {{ $device_count }}</h3>
                            </div>
                            <div class="card-subtitle">( activos / registrados )</div>
                        </div>
                    </section>

                    <section class="card dataCard" style="width: 16rem;">

                        <div class="card-body">
                            <div class="card-title">Acceso diario promedio</div>
                            <div class="center-icon">
                                <br>
                                <br>
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
                                <br>
                                <br>
                                <i class="material-icons">
                                    alarm
                                </i>
                            </div>
                            <div class="card-content">
                                <h3>{{ round($session_length, 1) }} seg</h3>
                            </div>
                        </div>
                    </section>

                </section>

                <div class="row _lists">

                    <div class="col-md-5 _notificationsPool" style="float: left">

                        <h2><i class="material-icons">info</i> Notificaciones</h2>
                        <br>

                        <div class="table-responsive">
                            <table class="table table-striped table-sm">

                                <tbody>

                                @if(!empty($notifications))
                                    @foreach($notifications as $log_entry)
                                        <tr>
                                            <td>{{$log_entry}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>No hay notificaciones</td>
                                    </tr>
                                @endif

                                </tbody>

                            </table>
                        </div>

                    </div>

                    <div class="col-md-6" style="float: left">

                        <h2>Log de los últimos 10 usuarios</h2>
                        <br>

                        <div class="table-responsive">
                            <table class="userLogTable table table-striped table-sm">

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
                                                <td><strong>{{ $log_entry->event['name'] }}</strong> [Interacciones: {{ $log_entry->event['actions']->interaction }}, Tiempo: {{ round($log_entry->event['actions']->timeSpent,1) }} seg]</td>
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
    </div>

@endsection